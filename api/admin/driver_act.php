<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=utf-8");

include "../connect.php";
include "../function.php";

$data = json_decode(file_get_contents("php://input"));

// The request is using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $datas = array();  
    $driver = $data->driver;     
     
    
    try{
        if ($driver->act == 'insert') {
            if ($driver->user_id == '') {
              http_response_code(200);
              echo json_encode(array('status' => 'error', 'message' => 'no driver_name'));
              exit();
            }
          
            $sql = "INSERT INTO car_driver (user_id) 
                    VALUES (:user_id)";
            $query = $conn->prepare($sql);
            $query->bindParam(':user_id', $driver->user_id, PDO::PARAM_INT);
            // $query->bindParam(':name', $driver->name, PDO::PARAM_STR);
            $query->execute();
          
            if ($query->rowCount() > 0) {
              http_response_code(200);
              echo json_encode(array('status' => 'success', 'message' => 'success'));
              exit();
            } else {
              http_response_code(200);
              echo json_encode(array('status' => 'error', 'message' => 'failed to insert data'));
              exit();
            }
        }
          
          

        if($driver->act == 'update'){
          $id = $driver->id;
          $user_id = $driver->user_id;
          // $name = $driver->name;
          $sql = "UPDATE car_driver 
                  SET 
                    user_id = :user_id          
                  WHERE id = :id";   

          $query = $conn->prepare($sql);
          $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
          // $query->bindParam(':name', $name, PDO::PARAM_STR);
          $query->bindParam(':id', $id, PDO::PARAM_INT);
          $query->execute();    

          
          if ($query->rowCount() > 0) {
            http_response_code(200);
            echo json_encode(array('status' => 'success', 'message' => 'success'));
            exit();
          } else {
            http_response_code(200);
            echo json_encode(array('status' => 'error', 'message' => 'failed to update data'));
            exit();
          }
                      
        }  
              
         
        if($driver->act == 'delete'){
            $id  = $driver->id;

            $sql = "DELETE FROM car_driver WHERE id = :id";
            $query = $conn->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            
            
            if ($query->rowCount() > 0) {
                http_response_code(200);
                echo json_encode(array('status' => 'success', 'message' => 'success'));
                exit();
              } else {
                http_response_code(200);
                echo json_encode(array('status' => 'error', 'message' => 'failed to delete data'));
                exit();
              }               
        }

        http_response_code(200);
        echo json_encode(array('status' => 'error', 'message' => 'ไม่มีการเปลี่ยนแปลง'));
        exit();  
        
        
    }catch(PDOException $e){
        http_response_code(200);
        echo json_encode(array('status' => 'error', 'message' => 'เกิดข้อผิดพลาด..' . $e->getMessage()));
        exit();
    }
}



