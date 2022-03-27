<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('countries.index');
        Carbon::setLocale(app()->getLocale());
        $countries = Country::latest();
        if($request->name) {
            $countries = $countries->where('name', 'like', '%'. $request->name . '%');
        }
        if($request->code) {
            $countries = $countries->where('code', 'like','%'. $request->code . '%');
        }
        if($request->active) {
            if($request->active == 'true') {
                $countries = $countries->where('active', 'like','%'. 1 . '%');
            } else {
                $countries = $countries->where('active', 'like','%'. 0 . '%');
            }
        }
        $countries = $countries->paginate(10);
        return view('countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('countries.create');
        return view('countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('countries.create');
        $creation =  [
            'name' => $request->name,
            'code' => $request->code,
        ];
        if($request->has('active')) {
            $creation['active'] = 1;
        } else {
            $creation['active'] = 0;
        }
        $rules = [
            'name' => 'required|string|unique:countries,name'
        ];
        $messages = [
            'name.required' => translate('the name is required'),
            'name.unique' => translate('you should choose a name is not exists')
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', translate('there is something error'))->withInput($request->all());
        }
        Country::create($creation);
        return redirect()->back()->with('success', translate('created successfully'));
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
    public function edit(Country $country)
    {
        $this->authorize('countries.edit');
        return view('countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $this->authorize('countries.edit');
        $creation =  [
            'name' => $request->name,
            'code' => $request->code,
        ];
        if($request->has('active')) {
            $creation['active'] = 1;
        } else {
            $creation['active'] = 0;
        }
        $rules = [
            'name' => ['required','string',Rule::unique('countries', 'name')->ignore($country->id)]
        ];
        $messages = [
            'name.required' => translate('the name is required'),
            'name.unique' => translate('you should choose a name is not exists')
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', translate('there is something error'))->withInput($request->all());
        }
        $country->update($creation);
        return redirect()->back()->with('info', translate('updated successfully'));
    }

    public function allCities(Request $request) {
        $cities = City::where('country_id', $request->country_id)->get();
        if($cities) {
            return response()->json(['status' => true, 'data' => $cities]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        $this->authorize('countries.destroy');
        Country::destroy($country->id);
        return redirect()->back()->with('error', translate('deleted successfully'));
    }
}
