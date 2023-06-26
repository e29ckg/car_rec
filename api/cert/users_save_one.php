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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $template   = $data->template;
    $user       = $data->user;
    $datas      = array();

    try{
        $name = $user;
        $user_status = 1;
        $active = 1;

        $project_template_id = $template->id;
        $project_id          = $template->project_id;

        $sql = "INSERT INTO project_user(project_id, project_template_id, name) 
            VALUE(:project_id, :project_template_id, :name);";        
        $query = $conn->prepare($sql);
        $query->bindParam(':project_id',$project_id, PDO::PARAM_INT);
        $query->bindParam(':project_template_id',$project_template_id, PDO::PARAM_INT);
        $query->bindParam(':name',$name, PDO::PARAM_STR);
        $query->execute();
    
        http_response_code(200);
        echo json_encode(array('status' => true, 'message' => 'สำเร็จ'));
        exit();
    
    }catch(PDOException $e){
        http_response_code(200);
        echo json_encode(array('status' => false, 'message' => 'เกิดข้อผิดพลาด..' . $e->getMessage()));
        exit();
    }
}