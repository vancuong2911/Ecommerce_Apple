<?php

namespace App\Http\Controllers\Admins\Charges;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChargesController extends Controller
{
    public function charge()
    {

        $charges = DB::table('charges')->get();


        return view('admin.charges', compact('charges'));
    }
    public function add_charge()
    {
        return view('admin.add_charge');
    }
    public function add_charge_process(Request $req)
    {

        $data = array();

        $data['name'] = $req->name;
        $data['price'] = $req->price;




        $price = $req->price;

        if ($price < 0) {

            session()->flash('wrong', 'Negative price do not accepted !');
            return back();
        }


        $load = DB::table('charges')->Insert($data);



        session()->flash('success', 'Charge added successfully !');

        return back();
    }
    public function delete_charge($id)
    {


        $delete = DB::table('charges')->where('id', $id)->delete();

        session()->flash('success', 'Charge deleted successfully !');

        return back();
    }
    public function edit_charge($id)
    {

        $charge = DB::table('charges')->where('id', $id)->get();



        return view('admin.edit_charge', compact('charge'));
    }
    public function edit_charge_process($id, Request $req)
    {

        $data = array();

        $data['name'] = $req->name;
        $data['price'] = $req->price;




        $price = $req->price;

        if ($price < 0) {

            session()->flash('wrong', 'Negative price do not accepted !');
            return back();
        }


        $load = DB::table('charges')->where('id', $id)->Update($data);



        session()->flash('success', 'Charge updated successfully !');

        return back();
    }
}
