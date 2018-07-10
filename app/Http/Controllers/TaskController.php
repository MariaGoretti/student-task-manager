<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\add_tasks;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

class TaskController extends Controller
{
     public function add(Request $req)
	{
	
		$title = $req->input('title');
		$description=$req->input('description');
		$start_date=$req->input('start_date');
		$due_date=$req->input('due_date');
		$sub_method=$req->input('sub_method');

		$data = array(
			'title'=>$title, 
			'description'=>$description, 
			'start_date'=>$start_date, 
			'due_date'=>$due_date, 
			'sub_method'=>$sub_method
			);

		DB::table('add_tasks')->insert($data);

		echo "<script type='text/javascript'>alert('Task Addded')</script>";
		echo "<script>setTimeout(\"location.href = '/add';\",1000);</script>";
	}

	public function all(Request $req)
    {
    	$data = add_tasks::all();
        return $data;

    }
}
