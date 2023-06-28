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
    $datas = [];
    $sql = "SELECT cd.*
            FROM car_driver AS cd";
    $query = $conn->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_OBJ);

    if($query->rowCount() > 0){                        //count($result)  for odbc
        foreach($result as $rs){
            $sql = "SELECT p.*
                    FROM profile AS p
                    WHERE id=:id";
            $query = $conn_main->prepare($sql);            
            $query->bindParam(':id', $rs->user_id, PDO::PARAM_INT);
            $query->execute();
            $res = $query->fetch(PDO::FETCH_OBJ);

            if($query->rowCount()){
                $datas[] = [
                    'id'=> $rs->id,
                    'user_id'=> $rs->user_id,
                    'name'=> $res->fname.$res->name.' '.$res->sname
                ];
            }

        }
        http_response_code(200);
        echo json_encode(array('status' => true, 'message' => 'สำเร็จ', 'data' => $datas));
        exit();
    }
    http_response_code(200);
    echo json_encode(array('status' => false, 'message' => 'ไม่พบข้อมูล ','data' => []));
    exit();
    
}
