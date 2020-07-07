<?php require_once __DIR__ . '/header&footer/_header.php'; ?>

<div class="list-group">
    <?php 
    foreach( $restaurantList as $restaurant ){
        echo '<a class="list-group-item list-group-item-action" href="index.php?rt=user/restaurant&id_restaurant=' . $restaurant->id_restaurant . '">' . 
            $restaurant->name . '<br>';
        echo $restaurant->description .'<br>';
        echo '</li></a>';
    }
    ?>
</div>

<div style="height: 50px;"> </div>

</div>
</div>
</div>

<!-- <h4>Istraži više restorana:</h4> -->
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">   
    <ul class="nav navbar-nav">
        <li class="nav-item"><a class="nav-link" href="<?php echo __SITE_URL; ?>/index.php?rt=user/popular">Popularni</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo __SITE_URL; ?>/index.php?rt=user/restaurants">Svi restorani</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo __SITE_URL; ?>/index.php?rt=user/neighborhood">U kvartu</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo __SITE_URL; ?>/index.php?rt=user/foodType">Prema vrsti hrane</a></li>
    </ul>
</nav> 

<!-- <div style="height: 250px;"> </div> -->

<?php require_once __DIR__ . '/header&footer/_footer.php'; ?>