<?php
$xml = simplexml_load_file("store.xml");
foreach ($xml->children() as $data){
    if($data->mobile == $_GET['id']){
        $values[] = [
        'name' => $data->name,
        'mobile' => $data->mobile,
        'email' => $data->email,
        'dept' => $data->dept
        ];
        break;
    }
}
echo json_encode($values);