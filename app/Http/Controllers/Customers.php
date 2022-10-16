<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Customers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $customers = DB::table('customers')->get();
        return ['customers'=>$customers];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //"Amena Hyde","ante@icloud.couk","$32.60"
        $name = 'Amena Hyde';
        $email = 'ante@icloud.couk';
        $picture = '1.png';
        $currency = '$';
        $balance = '32.60';
        $data = array('name' => $name, "email" => $email, "picture" => $picture, "currency" => $currency, "balance" => $balance);
        DB::table('customers')->insert($data);
        return to_route('view-records');
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
        $customer = DB::select('select * from customers where id = ?', [$id]);
        return ['customer'=>$customer];
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
//         $source = $id;
        $sourceCustomer = DB::select('select * from customers where id = ?', [$id]);
        $targetCustomer = DB::select('select * from customers where id = ?', [$request->input('target')]);
        $balance = $request->input('balance');
//         dd($targetCustomer);
//         dd($sourceCustomer[0]->balance - (int)$balance);
//         dd($sourceCustomer[0]->balance);
        DB::update('update customers set balance = ? where id = ?', [$sourceCustomer[0]->balance - (int)$balance, $sourceCustomer[0]->id]);
        DB::update('update customers set balance = ? where id = ?', [$targetCustomer[0]->balance + (int)$balance, $targetCustomer[0]->id]);

        $data = array('source' => $id, "target" => $targetCustomer[0]->id, "money" => $balance);
        DB::table('transactions')->insert($data);

        $customers = DB::table('customers')->get();
        $transactions = DB::table('transactions')->get();

        return ['message'=>'Money Transferred Successfully', 'customers'=>$customers, 'transactions'=>$transactions];
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
}
