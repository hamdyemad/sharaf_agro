<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FirebaseToken;
use App\Models\InquireView;
use App\Models\NewsView;
use App\Models\OrderUnderWorkView;
use App\Models\OrderView;
use App\Models\Setting;
use App\Traits\File;
use App\Traits\FirebaseNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{

    public function __construct()
    {
    }

    use File, FirebaseNotify;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function edit()
    {
        $this->authorize('settings.edit');
        return view('settings.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->authorize('settings.edit');
        if($request->logo) {
            $setting = Setting::where('type', 'logo')->first();
            if($setting) {
                if(file_exists($setting->value)) {
                    $img = last(explode('/', $setting->value));
                    if(in_array($img, scandir(dirname($setting->value)))) {
                        unlink($setting->value);
                    }
                }
                $setting->update([
                    'value' => $this->uploadFile($request, $this->settingsPath, 'logo')
                ]);
            } else {
                Setting::create([
                    'type' => 'logo',
                    'value' => $this->uploadFile($request, $this->settingsPath, 'logo')
                ]);
            }
        }
        if($request->has('type')) {
            foreach ($request->type as $key => $value) {
                $setting = Setting::where('type', $key)->first();
                if($setting) {
                    $setting->update(['value' => $value]);
                } else {
                    Setting::create([
                        'type' => $key,
                        'value' => $value
                    ]);
                }
            }
            return redirect()->back()->with('success', 'تم التعديل بنجاح');

        }
    }

    public function show_all_notify(Request $request) {
        InquireView::where('viewed', 0)->update(['viewed' => 1]);
        NewsView::where('viewed', 0)->update(['viewed' => 1]);
        OrderUnderWorkView::where('viewed', 0)->update(['viewed' => 1]);
        OrderView::where('viewed', 0)->update(['viewed' => 1]);
        return redirect()->back()->with('success', 'تم التعديل بنجاح');

    }

    public function firebase_tokens(Request $request) {
        $validator = Validator::make($request->all(), [
            'currentToken' => 'required|string'
        ], [
            'currentToken.required' => 'التوكين مطلوب',
            'currentToken.string' => 'التوكين يجب أن يكون نوعه سترينج'
        ]);
        if($validator->fails()) {
            return $this->sendRes('يوجد خطأ ما', false, $validator->errors());
        }
        $firebaseToken = FirebaseToken::where('token', $request->currentToken)->first();
        if(!$firebaseToken) {
            FirebaseToken::create([
                'user_id' => Auth::id(),
                'token' => $request->currentToken
            ]);
            return $this->sendRes('تم انشاء التوكين', true);
        } {
            return "token is created before";
        }
    }

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
