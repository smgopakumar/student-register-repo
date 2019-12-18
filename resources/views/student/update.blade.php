@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Profile Update</div>

                    <div class="panel-body">


                    <form method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        @if(\Illuminate\Support\Facades\Session::has('message'))
                            <p class="alert {{ \Illuminate\Support\Facades\Session::get('alert-class', 'alert-info') }}">{{ \Illuminate\Support\Facades\Session::get('message') }}</p>
                        @endif

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" required value="{{$student->name}}" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="class" class="col-md-4 col-form-label text-md-right">Class</label>
                                <div class="col-md-6">
                                    <input id="class" type="text" class="form-control" name="class" required value="{{$student->class}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>
                                <div class="col-md-6">
                                    <textarea id="address" type="text" class="form-control" name="address">{{$student->address}}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image_url" class="col-md-4 col-form-label text-md-right">Image</label>
                                <div class="col-md-6">
                                    <img src="{{asset($student->image_url)}}" style="width: 80%">
                                    <input id="image_url" type="file" class="form-control" name="image_url"  >

                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary pull-right" onclick="registerStudent()">  Update Profile</button>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function registerStudent() {

            $( ".alert-danger" ).empty();

            var formData = new FormData();

            formData.append('image_url', $('#image_url')[0].files[0]);
            formData.append('_token','{{ csrf_token() }}');
            formData.append('name',$('#name').val());
            formData.append('address',$('#address').val());
            formData.append('class',$('#class').val());

            $.ajax({
                method: "POST",
                url: "/student/register/update",
                processData: false,
                contentType: false,
                cache: false,
                data: formData,

                success: function (data, status, jqXHR) {

                    if(data.status == 1){

//                        $('#myModal').modal('toggle');
                        location.reload();

                    }else {

                        $.each(data.validation, function(key, value){
                            $('.alert-danger').show();
                            $('.alert-danger').append('<p>'+value+'</p>');
                        });

                    }

                },
                error: function (data, status, err) {

                },});


        }
    </script>
@endsection
