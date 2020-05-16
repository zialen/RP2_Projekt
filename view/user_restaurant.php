<?php require_once __DIR__ . '/_header.php'; ?>

Popis dostupnih jela:
<ul>
    <?php 
    foreach( $foodList as $food ){
        echo '<li>' .
             $food->name . ': ' . $food->price . '<br>' .
             $food->food_type . ' ' . $food->description . '<br>' .
            '</li>';
    }
    ?>
</ul>

Recenzije:
<ul>
    <?php 
    $i=0;
    foreach( $feedbackList as $feedback ){
        echo '<li>' .
             $feedback->id_user . ': ' . $feedback->rating . '<br>' .
             '<div id="ovaj' . $i . '">' . $feedback->content . '</div><br>' .
            '</li>';
        $i++;
    } ?>
</ul>

<script>
$( document ).ready( function() 
{
    var i = 0;
    var n = <?php echo $i; ?>;
    console.log(n);
    for ( i = 0; i < n;  i++){
        var text = $( '#ovaj' + i ).html();
        var char_limit = 100;

        if(text.length < char_limit)
            $( '#ovaj' + i ).html( text );
        else
            $( '#ovaj' + i ).html( '<span class="short-text">' + text.substr(0, char_limit) + '</span><span class="long-text" style="display:none">' + text.substr(char_limit) + '</span><span class="text-dots">...</span><span class="show-more-button" data-more="0" style="color:blue">Read More</span>' );
    }


    $(".show-more-button").on('click', function() {
	// If text is shown less, then show complete
	if($(this).attr('data-more') == 0) {
		$(this).attr('data-more', 1);
		$(this).css('display', 'block');
		$(this).text('Read Less');

		$(this).prev().css('display', 'none');
		$(this).prev().prev().css('display', 'inline');
	}
	// If text is shown complete, then show less
	else if(this.getAttribute('data-more') == 1) {
		$(this).attr('data-more', 0);
		$(this).css('display', 'inline');
		$(this).text('Read More');

		$(this).prev().css('display', 'inline');
		$(this).prev().prev().css('display', 'none');
	}
    });
} );
</script>

<?php require_once __DIR__ . '/_footer.php'; ?>