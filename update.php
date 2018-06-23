<?php

$dom = new DomDocument();
        $dom->load("store.xml");
        $xp = new DomXPath($dom);
        $id = $_GET['id'];
        $name = $xp->query("/details/detail[@id = '$id']/name") ;
        $name->item(0)->nodeValue = filter_input(INPUT_POST,'name2');
        $email = $xp->query("/details/detail[@id = '$id']/email") ;
        $email->item(0)->nodeValue = filter_input(INPUT_POST ,'mail2');
        $dept = $xp->query("/details/detail[@id = '$id']/dept") ;
        $dept->item(0)->nodeValue = filter_input(INPUT_POST,'dept2');
        $dom->save('store.xml');