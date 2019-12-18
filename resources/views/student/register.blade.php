@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Summer Camp Registration</div>

                    <div class="panel-body">

                    <form method="POST" enctype="multipart/form-data">
                        @if(\Illuminate\Support\Facades\Session::has('message'))
                            <p class="alert {{ \Illuminate\Support\Facades\Session::get('alert-class', 'alert-info') }}">{{ \Illuminate\Support\Facades\Session::get('message') }}</p>
                        @endif
                        <div class="alert alert-danger" style="display:none"></div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name<span style="color: red;">*</span></label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address<span style="color: red;">*</span></label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email"  required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="class" class="col-md-4 col-form-label text-md-right">Class</label>
                            <div class="col-md-6">
                                <input id="class" type="text" class="form-control" name="class" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>
                            <div class="col-md-6">
                                <textarea id="address" type="text" class="form-control" name="address"> </textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image_url" class="col-md-4 col-form-label text-md-right">Image</label>
                            <div class="col-md-6">
                                <input id="image_url" type="file" class="form-control" name="image_url"  >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password<span style="color: red;">*</span></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password"  required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password<span style="color: red;">*</span></label>

                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 ">
                                <button type="button" class="btn btn-primary pull-right" onclick="registerStudent()">  Register</button>
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
            formData.append('class',$('#class').val());
            formData.append('address',$('#address').val());
            formData.append('email',$('#email').val());
            formData.append('password_confirmation',$('#password_confirmation').val());
            formData.append('password',$('#password').val());



            $.ajax({
                method: "POST",
                url: "/student/register",
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
