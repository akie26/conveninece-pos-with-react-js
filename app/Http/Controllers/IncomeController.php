<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index(Request $request)
    {   
        if ($request->wantsJson()) {
        
            $payment = DB::table('payments')->whereDate('created_at', today())->get();
            return response($payment);
        }
        
        $payment = DB::table('payments')->whereDate('created_at', today())->get();

        return view('income.index')->with('pay', $payment);

        
    }

    public function net(Request $request)
    {   
        if ($request->wantsJson()) {
        
            $payment = DB::table('payments')->get();
            return response($payment);
        }
        return view('income.all');  
    }

    function fetch_data(Request $request)
        {
            if($request->ajax())
            {
                if($request->from_date != '' && $request->to_date != '')
                {
                    $data = DB::table('payments')
                            ->whereBetween('created_at', array($request->from_date, $request->to_date))
                            ->get();
                }else
                {
                    $data = DB::table('payments')->orderBy('created_at', 'desc')->get();
                }
                echo json_encode($data);
            }
        }   

    public function show($id)
    {   
        $id = DB::table('payments')->find($id);
        // $user = DB::table('payments')
        //         ->join('users', 'payments.user_id', '=' , 'users.id')
        //         ->select('users.id', 'users.name')
        //         ->get();
        // $detail = DB::table('order_items')
        //         ->join('products', 'order_items.products_id', '=', 'products.id')
        //         ->join('payments', 'order_items.sale_id', '=', 'payments.sale_id')
        //         ->select('products.name', 'order_items.*', 'payments.*')->get();
                return dd($id);
        // return view('income.detail', compact( 'user','id', 'detail'));
    }

    public function showall($id)
    {   
        $id = DB::table('payments')->find($id);
        // $user = DB::table('payments')
        //         ->join('users', 'payments.user_id', '=' , 'users.id')
        //         ->select('users.id', 'users.name')
        //         ->get();
        // $detail = DB::table('order_items')
        //         ->join('products', 'order_items.products_id', '=', 'products.id')
        //         ->join('payments', 'order_items.sale_id', '=', 'payments.sale_id')
        //         ->select('products.name', 'order_items.*', 'payments.*')->get();
                return dd($id);
        // return view('income.detail', compact( 'user','id', 'detail'));
    }


}
