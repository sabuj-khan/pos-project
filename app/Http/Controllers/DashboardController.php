<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function dashboardPage(){
        return view('pages.dashboard.dashboard-page');
    }


    function summeryReport(Request $request){
        $user_id = $request->header('id');

        $products = Product::where('user_id',$user_id)->count();
        $category= Category::where('user_id',$user_id)->count();
        $customers= Customer::where('user_id',$user_id)->count();
        $invoice = Invoice::where('user_id',$user_id)->count();

        $total=  Invoice::where('user_id',$user_id)->sum('total');
        $vat=  Invoice::where('user_id',$user_id)->sum('vat');
        $discount=  Invoice::where('user_id',$user_id)->sum('discount');
        $payable=  Invoice::where('user_id',$user_id)->sum('payable');

        return [
            'products'=>$products,
            'category'=>$category,
            'customers'=>$customers,
            'invoice'=>$invoice,
            'total'=>$total,
            'vat'=>$vat,
            'discount'=>$discount,
            'payable'=>$payable,
        ];


    }




















    
}
