<!--display error-->
<?php if ( isset( $_SESSION['error'] ) ) : ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $_SESSION['error']; ?>
        <?php 
            // clear error message after rendering it
            unset( $_SESSION['error'] );
        ?>
    </div>
<?php endif; ?>