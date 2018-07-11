<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\students;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

class StudentController extends Controller
{
    protected $database = 'students';
	
    public function register(Request $req)
	{
		/*$validate = $request->validate([
        'firstname'=>'required',
        'lastname'=>'required',
        'username'=>'required',
        'email'=>'required',
        'phone'>'required',
        'password'=>'required',
		]);*/

		$firstname = $req->input('firstname');
		$lastname=$req->input('lastname');
		$username=$req->input('username');
		$email=$req->input('email');
		$phone=$req->input('phone');
		$password=$req->input('password');

		$data = array(
			'firstname'=>$firstname, 
			'lastname'=>$lastname, 
			'email'=>$email, 
			'username'=>$username, 
			'phone'=>$phone,
			'password'=>$password
			);

		DB::table('students')->insert($data);
	}

	public function login(Request $req)
    {
        
        $email=$req['email'];
        $password=$req['password'];

        $students = students::where('email',$email)->firstOrFail();

        if(Hash::check($password, $students->password))
        {
            return $students->toJson();
        }
        return null;
    }

}
