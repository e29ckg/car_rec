<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// header("'Access-Control-Allow-Credentials', 'true'");
// header('Content-Type: application/javascript');
header("Content-Type: application/json; charset=utf-8");

include "../connect.php";
include "../function.php";

// $data = json_decode(file_get_contents("php://input"));


// The request is using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

$datas = array();
$datas_main = array();

    try{
        $sql = "SELECT pr.*
                FROM project AS pr 
                ORDER BY created_at DESC
                LIMIT 20";
        $query = $conn->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);

        if($query->rowCount() > 0){                        //count($result)  for odbc
            foreach($result as $rs){                

                $sql = "SELECT prt.*
                        FROM project_template AS prt                
                        WHERE prt.project_id = :id";
                $query = $conn->prepare($sql);
                $query->bindParam(':id',$rs->id, PDO::PARAM_INT);
                $query->execute();
                $res_template = $query->fetchAll(PDO::FETCH_OBJ);
                
                array_push($datas,array(
                    'id'    => $rs->id,
                    'year'  => $rs->year,
                    'name'  => $rs->name,
                    'detail' => $rs->detail,
                    'img'    => $rs->img,
                    'date_train'    => $rs->date_train,
                    'period'        => $rs->period,
                    'template'      => $res_template
                ));
            }

            http_response_code(200);
            echo json_encode(array('status' => true, 'message' => 'สำเร็จ', 'projects' => $datas));
            exit();
        }
     
        http_response_code(200);
        echo json_encode(array('status' => false, 'message' => 'ไม่พบข้อมูล ','projects' =>[]));
        exit();
    
    }catch(PDOException $e){
        http_response_code(200);
        echo json_encode(array('status' => false, 'message' => 'เกิดข้อผิดพลาด..' . $e->getMessage()));
        exit();
    }
}