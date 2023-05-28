<?php

namespace App\Http\Controllers\Admins\ListAdmins;


use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ListAdminController extends Controller
{
    public function admin_show()
    {
        $admins = DB::table('users')->where('usertype', '1')->get();

        return view('admin.admins', compact('admins'));
    }
    public function add_admin()
    {

        return view('admin.add_admin');
    }
    public function add_admin_process(Request $req)
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
        $data['usertype'] = $req->type;
        $data['salary'] = $req->salary;
        $data['profile_photo_path'] = $new_image;
        $data['password'] = Hash::make($req->password);


        if ($req->type == '1') {
            $usertype = "Super Admin";
        }

        $insert = DB::table('users')->Insert($data);


        $details = [
            'title' => 'Mail from MiniStore Admin',
            'body' => 'Congrats ! You are selected as a ' . $usertype . ' ( Salary - ' . $req->salary . 'USD ) of MiniStore by MiniStore Admin Panel. Your Email ID - ' . $req->email . ' & Password - ' . $req->password,
        ];



        Mail::to($req->email)->send(new \App\Mail\UserAddedMail($details));


        session()->flash('success', 'Admin added successfully !');
        return back();
    }
    public function delete_admin($id)
    {

        $my_id = NULL;

        if (Auth::user()->id == $id) {

            $my_id = "yes";
        }

        $details = [
            'title' => 'Mail from MiniStore Admin',
            'body' => 'Sorry ! You have been fired from your job by MiniStore Admin Panel.So, your account is deleted by MiniStore Admin Panel.',
        ];



        Mail::to(Auth::user()->email)->send(new \App\Mail\UserAddedMail($details));

        $delete = DB::table('users')->where('id', $id)->delete();


        if ($my_id == "yes") {

            return redirect::to('/login');
        }

        session()->flash('success', 'Admin deleted successfully !');
        return back();
    }

    public function edit_admin($id)
    {
        $admin = DB::table('users')->where('id', $id)->get();
        $image_logos = DB::table('users')->where('id', Auth::user()->id)->first();
        $image_logo = $image_logos->profile_photo_path;

        return view('admin.edit_admin', compact('admin', 'image_logo'));
    }
    public function edit_admin_process(Request $req, $id)
    {
        $user = DB::table('users')->where('id', Auth::user()->id)->first();
        $previous_salary = DB::table('users')->where('id', $id)->value('salary');
        $previous_position = DB::table('users')->where('id', $id)->value('usertype');

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
        $data['usertype'] = $req->type;
        $data['salary'] = $req->salary;
        $data['profile_photo_path'] = $req->file('image')->getClientOriginalName();

        if ($req->image != NULL) {

            $this->validate(request(), [

                'image' => 'mimes:jpeg,jpg,png',
            ]);
            $image_old_db = $user->profile_photo_path;
            $oldImagePath = 'assets/images/admins/' . $image_old_db;

            if (Storage::disk('public')->exists($oldImagePath)) {
                // Xóa tệp hình ảnh cũ
                Storage::disk('public')->delete($oldImagePath);
            }

            $uploadedfile = $req->file('image');
            $new_image = rand() . '.' . $uploadedfile->getClientOriginalExtension();
            $uploadedfile->storeAs('public/assets/images/admins', $new_image);
            $data['profile_photo_path'] = $new_image;
        }

        if ($req->type == '1') {

            $usertype = "Super Admin";
        }

        $update = DB::table('users')->where('id', $id)->Update($data);

        if ($update) {
            $details = [
                'title' => 'Mail from MiniStore Admin',
                'body' => 'Congrats ! Your information is updated by MiniStore Admin Panel.',
            ];

            if (($req->salary != NULL && $req->salary > $previous_salary) || ($req->type != NULL && $req->type < $previous_position)) {
                $details = [
                    'title' => 'Mail from MiniStore Admin',
                    'body' => 'Congrats ! You are promoted for a ' . $usertype . ' position. ( Now, Your salary - ' . $req->salary . 'Tk ) of MiniStore by MiniStore Admin Panel.',
                ];
            } else if (($req->salary != NULL && $req->salary < $previous_salary) || ($req->type != NULL && $req->type > $previous_position)) {


                $details = [
                    'title' => 'Mail from MiniStore Admin',
                    'body' => 'Sorry ! You are depromoted for a ' . $usertype . ' position. ( Now, Your salary - ' . $req->salary . 'Tk ) of MiniStore by MiniStore Admin Panel.',
                ];
            }


            Mail::to($req->email)->send(new \App\Mail\UserAddedMail($details));


            session()->flash('success', 'Admin updated successfully !');
        } else {

            session()->flash('wrong', 'Already same info exits !');
        }


        return back();
    }
}
