<?php

namespace App\Http\Controllers\Admins\DeliveryBoys;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class DeliveryBoysController extends Controller
{
    public function delivery_boy()
    {

        $delivery_boys = DB::table('users')->where('usertype', '2')->get();


        return view('admin.delivery_boys', compact('delivery_boys'));
    }
    public function add_delivery_boy()
    {

        return view('admin.add_delivery_boy');
    }
    public function add_delivery_boy_process(Request $req)
    {


        $salary = $req->salary;

        if ($salary < 0) {

            session()->flash('wrong', 'Negative Salary do no accepted !');
            return back();
        }



        $email = DB::table('users')->where('email', $req->email)->count();


        if ($email > 0) {

            session()->flash('wrong', 'Email already registered !');
            return back();
        }

        $phone = DB::table('users')->where('phone', $req->phone)->count();


        if ($phone > 0) {

            session()->flash('wrong', 'Phone already registered !');
            return back();
        }
        if (strlen($req->password) < 8) {

            session()->flash('wrong', 'Password lenght at least 8 words!');
            return back();
        }

        if ($req->password != $req->confirm_password) {


            session()->flash('wrong', 'Password do not match !');
            return back();
        }

        $this->validate(request(), [

            'image' => 'mimes:jpeg,jpg,png',
        ]);


        $uploadedfile = $req->file('image');
        $new_image = rand() . '.' . $uploadedfile->getClientOriginalExtension();
        $uploadedfile->move(public_path('/assets/images/admin/'), $new_image);

        $data = array();
        $data['name'] = $req->name;
        $data['email'] = $req->email;
        $data['phone'] = $req->phone;
        $data['usertype'] = "2";
        $data['salary'] = $req->salary;
        $data['profile_photo_path'] = $new_image;
        $data['password'] = Hash::make($req->password);





        $insert = DB::table('users')->Insert($data);


        $details = [
            'title' => 'Mail from RMS Admin',
            'body' => 'Congrats ! You are selected as a Delivery Boy position ( Salary - ' . $req->salary . 'USD ) of RMS by RMS Admin Panel. Your Email ID - ' . $req->email . ' & Password - ' . $req->password,
        ];



        Mail::to($req->email)->send(new \App\Mail\UserAddedMail($details));


        session()->flash('success', 'Delivery Boy added successfully !');
        return back();
    }
    public function delete_delivery_boy($id)
    {



        $details = [
            'title' => 'Mail from RMS Admin',
            'body' => 'Sorry ! You have been fired from your job by RMS Admin Panel.So, your account is deleted by RMS Admin Panel.',
        ];



        Mail::to(Auth::user()->email)->send(new \App\Mail\UserAddedMail($details));

        $delete = DB::table('users')->where('id', $id)->delete();

        session()->flash('success', 'Delivery Boy deleted successfully !');
        return back();
    }
    public function edit_delivery_boy($id)
    {

        $delivery_boys = DB::table('users')->where('id', $id)->get();


        return view('admin.edit_delivery_boy', compact('delivery_boys'));
    }

    public function edit_delivery_boy_process(Request $req, $id)
    {

        $previous_salary = DB::table('users')->where('id', $id)->value('salary');

        if ($req->salary < 0) {

            session()->flash('wrong', 'Negative Salary do no accepted !');
            return back();
        }



        $email = DB::table('users')->where('email', $req->email)->where('id', '!=', $id)->count();


        if ($email > 0) {

            session()->flash('wrong', 'Email already registered !');
            return back();
        }

        $phone = DB::table('users')->where('phone', $req->phone)->where('id', '!=', $id)->count();


        if ($phone > 0) {

            session()->flash('wrong', 'Phone already registered !');
            return back();
        }


        $data = array();
        $data['name'] = $req->name;
        $data['email'] = $req->email;
        $data['phone'] = $req->phone;
        $data['salary'] = $req->salary;


        if ($req->image != NULL) {

            $this->validate(request(), [

                'image' => 'mimes:jpeg,jpg,png',
            ]);


            $uploadedfile = $req->file('image');
            $new_image = rand() . '.' . $uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/admin/'), $new_image);
            $data['profile_photo_path'] = $new_image;
        }




        $update = DB::table('users')->where('id', $id)->Update($data);

        if ($update) {
            $details = [
                'title' => 'Mail from RMS Admin',
                'body' => 'Congrats ! Your information is updated by RMS Admin Panel.',
            ];


            if (($req->salary != NULL && $req->salary > $previous_salary)) {


                $details = [
                    'title' => 'Mail from RMS Admin',
                    'body' => 'Congrats ! You are promoted for a  Delivery Boy position. ( Now, Your salary - ' . $req->salary . 'USD ) of RMS by RMS Admin Panel.',
                ];
            } else if (($req->salary != NULL && $req->salary < $previous_salary)) {


                $details = [
                    'title' => 'Mail from RMS Admin',
                    'body' => 'Sorry ! You are depromoted for a  Delivery Boy position. ( Now, Your salary - ' . $req->salary . 'USD ) of RMS by RMS Admin Panel.',
                ];
            }


            Mail::to($req->email)->send(new \App\Mail\UserAddedMail($details));


            session()->flash('success', 'Delivery Boy updated successfully !');
        } else {

            session()->flash('wrong', 'Already same info exits !');
        }


        return back();
    }
}
