<?php

namespace App\Http\Controllers\Admins\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CustomersController extends Controller
{
    public function user_show()
    {

        $users = DB::table('users')->where('usertype', '=', '0')->get();


        return view('admin.users', compact('users'));
    }
}
