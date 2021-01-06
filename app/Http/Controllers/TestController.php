<?php

namespace App\Http\Controllers;

use App\Models\Shirt;
use App\Models\Test2;
use App\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|min:3',
            'price' => 'required|numeric|min:0|not_in:0',
            'description' =>'required',
            'image'=>'required|image|mimes:jpeg,png,jpg'
        ]);

        $path = $request->file('image')->store('shirts_images');
        $shirt =  Shirt::query()->create([
            'name'=> $request->name,
            'price'=> $request->price,
            'description' => $request->description,
            'image'=> $path,
            'rating'=> 0.0,
            'rating_number'=> 0

        ]);

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

}
