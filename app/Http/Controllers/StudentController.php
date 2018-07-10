<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\students;

class StudentController extends Controller
{
    protected $database = 'students';
	
    public function store(Request $request)
	{
		$validate = $request->validate([
        'firstname'=>'required',
        'lastname'=>'required',
        'username'=>'required',
        'email'=>'required',
        'phone'>'required',
        'password'=>'required',
		]);

		$firstname = $request->input('firstname');
		$lastname=$request->input('lastname');
		$username=$request->input('username');
		$email=$request->input('email');
		$phone=$request->input('phone');
		$password=$request->input('password');

		$data = array(
			'firstname'=>$firstname, 
			'lastname'=>$lastname, 
			'email'=>$email, 
			'username'=>$username, 
			'phone'=>$phone,
			'password'=>$password
			);

		DB::table('student')->insert($data);

		echo "<script type='text/javascript'>alert('Registration successful')</script>";
		echo "<script>setTimeout(\"location.href = '/register';\",1000);</script>";
	}

	public function login(Request $req)
    {
        
        $email=$req['email'];
        $password=$req['password'];

        $student = student::where('email',$email)->firstOrFail();

        if(Hash::check($password, $student->password))
        {
            return $student->toJson();
        }
        return null;
    }

}
