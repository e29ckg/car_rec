<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json; charset=utf-8");

require_once '../../vendor/autoload.php';

$data = json_decode(file_get_contents("php://input"));


$files = glob('../../output/preview/*'); 

// Deleting all the files in the list
foreach($files as $file) {   
    if(is_file($file))     
    unlink($file); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $data->data;
    
    
    $tm = './car_rec_tm.pdf';
    
    $text_font = 'thsarabun';
    $text_size = 10;
    $name_text_align = 'center';
    $name_x = 0;
    $text_y = 69;
        
    $name_file = 'preview.pdf';
    $output = $name_file;
    
    $mpdf = new \Mpdf\Mpdf();
    
    $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];
    
    $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    
    // var_dump($fontData);
    
    $mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        '../../fonts',
    ]),
    'fontdata' => $fontData + [
        'thsarabun' => [
            'R' => 'Sarabun-Regular.ttf',
            //'I' => 'THSarabunNew Italic.ttf',
            //'B' => 'THSarabunNew Bold.ttf',
            'useOTL' => 0xFF,
			// 'useKashida' => 75
        ],
        'prompt' => [
            'R' => 'Prompt.ttf',
            'B' => 'Prompt-Bold.ttf',
            'useOTL' => 0xFF,
			// 'useKashida' => 75
            ]
        ],
        'mode' => 'utf-8', 
        'format' => 'A4',
        'orientation' => 'P',
        // 'default_font' => 'thsarabun',
        // 'default_font_size' => 8,
        // 'format' => [235, 108],    
        // 'default_font' => 'kanit',
        // 'default_font' => 'NotoSerifThai',
        'default_font' => $text_font,
        'default_font_size' => $text_size
    ]);
    $mpdf->useDictionaryLBR = false;
    
    $mpdf->SetTitle('car_rc');
    $mpdf->SetAuthor('pkkjc');
    $mpdf->SetSubject('pkkjc-cert');
    $mpdf->SetCreator('pkkjc.coj');
    $mpdf->SetKeywords('pkkjc');
    
    $mpdf->AddPage();
    
    
    
    // $pagecount = $mpdf->setSourceFile('tm.pdf');
    $pagecount = $mpdf->setSourceFile($tm);
    // $pagecount = $mpdf->setSourceFile($tm);
    $tplId = $mpdf->importPage($pagecount);
    
    $actualsize = $mpdf->useTemplate($tplId);

    
    $data_text = '<div style="text-align:'.$name_text_align.';">'.$data->book_number.'</div>';
    $mpdf->WriteFixedPosHTML($data_text, 42, 45, 15, 15, 'auto');
    
    $data_text = '<div style="text-align:'.$name_text_align.'; border:1pt solid; ">'.$data->book_year.'</div>';
    $mpdf->WriteFixedPosHTML($data_text, 60, 45, 15, 20, 'auto');
    
    $data_text = '<div style="text-align:'.$name_text_align.'; border:1pt solid; ">'.$data->user_req_name.'</div>';
    $mpdf->WriteFixedPosHTML($data_text, 65, 79, 55, 20, 'auto');
    $data_text = '<div style="text-align:'.$name_text_align.'; border:1pt solid; ">'.$data->user_req_dep.'</div>';
    $mpdf->WriteFixedPosHTML($data_text, 135, 79, 55, 20, 'auto');
    $data_text = '<div style="text-align:'.$name_text_align.'; border:1pt solid; ">'.$data->user_req_dep.'</div>';
    $mpdf->WriteFixedPosHTML($data_text, 49, 86, 54, 20, 'auto');
    
    $data_text = '<div style="text-align:'.$name_text_align.'; border:1pt solid; ">'.$data->location_name.' เพื่อ '.$data->why.'</div>';
    $mpdf->WriteFixedPosHTML($data_text, 85, 92, 75, 20, 'auto');
    
    $data_text = '<div style="text-align:'.$name_text_align.'; border:1pt solid; ">'.$data->use_begin.' '.$data->use_begin_t.'</div>';
    $mpdf->WriteFixedPosHTML($data_text, 40, 99, 60, 20, 'auto');
    $data_text = '<div style="text-align:'.$name_text_align.'; border:1pt solid; ">'.$data->use_end.''. $data->use_end_t.'</div>';
    $mpdf->WriteFixedPosHTML($data_text, 120, 99, 60, 20, 'auto');
    
    $data_text = '<div style="text-align:'.$name_text_align.'; border:1pt solid; ">( '.$data->user_req_name.' )</div>';
    $mpdf->WriteFixedPosHTML($data_text, 115, 118, 50, 20, 'auto');
    $data_text = '<div style="text-align:'.$name_text_align.'; border:1pt solid; ">'.$data->user_req_dep.'</div>';
    $mpdf->WriteFixedPosHTML($data_text, 115, 122, 50, 20, 'auto');
    $data_text = '<div style="text-align:'.$name_text_align.'; border:1pt solid; ">'.$data->req_date.'</div>';
    $mpdf->WriteFixedPosHTML($data_text, 115, 126, 50, 20, 'auto');
    
    $data_text = '<div style="text-align:'.$name_text_align.'; border:1pt solid; ">( '.$data->driver_name.' )</div>';
    $mpdf->WriteFixedPosHTML($data_text, 87, 160, 65, 20, 'auto');

      
    $mpdf->Output($output);
    
    // $link_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
    $link_url = './service/mpdf/api/car_rec/'.$name_file;
    
    http_response_code(200);
    echo json_encode(array('status' => true, 'massege' => 'สำเร็จ', 'url' => $link_url,'data' => $data));
    exit;

}
?>