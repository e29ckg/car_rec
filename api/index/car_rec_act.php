<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Credentials: 'success'");
header("Content-Type: application/json; charset=utf-8");

include "../connect.php";
include "../function.php";

$data = json_decode(file_get_contents("php://input"));

// The request is using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $datas = array();    
    $car_rec = $data->car_rec;
    
    try{
        if($car_rec->act == 'insert'){
            $user_req_name = '';
            $user_req_dep = '';
            $driver_name = '';
            $driver_dep = '';
            $car_name = '';

            $sql = "SELECT * FROM profile WHERE id=:user_id";
            $query = $conn_main->prepare($sql);
            $query->bindParam(':user_id',$car_rec->user_req_id, PDO::PARAM_STR);
            $query->execute();
            $res_user = $query->fetch(PDO::FETCH_OBJ);
            if ($query->rowCount() > 0) {
                $user_req_name = $res_user->fname.$res_user->name. ' '.$res_user->sname;
                $user_req_dep = $res_user->dep;
            }

            $sql = "SELECT * FROM profile WHERE id=:user_id";
            $query = $conn_main->prepare($sql);
            $query->bindParam(':user_id',$car_rec->driver_id, PDO::PARAM_STR);
            $query->execute();
            $res_drver = $query->fetch(PDO::FETCH_OBJ);
            if ($query->rowCount() > 0) {
                $driver_name = $res_drver->fname.$res_drver->name. ' '.$res_drver->sname;
                $driver_dep = $res_drver->dep;

            }
            if (!($car_rec->car_id =='')) {
                $sql = "SELECT * FROM car WHERE id=:id";
                $query = $conn->prepare($sql);
                $query->bindParam(':id', $car_rec->car_id, PDO::PARAM_INT);
                $query->execute();
                $res_car = $query->fetch(PDO::FETCH_OBJ);
                if ($query->rowCount() > 0) {
                    $car_name = $res_car->name;
                }
            }

            $use_begin = date("Y-m-d H:i:s", strtotime($car_rec->use_begin . ' ' . $car_rec->use_begin_t));
            $use_end = date("Y-m-d H:i:s", strtotime($car_rec->use_end . ' ' . $car_rec->use_end_t));

            $created_at = date("Y-m-d h:i:s");
            
            $sql = "INSERT INTO car_rec( 
                                    book_number,
                                    book_year, 
                                    req_date,
                                    user_req_id,
                                    user_req_name,
                                    user_req_dep,
                                    location_name,
                                    why, 
                                    followers_num,
                                    use_begin,
                                    use_end,
                                    car_rec.status,
                                    comment,
                                    updated_at,
                                    created_at,
                                    car_id,
                                    car_name,
                                    driver_id,
                                    driver_name,
                                    driver_dep
                                    ) 
                    VALUE(
                                    :book_number,
                                    :book_year, 
                                    :req_date,
                                    :user_req_id,
                                    :user_req_name,
                                    :user_req_dep,
                                    :location_name,
                                    :why, 
                                    :followers_num,
                                    :use_begin,
                                    :use_end,
                                    :status,
                                    :comment,
                                    :updated_at,
                                    :created_at,
                                    :car_id,
                                    :car_name,
                                    :driver_id,
                                    :driver_name,
                                    :driver_dep
                        );";        
            $query = $conn->prepare($sql);
            $query->bindParam(':book_number',$car_rec->book_number, PDO::PARAM_STR);
            $query->bindParam(':book_year',$car_rec->book_year, PDO::PARAM_STR);
            $query->bindParam(':req_date',$car_rec->req_date, PDO::PARAM_STR);
            $query->bindParam(':user_req_id',$car_rec->user_req_id, PDO::PARAM_INT);
            $query->bindParam(':user_req_name',$user_req_name, PDO::PARAM_STR);
            $query->bindParam(':user_req_dep',$user_req_dep, PDO::PARAM_STR);
            $query->bindParam(':location_name',$car_rec->location_name, PDO::PARAM_STR);            
            $query->bindParam(':why',$car_rec->why, PDO::PARAM_STR);            
            $query->bindParam(':followers_num',$car_rec->followers_num, PDO::PARAM_INT);            
            $query->bindParam(':use_begin',$use_begin, PDO::PARAM_STR);            
            $query->bindParam(':use_end',$use_end, PDO::PARAM_STR);            
            $query->bindParam(':status',$car_rec->status, PDO::PARAM_STR);            
            $query->bindParam(':comment',$car_rec->comment, PDO::PARAM_STR);            
            // $query->bindParam(':own_created',$car_rec->own_created, PDO::PARAM_STR);            
            $query->bindParam(':updated_at',$created_at, PDO::PARAM_STR);            
            $query->bindParam(':created_at',$created_at, PDO::PARAM_STR);
            $query->bindParam(':car_id',$car_rec->car_id, PDO::PARAM_INT);
            $query->bindParam(':car_name',$car_name, PDO::PARAM_STR);
            $query->bindParam(':driver_id',$car_rec->driver_id, PDO::PARAM_INT);
            $query->bindParam(':driver_name',$driver_name, PDO::PARAM_STR);
            $query->bindParam(':driver_dep',$driver_dep, PDO::PARAM_STR);
            $query->execute();            

            if ($query->rowCount() > 0) {
                http_response_code(200);
                echo json_encode(array('status' => 'success', 'message' => 'success'));
                exit();
              } else {
                http_response_code(200);
                echo json_encode(array('status' => 'error', 'message' => 'failed to insert data'));
                exit();
              }               
        } 

        if($car_rec->act == 'update'){
            $user_req_name = '';
            $user_req_dep = '';
            $driver_name = '';
            $driver_dep = '';
            $car_name = '';

            if (!($car_rec->user_req_id == '')) {
                $sql = "SELECT * FROM profile WHERE id=:user_id";
                $query = $conn_main->prepare($sql);
                $query->bindParam(':user_id', $car_rec->user_req_id, PDO::PARAM_INT);
                $query->execute();
                $res_user = $query->fetch(PDO::FETCH_OBJ);
                if ($query->rowCount() > 0) {
                    $user_req_name = $res_user->fname . $res_user->name . ' ' . $res_user->sname;
                    $user_req_dep = $res_user->dep;
                }
            }

            if (!($car_rec->driver_id =='')) {
                $sql = "SELECT * FROM profile WHERE id=:id";
                $query = $conn_main->prepare($sql);
                $query->bindParam(':id', $car_rec->driver_id, PDO::PARAM_INT);
                $query->execute();
                $res_drver = $query->fetch(PDO::FETCH_OBJ);
                if ($query->rowCount() > 0) {
                    $driver_name = $res_drver->fname . $res_drver->name . ' ' . $res_drver->sname;
                    $driver_dep = $res_drver->dep;

                }
            }

            if (!($car_rec->car_id =='')) {
                $sql = "SELECT * FROM car WHERE id=:id";
                $query = $conn->prepare($sql);
                $query->bindParam(':id', $car_rec->car_id, PDO::PARAM_INT);
                $query->execute();
                $res_car = $query->fetch(PDO::FETCH_OBJ);
                if ($query->rowCount() > 0) {
                    $car_name = $res_car->name;
                }
            }

            $use_begin = date("Y-m-d H:i:s", strtotime($car_rec->use_begin . ' ' . $car_rec->use_begin_t));
            $use_end = date("Y-m-d H:i:s", strtotime($car_rec->use_end . ' ' . $car_rec->use_end_t));
            $updated_at = date("Y-m-d H:i:s");

            $sql = "UPDATE car_rec 
                        SET book_number = :book_number,
                            book_year = :book_year, 
                            req_date = :req_date,
                            user_req_id = :user_req_id,
                            user_req_name = :user_req_name,
                            user_req_dep = :user_req_dep,
                            location_name = :location_name,
                            why = :why, 
                            followers_num = :followers_num,
                            use_begin = :use_begin,
                            use_end = :use_end,
                            status = :status,
                            comment = :comment,
                            updated_at = :updated_at,
                            car_id = :car_id,
                            car_name = :car_name,
                            driver_id = :driver_id,                       
                            driver_name = :driver_name,                       
                            driver_dep = :driver_dep                       
                    WHERE id = :id";   

            $query = $conn->prepare($sql);
            $query->bindParam(':book_number', $car_rec->book_number, PDO::PARAM_STR);
            $query->bindParam(':book_year', $car_rec->book_year, PDO::PARAM_STR);
            $query->bindParam(':req_date', $car_rec->req_date, PDO::PARAM_STR);
            $query->bindParam(':user_req_id', $car_rec->user_req_id, PDO::PARAM_INT);
            $query->bindParam(':user_req_name', $user_req_name, PDO::PARAM_STR);
            $query->bindParam(':user_req_dep', $user_req_dep, PDO::PARAM_STR);
            $query->bindParam(':location_name', $car_rec->location_name, PDO::PARAM_STR);            
            $query->bindParam(':why', $car_rec->why, PDO::PARAM_STR);            
            $query->bindParam(':followers_num', $car_rec->followers_num, PDO::PARAM_INT);            
            $query->bindParam(':use_begin', $use_begin, PDO::PARAM_STR);            
            $query->bindParam(':use_end', $use_end, PDO::PARAM_STR);            
            $query->bindParam(':status', $car_rec->status, PDO::PARAM_STR);            
            $query->bindParam(':comment', $car_rec->comment, PDO::PARAM_STR);                     
            $query->bindParam(':updated_at', $updated_at, PDO::PARAM_STR); 
            $query->bindParam(':car_id', $car_rec->car_id, PDO::PARAM_INT);
            $query->bindParam(':car_name', $car_name, PDO::PARAM_STR);
            $query->bindParam(':driver_id', $car_rec->driver_id, PDO::PARAM_INT);
            $query->bindParam(':driver_name', $driver_name, PDO::PARAM_STR);
            $query->bindParam(':driver_dep', $driver_dep, PDO::PARAM_STR);
            $query->bindParam(':id', $car_rec->id, PDO::PARAM_INT);
            $query->execute();    

            if ($query->rowCount() > 0) {
                http_response_code(200);
                echo json_encode(array('status' => 'success', 'message' => 'success'));
                exit();
            } else {
                http_response_code(200);
                echo json_encode(array('status' => 'error', 'message' => 'failed to update data'));
                exit();
            }

                          
        }  
              
         
        if($car_rec->act == 'delete'){
            $id  = $car_rec->id;
            
            $sql = "DELETE FROM car_rec WHERE id = :id";
            $query = $conn->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();  

            if ($query->rowCount() > 0) {
                http_response_code(200);
                echo json_encode(array('status' => 'success', 'message' => 'success'));
                exit();
            } 
                http_response_code(200);
                echo json_encode(array('status' => 'error', 'message' => 'failed to update data'));
                exit();
            }

        http_response_code(200);
        echo json_encode(array('status' => 'error', 'message' => 'ไม่มีการเปลี่ยนแปลง'));
        exit();  
        
        
    }catch(PDOException $e){
        http_response_code(200);
        echo json_encode(array('status' => 'error', 'message' => 'เกิดข้อผิดพลาด..' . $e->getMessage()));
        exit();
    }
}



