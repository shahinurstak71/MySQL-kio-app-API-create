<?php

header('content-type: application/json');

$request = $_SERVER['REQUEST_METHOD'];


switch($request)
{

    case 'GET':
        getmethod();
   
        break;
    case 'POST':

        $data = json_decode(file_get_contents('php://input'), true);
      postmethod($data);
        break;
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);

        if(isset($data['id'])){
            $id = $data['id'];
            updatemethod($data, $id);
        } else {
            echo 'ID is not provided';
        }
        
         break;
    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);

        if(isset($data['id'])){
            $id = $data['id'];
            deletemethod($id);
        } else {
            echo 'ID is not provided';
        }
          break;
    default:
          echo 'not found';
          break;
}

// this is a get method 
 function getmethod(){
    include "db.php";
    $sql = "SELECT * FROM  users";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        $rows = array();
        while($r = mysqli_fetch_assoc($result)){
            $rows["result"][] =$r;

        }
        echo json_encode($rows);
    }else{
        echo '{"no data found"}';
    }
    
 }

// this is a put method
function postmethod($data){
    include 'db.php';

    $name = $data['name'];
    $age = $data['age'];
    $school = $data['school'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (name, age, school) VALUES (?, ?, ?)");

    // Bind parameters (s = string, i = integer)
    $stmt->bind_param("sis", $name, $age, $school);

    // Execute the statement
    if($stmt->execute()){
        echo 'Data inserted';
    }else{
        echo 'Data not inserted: ' . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

// this is a update method

function updatemethod($data, $id){
    include 'db.php';

    $name = $data['name'];
    $age = $data['age'];
    $school = $data['school'];

    // Prepare the SQL statement for updating
    $stmt = $conn->prepare("UPDATE users SET name = ?, age = ?, school = ? WHERE id = ?");

    // Bind parameters (s = string, i = integer)
    $stmt->bind_param("sisi", $name, $age, $school, $id);

    // Execute the statement
    if($stmt->execute()){
        echo 'Data updated';
    }else{
        echo 'Data not updated: ' . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}


// delete method 

function deletemethod($id){
    include 'db.php';

    // Prepare the SQL statement for deleting a record
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");

    // Bind the `id` parameter (i = integer)
    $stmt->bind_param("i", $id);

    // Execute the statement
    if($stmt->execute()){
        echo 'Data deleted';
    }else{
        echo 'Data not deleted: ' . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}




?>