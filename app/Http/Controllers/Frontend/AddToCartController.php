<?php

namespace App\Http\Controllers\Frontend;

use Cart;
use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class AddToCartController extends Controller {

    // public function __construct()
    // {
    //     $this->middleware('auth', ['only' => ['add_to_cart']]);
    // }
    public function add_to_cart(Request $request)
    {
        $id = $request->id;
        $package = Package::find($id);
        if (!$package) {
            return back();
        }
        if (Cart::get($id)) {
            return redirect()->route('cart');
        }

        Cart::add(array(
            'id' => $package->id,
            'name' => $package->title,
            'price' => $package->sale_price ? $package->sale_price : 0,
            'quantity' => 1,
            'attributes' => [
                'photo' => $package->photo
            ],
            'associatedModel' => $package
        ));

        return redirect()->route('cart');

    }

    public function remove_cart(Request $request, $id)
    {
        $cart = Cart::get($id);
        if (!$cart) {
            return back();
        }
        Cart::remove($id);

        if (Cart::isEmpty()) {
            Cart::clearCartConditions();
        }

        return back();
    }

    public function empty_cart(Request $request)
    {
        Cart::clear();
        Cart::clearCartConditions();

        return redirect()->route('cart');
    }

    public function apply_coupon(Request $request)
    {
        $request->validate([
            'coupon' => 'required',
        ]);
        $code = $request->coupon;
        if ($coupon = Coupon::where('code', $code)->first()) {
            $coupon_validate = $coupon->date;
            $today_date = Carbon::now()->format('Y-m-d');
            if ($coupon->status == 1) {
                if (!empty($coupon->student_class_id)) {
                    if (Auth::user()->grad == $coupon->student_class_id) {
                        if ($today_date <= $coupon_validate) {
                            if ($coupon->min_buy <= Cart::getSubTotalWithoutConditions()) {
                                $coupon_discount = $coupon->discount;
                                if (empty($coupon->user)) {
                                    $condition = new \Darryldecode\Cart\CartCondition(array(
                                        'name' => 'coupon_code',
                                        'type' => 'coupon',
                                        'target' => 'subtotal',
                                        'value' => ($coupon->type == 'percent') ? '-' . $coupon_discount . '%' : '-' . $coupon_discount,
                                        'order' => 1
                                    ));
                                    Cart::condition($condition);
                                    $coupon->increment('coupon_use');
                                    Toastr::success('Great, enjoy discount 😃😃😃');

                                    return back();
                                } else {
                                    if ($coupon->coupon_use < $coupon->user) {
                                        $condition = new \Darryldecode\Cart\CartCondition(array(
                                            'name' => 'coupon_code',
                                            'type' => 'coupon',
                                            'target' => 'subtotal',
                                            'value' => ($coupon->type == 'percent') ? '-' . $coupon_discount . '%' : '-' . $coupon_discount,
                                            'order' => 1
                                        ));
                                        Cart::condition($condition);
                                        $coupon->increment('coupon_use');
                                        Toastr::success('Great, enjoy discount 😃😃😃');

                                        return back();
                                    } else {
                                        Toastr::error('Coupon has exceeded user limit!😢');

                                        return back();
                                    }
                                }
                            } else {
                                Toastr::error('Minimum buy ' . currency_type($coupon->min_buy) . ' then apply this coupon');

                                return back();
                            }
                        } else {
                            Toastr::error('Your coupon expired!😢');

                            return back();
                        }
                    } else {
                        Toastr::error('Your coupon for ' . ($coupon->class->name ?? "") . ' class!😢');

                        return back();
                    }
                } else {
                    if ($today_date <= $coupon_validate) {
                        if ($coupon->min_buy <= Cart::getSubTotalWithoutConditions()) {
                            $coupon_discount = $coupon->discount;
                            if (empty($coupon->user)) {
                                $condition = new \Darryldecode\Cart\CartCondition(array(
                                    'name' => 'coupon_code',
                                    'type' => 'coupon',
                                    'target' => 'subtotal',
                                    'value' => ($coupon->type == 'percent') ? '-' . $coupon_discount . '%' : '-' . $coupon_discount,
                                    'order' => 1
                                ));
                                Cart::condition($condition);
                                $coupon->increment('coupon_use');
                                Toastr::success('Great, enjoy discount 😃😃😃');

                                return back();
                            } else {
                                if ($coupon->coupon_use < $coupon->user) {
                                    $condition = new \Darryldecode\Cart\CartCondition(array(
                                        'name' => 'coupon_code',
                                        'type' => 'coupon',
                                        'target' => 'subtotal',
                                        'value' => ($coupon->type == 'percent') ? '-' . $coupon_discount . '%' : '-' . $coupon_discount,
                                        'order' => 1
                                    ));
                                    Cart::condition($condition);
                                    $coupon->increment('coupon_use');
                                    Toastr::success('Great, enjoy discount 😃😃😃');

                                    return back();
                                } else {
                                    Toastr::error('Coupon has exceeded user limit!😢');

                                    return back();
                                }
                            }
                        } else {
                            Toastr::error('Minimum buy ' . currency_type($coupon->min_buy) . ' then apply this coupon');

                            return back();
                        }
                    } else {
                        Toastr::error('Your coupon expired!😢');

                        return back();
                    }
                }
            } else {
                Toastr::error('Your coupon is no longer active!😢');

                return back();
            }
        } else {
            // return response(['error' => "Invalid  Coupon Code!"]);
            Toastr::error('Invalid  Coupon Code!😢');

            return back();
        }
    }

    // function for wishlist
    public function wish_list(Request $request)
    {
        $id = $request->id;
        if (!Package::find($id)) {
            Toastr::error('Something wrong try again!');

            return back();
        }
        $user = Auth::user();
        if (!$user) {
            Toastr::error('First, need to log in!');

            return back();
        } else {
            $is_wishlist = $user->my_wishlist()->where('package_id', $id)->count();
            if ($is_wishlist == 0) {
                $user->my_wishlist()->attach($id);
                Toastr::success('Successfully add to wishlist');

                return back();
            } else {
                $user->my_wishlist()->detach($id);
                Toastr::warning('Reomve from wishlist');

                return back();
            }
        }
    }

    public function remove_wishlist(Request $request)
    {
        $id = $request->id;
        $user = Auth::user();
        if ($user->my_wishlist()->where('package_id', $id)->exists()) {
            $user->my_wishlist()->detach($id);
            Toastr::warning('Reomve from wishlist');

            return back();
        } else {
            Toastr::error('The package was not found in your wishlist');

            return back();
        }
    }
}
