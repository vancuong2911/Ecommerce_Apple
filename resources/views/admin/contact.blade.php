@extends('admin/adminlayout')

@section('container')
    <div class="row ">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">contact Details</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> Name </th>
                                    <th> Email </th>
                                    <th> Phone</th>
                                    <th> Message </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $contact)
                                    <tr>
                                        <td>
                                            {{ $contact->name }}
                                        </td>
                                        <td>
                                            {{ $contact->email }}
                                        </td>
                                        <td>
                                            {{ $contact->phone }}
                                        </td>
                                        <td>
                                            {{ $contact->message }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection()
