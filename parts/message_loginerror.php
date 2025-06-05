<!--display error-->
<?php if ( isset( $_SESSION['loginerror'] ) ) : ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $_SESSION['loginerror']; ?>
        <?php 
            // clear loginerror message after rendering it
            unset( $_SESSION['loginerror'] );
        ?>
    </div>
<?php endif; ?>