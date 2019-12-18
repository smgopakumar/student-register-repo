@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            @guest
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Welcome</div>

                        <div class="panel-body">


                        </div>
                    </div>
                </div>
            @else

                    @if(\Illuminate\Support\Facades\Auth::user()->user_type_id == 2)
                        <div class="col-md-10">
                            <div class="panel panel-default">
                                <div class="panel-heading">Student List</div>

                                <div class="panel-body">
                                    @if(\Illuminate\Support\Facades\Session::has('message'))
                                        <p class="alert {{ \Illuminate\Support\Facades\Session::get('alert-class', 'alert-info') }}">{{ \Illuminate\Support\Facades\Session::get('message') }}</p>
                                    @endif
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th class="col-md-2">Name</th>
                                            <th class="col-md-1">Class</th>
                                            <th class="col-md-2">Address</th>
                                            <th class="col-md-2">Email</th>
                                            <th class="col-md-2">Image</th>
                                            <th class="col-md-2">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($students as $student)

                                            <tr>
                                                <td>{{$student->name}}</td>
                                                <td>{{$student->class}}</td>
                                                <td>{{$student->address}}</td>
                                                <td>{{$student->email}}</td>
                                                <td><img src="{{asset($student->image_url)}}" style="width: 70%;"></td>
                                                <td>
                                                    @if($student->registration_status == 0)
                                                        <button class="btn btn-success" onclick="changeRegStatus(1,'{{$student->id}}')">Select</button>
                                                        <button  class="btn btn-danger" onclick="changeRegStatus(2,'{{$student->id}}')">Reject</button>
                                                    @elseif($student->registration_status == 1)
                                                        <button  class="btn btn-danger" onclick="changeRegStatus(2,'{{$student->id}}')">Reject</button>
                                                    @elseif($student->registration_status == 2)
                                                        <button class="btn btn-success" onclick="changeRegStatus(1,'{{$student->id}}')">Select</button>
                                                    @endif
                                                </td>
                                            </tr>

                                        @endforeach

                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div>
                    @else
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel panel-default">
                                <div class="panel-heading">Welcome</div>

                                <div class="panel-body">


                                </div>
                            </div>
                        </div>
                    @endif
            @endguest

        </div>
    </div>

    <script>
        function changeRegStatus(status,id){

            $.ajax({
                method: "GET",
                url: "/student/changeStatus",
                data: {'status':status,'id':id},

                success: function (data, status, jqXHR) {
                        location.reload();

                },
                error: function (data, status, err) {

                },});



        }
    </script>
@endsection
