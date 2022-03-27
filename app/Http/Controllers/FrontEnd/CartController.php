<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\Res;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use function GuzzleHttp\Promise\all;

class CartController extends Controller
{

    use Res;

    function index(Request $request) {
        return view('frontend.cart');
    }

    function addToCart(Request $request) {
        unset($request['_token']);
        $product = Product::find($request['product_id']);
        if($product) {
            $total_price = [];
            if($request['size_id']) {
                array_push($total_price, $product->variants->find($request['size_id'])->price_after_discount * $request['size_amount']);
            }
            if($request['extra_id']) {
                array_push($total_price, $product->variants->find($request['extra_id'])->price_after_discount * $request['extra_amount']);
            }

            if($request['size_id'] == null) {
                unset($request['size_id']);
                unset($request['size_name']);
                unset($request['size_amount']);
            }
            if($request['extra_id'] == null) {
                unset($request['extra_id']);
                unset($request['extra_name']);
                unset($request['extra_amount']);
            }

            if($request['amount']) {
                if($request['amount'] !== '0') {
                    array_push($total_price, $product['price_after_discount'] * $request['amount']);
                }
            }
            $total_price = array_reduce($total_price, function($acc, $curr) {return $acc + $curr;});
            $request['total_price'] = $total_price;
            if($request->session()->has('carts')) {
                $oldCarts = $request->session()->get('carts');
                if(is_array($oldCarts) && count($oldCarts) > 0) {
                    $current_branch = Product::find($oldCarts[array_key_first($oldCarts)]['product_id'])->category->branch;
                    $new_branch = Product::find($request['product_id'])->category->branch;
                    if($current_branch == $new_branch) {
                        foreach ($oldCarts as $index =>  $oldCart) {
                            if($oldCart['product_id'] == $request['product_id']) {
                                $oldCart['total_price'] += $total_price;
                                if($request['amount']) {
                                    if($request['amount'] !== '0') {
                                        $oldCart['amount'] += $request['amount'];
                                    }
                                }
                                if($request['extra_id']) {
                                    $current_extras['extra_id'] = $request['extra_id'];
                                    $current_extras['extra_name'] = $request['extra_name'];
                                    $current_extras['extra_amount'] = $request['extra_amount'];
                                    if(isset($oldCart['extras'])) {
                                        foreach ($oldCart['extras'] as $extraIndex => $extra) {
                                            if($extra['extra_id'] == $request['extra_id']) {
                                                $extra['extra_amount'] += $request['extra_amount'];
                                                $oldCart['extras'][$extraIndex] = $extra;
                                                session()->put("carts.$index", $oldCart);
                                            }
                                        }
                                        $finded = array_filter($oldCart['extras'], function($obj) use($request) {
                                            if($obj['extra_id'] == $request['extra_id']) {
                                                return $obj;
                                            }
                                        });
                                        if(count($finded) == 0) {
                                            array_push($oldCart['extras'], $current_extras);
                                            session()->put("carts.$index", $oldCart);
                                        }
                                    } else {
                                        $oldCart['extras'] = [];
                                        array_push($oldCart['extras'], $current_extras);
                                        session()->put("carts.$index", $oldCart);
                                    }
                                }
                                if($request['size_id']) {
                                    $current_sizes['size_id'] = $request['size_id'];
                                    $current_sizes['size_name'] = $request['size_name'];
                                    $current_sizes['size_amount'] = intval($request['size_amount']);
                                    if(isset($oldCart['sizes'])) {
                                        foreach ($oldCart['sizes'] as $sizeIndex => $size) {
                                            if($size['size_id'] == $request['size_id']) {
                                                $size['size_amount'] += $request['size_amount'];
                                                $oldCart['sizes'][$sizeIndex] = $size;
                                                session()->put("carts.$index", $oldCart);
                                            }
                                        }
                                        $finded = array_filter($oldCart['sizes'], function($obj) use($request) {
                                            if($obj['size_id'] == $request['size_id']) {
                                                return $obj;
                                            }
                                        });
                                        if(count($finded) == 0) {
                                            array_push($oldCart['sizes'], $current_sizes);
                                            session()->put("carts.$index", $oldCart);
                                        }
                                    } else {
                                        $oldCart['sizes'] = [];
                                        array_push($oldCart['sizes'], $current_sizes);
                                        session()->put("carts.$index", $oldCart);
                                    }
                                }
                                if(!$request['extra_id'] && !$request['size_id']) {
                                    session()->put("carts.$index", $oldCart);
                                }
                            }
                        }
                        $findedCartArray = array_filter($oldCarts, function($obj) use($request) {
                            if($obj['product_id'] == $request['product_id']) {
                                return $obj;
                            }
                        });
                        if(count($findedCartArray) == 0) {
                            if( $request['amount'] == '0') {
                                return redirect()->back()->with('error', 'يجب أن تضيف الأكلة أولا');
                            }
                            if($request['size_id']) {
                                $sizes = array();
                                $current_sizes['size_id'] = $request['size_id'];
                                $current_sizes['size_name'] = $request['size_name'];
                                $current_sizes['size_amount'] = $request['size_amount'];
                                array_push($sizes, $current_sizes);
                                $request['sizes'] = $sizes;
                                unset($request['size_id']);
                                unset($request['size_name']);
                                unset($request['size_amount']);
                                if(!$request['extra_id']) {
                                    unset($request['extra_id']);
                                    unset($request['extra_name']);
                                    unset($request['extra_amount']);
                                }
                            }
                            if($request['extra_id']) {
                                $extras = array();
                                $current_extras['extra_id'] = $request['extra_id'];
                                $current_extras['extra_name'] = $request['extra_name'];
                                $current_extras['extra_amount'] = $request['extra_amount'];
                                array_push($extras, $current_extras);
                                $request['extras'] = $extras;
                                unset($request['extra_id']);
                                unset($request['extra_name']);
                                unset($request['extra_amount']);
                            }
                            $request->session()->push('carts', $request->all());
                        }
                    } else {
                        return redirect()->back()->with('error', 'يجب أن يتم الشراء من فرع واحد');
                    }
                } else {
                    if( $request['amount'] == '0' && !$request['extra_id'] && !$request['size_id'] ||
                        $request['amount'] == '0' && $request['extra_id'] ||
                        !$request['extra_id'] && !$request['size_id'] && !$request['amount'] ||
                        $request['extra_id'] && !$request['amount'] && !$request['size_id']
                    ) {
                        return redirect()->back()->with('error', 'يجب أن تضيف الأكلة أولا');
                    }
                    $this->newProd($request);
                }
            } else {
                if( $request['amount'] == '0' && !$request['extra_id'] && !$request['size_id'] ||
                    $request['amount'] == '0' && $request['extra_id'] ||
                    !$request['extra_id'] && !$request['size_id'] && !$request['amount'] ||
                    $request['extra_id'] && !$request['amount'] && !$request['size_id']
                ) {
                    return redirect()->back()->with('error', 'يجب أن تضيف الأكلة أولا');
                }
                $this->newProd($request);
            }
            return redirect()->back()->with('success', 'تمت الأضافة الى عربة التسوق');
        } else {
            return $this->sendRes('يوجد خطأ ما', false);
        }
    }

