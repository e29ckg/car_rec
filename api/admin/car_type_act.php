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
    $car_type = $data->car_type;  
    
     
    
    try{
        if ($car_type->act == 'insert') {
            if ($car_type->car_type_name == '') {
              http_response_code(200);
              echo json_encode(array('status' => false, 'message' => 'no car_type_name'));
              exit();
            }
          
            $sql = "INSERT INTO car_type (car_type_name) 
                    VALUES (:car_type_name)";
            $query = $conn->prepare($sql);
            $query->bindParam(':car_type_name', $car_type->car_type_name, PDO::PARAM_STR);
            $query->execute();
          
            if ($query->rowCount() > 0) {
              http_response_code(200);
              echo json_encode(array('status' => true, 'message' => 'success'));
              exit();
            } else {
              http_response_code(200);
              echo json_encode(array('status' => false, 'message' => 'failed to insert data'));
              exit();
            }
        }
          
          

        if($car_type->act == 'update'){
            $id      = $car_type->id;
            $name    = $car_type->name;
            $year    = $car_type->year;
            $date_train    = $car_type->date_train;
            $detail    = $car_type->detail;
            $period    = $car_type->period;

            $sql = "UPDATE car_type 
                    SET name =:name, 
                        year =:year, 
                        date_train = :date_train, 
                        detail = :detail, 
                        period = :period                         
                    WHERE id = :id";   

            $query = $conn->prepare($sql);
            $query->bindParam(':name',$name, PDO::PARAM_STR);
            $query->bindParam(':year',$year, PDO::PARAM_STR);
            $query->bindParam(':date_train',$date_train, PDO::PARAM_STR);
            $query->bindParam(':date_train',$date_train, PDO::PARAM_STR);
            $query->bindParam(':detail',$detail, PDO::PARAM_STR);
            $query->bindParam(':period',$period, PDO::PARAM_STR);
            $query->bindParam(':id',$id, PDO::PARAM_STR);
            $query->execute();    

            http_response_code(200);
            echo json_encode(array('status' => true, 'message' => 'ok', 'responseJSON' => $car_type));
            exit();                
        }  
              
         
        if($car_type->act == 'delete'){
            $id  = $car_type->id;

            // http_response_code(200);
            // echo json_encode(array('status' => true, 'message' => 'ok', 'data' => $id));
            // exit();

            $sql = "DELETE FROM car_type WHERE id =$id";
            $query->execute();
            
            if ($query->rowCount() > 0) {
                http_response_code(200);
                echo json_encode(array('status' => true, 'message' => 'success'));
                exit();
              } else {
                http_response_code(200);
                echo json_encode(array('status' => false, 'message' => 'failed to delete data'));
                exit();
              }               
        }

        http_response_code(200);
        echo json_encode(array('status' => false, 'message' => 'ไม่มีการเปลี่ยนแปลง'));
        exit();  
        
        
    }catch(PDOException $e){
        http_response_code(200);
        echo json_encode(array('status' => false, 'message' => 'เกิดข้อผิดพลาด..' . $e->getMessage()));
        exit();
    }
}



