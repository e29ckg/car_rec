<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// header("'Access-Control-Allow-Credentials', 'true'");
// header('Content-Type: application/javascript');
header("Content-Type: application/json; charset=utf-8");

include "../connect.php";
include "../function.php";

$data = json_decode(file_get_contents("php://input"));

// The request is using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$datas = array();
$datas_main = array();

    try{
        $id = $data->id;                               

        $sql = "SELECT pr.*
                FROM project AS pr 
                WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->bindParam(':id',$id, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        if($query->rowCount() > 0){                        //count($result)  for odbc
            
            http_response_code(200);
            echo json_encode(array('status' => true, 'message' => 'สำเร็จ', 'rep' => $result));
            exit();
        }
     
        http_response_code(200);
        echo json_encode(array('status' => false, 'message' => 'ไม่พบข้อมูล '));
        exit();
    
    }catch(PDOException $e){
        http_response_code(200);
        echo json_encode(array('status' => false, 'message' => 'เกิดข้อผิดพลาด..' . $e->getMessage()));
        exit();
    }
}