<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Students;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\StudentResource;

class StudentController extends Controller
{
	
    public function register()
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
 if(isset($_POST['firstname'])&&isset($_POST['lastname'])&&isset($_POST['username'])&&isset($_POST['email'])&&isset($_POST['phone'])&&isset($_POST['password'])){
//Check for mandatory parameters
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    
    //Query to insert a user
    $query = "INSERT INTO students(firstname, lastname, username, phone, email, password) VALUES (?,?,?,?,?,?)";
    //Prepare the query
    if($stmt = $con->prepare($query)){
        //Bind parameters
        $stmt->bind_param("ssis",$firstname,$lastname,$username, $phone, $email, $password);
        //Exceting MySQL statement
        $stmt->execute();

        //Check if data got inserted
        if($stmt->affected_rows == 1){
            $response["success"] = 1;           
            $response["message"] = "Registration Successful";           
            
        }else{
            //Some error while inserting
            $response["success"] = 0;
            $response["message"] = "Error while registering";
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



	public function login()
    {
    	  $loginArray = array();
$response = array();

if(isset($_POST['email'])&&isset($_POST['password'])){
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    
    $query = "SELECT email, password FROM students WHERE email=? && password=?";
    if($stmt = $con->prepare($query)){
        
        $stmt->bind_param("i",$email, $password);
        $stmt->execute();
        
        $stmt->bind_result($email,$password);
           
        if($stmt->fetch()){
        
            $loginArray["email"] = $email;
            $loginArray["password"] = $password;
            
            $response["success"] = 1;
            //$response["data"] = $loginArray;
        
        }else{
            
            $response["success"] = 0;
            $response["message"] = "Error: Either you haven't registered yet or have input an incorrect username or password";
        }
        $stmt->close();
 
 
    }else{
        //Whe some error occurs
        $response["success"] = 0;
        $response["message"] = mysqli_error($con);
        
    }
 
}else{
    
    $response["success"] = 0;
    $response["message"] = "Missing either email address or password";
}
//Display JSON response
echo json_encode($response);

}
