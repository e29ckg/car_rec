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
        $sql = "SELECT *
                FROM car_rec AS cr 
                ORDER BY created_at DESC
                LIMIT 20";
        $query = $conn->prepare($sql);
        $query->bindValue(':q', "%$q%", PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);
        

            if($query->rowCount() > 0){                        //count($result)  for odbc
                foreach($result as $rs){     
                    $use_begin = date("Y-m-d H:i:s", strtotime($rs->use_begin));
                    $use_begin_t = date("Y-m-d H:i:s", strtotime($rs->use_begin));
                    $use_end = date("Y-m-d", strtotime($rs->use_end));
                    $use_end_t = date("H:i:s", strtotime($rs->use_end));
                    array_push($datas,array(
                        'id' => $rs->id,
                        'book_number'   => $rs->book_number,
                        'book_year'     => $rs->book_year,
                        'req_date'      => $rs->req_date,
                        'user_req_id'   => $rs->user_req_id,
                        'user_req_name'   => $rs->user_req_name,
                        'user_req_dep'   => $rs->user_req_dep,
                        'user_req_workgroup'   => $rs->user_req_workgroup,
                        'location_name' => $rs->location_name,
                        'why'           => $rs->why,
                        'followers_num' => $rs->followers_num,
                        'use_begin'     => $use_begin,
                        'use_begin_t'   => $use_begin_t,
                        'use_end'       => $use_end,
                        'use_end_t'     => $use_end_t,
                        'status'        => $rs->status,
                        'comment'       => $rs->comment,
                        'car_id'        => $rs->car_id,
                        'car_name'        => $rs->car_name,
                        'driver_id'     => $rs->driver_id,
                        'driver_name'     => $rs->driver_name,
                        'driver_dep'     => $rs->driver_dep,
                        ));
                    }
               
        
                http_response_code(200);
                echo json_encode(array('status' => true, 'message' => 'สำเร็จ', 'data' => $datas));
                exit();
            }

            http_response_code(200);
            echo json_encode(array('status' => false, 'message' => 'ไม่พบข้อมูล ', 'data' => []));
            exit();

        }else{                      

            $sql = "SELECT *
                    FROM car_rec AS cr 
                    ORDER BY created_at DESC
                    LIMIT 50";
            $query = $conn->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_OBJ);

            if($query->rowCount() > 0){                        //count($result)  for odbc
                
                foreach($result as $rs){     
                    $use_begin = date("Y-m-d", strtotime($rs->use_begin));
                    $use_begin_t = date("H:i", strtotime($rs->use_begin));
                    $use_end = date("Y-m-d", strtotime($rs->use_end));
                    $use_end_t = date("H:i", strtotime($rs->use_end));
                    array_push($datas,array(
                            'id' => $rs->id,
                            'book_number'   => $rs->book_number,
                            'book_year'     => $rs->book_year,
                            'req_date'      => $rs->req_date,
                            'user_req_id'   => $rs->user_req_id,
                            'user_req_name'   => $rs->user_req_name,
                            'user_req_dep'   => $rs->user_req_dep,
                            'user_req_workgroup'   => $rs->user_req_workgroup,
                            'location_name' => $rs->location_name,
                            'why'           => $rs->why,
                            'followers_num' => $rs->followers_num,
                            'use_begin'     => $use_begin,
                            'use_begin_t'   => $use_begin_t,
                            'use_end'       => $use_end,
                            'use_end_t'     => $use_end_t,
                            'status'        => $rs->status,
                            'comment'       => $rs->comment,
                            'car_id'        => $rs->car_id,
                            'car_name'        => $rs->car_name,
                            'driver_id'     => $rs->driver_id,
                            'driver_name'     => $rs->driver_name,
                            'driver_dep'     => $rs->driver_dep,
                        ));
                    }
               
        
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