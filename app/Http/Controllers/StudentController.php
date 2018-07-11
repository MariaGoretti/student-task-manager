<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Students;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\StudentResource;

class StudentController extends Controller
{
	
    public function register(Request $req)
	{
	    $firstname = $req['firstname'];
        $lastname = $req['lastname'];
        $email = $req['email'];
        $phone = $req['phone'];
        $username =$req['username'];
        $password = $req['password'];

        $student = new Students;
        $student->firstname =$firstname;
        $student->lastname = $lastname;
        $student->email = $email;
        $student->phone = $phone;
        $student->username =$username;
        $student->password = Hash::make($password);
        $student->save();

         return new StudentResource(
            $student
        );


	}

	public function login(Request $req)
    {
        
        $email=$req['email'];
        $password=$req['password'];

        $student = Students::where('email',$email)->firstOrFail();

        if(Hash::check($password, $student->password))
        {
            return $student->toJson();
        }
        return null;
    }

}
