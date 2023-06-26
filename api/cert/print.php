<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// header("'Access-Control-Allow-Credentials', 'true'");
// header('Content-Type: application/javascript');
header("Content-Type: application/json; charset=utf-8");

include "../connect.php";
// include "../function.php";

$data = json_decode(file_get_contents("php://input"));


// The request is using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$pro_user_id = $data->id;

$datas = array();

try{
    
    $sql = "SELECT project_user.*
            FROM project_user 
            WHERE project_user.id = :pro_user_id";
    $query = $conn->prepare($sql);
    $query->bindParam(':pro_user_id',$pro_user_id, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    $sql = "SELECT project_template.*
            FROM project_template 
            WHERE id = :project_template_id";
    $query = $conn->prepare($sql);
    $query->bindParam(':project_template_id',$result->project_template_id, PDO::PARAM_INT);
    $query->execute();
    $rs_template = $query->fetch(PDO::FETCH_OBJ);

    $sql = "SELECT project_text.*
            FROM project_text 
            WHERE project_template_id = :project_template_id";
    $query = $conn->prepare($sql);
    $query->bindParam(':project_template_id',$result->project_template_id, PDO::PARAM_INT);
    $query->execute();
    $rs_text = $query->fetchAll(PDO::FETCH_OBJ);

        if($query->rowCount() > 0){                        //count($result)  for odbc
            
            http_response_code(200);
            echo json_encode(array(
                'status'    => true, 
                'message'   => 'สำเร็จ', 
                'resp'      => $result,
                'template'  => $rs_template,
                'text'      => $rs_text 
            ));
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