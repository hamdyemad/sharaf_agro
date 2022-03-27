<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Permession;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Traits\File;
use App\Traits\Res;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    use File, Res;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('products.index');
        Carbon::setLocale(app()->getLocale());
        if(Auth::user()->type == 'admin') {
            $categories = Category::latest()->get();
            $products = Product::latest();
        } else {
            $categories = Category::where('branch_id', Auth::user()->branch_id)->latest()->get();
            $products = Product::whereHas('category', function($query) {
                return $query->where('branch_id', Auth::user()->branch_id);
            })->latest();
        }
        if($request->name) {
            $products->where('name', 'like', '%' . $request->name . '%');
        }
        if($request->description) {
            $products->where('description', 'like', '%' . $request->description . '%');
        }
        if($request->price) {
            $products->where('price', 'like', '%' . $request->price . '%');
        }
        if($request->category_id) {
            $products->where('category_id', 'like', '%' . $request->category_id . '%');
        }
        if($request->viewed_number) {
            $products->where('viewed_number', 'like', '%' . $request->viewed_number . '%');
        }
        if($request->discount) {
            $products->where('discount', 'like', '%' . $request->discount . '%');
        }
        if($request->active) {
            if($request->active == 'true') {
                $products->where('active', 1);
            } else {
                $products->where('active', 0);
            }
        }
        if($request->price_after_discount) {
            $products->where('price_after_discount', 'like', '%' . $request->price_after_discount . '%');
        }
        if($request->start && $request->end) {
            $start = date('Y-m-d', strtotime($request->start));
            $end = date('Y-m-d', strtotime($request->end));
            $products
            ->whereDate('created_at', '=', $start)
            ->whereDate('created_at', '<=', $end);
        }
        $products = $products->paginate(10);
        return view('categories.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('products.create');
        $branches = Branch::orderBy('name')->get();
        if(count($branches) > 0) {
            return view('categories.products.create', compact('branches'));
        } else {
            return redirect()->back()->with('error', translate('you should create branch first'));
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
        $this->authorize('products.create');
        $validator_array = [
            'name' => 'required',
            'branch_id' => 'required|exists:branches,id',
            'category_id' => ['required', 'exists:categories,id'],
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'discount' => 'regex:/^\d+(\.\d{1,2})?$/',
            'viewed_number' => 'integer',
        ];
        $validator_array_msgs = [
            'name.required' => translate('the name is required'),
            'branch_id.required' => translate('the branch is required'),
            'branch_id.exists' => translate('the branch should be exists'),
            'category_id.required' => translate('the category is required'),
            'category_id.exists' => translate('the category should be exists'),
            'price.required' => translate('the price is required'),
            'price.regex' => translate('the price should be a number'),
            'discount.regex' => translate('the discount should be a number'),
            'viewed_number.integer' => translate('the viewed number should be a number'),
        ];
        if(isset($request->extras_type)) {
            if($request->extras) {
                $validator_array['extras.*.variant'] = 'required';
                $validator_array['extras.*.price'] = 'required';
                $validator_array['extras.*.price'] = 'regex:/^\d+(\.\d{1,2})?$/';
                $validator_array_msgs['extras.*.variant.required'] = translate('the extra is required');
                $validator_array_msgs['extras.*.price.required'] = translate('the price is required');
                $validator_array_msgs['extras.*.price.regex'] = translate('the price should be a number');
            }
            if($request->sizes) {
                unset($validator_array['price']);
                unset($validator_array['discount']);
                $validator_array['sizes.*.variant'] = 'required';
                $validator_array['sizes.*.price'] = 'required';
                $validator_array['sizes.*.price'] = 'regex:/^\d+(\.\d{1,2})?$/';
                $validator_array['sizes.*.discount'] = 'regex:/^\d+(\.\d{1,2})?$/';
                $validator_array_msgs['sizes.*.variant.required'] = translate('the size is required');
                $validator_array_msgs['sizes.*.price.required'] = translate('the price is required');
                $validator_array_msgs['sizes.*.price.regex'] = translate('the price should be a number');
                $validator_array_msgs['sizes.*.discount.regex'] = translate('the discount should be a number');
            }
        }
        $validator = Validator::make($request->all(), $validator_array, $validator_array_msgs);
        $creation = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'discount' => $request->discount,
            'viewed_number' => $request->viewed_number,
            'price_after_discount' => ($request->price - $request->discount)
        ];
        if($request->has('active') && $request->active == 'on') {
            $creation['active'] = 1;
        } else {
            $updateArray['active'] = 0;
        }

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())
            ->withInput($request->all())
            ->with('error', translate('there is something error'));
        }
        if($request->has('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photos[] = $this->uploadFiles($photo, $this->productsPath);
            }
            $creation['photos'] = json_encode($photos);
        }
        if($request->sizes) {
            $creation['price'] = 0;
            $creation['discount'] = 0;
            $creation['price_after_discount'] = 0;
        }
        $product = Product::create($creation);
        if($request->extras) {
            foreach ($request->extras as $extra) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'type' => 'extra',
                    'variant' => $extra['variant'],
                    'price' => $extra['price'],
                    'price_after_discount' => $extra['price']
                ]);
            }
        }
        if($request->sizes) {
            foreach ($request->sizes as $size) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'type' => 'size',
                    'variant' => $size['variant'],
                    'price' => $size['price'],
                    'discount' => $size['discount'],
                    'price_after_discount' => ($size['price'] - $size['discount'])
                ]);
            }
        }
        return redirect()->back()->with('success', translate('created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $this->authorize('products.show');
        return view('categories.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->authorize('products.edit');
        $branches = Branch::orderBy('name')->get();
        if(count($branches) > 0) {
            return view('categories.products.edit', compact('product', 'branches'));
        } else {
            return redirect()->back()->with('error', translate('you should create branch first'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('products.edit');
        $updateArray = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'discount' => $request->discount,
            'viewed_number' => $request->viewed_number,
            'price_after_discount' => ($request->price - $request->discount)
        ];
        $validator_array = [
            'name' => ['required'],
            'branch_id' => 'required|exists:branches,id',
            'category_id' => ['required', 'exists:categories,id'],
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'discount' => 'regex:/^\d+(\.\d{1,2})?$/',
            'viewed_number' => 'integer',
        ];
        $validator_array_msgs = [
            'name.required' => translate('the name is required'),
            'branch_id.required' => translate('the branch is required'),
            'branch_id.exists' => translate('the branch should be exists'),
            'category_id.required' => translate('the category is required'),
            'category_id.exists' => translate('the category should be exists'),
            'price.required' => translate('the price is required'),
            'price.regex' => translate('the price should be a number'),
            'discount.regex' => translate('the discount should be a number'),
            'viewed_number.integer' => translate('the viewed number should be a number'),
        ];
        if(isset($request->extras_type)) {
            if($request->extras) {
                $validator_array['extras.*.variant'] = 'required';
                $validator_array['extras.*.price'] = 'required';
                $validator_array['extras.*.price'] = 'regex:/^\d+(\.\d{1,2})?$/';
                $validator_array_msgs['extras.*.variant.required'] = translate('the branch is required');
                $validator_array_msgs['extras.*.price.required'] = translate('the price is required');
                $validator_array_msgs['extras.*.price.regex'] = translate('the price should be a number');
            }
            if($request->sizes) {
                unset($validator_array['price']);
                unset($validator_array['discount']);
                $updateArray['price'] = 0;
                $updateArray['discount'] = 0;
                $validator_array['sizes.*.variant'] = 'required';
                $validator_array['sizes.*.price'] = 'required';
                $validator_array['sizes.*.price'] = 'regex:/^\d+(\.\d{1,2})?$/';
                $validator_array['sizes.*.discount'] = 'regex:/^\d+(\.\d{1,2})?$/';
                $validator_array_msgs['sizes.*.variant.required'] = translate('the size is required');
                $validator_array_msgs['sizes.*.price.required'] = translate('the price is required');
                $validator_array_msgs['sizes.*.price.regex'] = translate('the price should be a number');
                $validator_array_msgs['sizes.*.discount.regex'] = translate('the discount should be a number');
            }
        }
        $validator = Validator::make($request->all(), $validator_array, $validator_array_msgs);

        if($request->has('active') && $request->active == 'on') {
            $updateArray['active'] = 1;
        } else {
            $updateArray['active'] = 0;
        }

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())
            ->withInput($request->all())
            ->with('error', translate('there is something error'));
        }
        if($request->has('photos')) {
            // Remove Current Photo
            $this->removePhotos($product);
            // Upload New Photos
            foreach ($request->file('photos') as $photo) {
                $photos[] = $this->uploadFiles($photo, $this->productsPath);
            }
            $updateArray['photos'] = json_encode($photos);
        }
        $product->update($updateArray);
        ProductVariant::where('product_id', $product->id)->where('type', 'extra')->delete();
        ProductVariant::where('product_id', $product->id)->where('type', 'size')->delete();
        if($request->extras) {
            foreach ($request->extras as $extra) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'type' => 'extra',
                    'variant' => $extra['variant'],
                    'price' => $extra['price'],
                    'price_after_discount' => $extra['price']
                ]);
            }
        }
        if($request->sizes) {
            foreach ($request->sizes as $size) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'type' => 'size',
                    'variant' => $size['variant'],
                    'price' => $size['price'],
                    'discount' => $size['discount'],
                    'price_after_discount' => ($size['price'] - $size['discount'])
                ]);
            }
        }
        return redirect()->back()->with('info', translate('updated successfully'));
    }

    public function removePhotos(Product $product) {
        if($product->photos) {
            foreach (json_decode($product->photos) as $photo) {
                if(file_exists($photo)) {
                    unlink($photo);
                }
            }
        }
    }

    public function all_by_ids(Request $request) {
        $products = Product::with('variants')->whereIn('id', $request->ids)->get();
        return $request->json('data', $products);
    }

    public function allByBranchId(Request $request) {
        $products = Product::whereHas('category', function($query) use($request) {
            return $query->where('branch_id', $request['branch_id']);
        })->orderBy('name')->get();
        if(count($products) > 0) {
            return $this->sendRes('', true, $products);
        } else {
            return $this->sendRes(translate('there is no foods in the branch yet'), false);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('products.destroy');
        if($product->photos) {
            $this->removePhotos($product);
        }
        Product::destroy($product->id);
        return redirect()->back()->with('error', translate('deleted successfully'));
    }
}
