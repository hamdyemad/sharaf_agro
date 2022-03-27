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
        Carbon::setLocale(app()->getLocale());
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
            return redirect()->back()->with('error', translate('you should create category first'));

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
            'name.required' => translate('the name is required'),
            'branch_id.required' => translate('the branch is required'),
            'branch_id.exists' => translate('the branch should be exists')

        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all())->with('error', translate('there is something error'));
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
        return redirect()->back()->with('success', translate('created successfully'));
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
            'name.required' => translate('the name is required'),
            'branch_id.required' => translate('the branch is required'),
            'branch_id.exists' => translate('the branch should be exists')
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
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all())->with('error', translate('there is something error'));
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
        return redirect()->back()->with('info', translate('updated successfully'));
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
        return redirect()->back()->with('success', translate('deleted successfully'));
    }
}
