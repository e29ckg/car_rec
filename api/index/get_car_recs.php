<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=utf-8");


include "../connect.php";
include "../function.php";

// The request is using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$data = json_decode(file_get_contents("php://input"));
$datas = array();
try{
    if(isset($data->q)){
        $q = $data->q;
        $sql = "SELECT cr.*
                FROM car_rec AS cr 
                WHERE cr.book_number LIKE :q
                LIMIT 20";
        $query = $conn->prepare($sql);
        $query->bindValue(':q', "%$q%", PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);
        

            if($query->rowCount() > 0){                        //count($result)  for odbc
                // foreach($result as $rs){     
    
                    
                //     if($query->rowCount() > 0){
                //         array_push($datas,array(
                //             'id'            => $rs->id,
                //             'year'          => $rs->year,
                //             'name'          => $rs->name,
                //             'detail'        => $rs->detail,
                //             'img'           => $rs->img,
                //             'date_train'    => $rs->date_train,
                //             'period'        => $rs->period,
                //             'c_users'       => $res_pr_u
                //         ));
                //     }
                // }
        
                http_response_code(200);
                echo json_encode(array('status' => true, 'message' => 'สำเร็จ', 'data' => $result));
                exit();
            }

            http_response_code(200);
            echo json_encode(array('status' => false, 'message' => 'ไม่พบข้อมูล ', 'data' => []));
            exit();

        }else{                      

            $sql = "SELECT cr.*
                    FROM car_rec AS cr 
                    LIMIT 20";
            $query = $conn->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_OBJ);

            if($query->rowCount() > 0){                        //count($result)  for odbc
                
    
                http_response_code(200);
                echo json_encode(array('status' => true, 'message' => 'สำเร็จ', 'data' => $datas));
                exit();
            }
            http_response_code(200);
            echo json_encode(array('status' => false, 'message' => 'ไม่พบข้อมูล ','data' => []));
            exit();
        }    
    
    }catch(PDOException $e){
        http_response_code(200);
        echo json_encode(array('status' => false, 'message' => 'เกิดข้อผิดพลาด..' . $e->getMessage()));
        exit();
    }
}