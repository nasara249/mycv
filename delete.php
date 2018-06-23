<?php

$dom = new DomDocument();
        $dom->load("store.xml");
        $xp = new DomXPath($dom);
        $id= $_POST['id'];
        $target = $xp->query("/details/detail[@id = '$id']") ;
        $target->item(0)->parentNode->removeChild($target->item(0));
        $dom->save('store.xml');