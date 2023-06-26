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

try{
        $id = $data->id;                               

        $sql = "SELECT *
                FROM project_template 
                WHERE id = '$id'";
        $query = $conn->prepare($sql);
        $query->execute();
        $rs = $query->fetch(PDO::FETCH_OBJ);

        if($query->rowCount() > 0){                        //count($result)  for odbc
        
            $sql = "SELECT *
                    FROM project_text                
                    WHERE project_template_id = :id";
            $query = $conn->prepare($sql);
            $query->bindParam(':id',$id, PDO::PARAM_INT);
            $query->execute();
            $texts = $query->fetchAll(PDO::FETCH_OBJ);

            array_push($datas,array(
                'id'    => $rs->id,
                'project_id'    => $rs->project_id,
                'template_name' => $rs->template_name,
                'size' => $rs->size,
                'orientation'   => $rs->orientation,
                'template_url'  => $rs->template_url,
                // 'texts'  => $texts
            ));
        

            http_response_code(200);
            echo json_encode(array('status' => true, 'message' => 'สำเร็จ', 'template' =>  $datas, "text" => $texts));
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