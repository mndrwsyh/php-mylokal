<!--display success-->
<?php if ( isset( $_SESSION["reviewsuccess"] ) ) : ?>
    <div class="alert alert-success" role="alert">
        <?php echo $_SESSION["reviewsuccess"]; ?>
        <?php 
            // clear reviewsuccess message after rendering it
            unset( $_SESSION["reviewsuccess"] );
        ?>
    </div>
<?php endif; ?>