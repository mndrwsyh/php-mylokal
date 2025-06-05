<?php

if ( !isUserLoggedIn() ) {
  header("Location: /home"); 
    exit;
}

$database = connectToDB();
    

 $sql = "SELECT * FROM users";
  $query = $database->prepare( $sql );
  $query->execute();
  $users = $query->fetch();
?>



<?php require "parts/header_back.php"; ?>

    <!-- account start-->
    <div id="account">
        <div class="container">
            <h1 class="mt-4 text-center">My Account</h1>
            <div class="card rounded shadow-sm mx-auto mt-4 py-3" style="width: 800px">
                <div class="card-body">
                <?php require "parts/message_success.php"; ?>
                    <!-- <h3 class="card-title mb-3 text-center">My Account</h3> -->
                    <!--profile pic start-->
                    <div class="d-flex justify-content-center align-items-center mt-1">
                        <img src="<?php echo $_SESSION["user"]["image"]; ?>" class="border border-2 border-primary rounded-circle" style="width: 150px; border-radius: 100%;" alt="...">
                    </div>
                    <form method="POST" action="/user/img/update" enctype="multipart/form-data">
                    <div class="d-flex justify-content-center align-items-center mt-2">  
                            <input type="file" name="image" accept="image/*" style="width:150px;">
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION["user"]["id"]; ?>" />
                            <button type="submit" class="ms-3 btn btn-sm btn-primary">Update</button>
                    </div>
                    </form>

                    <!--username start-->
                    <div class="d-flex justify-content-center align-items-center mt-5">
                        <div class="container d-flex justify-content-between border-bottom" style="width:500px;">
                        <h5><i class="bi bi-person me-3 text-secondary"></i><?php echo $_SESSION["user"]["name"]; ?></h5>
                        <!--update button-->
                        <div class="collapse" id="collapse-<?php echo $_SESSION["user"]["id"]; ?>">
                        <form 
                        method="POST" 
                        action="/user/name/update">
                        <input type="text" name="user_name" value="<?php echo $_SESSION["user"]["name"]; ?>" />
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION["user"]["id"]; ?>" />
                        <button class="btn btn-primary btn-sm"><i class="bi bi-floppy"></i></button>
                        </form>
                        </div>
                        <button class="btn btn-transparent btn-sm" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $_SESSION["user"]["id"]; ?>">
                        <i class="bi bi-pencil fs-5"></i>
                        </button>
                        
                        </div>
                    </div>

                    <!--email start-->
                    <div class="d-flex justify-content-center align-items-center mt-3">
                        <div class="container d-flex border-bottom justify-content-between" style="width:500px;">
                            <div>
                            <h5><i class="bi bi-envelope me-3 text-secondary"></i><?php echo $_SESSION["user"]["email"]; ?></h5>
                            </div>
                            <div>
                            <?php if ($_SESSION["user"]["role"]=="user") {?>
                            <h5 class="badge bg-success"></i><?php echo $_SESSION["user"]["role"]; ?></h5>
                            <?php } else if ($_SESSION["user"]["role"]=="admin") {?>
                            <h5 class="badge bg-danger"></i><?php echo $_SESSION["user"]["role"]; ?></h5>
                            <?php } else {?>
                            <h5 class="badge bg-warning"></i><?php echo $_SESSION["user"]["role"]; ?></h5>
                            <?php }; ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
<?php require "parts/footer.php"; ?>