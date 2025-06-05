<!--display error-->
<?php if ( isset( $_SESSION['signuperror'] ) ) : ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $_SESSION['signuperror']; ?>
        <?php 
            // clear signuperror message after rendering it
            unset( $_SESSION['signuperror'] );
        ?>
    </div>
<?php endif; ?>