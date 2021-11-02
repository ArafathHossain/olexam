<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StudentClass;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'desc')->get();

        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = StudentClass::orderBy('id', 'desc')->get();
        return view('admin.coupons.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|alpha_dash|unique:coupons,code',
            'type' => 'required',
            'date' => 'required|date',
            'user' => 'nullable|numeric',
            'min_buy' => 'nullable|numeric',
            'student_class_id' => 'nullable|numeric',
        ], [
            'type.required' => 'Please select coupon discount type'
        ]);
        if ($request->type == 'percent') {
            $request->validate([
                'discount' => 'required|numeric|min:1|max:100',
            ]);
        } else {
            $request->validate([
                'discount' => 'required|numeric',
            ]);
        }

        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->discount = $request->discount;
        $coupon->date = $request->date;
        $coupon->user = $request->user;
        $coupon->min_buy = $request->min_buy;
        $coupon->student_class_id = $request->student_class_id;
        $coupon->status = $request->status ? 1 : 0;
        $coupon->save();

        return redirect()->route('admin.coupons.index')->with('success', 'Data is successfully saved');
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
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        $classes = StudentClass::orderBy('id', 'desc')->get();
        return view('admin.coupons.edit', compact('coupon', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|alpha_dash|unique:coupons,code,' . $id,
            'type' => 'required',
            'date' => 'required|date',
            'user' => 'nullable|numeric',
            'min_buy' => 'nullable|numeric',
            'student_class_id' => 'nullable|numeric',
        ], [
            'type.required' => 'Please select coupon discount type'
        ]);
        if ($request->type == 'percent') {
            $request->validate([
                'discount' => 'required|numeric|min:1|max:100',
            ]);
        } else {
            $request->validate([
                'discount' => 'required|numeric',
            ]);
        }
    
        $coupon = Coupon::find($id);
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->discount = $request->discount;
        $coupon->date = $request->date;
        $coupon->user = $request->user;
        $coupon->min_buy = $request->min_buy;
        $coupon->student_class_id = $request->student_class_id;
        $coupon->status = $request->status ? 1 : 0;
        $coupon->save();

        return redirect()->route('admin.coupons.index')->with('success', 'Data is successfully saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Coupon::findOrFail($id);
        $destroy->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Data is successfully deleted');
    }
}
