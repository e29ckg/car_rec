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
    $car = $data->car;  
    
    try{
        if ($car->act == 'insert') {
            if ($car->name == '') {
              http_response_code(200);
              echo json_encode(array('status' => false, 'message' => 'no car_name'));
              exit();
            }
          
            $sql = "INSERT INTO car (car.name) 
                    VALUES (:name)";
            $query = $conn->prepare($sql);
            $query->bindParam(':name', $car->name, PDO::PARAM_STR);
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
          
          

        if($car->act == 'update'){
          $id = $car->id;
          $name = $car->name;

          $sql = "UPDATE car 
                  SET 
                    car.name = :name
                  WHERE id = :id";   

          $query = $conn->prepare($sql);
          $query->bindParam(':name', $name, PDO::PARAM_STR);
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
              
         
        if($car->act == 'delete'){
            $id  = $car->id;

            // http_response_code(200);
            // echo json_encode(array('status' => true, 'message' => 'ok', 'data' => $id));
            // exit();

            $sql = "DELETE FROM car WHERE id = :id";
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



