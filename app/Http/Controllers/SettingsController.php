<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{


    public function index(){
        $student = array();
        if(Auth::check()){
            if(Auth::user()->user_type_id == 2){
                  $student = User::where('user_type_id',1)->get();
            }
        }

        return view('welcome')->with('students',$student);
    }

    public function studentRegisterPage(){
        return view('student.register');
    }

    public function studentRegister(Request $request)
    {

        $rules = array(
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'image_url' => 'required',
            'password' => 'required|confirmed|min:6',
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response(['message' => 'validation issue', 'validation' => $validator->errors(),'status'=>0], 200);
        } else {
            $data = $request->all();
            $image_url = $request->file('image_url');
            if($image_url){
                $data['image_url'] = 'storage/'.Storage::disk('public')->put('uploads/student',$image_url);
            }
            $data['password'] = Hash::make($request->password);
            $user = User::create($data);

            if($user){
                Session::flash('message', 'Record successfully added! Go for login!!!');
                Session::flash('alert-class', 'alert-success');

                return response(['message' => 'successfully', 'status'=>1], 200);
            }
        }
    }

    public function studentRegisterUpdatePage(){
        $student = User::find(Auth::id());
        return view('student.update')->with('student',$student);
    }

    public function studentRegisterUpdate(Request $request)
    {

        $rules = array(
            'name' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response(['message' => 'validation issue', 'validation' => $validator->errors(),'status'=>0], 200);
        } else {
            $data = $request->all();

            $image_url = $request->file('image_url');
            if($image_url){
                $data['image_url'] = 'storage/'.Storage::disk('public')->put('uploads/student',$image_url);
            }

            unset($data['_token']);
            $user = User::where('id',Auth::id())->update($data);

            if($user){

                Session::flash('message', 'Record successfully updated!!');
                Session::flash('alert-class', 'alert-success');
                return response(['message' => 'successfully', 'status'=>1], 200);
            }else{
                Session::flash('message', 'Record not updated ! Try again..!');
                Session::flash('alert-class', 'alert-success');
                return response(['message' => 'trayu again', 'status'=>1], 200);
            }
        }
    }


    public function setLogin(Request $request)
    {
        $rules = array(
            'email' => 'required',
            'password' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors(['msg' => $validator->errors()->first(),'login_status' => 2]);
        } else {

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1], true)) {
                return redirect('/');

            } else {
                Auth::logout();
                return Redirect::back()->withErrors(['msg' => 'Invalid username or password','login_status' => 2]);
            }
        }
    }

    public function logOut(){
        Auth::logout();
        return redirect('/');
    }

    public function changeStatus(Request $request){

        $user = User::where('id',$request->id)->update(['registration_status'=>$request->status]);

        if($user){
            Session::flash('message', 'Record successfully updated!!');
            Session::flash('alert-class', 'alert-success');
            return response(['message' => 'successfully', 'status'=>1], 200);
        }else{

            Session::flash('message', 'Record not updated ! Try again..!');
            Session::flash('alert-class', 'alert-success');
            return response(['message' => 'successfully', 'status'=>0], 200);

        }

    }


}
