<?php

require_once __DIR__ . '/database/db.class.php';


function sendJSONandExit($message)
{
    header( 'Content-type:application/json;charset=utf-8');
    echo json_encode($message);
    flush();
    exit(0);
}


$message=[];

if( !isset($_post['name']) || !isset($_post['price']) || !isset($_post['description']) ||
    !isset($_post['waitingTime']) || !isset($_post['id_restaurant']) )
{
    $message['greska'] = 'Parameters missing!';
    sendJSONandExit($message);
    exit(1);
}


try
		{
            $db=DB::getConnection();
            $st=$db->prepare( 'INSERT INTO spiza_food(name, description, waiting_time, id_restaurant, price, in_offering) VALUES (:name, :description, :waiting_time, :id_restaurant, :price, :in_offering)' );
            $st->execute( array( 'name' => $_post['name'],  'description' => $_post['description'], 'waiting_time' => intval( $_post['waitingTime'] ), 'id_restaurant' => intval( $_post['id_restaurant'] ), 'price' => intval( $_post['price'] ), 'in_offering' => 1) );		
        }
        catch( PDOException $e ) { 
            $message['greska'] = 'Greška u bazi!';echo $e;
            sendJSONandExit($e);
            exit(2);
         }
    $message['rezultat'] = 'Added food ' . $_post['name'] . '!';
    sendJSONandExit($message);



?>