    function newProd($request) {
        $carts = array();
        if($request['size_id']) {
            $sizes = array();
            $current_sizes['size_id'] = $request['size_id'];
            $current_sizes['size_name'] = $request['size_name'];
            $current_sizes['size_amount'] = $request['size_amount'];
            array_push($sizes, $current_sizes);
            $request['sizes'] = $sizes;
            unset($request['size_id']);
            unset($request['size_name']);
            unset($request['size_amount']);
        }
        if($request['extra_id']) {
            $extras = array();
            $current_extras['extra_id'] = $request['extra_id'];
            $current_extras['extra_name'] = $request['extra_name'];
            $current_extras['extra_amount'] = $request['extra_amount'];
            array_push($extras, $current_extras);
            $request['extras'] = $extras;
            unset($request['extra_id']);
            unset($request['extra_name']);
            unset($request['extra_amount']);
        }
        array_push($carts, $request->all());
        $request->session()->put('carts', $carts);
    }

    function updateCart(Request $request) {
        $carts = $request->session()->get('carts');
        foreach($carts as $index => $cart) {
            if($index == $request['data']['index']) {
                $product = Product::find($cart['product_id']);
                if($request['data']['name'] == 'amount') {
                    $cart['amount'] = intval($request['data']['amount']);
                    $cart['total_price'] =  $product->price_after_discount * $cart['amount'];
                } else {
                    $variantArray = explode('-', $request['data']['name']);
                    if($variantArray[0] == 'size') {
                        foreach ($cart['sizes'] as $sizeIndex => $size) {
                            if($variantArray[1] == $sizeIndex) {
                                $cart['total_price'] -=  $product->variants->find($size['size_id'])->price_after_discount * intval($size['size_amount']);
                                $size['size_amount'] = intval($request['data']['amount']);
                                $cart['total_price'] += $product->variants->find($size['size_id'])->price_after_discount * $size['size_amount'];
                                $cart['sizes'][$sizeIndex] = $size;
                            }
                        }
                    }
                    if($variantArray[0] == 'extra') {
                        foreach ($cart['extras'] as $extraIndex => $extra) {
                            if($variantArray[1] == $extraIndex) {
                                $cart['total_price'] -=  $product->variants->find($extra['extra_id'])->price_after_discount * intval($extra['extra_amount']);
                                $extra['extra_amount'] = intval($request['data']['amount']);
                                $cart['total_price'] += $product->variants->find($extra['extra_id'])->price_after_discount * $extra['extra_amount'];
                                $cart['extras'][$extraIndex] = $extra;
                            }
                        }
                    }
                }
                $request->session()->put("carts.$index", $cart);
                return $this->sendRes('تم التعديل بنجاح', true);
            }
        }

    }

    function removeCart(Request $request) {
        $carts = $request->session()->get('carts');
        if($carts) {
            $request->session()->pull("carts.$request->index");
            return $this->sendRes('تمت الأزالة بنجاح', true);
        }
    }
}
