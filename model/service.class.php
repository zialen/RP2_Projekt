<?php 

require_once __DIR__ . '/../app/database/db.class.php';

class Service{
    /*          P   R   I   M   J   E   R   I       F   U   N   K   C   I   J   A
    public function getMyChannels(){
        
        $channels =[];

        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM dz2_channels WHERE id_user=:user');
        $st->execute( ['user'=>$_SESSION['user']->id] );

        while( $row = $st->fetch() )
            $channels[] = new Channel($row['id'], $row['id_user'], $row['name']);
        return $channels;
    }


    public function sendMessege()
    {
        $messege = $_POST['poruka'];
        date_default_timezone_set("Europe/Zagreb");
        
        $db = DB::getConnection();
        $st = $db->prepare( 'INSERT INTO dz2_messages (id_user, id_channel, content, thumbs_up, date) VALUES (:val1,:val2,:val3,:val4,:val5)');
        $st->execute(['val1'=> $_SESSION['user']->id, 'val2'=> $_SESSION['current_channel']->id, 'val3'=>$messege, 'val4'=>0, 'val5'=>date("Y-m-d h:i:s")]);
    }*/

    //                      F-je    za  LOGIN
    function userExsists($databaseName, $username)
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM '.$databaseName.' WHERE username=:user');
        $st->execute(['user'=>$username]);
        if( $st->rowCount() !== 0)
            return True;
        else
            return False;
    }

    function emailConfirmed($databaseName, $username )
    {
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT has_registered FROM '.$databaseName.' WHERE username=:user');
        $st->execute(['user'=>$username]);
        $st = $st->fetch();
        if( $st[0] )
            return True;
        else
            return False;
    }

    function loginToDatabase( $databaseName )    //  username i password primamo preko $_POST-a
    {   
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM '.$databaseName.' WHERE username=:user');
        $st->execute(['user'=>$_POST['username']]);
    
        if( $st->rowCount() !== 1)	// korisnik ne postoji ili ih je više -- ispisat grrešku
            return False;
 
        $row = $st->fetch();
        $password_hash = $row['password_hash'];

        if( password_verify( $_POST['password'], $password_hash) )
        {
            if( $_POST['log_in'] === 'login_user')
                $_SESSION['user'] = new User($row['id'], $row['username'], ' ',$row['email'], $row['registration_sequence'], $row['has_registered'] );
            else if($_POST['log_in'] === 'login_restaurants')
                $_SESSION['restaurants'] = new Restaurants($row['id'], $row['username'], ' ', $row['name'], $row['address'], $row['email'], $row['registration_sequence'], $row['rating'], $row['food_type'], $row['description'], $row['has_registered'] );
            else
                $_SESSION['deliverers'] = new Deliverers($row['id'], $row['username'], ' ',$row['email'], $row['registration_sequence'], $row['has_registered'] );
            return True;
        }
        else
            return False;
    }

    //                      F-je    za  REGISTER
    function registerUser($databaseName)
    {
        $reg_seq = '';
        for( $i = 0; $i < 20; ++$i )
            $reg_seq .= chr( rand(0, 25) + ord( 'a' ) );

        $db = DB::getConnection();

        if( $databaseName === 'spiza_users' )
		{
            try{
                $st = $db->prepare( 'INSERT INTO '.$databaseName.' (username, password_hash, email, registration_sequence, has_registered) VALUES (:val1,:val2,:val3,:val4,:val5)');
                $st->execute(['val1'=> $_POST['username'],'val2'=> password_hash( $_POST['password'], PASSWORD_DEFAULT ), 
                            'val3'=> $_POST['email'],'val4'=> $reg_seq,'val5'=> 0]);
            }catch( PDOException $e ) { exit( "PDO error [insert spiza_users]: " . $e->getMessage() ); }
        }
        elseif( $databaseName === 'spiza_restaurants' )
        {
            try{
                $st = $db->prepare( 'INSERT INTO '.$databaseName.' (username, password_hash, email, registration_sequence, has_registered, name, address, description) VALUES (:val1,:val2,:val3,:val4,:val5, :val6, :val7, :val8)');
                $st->execute(['val1'=> $_POST['username'],'val2'=> password_hash( $_POST['password'], PASSWORD_DEFAULT ), 
                            'val3'=> $_POST['email'],'val4'=> $reg_seq,'val5'=> 0, 'val6'=>$_POST['name'], 'val7'=>$_POST['address'], 'val8'=>$_POST['description'] ]);
            }catch( PDOException $e ) { exit( "PDO error [insert spiza_restaurants]: " . $e->getMessage() ); }
        }


        $to       = $_POST['email'];
        $subject  = 'Registracijski mail';
        $message  = 'Poštovani ' . $_POST['username'] . "!\nZa dovršetak registracije kliknite na sljedeći link: ";
        $message = 'http://' . $_SERVER['SERVER_NAME'] . htmlentities( dirname( $_SERVER['PHP_SELF'] ) ) . '/register.php?niz=' . $reg_seq . "\n";

        if( $databaseName === 'spiza_restaurants' )
            $message = 'http://' . $_SERVER['SERVER_NAME'] . htmlentities( dirname( $_SERVER['PHP_SELF'] ) ) . '/register_restaurant.php?niz=' . $reg_seq . "\n";

        $headers  = 'From: rp2@studenti.math.hr' . "\r\n" .
                    'Reply-To: rp2@studenti.math.hr' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        $isOK = mail($to, $subject, $message, $headers);

        if( !$isOK )
            exit( 'Greška: ne mogu poslati mail. (Pokrenite na rp2 serveru.)' );
        
    }

    //                      F-je za prikaz restorana
    
    function getRestaurantListByRating()
    {
        $restaurants =[];

        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM spiza_restaurants ORDER BY rating DESC');
        $st->execute( );

        while( $row = $st->fetch() )
            $restaurants[] = new Restaurants($row['id'], '', '', $row['name'], $row['address'], $row['email'], '', $row['rating'], $row['food_type'], $row['description'], 1 );
        return $restaurants;
    }

    // nedovrseno --> treba odlučiti kako ćemo spremati food_type za restoran pa onda prilagoditi upit
    function getRestaurantListByFoodType( $food_type )
    {
        $restaurants =[];

        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM spiza_restaurants WHERE food_type=:food_type ORDER BY rating DESC');
        $st->execute( [ 'food_type' => $food_type ] );

        while( $row = $st->fetch() )
            $restaurants[] = new Restaurants($row['id'], '', '', $row['name'], $row['address'], $row['email'], '', $row['rating'], $row['food_type'], $row['description'], 1 );
        return $restaurants;
    }

    // funkcija prima id usera i vraća njegove feedbackove poredano silazno po njegovoj ocjeni,
    // ako taj korisnik nije ocijenio do sada nijedan restoran vraca null 
    function getMyFeedbackList( $id_user )
    {
        try
		{
            $db=DB::getConnection();
            $st=$db->prepare('SELECT * FROM spiza_feedback WHERE id_user=:id_user ORDER BY rating DESC');
            $st->execute( ['id_user'=>$id_user] );
		}
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
        if ($st->rowCount()===0)
            return null;
        else{
            $feedbacks = [];
            
            while( $row = $st->fetch() )
            {
                $feedbacks[] = new Feedback( $row['id'], $row['id_user'], $row['id_restaurant'], $row['content'], $row['rating'], $row['thumbs_up'], $row['thumbs_down'] );
            }
            return $feedbacks;
        }
    }

    // funkcija prima id usera, poziva fju getMyFeedbackList koja vraca korisnikove recenzije sortirano silazno po ocjeni
    // te vraca popis restorana koje je korisnik ocijenio (silazno po ocjeni)
    // možemo još nekako ubaciti da se za svaki restoran koji je korisnik ocijenio gleda koliko puta je naručio iz istog pa se restoran koji ima
    // najveću ocjenu i iz kojeg je korisnik najvise puta narucio hranu nalazi na vrhu liste, zatim se redaju restorani s istom ocjenom,
    // ali silazno po broju narudzbi --> za ovo bi trebali ubaciti broj narudzbi u bazu jer bi upit za brojanje narudzbi nekog korisnika iz nekog restorana
    // i jos poredano silazno po tom broju bio jako kompliciran...
    function getRestaurantListByMyRating( $id_user ){
        $ls = new Service();
        $feedbacks = $ls->getMyFeedbackList( $id_user );
        if( $feedbacks === null )
            return null;

        foreach( $feedbacks as $feedback ){
            $id = $feedback->id_restaurant;

            try{
                $db = DB::getConnection();
                $st = $db->prepare( 'SELECT * FROM spiza_restaurants WHERE id=:id' );
                $st->execute( [ 'id' => $id ] );
            }
            catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
            $restaurants = [];
                    
             while( $row = $st->fetch() )
                $restaurants[] = new Restaurants($row['id'], '', '', $row['name'], $row['address'], $row['email'], '', $row['rating'], $row['food_type'], $row['description'], 1 );
        }
        return $restaurants;
    }

    function getRestaurantById( $id )
    {
        try
		{
            $db=DB::getConnection();
            $st=$db->prepare('SELECT * FROM spiza_restaurants WHERE id=:rest');
            $st->execute(['rest'=>$id]);
		}
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
        if ($st->rowCount()!==1)
            return null;
        else{
            $row=$st->fetch();
            return new Restaurants( $row['id'], '', '', $row['name'], $row['address'], $row['email'], '', $row['rating'], $row['food_type'], $row['description'], 1  );
        }
    }


    //fje za prikaz narudžbi

    function getOrdersByUserId( $id_user )
    {
        try
		{
            $db=DB::getConnection();
            $st=$db->prepare('SELECT * FROM spiza_orders WHERE id_user=:user');
            $st->execute(['user'=>$id_user]);
		}
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
        if ($st->rowCount()===0)
            return null;
        else{
            $arr = array();
            while( $row = $st->fetch() )
            {
                $arr[] = new Order( $row['id'], $row['id_user'], $row['id_restaurant'], $row['id_food'], $row['id_order'] );
            }
            return $arr;
        }
    }

    //fje za prikaz hrane

    function getFoodById( $id )
    {
        try
		{
            $db=DB::getConnection();
            $st=$db->prepare('SELECT * FROM spiza_food WHERE id=:hrana');
            $st->execute(['hrana'=>$id]);
		}
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
        if ($st->rowCount()!==1)
            return null;
        else{
            $row=$st->fetch();
            return new Food ( $row['id'], $row['name'], $row['food_type'], $row['description'], $row['waiting_time'], $row['id_restaurant'], $row['price'] );
        }
    }

    function getFoodListByRestaurantId( $id_restaurant )
    {
        try
		{
            $db=DB::getConnection();
            $st=$db->prepare('SELECT * FROM spiza_food WHERE id_restaurant=:rest');
            $st->execute(['rest'=>$id_restaurant]);
		}
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
        if ($st->rowCount()===0)
            return null;
        else{
            $arr = array();
            while( $row = $st->fetch() )
            {
                $arr[] = new Food( $row['id'], $row['name'], $row['food_type'], $row['description'], $row['waiting_time'], $row['id_restaurant'], $row['price'] );
            }
            return $arr;
        }
    }

    //fje za prikaz feedbacka
    function getFeedbackListByRestaurantId( $id_restaurant )
    {
        try
		{
            $db=DB::getConnection();
            $st=$db->prepare('SELECT * FROM spiza_feedback WHERE id_restaurant=:rest');
            $st->execute(['rest'=>$id_restaurant]);
		}
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
        if ($st->rowCount()===0)
            return null;
        else{
            $arr = array();
            while( $row = $st->fetch() )
            {
                $arr[] = new Feedback( $row['id'], $row['id_user'], $row['id_restaurant'], $row['content'], $row['rating'], $row['thumbs_up'], $row['thumbs_down'] );
            }
            return $arr;
        }
    }

    //fje za prikaz korisnika
    function getUserById( $id )
    {
        try
		{
            $db=DB::getConnection();
            $st=$db->prepare('SELECT * FROM spiza_users WHERE id=:user');
            $st->execute(['user'=>$id]);
		}
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
        if ($st->rowCount()!==1)
            return null;
        else{
            $row=$st->fetch();
            return new User( $row['id'], $row['username'], $row['password_hash'], $row['email'], $row['registration_sequence'], $row['has_registered'] );
        }
    }

};

//  -------------------------------------------------------------


function editContent( $userList, $content){
    foreach( $userList as $user )
        if( strpos($content, '@'.$user) !== False )
            $content = str_replace('@'.$user,'<a href="'. __SITE_URL . '/index.php?rt=messeges/userMesseges/?name='.$user.'">@' . $user . '</a>', $content);
    return $content;
}
function stringToColorCode($str) {
    $code = dechex(crc32($str));
    $code = substr($code, 0, 6);
    return $code;
  }
?>