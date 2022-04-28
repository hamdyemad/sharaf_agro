<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('categories.index');
        $categories = Category::latest();
        if($request->name) {
            $categories->where('name', 'like', '%' . $request->name . '%');
        }
        $categories = $categories->paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('categories.create');
        return view('categories.create');
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
            'name' => 'required|unique:categories,name',
        ], [
            'name.required' => 'أسم القسم مطلوب',
            'name.unique' => 'أسم القسم موجود بالفعل',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all())->with('error', 'يوجد خطأ ما');
        }
        $creation = [
            'name' => $request->name
        ];
        Category::create($creation);
        return redirect()->to(route('categories.index'))->with('success', 'تم انشاء القسم بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $this->authorize('categories.edit');

        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('categories.edit');
        $validator = Validator::make($request->all(), [
            'name' => ['required',Rule::unique('categories', 'name')->ignore('category')],
        ], [
            'name.required' => 'أسم القسم مطلوب',
            'name.unique' => 'أسم القسم موجود بالفعل',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all())->with('error', 'يوجد خطأ ما');
        }
        $creation = [
            'name' => $request->name
        ];
        $category->update($creation);
        return redirect()->back()->with('success', 'تم تعديل القسم بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->authorize('categories.destroy');
        Category::destroy($category->id);
        return redirect()->back()->with('success', 'تم ازالة القسم بنجاح');
    }
}
