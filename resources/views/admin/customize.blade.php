@extends('admin/adminlayout')

@section('container')
    <a href="/customize/edit" type="button" class="btn btn-primary">Edit Template</a>
    <br><br>

    @foreach ($customize as $customize_theme)
        <div class="card">
            <h5 class="card-header">Title : {{ $customize_theme->title }}</h5>
            <div class="card-body">
                <p class="card-text"><b>Description : </b> {{ $customize_theme->description }}</p>
                <br>
            </div>
        </div>

        <br>
        <br>

        <div class="card-group">
            <div class="card">
                <img src="{{ asset('clients/images_upload/Banners/' . $customize_theme->image) }}"
                    class="card-img-top"alt="banner" height="675px">
                <div class="card-body">
                    <h5 class="card-title">Image</h5>
                    <p class="card-text">





                    </p>
                </div>

            </div>
        </div>
        </div>

        <br><br>
        <h1>Video</h1>
        <br>

        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="{{ $customize_theme->youtube_link }}" allowfullscreen></iframe>
        </div>

        <br>
        <br>



        <br>
        <br>
        <br>



        <div class="card mb-3">
            <img src="{{ asset('clients/images_upload/About_Us/' . $customize_theme->vd_image) }}" class="card-img-top"
                alt="...">
            <div class="card-body">
                <h5 class="card-title">Video Thumbnail</h5>
            </div>
        </div>
    @endforeach
@endsection()
