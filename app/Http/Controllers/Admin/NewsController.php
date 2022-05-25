<?php

namespace App\Http\Controllers\Admin;

use App\Events\newNews;
use App\Http\Controllers\Controller;
use App\Mail\SendNew;
use App\Models\News;
use App\Models\NewsView;
use App\Traits\File;
use App\Traits\Res;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    use File, Res;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('news.index');
        $news = News::latest();
        if($request->name) {
            $news = $news->where('name','like','%' . $request->name . '%');
        }
        $news = $news->paginate(10);
        return view('news.index', compact('news'));
    }

    public function all_news(Request $request) {
        if(Auth::user()->type == 'user') {
            $news = News::latest();
            if($request->name) {
                $news = $news->where('name','like','%' . $request->name . '%');
            }
            $news = $news->paginate(10);
            return view('news.all_news', compact('news'));
        } else {
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('news.create');
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('news.create');
        $creation = [
            'name' => $request->name,
            'details' => $request->details
        ];
        if($request->send_notify == 'on') {
            $creation['send_notify'] = 1;
        } else {
            $creation['send_notify'] = 0;
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'details' => 'required',
            'images' => 'required',
        ], [
            'name.required' => 'أسم الخبر مطلوب',
            'name.max' => 'يجب أن يكون الأسم اقل من 255 حرف',
            'details.required' => 'تفصايل الخبر مطلوبة',
            'images.required' => 'الصور مطلوبة'
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all())->with('error', 'يوجد خطأ ما');
        }
        if($request['images']) {
            foreach ($request->file('images') as $image) {
                $images[] = $this->uploadFiles($image, $this->newsPath);
            }
            $creation['images'] = json_encode($images);
        }
        $new = News::create($creation);
        try {
            event(new newNews($new));
        } catch (\Throwable $th) {
            //throw $th;
        }
        if($request->send_notify == 'on') {
            $users = User::all();
            if($users->count() > 0) {
                $data = [
                    'name' => $request->name,
                    'details' => 'details',
                    'images' => $new->images,
                    'subject' => $request->name
                ];
                foreach ($users as $user) {
                    try {
                        Mail::to($user->email)->send(new SendNew($data));
                    } catch (\Throwable $th) {
                        // throw $th;
                    }
                }
            }
        }
        return redirect()->to(route('news.index'))->with('success', 'تم انشاء الخبر بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(News $new)
    {
        if(Auth::user()->type !== 'user') {
            $this->authorize('news.show');
        }
        $new_view = NewsView::
        where('new_id', $new->id)
        ->where('user_id', Auth::id())
        ->first();
        if(!$new_view) {
            NewsView::create([
                'new_id' => $new->id,
                'user_id' => Auth::id(),
                'viewed' => 1
            ]);
        } else {
            $new_view->update([
                'viewed' => 1
            ]);
        }
        return view('news.show', compact('new'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(News $new)
    {
        $this->authorize('news.edit');
        return view('news.edit', compact('new'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $new)
    {
        $this->authorize('news.edit');
        $creation = [
            'name' => $request->name,
            'details' => $request->details
        ];
        if($request->send_notify == 'on') {
            $creation['send_notify'] = 1;
        } else {
            $creation['send_notify'] = 0;
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'details' => 'required',
        ], [
            'name.required' => 'أسم الخبر مطلوب',
            'details.required' => 'تفصايل الخبر مطلوبة'
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all())->with('error', 'يوجد خطأ ما');
        }
        if($request['images']) {
            if($new->images) {
                $images = json_decode($new->images);
            } else {
                $images = [];
            }
            foreach ($request->file('images') as $image) {
                array_push($images, $this->uploadFiles($image, $this->newsPath));
            }
            $creation['images'] = json_encode($images);
        }
        $new->update($creation);
        return redirect()->back()->with('success', 'تم تعديل الخبر بنجاح');
    }

    public function remove_files(Request $request, $id) {
        $new = News::find($id);
        if(file_exists(json_decode($new->images)[$request->index])) {
            $images = json_decode($new->images, true);
            unlink($images[$request->index]);
            array_splice($images, $request->index, 1);
            $new->update([
                'images' => json_encode($images)
            ]);
        }
        return $this->sendRes('تم ازالة الملف بنجاح', true);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $new)
    {
        $this->authorize('news.destroy');
        if($new->images) {
            foreach (json_decode($new->images) as $image) {
                if(file_exists($image)) {
                    unlink($image);
                }
            }
        }
        News::destroy($new->id);
        return redirect()->back()->with('success', 'تم ازالة الخبر بنجاح');

    }
}
