<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

   
    <title>Spiza</title>
    <link rel="icon" href="<?php echo __SITE_URL; ?>/css/logo.png" />

    <!--        BOOTSTRAP           -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet"  href="<?php echo __SITE_URL; ?>/css/preIgnore.css">

</head>
<body>

<div class="jumbotron text-center" style="margin-bottom: 0px;">
    <h1>Spiza.hr</h1>
    <h2><?php //echo $title; ?>Registriraj novog korisnika</h2>
</div>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark" style="margin-bottom: 50px;">
  <a class="navbar-brand" href="#">
      <img src="<?php echo __SITE_URL; ?>/css/logo.png" alt="Spiza.hr" style="width:40px;filter: brightness(0) invert(1);">
  </a>

  <!-- Linkovi -->
  <ul class="navbar-nav">
    <li class="nav-item">
    <a class="nav-link" href="<?php echo __SITE_URL; ?>/index.php?rt=index">Prijava korisnika</a>
    </li>
    

    <!-- Dropdown meni -->
    <li class="nav-item dropdown">
      
      <div class="dropdown-menu">
      </div>
    </li>
  </ul>
</nav> 

<!--        NOTIFICATION    4   ERROR       -->
<div style="position: relative;" >
  <div class="toast" data-autohide="ture"  style=" z-index: 1; background-color: #DCDCDC; position: absolute; top: 10; right: 10px;">
      <div class="toast-header">
        <strong class="mr-auto text-primary">Obavijest</strong>     
        <small class="text-muted"><!--5 min--></small>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
      </div>
      <div class="toast-body"><?php
      if( isset($errorFlag))
          if( $errorFlag )
              echo $errorMsg . '<br>';
      ?></div>
  </div>
</div>

<!----      BODY         -->
<div class="container">
  <div class="row">
    <div class="col-12">

<h2>Unesite podatke za registraciju restorana!</h2>

<p>Nakon registracije primit ??ete e-mail potvrdu sa poveznicom za aktivaciju korisni??kog ra??una.</p>

<form action="<?php echo __SITE_URL; ?>/index.php?rt=index/register" method='post' class="was-validated">
    <div class="form-group">
        <label for="uname">Unesi korisni??ko ime:</label>
        <input type="text" name="username" class="form-control" id="uname" placeholder="Korisni??ko ime" required>
        <div class="valid-feedback">Ispunjeno.</div>
        <div class="invalid-feedback">Niste unijeli korisni??ko ime!</div>
    </div>
    <div class="form-group">
      <label for="pwd">Unesi password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Lozinka" name="password" required>
      <div class="valid-feedback">Ispunjeno.</div>
      <div class="invalid-feedback">Niste unijeli lozinku!</div>
    </div>
    <div class="form-group">
        <label for="email">Unesi e-mail addresu:</label>
        <input type="email" class="form-control" placeholder="E-mail" id="email" name="email" required>
        <div class="valid-feedback">Ispunjeno.</div>
        <div class="invalid-feedback">Neispravna e-mail adresa!</div>
    </div>
    <div class="form-group">
        <label for="naziv">Unesi naziv resotrana:</label>
        <input type="text" class="form-control" placeholder="Naziv restorana" id="naziv" name="name" required>
        <div class="valid-feedback">Ispunjeno.</div>
        <div class="invalid-feedback">Niste unijeli naziv restorana!</div>
    </div>
    <div class="form-group">
        <label for="addr">Unesi adresu restorana:</label>
        <input type="text" class="form-control" placeholder="Adresa" id="addr" name="address" required>
        <div class="valid-feedback">Ispunjeno.</div>
        <div class="invalid-feedback">Niste unijeli adresu!</div>
    </div>
    <div class="form-group">
        <label for="opis">Unesi opis restorana:</label>
        <input type="text" class="form-control" placeholder="Opis" id="opis" name="description" required>
        <div class="valid-feedback">Ispunjeno.</div>
        <div class="invalid-feedback">Niste unijeli opis restorana!</div>
     </div>
     <div class="form-group form-check">
      <label class="form-check-label">
        <input class="form-check-input" type="checkbox"  required> Sla??em se sa uvjetima kori??tenja stranice.
        <div class="valid-feedback">Ispunjeno.</div>
        <div class="invalid-feedback">Ozna??ite da prihva??ate uvjete kori??tenja stranice.</div>
      </label>
    </div>
    <input type="submit" name="Register restaurant" value="Register restaurant" class="btn btn-primary btn-block">
</form>


<div style="height: 250px;"> </div>


</div>
</div>
</div>



<script>
  $( document ).ready( function()
{
  var toast =   $( 'div.toast-body');
  if( toast.html() !== '')
    $( 'div.toast' ).toast('show');
});
</script>
</body>




<footer>
<div class="jumbotron text-center" style="margin-bottom:0">

&copy; <?php echo date("Y");?>

</div>

</html>