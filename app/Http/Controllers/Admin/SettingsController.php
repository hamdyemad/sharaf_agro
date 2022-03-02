<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\File;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function __construct()
    {
    }

    use File;
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
            return redirect()->back()->with('info', 'تم التعديل بنجاح');

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
