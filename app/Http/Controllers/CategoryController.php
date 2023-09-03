<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function categoryPage(){
        return view('pages.dashboard.category-page');
    }


    function categoryList(Request $request){
        $user_id = $request->header('id');
       $result = Category::where('user_id', '=', $user_id)->get();

       return $result;
    }

    function categoryCreate(Request $request){
        $user_id = $request->header('id');
        $name = $request->input('name');
       return Category::create([
            'name'=>$name,
            'user_id'=>$user_id
        ]);
    }


    function categoryUpdate(Request $request){
        $user_id = $request->header('id');
        $category_id = $request->input('id');

        Category::where('id', '=', $category_id)
        ->where('user_id', '=', $user_id)->update([
            'name'=>$request->input('name')
        ]);

        return response()->json([
            'status'=>'Success',
            'message'=>'The category has been updated successfully'
        ]);
    }


    function categoryById(Request $request){
        $user_id = $request->header('id');
        $category_id = $request->input('id');

        return Category::where('id', '=', $category_id)->where('user_id', '=', $user_id)->first();

         
    }

    function categoryDelete(Request $request){
        $user_id = $request->header('id');
        $category_id = $request->input('id');

        Category::where('id', '=', $category_id)
        ->where('user_id', '=', $user_id)->delete();

        return response()->json([
            'status'=>'Success',
            'message'=>'The category has been deleted successfully'
        ]);
    }









}
