<?php

namespace App\Http\Controllers\Men;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rate;
use App\Models\Shirt;
use Illuminate\Http\Request;

class ShirtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $shirts = Shirt::query()->where('men',1)->orderBy('id', 'desc')->paginate(5);
        return response()->json($shirts,200);

    }

    /**~ئ
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
           'name'=>'required|min:3',
            'price' => 'required|numeric|min:0|not_in:0',
            'description' =>'required',
            'image'=>'required|image|mimes:jpeg,png,jpg'
        ]);

        $path = $request->file('image')->store('Men/shirts_images');
        $shirt =  Product::query()->create([
           'name'=> $request->name,
            'price'=> $request->price,
            'description' => $request->description,
            'image'=> $path,
            'category_id'=>1,
            'men'=>1


        ]);
        if ($shirt == null)
        {
            return response()->json($shirt,500);
        }
        else
        {
            return response()->json($shirt,200);
        }

//
//        $shirt = new Shirt();
//        $shirt->name = $request->name;
//        $shirt->price = $request->price;
//        $shirt->description = $request->description;
//        $shirt->image = $path;
//        $shirt->rating = 0;
//        $shirt->rating_number = 0;
//        if ($shirt->save())
//        {
//            return response()->json($shirt,200);
//        }else{
//            return $request;
////            return response()->json($shirt,500);
//        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shirt  $shirt
     * @return \Illuminate\Http\Response
     */
    public function show(Shirt $shirt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shirt  $shirt
     * @return \Illuminate\Http\Response
     */
    public function edit(Shirt $shirt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shirt  $shirt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shirt $shirt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shirt  $shirt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shirt $shirt)
    {
        //
    }
    public function addRating(Request $request,$id)
    {
        $request->validate([
            'rating'=>'required',
        ]);
        $shirtRating = Product::query()->where('id',$id);
        $old_rating = $shirtRating->first();
        Rate::query()->create([
            'rate' => $request->rating,
            'product_id'=>$id
        ]);
        $newRatingNumber = $old_rating->rating_number+1;
        $total_rating = 0;
        if ($old_rating->rating_number == 0)
        {
            $total_rating = $request->rating;

        }else
        {
            $rates = Rate::query()->where('product_id',$id)->get();
            foreach ($rates as $rate)
            {
                $total_rating = $total_rating + $rate->rate;
            }

        }
        $avarageRate = $total_rating/$newRatingNumber;



        $shirtRating->update([
            'rating'=>$avarageRate,
            'rating_number'=>$newRatingNumber
        ]);
        if ($shirtRating)
        {
            return response()->json($shirtRating,200);
        }
        else
        {
            return response()->json($shirtRating,500);
        }
    }
}
