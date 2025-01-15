<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Product;
use DB;
use Auth;
use Carbon\Carbon;

class ShoppingController extends Controller
{
    public function addTocartGet($id, Request $request)
    {
        $qty = 1;

        $product = Product::where(['id' => $request->id])->first();
        $productInfo = DB::table('products')->where('id', $id)->select('id', 'whole_sell_price', 'new_price', 'name', 'old_price', 'slug', 'purchase_price', 'advance')->first();
        $advance_amount = ($productInfo->new_price * $productInfo->advance) / 100;
        if ($productInfo->whole_sell_price != null) {
            $wholesell_price = $productInfo->whole_sell_price;
        } else {
            $wholesell_price = $productInfo->new_price;
        }
        $productImage = DB::table('productimages')->where('product_id', $id)->first();


        $cartinfo = Cart::instance('shopping')->add([
            'id' => $productInfo->id,
            'name' => $productInfo->name,
            'qty' => $qty,
            'price' => $productInfo->new_price,
            'options' => [
                'image' => $productImage->image,
                'old_price' => $productInfo->old_price,
                'slug' => $productInfo->slug,
                'purchase_price' => $productInfo->purchase_price,
                'whole_sell_price' => $wholesell_price,
                'reseller_price' => $wholesell_price,
                'advance' => $advance_amount,
                'seller_id' => $product->seller_id,

            ]
        ]);
        // return redirect()->back();
        return response()->json($cartinfo);
    }

    public function cart_show()
    {
        $data = Cart::instance('shopping')->content();
        // return $data;
        return view('frontEnd.layouts.pages.cart', compact('data'));
    }

