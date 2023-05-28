<?php

namespace App\Http\Controllers\Admins\Customize;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomizeController extends Controller
{
    public function customize()
    {
        $customize = DB::table('about_us')->get();
        return view('admin.customize', compact('customize'));
    }
    public function customize_edit()
    {

        $customize = DB::table('about_us')->get();

        return view('admin.customize_edit', compact('customize'));
    }
    public function edit_customize_process(Request $req)
    {

        $data = array();

        //return $req->description;


        $data['title'] = $req->title;
        $data['description'] = $req->description;
        $data['youtube_link'] = $req->youtube_video_link;


        if ($req->image != NULL) {

            $this->validate(request(), [

                'image' => 'mimes:jpeg,jpg,png',
            ]);


            $uploadedfile = $req->file('image');
            $new_image = rand() . '.' . $uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('clients/images_upload/Banners/'), $new_image);
            $data['image'] = $new_image;
        }

        if ($req->image2 != NULL) {

            $this->validate(request(), [

                'image' => 'mimes:jpeg,jpg,png',
            ]);


            $uploadedfile = $req->file('image');
            $new_image2 = rand() . '.' . $uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('clients/images_upload/About_Us/'), $new_image2);
            $data['iamge2'] = $new_image2;
        }

        $load = DB::table('about_us')->Update($data);



        session()->flash('success', 'Customize updated successfully !');

        return back();
    }
}
