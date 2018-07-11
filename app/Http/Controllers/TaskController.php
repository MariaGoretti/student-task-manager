<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Tasks;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\StudentResource;

class TaskController extends Controller
{
     public function add()
	{
	
		 define('DB_USER', "task_manager");
define('DB_PASSWORD', "student1");
define('DB_DATABASE', "task_manager");
define('DB_HOST', "db4free.net");
 
$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
 
// Check connection
if(mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
     $response = array();
 if(isset($_POST['title'])&&isset($_POST['description'])&&isset($_POST['start_date'])&&isset($_POST['due_date'])&&isset($_POST['sub_method'])){
//Check for mandatory parameters
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $due_date = $_POST['due_date'];
    $sub_method = $_POST['sub_method'];
    
    //Query to insert a user
    $query = "INSERT INTO add_tasks(title, description, start_date, due_date, sub_method) VALUES (?,?,?,?,?)";
    //Prepare the query
    if($stmt = $con->prepare($query)){
        //Bind parameters
        $stmt->bind_param("ssis",$first_name,$last_name,$email_address,$password);
        //Exceting MySQL statement
        $stmt->execute();

        //Check if data got inserted
        if($stmt->affected_rows == 1){
            $response["success"] = 1;           
            $response["message"] = "Task Successfully Added";           
            
        }else{
            //Some error while inserting
            $response["success"] = 0;
            $response["message"] = "Error while adding task";
        } }                  
    else{
        //Some error while inserting
        $response["success"] = 0;
        $response["message"] = mysqli_error($con);
}}else{
    //Mandatory parameters are missing
    $response["success"] = 0;
    $response["message"] = "Missing mandatory parameters";
}

//Displaying JSON response
echo json_encode($response);
}

	}

	public function all(Request $req)
    {
    	$data = Tasks::all();
        return $data;

    }
}
