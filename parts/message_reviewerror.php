<!--display error-->
<?php if ( isset( $_SESSION['reviewerror'] ) ) : ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $_SESSION['reviewerror']; ?>
        <?php 
            // clear reviewerror message after rendering it
            unset( $_SESSION['reviewerror'] );
        ?>
    </div>
<?php endif; ?>