<?php

namespace App\Http\Controllers\Women;

use App\Http\Controllers\Controller;
use App\Models\Dress;
use App\Models\Product;
use App\Models\Rate;
use Illuminate\Http\Request;

class DressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dresses = Dress::query()->where('women',1)->orderBy('id', 'desc')->paginate(5);
        return response()->json($dresses,200);

    }

    /**
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

        $path = $request->file('image')->store('Women/dresses_images');
        $dress =  Product::query()->create([
            'name'=> $request->name,
            'price'=> $request->price,
            'description' => $request->description,
            'image'=> $path,
            'category_id'=>4,
            'women'=>1


        ]);
        if ($dress == null)
        {
            return response()->json($dress,500);
        }
        else
        {
            return response()->json($dress,200);
        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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
