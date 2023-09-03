<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    function productPage(Request $request){
        return view('pages.dashboard.product-page');
    }

    function productCreate(Request $request){
        $user_id = $request->header('id');

        $img = $request->file('img');
        $time = time();
        $file_name = $img->getClientOriginalName();
        $image_name = "{$user_id}-{$time}-{$file_name}";
        $image_url = "uploads/{$image_name}";

        // File Upload 
        $img->move(public_path('uploads'), $image_name);

       return Product::create([
            'user_id'=>$user_id,
            'category_id'=>$request->input('category_id'),
            'name'=>$request->input('name'),
            'price'=>$request->input('price'),
            'unit'=>$request->input('unit'),
            'img'=>$image_url
        ]);
    }


    function productList(Request $request){
        $user_id = $request->header('id');

        return Product::where('user_id', '=', $user_id)->get();
    }


    function productDelete(Request $request){
        $user_id = $request->header('id');
        $product_id = $request->input('id');
        $filePath=$request->input('file_path');
        File::delete($filePath);

        Product::where('user_id', '=', $user_id)->where('id', '=', $product_id)->delete();

        return response()->json([
            'status'=>'Success',
            'messsage'=>'The item has been deleted'
        ]);

    }


    function productById(Request $request){
        $user_id = $request->header('id');
        $product_id = $request->input('id');

        return Product::where('id', '=', $product_id)->where('user_id', '=', $user_id)->first();
    }


    function productUpdate(Request $request){
        $user_id = $request->header('id');
        $product_id = $request->input('id');
        
        if($request->hasFile('img')){
            $img = $request->file('img');
            $time = time();
            $file_name = $img->getClientOriginalName();
            $image_name = "{$user_id}-{$time}-{$file_name}";
            $image_url = "uploads/{$image_name}";

            // File Upload 
            $img->move(public_path('uploads'), $image_name);
            // Old file delete
            $filePath=$request->input('file_path');
            File::delete($filePath);

            Product::where('id', '=', $product_id)->where('user_id', '=', $user_id)
            ->update([
                'name'=>$request->input('name'),
                'price'=>$request->input('price'),
                'unit'=>$request->input('unit'),
                'img'=>$image_url,
                'category_id'=>$request->input('category_id')
            ]);

            return response()->json([
                'status' => 'Success',
                'message'=>'The item has been updated'
            ]);


        }else{
            Product::where('id', '=', $product_id)->where('user_id', '=', $user_id)
            ->update([
                'name'=>$request->input('name'),
                'price'=>$request->input('price'),
                'unit'=>$request->input('unit'),
                'category_id'=>$request->input('category_id')
            ]);

            return response()->json([
                'status' => 'Success',
                'message'=>'The item has been updated without Img'
            ]);
        }
    }





}
