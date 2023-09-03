<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    function customerPageShow(Request $request){
        return view('pages.dashboard.customer-page');
    }


    function customerListDisplay(Request $request){
        $user_id = $request->header('id');

        return Customer::where('user_id', '=', $user_id)->get();       
    }


    function customerCreation(Request $request){
        try{
            $user_id = $request->header('id');

            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');

            $nCustomer = Customer::create([
                'name'=>$name,
                'email'=>$email,
                'phone'=>$phone,
                'user_id'=>$user_id,
            ]);

            return response()->json([
                'status'=>'success',
                'message'=>'Customer created successfully',
                'customer'=>$nCustomer
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'status'=>'fail',
                'message'=>'Request failed to create customer'
            ]);
        }
    }


    function customerUpdating(Request $request){
        try{
            $user_id = $request->header('id');
            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $customer_id = $request->input('id');

            Customer::where('id', '=', $customer_id)->where('user_id', '=', $user_id)
            ->update([
                'name'=>$name,
                'email'=>$email,
                'phone'=>$phone
            ]);

            return response()->json([
                'status'=>'success',
                'message'=>'Customer has been updated'
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'status'=>'fail',
                'message'=>'Request failed to update customer'
            ]);
        }
    }


    function customerDeleting(Request $request){
        $user_id = $request->header('id');
        $customer_id = $request->input('id');

        Customer::where('id', '=', $customer_id)->where('user_id', '=', $user_id)->delete();

        return response()->json([
            'status'=>'success',
            'message'=>'Customer has been deleted successfully'
        ]);
        
    }


    function showCustomerById(Request $request){
        $user_id = $request->header('id');
        $customer_id = $request->input('id');

        return Customer::where('id', '=', $customer_id)->where('user_id', '=', $user_id)->first();
    }






}
