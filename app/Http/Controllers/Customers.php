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
    public function update($source, $target, $balance)
    {
        //
        $sourceCustomer = DB::select('select * from customers where id = ?', [$source]);
        $targetCustomer = DB::select('select * from customers where id = ?', [$target]);

        DB::update('update customers set balance = ? where id = ?', [$sourceCustomer.balance - $balance, $sourceCustomer]);
        DB::update('update customers set balance = ? where id = ?', [$targetCustomer.balance + $balance, $targetCustomer]);
//         $balance = $request->input('balance');
//         DB::update('update customers set balance = ? where id = ?', [$balance, $id]);
        return ['message'=>'Money Transferred Successfully'];
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
