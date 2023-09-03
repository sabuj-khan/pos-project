<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\InvoiceProduct;
use PhpParser\Node\Stmt\Foreach_;
use Illuminate\Support\Facades\DB;

class InvoiceControlller extends Controller
{

    function invoicePageDisplay(){
        return view('pages.dashboard.invoice-page');
    }


    function salePageInformationShow(){
        return view('pages.dashboard.sale-page');
    }

    function invoiceCreation(Request $request){
        DB::beginTransaction();

        try{
            $user_id = $request->header('id');
            $total = $request->input('total');
            $discount = $request->input('discount');
            $vat = $request->input('vat');
            $payable = $request->input('payable');
            $customer_id = $request->input('customer_id');

            $invoice = Invoice::create([
                'total'=>$total,
                'discount'=>$discount,
                'vat'=>$vat,
                'payable'=>$payable,
                'user_id'=>$user_id,
                'customer_id'=>$customer_id,
            ]);

            $invoiceId = $invoice->id;
            $userID = $invoice->user_id;
            $products = $request->input('products');

            foreach ($products as $eachProduct){
                InvoiceProduct::create([
                    'invoice_id'=>$invoiceId,
                    'user_id'=>$userID,
                    'product_id'=>$eachProduct['product_id'],
                    'qty'=>$eachProduct['qty'],
                    'sale_price'=>$eachProduct['sale_price'],
                ]);
            }

            // foreach ($products as $EachProduct) {
            //     InvoiceProduct::create([
            //         'invoice_id' => $invoiceId,
            //         'user_id'=>$user_id,
            //         'product_id' => $EachProduct['product_id'],
            //         'qty' =>  $EachProduct['qty'],
            //         'sale_price'=>  $EachProduct['sale_price'],
            //     ]);
            // }

            DB::commit();
            return response()->json([
                'status'=>'success',
                'message'=>'Request success to create new invoice'
            ]);
        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status'=>'fail',
                'message'=>'Request fail',
                'error'=>$e->getMessage()
            ]);
        }
    }


    function invoiceSelection(Request $request){
        $user_id = $request->header('id');

        return Invoice::where('user_id', '=', $user_id)->with('customer')->get();
    }


    function invoiceDetailFetch(Request $request){
        $user_id = $request->header('id');

        $invoiceTotal = Invoice::where('user_id', '=', $user_id)
        ->where('id', '=', $request->input('invoice_id'))->first();

        $customerDetail = Customer::where('user_id', '=', $user_id)
        ->where('id', '=', $request->input('customer_id'))->first();

        $invoiceProduct = InvoiceProduct::where('user_id', '=', $user_id)
        ->where('invoice_id', '=', $request->input('invoice_id'))->with('product')->get();

        return array(
            'invoice'=>$invoiceTotal,
            'customer'=>$customerDetail,
            'products'=>$invoiceProduct
        );
    }


    function invoiceDeleting(Request $request){
        DB::beginTransaction();
        try{
            $user_id = $request->header('id');

            InvoiceProduct::where('user_id', '=', $user_id)
            ->where('invoice_id', '=', $request->input('inv_id'))->delete();

            Invoice::where('id', '=', $request->input('inv_id'))
            ->where('user_id', '=', $user_id)->delete();

            Db::commit();

            return response()->json([
                'status'=>'success',
                'message'=>'Request success to delete invoice'
            ]);

        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status'=>'fail',
                'message'=>'Request fail to delete invoice',
                'error'=>$e->getMessage()
            ]);
        }
            

    }












}