    public function cart_store(Request $request)
    {
        $product = Product::where(['id' => $request->id])->first();
        $product_qty = $request->qty;
        if ($request->details_method == 'wholesell') {
            if (Auth::guard('customer')->user()) {
                if (Auth::guard('customer')->user()->seller_type != 0) {
                    $productPrice = $product->whole_sell_price;
                    $product_qty = $request->qty;

                } else {
                    $productPrice = $product->whole_sell_price;
                    $product_qty = max(5, $product_qty, $request->qty);
                }
            } else {
                $productPrice = $product->whole_sell_price;
                $product_qty = max(5, $product_qty, $request->qty);
            }
        } else {
            $productPrice = $product->new_price;
        }
        $advance_amount = ($product->new_price * $product->advance) / 100;


        if (Auth::guard('customer')->user()) {
            if (Auth::guard('customer')->user()->seller_type != 0) {
                // if (Auth::guard('customer')->user()->balance < 200) {
                //     Toastr::error('Your account balance low', 'Sorry!');
                //     return redirect()->back();
                // }
            }
            Cart::instance('shopping')->add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $product_qty,
                'price' => $productPrice,
                'options' => [
                    'slug' => $product->slug,
                    'image' => $product->image->image,
                    'old_price' => $product->new_price,
                    'purchase_price' => $product->purchase_price,
                    'product_size' => $request->product_size,
                    'product_color' => $request->product_color,
                    'pro_unit' => $request->pro_unit,
                    'seller_id' => $product->seller_id,
                    'proCommission' => $product->proCommission,
                    'product_code' => $product->proCode,
                    'whole_sell_price' => $productPrice,
                    'reseller_price' => $productPrice,
                    'advance' => $advance_amount,
                ],
            ]);
            Toastr::success('Product successfully add to cart', 'Success!');
            if ($request->add_to_cart) {
                return redirect()->back();
            }
            return redirect()->route('customer.checkout');
        } else {
            Cart::instance('shopping')->add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $product_qty,
                'price' => $productPrice,
                'options' => [
                    'slug' => $product->slug,
                    'image' => $product->image->image,
                    'old_price' => $product->new_price,
                    'purchase_price' => $product->purchase_price,
                    'product_size' => $request->product_size,
                    'product_color' => $request->product_color,
                    'pro_unit' => $request->pro_unit,
                    'seller_id' => $product->seller_id,
                    'proCommission' => $product->proCommission,
                    'product_code' => $product->proCode,
                    'whole_sell_price' => $productPrice,
                    'reseller_price' => $productPrice,
                    'advance' => $advance_amount,
                ],
            ]);
            Toastr::success('Product successfully add to cart', 'Success!');
            if ($request->add_to_cart) {
                return redirect()->back();
            }
            return redirect()->route('customer.checkout');
        }

    }

    // public function cart_store(Request $request)
    // {

    //     if ($request->order_now) {
    //         $product = Product::where(['id' => $request->id])->first();

    //         if ($request->details_method == 'wholesell') {
    //             if (Auth::guard('customer')->user()) {
    //                 if (Auth::guard('customer')->user()->seller_type != 0) {
    //                     $currentDate = Carbon::now()->format('Y-m-d');
    //                     if ($currentDate <= Auth::guard('customer')->user()->activation) {
    //                         $productPrice = $product->whole_sell_price;
    //                     } else {
    //                         Toastr::error('Your Reseller Activation has been revoked');
    //                         return redirect()->back();
    //                     }
    //                 } else {
    //                     Toastr::error('This is for only Whole sell customer . Please be our Whole sell Customer', 'Sorry!');
    //                     return redirect()->back();
    //                 }
    //             } else {
    //                 return redirect()->route('customer.login');
    //             }
    //         } else {
    //             $productPrice = $product->new_price;
    //         }
    //         $advance_amount = ($product->new_price * $product->advance) / 100;
    //         $testing = Cart::instance('shopping')->add([
    //             'id' => $product->id,
    //             'name' => $product->name,
    //             'qty' => $request->qty,
    //             'price' => $productPrice,
    //             'options' => [
    //                 'slug' => $product->slug,
    //                 'image' => $product->image->image,
    //                 'old_price' => $product->new_price,
    //                 'purchase_price' => $product->purchase_price,
    //                 'product_size' => $request->product_size,
    //                 'product_color' => $request->product_color,
    //                 'pro_unit' => $request->pro_unit,
    //                 'seller_id' => $product->seller_id,
    //                 'proCommission' => $product->proCommission,
    //                 'product_code' => $product->proCode,
    //                 'whole_sell_price' => $productPrice,
    //                 'reseller_price' => $productPrice,
    //                 'advance' => $advance_amount,
    //             ],
    //         ]);

    //         Toastr::success('Product successfully add to cart', 'Success!');

    //         return redirect()->route('customer.checkout');
    //     } elseif ($request->add_to_cart) {

    //         $product = Product::where(['id' => $request->id])->first();
    //         $product_qty = $request->qty;
    //         if ($request->details_method == 'wholesell') {
    //             if (Auth::guard('customer')->user()) {

    //                 $currentDate = Carbon::now()->format('Y-m-d');
    //                 $productPrice = $product->whole_sell_price;
    //                 if ($currentDate <= Auth::guard('customer')->user()->activation) {
    //                     $product_qty = $request->qty;
    //                 } else {
    //                     if ($product_qty >= 5) {
    //                         $product_qty = $request->qty;
    //                     } else {
    //                         $product_qty = 5;
    //                     }
    //                     //Toastr::error('Your Reseller Activation has been revokedtttttttt');
    //                     // return redirect()->back();
    //                 }
    //             } else {
    //                 return redirect()->route('customer.login');
    //             }
    //         } else {
    //             $productPrice = $product->new_price;
    //         }
    //         $advance_amount = ($product->new_price * $product->advance) / 100;
    //         $testing = Cart::instance('shopping')->add([
    //             'id' => $product->id,
    //             'name' => $product->name,
    //             'qty' => $product_qty,
    //             'price' => $product->new_price,
    //             'options' => [
    //                 'slug' => $product->slug,
    //                 'image' => $product->image->image,
    //                 'old_price' => $product->new_price,
    //                 'purchase_price' => $product->purchase_price,
    //                 'product_size' => $request->product_size,
    //                 'product_color' => $request->product_color,
    //                 'pro_unit' => $request->pro_unit,
    //                 'seller_id' => $product->seller_id,
    //                 'proCommission' => $product->proCommission,
    //                 'product_code' => $product->proCode,
    //                 'whole_sell_price' => $productPrice,
    //                 'reseller_price' => $productPrice,
    //                 'advance' => $advance_amount,
    //             ],
    //         ]);


    //         Toastr::success('Product successfully add to cart', 'Success!');
    //         return redirect()->back();
    //     }
    // }




    public function cart_remove(Request $request)
    {
        $remove = Cart::instance('shopping')->update($request->id, 0);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart', compact('data'));
    }
    public function cart_increment(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty + 1;
        $increment = Cart::instance('shopping')->update($request->id, $qty);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart', compact('data'));
    }
    public function cart_decrement(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty;
        if ($qty <= 5) {
            if (Auth::guard('customer')->check() && Auth::guard('customer')->user()->seller_type != 0) {
                $qty = max(0, $item->qty - 1);
            }
        } else {
            $qty = max(0, $item->qty - 1);
        }
        $decrement = Cart::instance('shopping')->update($request->id, $qty);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart', compact('data'));
    }
    // cartpage-start
    public function cart_remove_pg(Request $request)
    {
        $remove = Cart::instance('shopping')->update($request->id, 0);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cartpage', compact('data'));
    }
    public function cart_increment_pg(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty + 1;
        $increment = Cart::instance('shopping')->update($request->id, $qty);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cartpage', compact('data'));
    }
    public function cart_decrement_pg(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty;
        if ($qty <= 5) {
            if (Auth::guard('customer')->check() && Auth::guard('customer')->user()->seller_type != 0) {
                $qty = max(0, $item->qty - 1);
            }
        } else {
            $qty = max(0, $item->qty - 1);
        }
        $decrement = Cart::instance('shopping')->update($request->id, $qty);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cartpage', compact('data'));
    }
    // cartpage-end
    public function cart_count(Request $request)
    {
        $data = Cart::instance('shopping')->count();
        return view('frontEnd.layouts.ajax.cart_count', compact('data'));
    }
    public function mobilecart_qty(Request $request)
    {
        $data = Cart::instance('shopping')->count();
        return view('frontEnd.layouts.ajax.mobilecart_qty', compact('data'));
    }
    public function cart_remove_bn(Request $request)
    {
        $remove = Cart::instance('shopping')->update($request->id, 0);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart_bn', compact('data'));
    }
    public function cart_increment_bn(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty + 1;
        $increment = Cart::instance('shopping')->update($request->id, $qty);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart_bn', compact('data'));
    }
    public function cart_decrement_bn(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty - 1;
        $decrement = Cart::instance('shopping')->update($request->id, $qty);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart_bn', compact('data'));
    }
    public function product_size(Request $request)
    {
        // Find the product by ID
        $product = Product::where('id', $request->id)
            ->where('status', 1)
            ->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found or inactive.'], 404);
        }

        // Get the cart content
        $cart = Cart::instance('shopping')->content();

        // Find the item in the cart with the given product_id
        $item = $cart->firstWhere('id', $request->id);

        if (!$item) {
            return response()->json(['error' => 'Product not found in cart.'], 404);
        }

        // Update the cart item options based on the selected size
        $cartinfo = Cart::instance('shopping')->update($item->rowId, [
            'options' => [
                'slug' => $product->slug,
                'image' => $product->image->image ?? null, // if image exists
                'old_price' => $product->old_price,
                'purchase_price' => $product->purchase_price,
                'product_color' => $item->options->product_color,
                'product_size' => $request->product_size,
                'seller_id' => $product->seller_id,
            ]
        ]);

        // Get the updated cart content
        $data = Cart::instance('shopping')->content();

        // Return the updated cart view
        return view('frontEnd.layouts.ajax.cart_bn', compact('data'));
    }

    public function product_color(Request $request)
    {
        // Find the product by ID
        $product = Product::where('id', $request->id)
            ->where('status', 1)
            ->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found or inactive.'], 404);
        }

        // Get the cart content
        $cart = Cart::instance('shopping')->content();

        // Find the item in the cart with the given product_id
        $item = $cart->firstWhere('id', $request->id);

        if (!$item) {
            return response()->json(['error' => 'Product not found in cart.'], 404);
        }

        // Update the cart item options based on the selected size
        $cartinfo = Cart::instance('shopping')->update($item->rowId, [
            'options' => [
                'slug' => $product->slug,
                'image' => $product->image->image ?? null, // if image exists
                'old_price' => $product->old_price,
                'purchase_price' => $product->purchase_price,
                'product_color' => $request->product_color,
                'product_size' => $item->options->product_size,
                'seller_id' => $product->seller_id,
            ]
        ]);

        // Get the updated cart content
        $data = Cart::instance('shopping')->content();

        // Return the updated cart view
        return view('frontEnd.layouts.ajax.cart_bn', compact('data'));
    }

    // wishlist script
    public function wishlist_store(Request $request)
    {
        $product = Product::select('id', 'name', 'slug', 'old_price', 'new_price', 'purchase_price')->where(['id' => $request->id])->first();
        Cart::instance('wishlist')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $request->qty,
            'price' => $product->new_price,
            'options' => [
                'slug' => $product->slug,
                'image' => $product->image->image,
                'old_price' => $product->new_price,
                'purchase_price' => $product->purchase_price,
            ],
        ]);
        $data = Cart::instance('wishlist')->content();
        return response()->json('data');
    }
    public function wishlist_show()
    {
        $data = Cart::instance('wishlist')->content();
        return view('frontEnd.layouts.pages.wishlist', compact('data'));
    }
    public function wishlist_remove(Request $request)
    {
        $remove = Cart::instance('wishlist')->update($request->id, 0);
        $data = Cart::instance('wishlist')->content();
        return view('frontEnd.layouts.ajax.wishlist', compact('data'));
    }
    public function wishlist_count(Request $request)
    {
        $data = Cart::instance('wishlist')->count();
        return view('frontEnd.layouts.ajax.wishlist_count', compact('data'));
    }


    // compare product functions

    public function add_compare($id)
    {
        $qty = 1;
        $productInfo = DB::table('products')
            ->where('id', $id)
            ->first();
        $productImage = DB::table('productimages')
            ->where('product_id', $id)
            ->first();
        $compareinfo = Cart::instance('compare')->add([
            'id' => $productInfo->id,
            'name' => $productInfo->name,
            'qty' => $qty,
            'price' => $productInfo->new_price,
            'options' => ['image' => $productImage->image, 'description' => $productInfo->description],
        ]);
        return response()->json($compareinfo);
    }
    public function compare_content()
    {
        return view('frontEnd.layouts.ajax.comparecontent');
    }
    public function compare_product()
    {
        $compareproduct = Cart::instance('compare')->content();
        if ($compareproduct->count()) {
            return view('frontEnd.layouts.pages.compareproduct', compact('compareproduct'));
        } else {
            Toastr::info('You have no product in compare', 'Opps!');
            return redirect('/');
        }
    }
    public function compare_product_add($id, $rowId)
    {
        $totalProduct = Cart::instance('shopping')
            ->content()
            ->count();
        $qty = 1;
        $productInfo = DB::table('products')
            ->where('id', $id)
            ->first();
        $productImage = DB::table('productimages')
            ->where('product_id', $id)
            ->first();
        Cart::instance('shopping')->add([
            'id' => $productInfo->id,
            'name' => $productInfo->name,
            'qty' => $qty,
            'price' => $productInfo->new_price,
            'options' => [
                'image' => $productImage->image,
                'slug' => $productInfo->slug,
            ]
        ]);
        Toastr::success('product add to cart', 'successfully');
        Cart::instance('compare')->update($rowId, 0);
        return redirect()->back();
    }
    public function remove_compare(Request $request)
    {
        $compareproduct = Cart::instance('compare')->content();
        if ($compareproduct) {
            $rowId = $request->rowId;
            Cart::instance('compare')->update($rowId, 0);
            Toastr::success('Compare product remove successfully', 'successfully');
            return redirect()->back();
        } else {
            return redirect('/');
        }
    }
    public function resellerupdateCart(Request $request)
    {
        $rowId = $request->rowId;
        $resellamount = $request->resellamount;
        $productInfo = Cart::instance('shopping')->get($rowId);
        $product = Product::where('id', $productInfo->id)->first();
        $productImage = DB::table('productimages')->where('product_id', $productInfo->id)->first();
        if ($product->whole_sell_price <= $resellamount) {
            $resellprice = Cart::instance('shopping')->update($rowId, [
                'options' => [
                    'reseller_price' => $resellamount,
                    'image' => $productImage->image,
                    'slug' => $product->slug,
                    'purchase_price' => $product->purchase_price,
                    'whole_sell_price' => $product->whole_sell_price,
                    'seller_id' => $product->seller_id,
                ]
            ]);

            Toastr::success('Cart Updated successfully', 'Thanks');
            return redirect()->back();
        } else {
            Toastr::error('Reseller amount need to less than reguler price', 'Opps!');
            return redirect()->back();
        }
    }
}
