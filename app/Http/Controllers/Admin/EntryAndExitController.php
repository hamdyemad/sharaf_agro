<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EntryAndExitExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\EntryAndExit;
use App\Models\UserCategory;
use App\Models\UserSubCategory;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class EntryAndExitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->authorize('entry_and_exit.index');
        if(Auth::user()->type !== 'sub-admin') {
            $categories = Category::all();
        } else {
            $employeeCategories = UserCategory::where('user_id', Auth::id())->pluck('category_id');
            $categories = Category::whereIn('id',$employeeCategories)->get();
        }

        $users = User::where('id', '!=', Auth::id())->where('type', 'sub-admin')->latest();

        $users = $users->get();

        $entriesAndExits = EntryAndExit::latest();

        if($request->category_id) {
            $usersIdsByCategory_id = UserCategory::where('category_id', $request->category_id)->pluck('user_id');
            $entriesAndExits = $entriesAndExits->whereIn('user_id', $usersIdsByCategory_id);
        }
        if($request->sub_category_id) {
            $usersIdsBySubCategory_id = UserSubCategory::where('sub_category_id', $request->sub_category_id)->pluck('user_id');
            $entriesAndExits = $entriesAndExits->whereIn('user_id', $usersIdsBySubCategory_id);
        }

        if($request->user_id) {
            $entriesAndExits = $entriesAndExits->where('user_id', $request->user_id);
        }
        if($request->from) {
            $entriesAndExits->whereDate('current_date', '>=', $request->from);
        }
        if($request->to) {
            $entriesAndExits->whereDate('current_date', '<=', $request->to);
        }
        if($request->from && $request->to) {
            $entriesAndExits
            ->whereDate('current_date', '<=', $request->to)
            ->whereDate('current_date', '>=', $request->from);
        }

        if($request->extras) {
            $entriesAndExits = $entriesAndExits->get();
            if($request->extras == 'late') {
                $entriesAndExits = $this->extras($entriesAndExits->toArray(), 'entry', 'is_enter');
            }
            if($request->extras == 'extra_time') {
                $entriesAndExits = $this->extras($entriesAndExits->toArray(), 'exit', 'is_exit');
            }
            if($request->extras == 'delay_allowed') {
                $entriesAndExits = $this->extras($entriesAndExits->toArray(), 'entry', 'is_enter', true);
            }
        } else {
            $entriesAndExits = $entriesAndExits->paginate(10);
        }
        return view('entry_and_exit.e', compact('entriesAndExits', 'categories', 'users'));

    }
    public function export(Request $request)
    {
        if(Auth::user()->type !== 'sub-admin') {
            $categories = Category::all();
        } else {
            $employeeCategories = UserCategory::where('user_id', Auth::id())->pluck('category_id');
            $categories = Category::whereIn('id',$employeeCategories)->get();
        }

        $users = User::where('id', '!=', Auth::id())->where('type', 'sub-admin')->latest();

        $users = $users->get();

        $entriesAndExits = EntryAndExit::latest();

        if($request->category_id) {
            $usersIdsByCategory_id = UserCategory::where('category_id', $request->category_id)->pluck('user_id');
            $entriesAndExits = $entriesAndExits->whereIn('user_id', $usersIdsByCategory_id);
        }
        if($request->sub_category_id) {
            $usersIdsBySubCategory_id = UserSubCategory::where('sub_category_id', $request->sub_category_id)->pluck('user_id');
            $entriesAndExits = $entriesAndExits->whereIn('user_id', $usersIdsBySubCategory_id);
        }

        if($request->user_id) {
            $entriesAndExits = $entriesAndExits->where('user_id', $request->user_id);
        }
        if($request->from) {
            $entriesAndExits->whereDate('current_date', '>=', $request->from);
        }
        if($request->to) {
            $entriesAndExits->whereDate('current_date', '<=', $request->to);
        }
        if($request->from && $request->to) {
            $entriesAndExits
            ->whereDate('current_date', '<=', $request->to)
            ->whereDate('current_date', '>=', $request->from);
        }

        $entriesAndExits = $entriesAndExits->get();
        if($request->extras) {
            if($request->extras == 'late') {
                $entriesAndExits = $this->extras($entriesAndExits->toArray(), 'entry', 'is_enter');
            }
            if($request->extras == 'extra_time') {
                $entriesAndExits = $this->extras($entriesAndExits->toArray(), 'exit', 'is_exit');
            }
            if($request->extras == 'delay_allowed') {
                $entriesAndExits = $this->extras($entriesAndExits->toArray(), 'entry', 'is_enter', true);
            }
        }
        return Excel::download(new EntryAndExitExport($entriesAndExits), 'entries_and_exists.xlsx');

    }


    public function extras($data,$timeSetting, $is_enter_or_exit, $delayAllowed = false) {
        $entriesAndExits = $data;
        $timeSetting = $timeSetting;
        $is_enter_or_exit = $is_enter_or_exit;
        $entriesAndExits =  array_values(array_filter(array_map(function($obj) use($timeSetting, $is_enter_or_exit, $delayAllowed) {
            $entrySettingTimeStamp = strtotime(new Carbon($obj['current_date'] . ' ' . get_setting($timeSetting)));
            if($delayAllowed) {
                $delayAllowedSetting = strtotime(new Carbon($obj['current_date'] . ' ' . get_setting('delay_allowed')));
                $entryTimeStamp = strtotime($obj['entry']);
                if($entryTimeStamp <= $delayAllowedSetting && $entryTimeStamp > $entrySettingTimeStamp  && $obj['is_enter'] == 1) {
                    return $obj;
                }
            } else {
                $entryTimeStamp = strtotime($obj[$timeSetting]);
                if($entryTimeStamp > $entrySettingTimeStamp  && $obj[$is_enter_or_exit] == 1) {
                    return $obj;
                }
            }
        }, $entriesAndExits)));
        return paginate($entriesAndExits, 10, null);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('entry_and_exit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
