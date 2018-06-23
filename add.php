<?php
$xml = simplexml_load_file("store.xml");
$flag = true;
foreach ($xml->children() as $data){
    if($data->attributes()->id == filter_input( INPUT_POST , 'mob')){
        $flag = false;
    }
}
if($flag){
       $doc = new DOMDocument();
        $doc->load('store.xml');
        $nodes = $doc->getElementsByTagName('details');
            $b = $doc->createElement( "detail" );
            $b->setAttribute('id', filter_input(INPUT_POST, 'mob'));
            $b->setAttribute('posted_at', date('Y-m-d H:i'));
            $name = $doc->createElement( "name" );
            $name->appendChild($doc->createTextNode( filter_input(INPUT_POST, 'name') ));
            $b->appendChild( $name );

            $mobile = $doc->createElement( "mobile" );
            $mobile->appendChild(
            $doc->createTextNode( filter_input(INPUT_POST, 'mob') ));
            $b->appendChild( $mobile );

            $email = $doc->createElement( "email" );
            $email->appendChild(
            $doc->createTextNode( filter_input(INPUT_POST, 'mail') ));
            $b->appendChild( $email );

            $dept = $doc->createElement( "dept" );
            $dept->appendChild(
            $doc->createTextNode( filter_input(INPUT_POST, 'dept') ));
            $b->appendChild( $dept );
            $doc->formatOutput = true;
            $doc->documentElement->appendChild($b);

        $doc->save('store.xml');
        echo "saved";
}else{
    echo "already";
}
