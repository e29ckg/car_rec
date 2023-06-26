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
    http_response_code(200);
    echo json_encode(array('status' => true, 'message' => 'ok-test', 'data' => $car_type));
    exit(); 
    
    try{
        if($car_type->act == 'insert'){
            if($project->name == ''){
                http_response_code(200);
                echo json_encode(array('status' => false, 'message' => 'no name'));
                exit();
            }
            $created_at = date("Y-m-d h:i:s");
            
            $sql = "INSERT INTO project( project.year, `name`, date_train, detail, period, created_at) 
                    VALUE(:year, :name, :date_train, :detail, :period, :created_at);";        
            $query = $conn->prepare($sql);
            // $query->bindParam(':id',$id, PDO::PARAM_INT);
            $query->bindParam(':year',$project->year, PDO::PARAM_STR);
            $query->bindParam(':name',$project->name, PDO::PARAM_STR);
            $query->bindParam(':date_train',$project->date_train, PDO::PARAM_STR);
            $query->bindParam(':detail',$project->detail, PDO::PARAM_STR);            
            $query->bindParam(':period',$project->period, PDO::PARAM_STR);            
            $query->bindParam(':created_at',$created_at);
            $query->execute();            

            http_response_code(200);
            echo json_encode(array('status' => true, 'message' => 'ok'));
            exit();                
        } 

        if($project->act == 'update'){
            $id      = $project->id;
            $name    = $project->name;
            $year    = $project->year;
            $date_train    = $project->date_train;
            $detail    = $project->detail;
            $period    = $project->period;

            $sql = "UPDATE project 
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
            echo json_encode(array('status' => true, 'message' => 'ok', 'responseJSON' => $project));
            exit();                
        }  
              
         
        if($project->act == 'del'){
            $id  = $project->id;

            $sql = "SELECT * FROM project WHERE id = :id";
            $query = $conn->prepare($sql);
            $query->bindParam(':id',$id, PDO::PARAM_INT);
            $query->execute();
            $res_project = $query->fetch(PDO::FETCH_OBJ);
            if(!($res_project->img == null OR $res_project->img == '')){
                unlink('../../img/'.$res_project->img);
            }

            $sql = "DELETE FROM project WHERE id = $id";
            $conn->exec($sql);

            $sql = "SELECT prt.*
                    FROM project_template AS prt                
                    WHERE prt.project_id = $id";
            $query = $conn->prepare($sql);
            $query->execute();
            $res_template = $query->fetchAll(PDO::FETCH_OBJ);
            if($query->rowCount() > 0){
                foreach($res_template as $rtm){
    
                        unlink('../../template/'.$rtm->template_url);
                }
            }

            $sql = "DELETE FROM project_template WHERE project_id = $id";
            $conn->exec($sql);

            $sql = "DELETE FROM project_text WHERE project_id = $id";
            $conn->exec($sql);

            $sql = "DELETE FROM project_user WHERE project_id = $id";
            $conn->exec($sql);

            http_response_code(200);
            echo json_encode(array('status' => true, 'message' => 'DEL ok'));
            exit();                
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



