<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Category;
use App\Traits\File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{

    use File;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('categories.index');
        Carbon::setLocale('ar');
        if(Auth::user()->type == 'admin') {
            $categories = Category::latest();
        } else {
            $categories = Category::where('branch_id', Auth::user()->branch_id)->latest();
        }
        $branches = Branch::orderBy('name')->get();
        if($request->name) {
            $categories->where('name', 'like', '%' . $request->name . '%');
        }
        if($request->branch_id) {
            $categories->where('branch_id', 'like', '%' . $request->branch_id . '%');
        }
        $categories = $categories->paginate(10);
        return view('categories.index', compact('categories', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('categories.create');
        $branches = Branch::orderBy('name')->get();
        if(count($branches) > 0) {
            return view('categories.create', compact('branches'));
        } else {
            return redirect()->back()->with('error', 'يجب أنشاء فروع أولا');

        }
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
            'branch_id' => 'required|exists:branches,id'
        ], [
            'name.required' => 'الأسم مطلوب',
            'branch_id.required' => 'الفرع مطلوب',
            'branch_id.exists' => 'الفرع يجب ان يكون موجود'

        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all())->with('error', 'يوجد خطأ ما');
        }
        $creation = [
            'name' => $request->name,
            'branch_id' => $request->branch_id,
            'viewed_number' => $request->viewed_number
        ];
        if($request->active) {
            $creation['active'] = 1;
        } else {
            $creation['active'] = 0;
        }
        if($request->has('photo')) {
            $creation['photo'] = $this->uploadFile($request, $this->categoriesPath, 'photo');
        }
        Category::create($creation);
        return redirect()->back()->with('success', 'تم انشاء الصنف بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $this->authorize('categories.show');
        return view('categories.show', compact('category'));
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
        $branches = Branch::orderBy('name')->get();

        return view('categories.edit', compact('category', 'branches'));
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
            'name' => ['required'],
            'branch_id' => 'required|exists:branches,id'
        ], [
            'name.required' => 'الأسم مطلوب',
            'branch_id.required' => 'الفرع مطلوب',
            'branch_id.exists' => 'الفرع يجب ان يكون موجود'
        ]);
        $updateTable = [
            'name' => $request->name,
            'branch_id' => $request->branch_id,
            'viewed_number' => $request->viewed_number
        ];
        if($request->active) {
            $updateTable['active'] = 1;
        } else {
            $updateTable['active'] = 0;
        }
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all())->with('error', 'يوجد خطأ ما');
        }
        if($request->has('photo')) {
            $updateTable['photo'] = $this->uploadFile($request, $this->categoriesPath, 'photo');
            if(file_exists($category->photo)) {
                $img = last(explode('/', $category->photo));
                if(in_array($img, scandir(dirname($category->photo)))) {
                    unlink($category->photo);
                }
            }
        }
        $category->update($updateTable);
        return redirect()->back()->with('info', 'تم تعديل الصنف بنجاح');
    }


    public function allCategories(Request $request) {
        $categories = Category::where('branch_id', $request->branch_id)->orderBy('name')->get();
        if($categories) {
            return response()->json(['status' => true, 'data' => $categories]);
        } else {
            return response()->json(['status' => false, 'data' => []]);
        }
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
        if(file_exists($category->photo)) {
            $img = last(explode('/', $category->photo));
            if(in_array($img, scandir(dirname($category->photo)))) {
                unlink($category->photo);
            }
        }
        Category::destroy($category->id);
        return redirect()->back()->with('success', 'تمت ازالة ' . $category->name . ' بنجاح');
    }
}
