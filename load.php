<?php

$xml = simplexml_load_file("store.xml");
        foreach ($xml->children() as $data){
            $values[] = [
                'name' => $data->name,
                'mobile' => $data->mobile,
                'email' => $data->email,
                'dept' => $data->dept,
                'posted' => $data->attributes()->posted_at
            ];
        }
        echo json_encode($values);