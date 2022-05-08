<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\UserSubCategory;
use App\Traits\Res;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mpdf\Tag\Sub;

class SubCategoryController extends Controller
{

    use Res;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('categories.index');
        $categories = Category::all();
        $sub_categories = SubCategory::latest();
        if($request->name) {
            $sub_categories->where('name', 'like', '%' . $request->name . '%');
        }
        if($request->category_id) {
            $sub_categories->where('category_id', $request->category_id);
        }
        $sub_categories = $sub_categories->paginate(10);
        return view('categories.sub_categories.index', compact('sub_categories','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('categories.create');
        $categories = Category::all();
        return view('categories.sub_categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('categories.create');
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required|exists:categories,id'
        ], [
            'name.required' => 'أسم القسم مطلوب',
            'category_id.required' => 'القسم الرئيسى مطلوب',
            'category_id.exists' => 'القسم الرئيسى غير موجود',

        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all())->with('error', 'يوجد خطأ ما');
        }
        $creation = [
            'name' => $request->name,
            'category_id' => $request->category_id
        ];
        SubCategory::create($creation);
        return redirect()->to(route('sub_categories.index'))->with('success', 'تم انشاء القسم بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $sub_category)
    {
        $this->authorize('categories.edit');
        $categories = Category::all();
        return view('categories.sub_categories.edit', compact('categories', 'sub_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $sub_category)
    {
        $this->authorize('categories.edit');
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'category_id' => 'required|exists:categories,id'
        ], [
            'name.required' => 'أسم القسم مطلوب',
            'category_id.required' => 'القسم الرئيسى مطلوب',
            'category_id.exists' => 'القسم الرئيسى غير موجود',

        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all())->with('error', 'يوجد خطأ ما');
        }
        $creation = [
            'name' => $request->name,
            'category_id' => $request->category_id
        ];
        $sub_category->update($creation);
        return redirect()->back()->with('success', 'تم تعديل القسم بنجاح');
    }

    public function all(Request $request) {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'user' || $request->all) {
            $sub_categories = SubCategory::whereIn('category_id', $request->categories_ids)->get();
        } else {
            $user_sub_categories = UserSubCategory::where('user_id', Auth::id())->pluck('sub_category_id');
            $sub_categories = SubCategory::whereIn('id', $user_sub_categories)->whereIn('category_id', $request->categories_ids)->get();
        }
        return $this->sendRes('تم استرجاع البيانات ',true, $sub_categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $sub_category)
    {
        $this->authorize('categories.destroy');
        SubCategory::destroy($sub_category->id);
        return redirect()->back()->with('success', 'تم ازالة القسم بنجاح');
    }
}
