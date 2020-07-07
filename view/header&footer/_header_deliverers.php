<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Spiza</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="<?php echo __SITE_URL; ?>/view/javascript/deliverers.js"></script>

    <link rel="icon" href="<?php echo __SITE_URL; ?>/css/logo.png" />

    <!--        BOOTSTRAP           -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</head>

<body>


<div class="jumbotron text-center" style="margin-bottom: 0px;">
    <h1>Spiza.hr</h1>
    <h2><?php echo $title; ?></h2>
</div>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark" style="margin-bottom: 50px;">   
    <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="<?php echo __SITE_URL; ?>/index.php?rt=index/logout">Logout</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo __SITE_URL;?>/index.php?rt=deliverers">Naslovnica</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo __SITE_URL;?>/index.php?rt=deliverers/active">Aktivne narudžbe</a></li>
    </ul>
</nav>


     <?php
    if( isset($errorFlag))
        if( $errorFlag )
            echo $errorMsg . '<br>';
    ?>

