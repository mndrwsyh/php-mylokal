<?php

if ( !isAdmin() ) {
  header("Location: /home"); 
    exit;
}


  // TODO: 1. connect to database
  $database = connectToDB();
  // TODO: 2. get all the users
  // TODO: 2.1
  $sql = "SELECT * FROM users ORDER BY users.id DESC";
  // TODO: 2.1
  $query = $database->query( $sql );
  // TODO: 2.3
  $query->execute();
  // TODO: 2.4
  $users = $query->fetchAll();
?>
<?php require "parts/header_back.php"; ?>

<div id="users">
<div class="container mx-auto my-5" style="max-width: 900px;">
      <div class="mb-5">
        <h1 class="h1 text-center">Manage Users</h1>
        </div>
          <!--success message-->
          <?php require "parts/message_success.php"; ?>
          <?php require "parts/message_error.php"; ?>
      <div class="card mb-2 p-4">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Profile Picture</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Role</th>
              <th scope="col" class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
          <!--3. use foreach to display all the users-->
      <?php
        foreach ($users as $user) { ?>
            <tr>
              <td><img src="<?php echo $user["image"]; ?>" class="border border-2 border-primary rounded-circle" style="width: 45px; border-radius: 100%;" alt="..."></td>
              <td class="pt-3"><?php echo $user["name"]; ?></td>
              <td class="pt-3"><?php echo $user["email"]; ?></td>
              
              <?php if ($user["role"]=="user") {?>
              <td class="pt-3"><span class="badge bg-success"><?php echo $user["role"]; ?></span></td>

              <?php } else if ($user["role"]=="admin") {?>
              <td class="pt-3"><span class="badge bg-danger"><?php echo $user["role"]; ?></span></td>

              <?php } else {?>
              <td class="pt-3"><span class="badge bg-warning"><?php echo $user["role"]; ?></span></td>
              <?php } ?>

              <td class="pt-3">
                <div class="buttons d-flex justify-content-end">
                    <a 
                    data-bs-toggle="modal"
                    data-bs-target="#userModal<?php echo $user["id"]; ?>"
                    class="btn btn-success btn-sm me-2"
                    ><i class="bi bi-pencil"></i
                  ></a>

                  <!-- edit user modal -->
                  <div class="modal fade" id="userModal<?php echo $user["id"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog mt-4">
                        <div class="modal-content bg-transparent border-0">
                        <div
                            class="card rounded shadow-sm mx-auto mt-5 my-4 p-1"
                        >
                            <div class="card-body" style="width: 490px; min-height: 350px">
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                            <!--display error-->
                            <div class="mt-3">
                            <?php require "parts/message_error.php"; ?>
                            <!--display success-->
                            <?php require "parts/message_success.php"; ?>
                            </div>
                            <h5 class="card-title text-center mb-3 pb-3 border-bottom">
                                Update User
                            </h5>
                            <!-- login form-->
                            <form method="POST" action="/user/update" enctype="multipart/form-data">
                            <div class="mb-3">
                              <div class="d-flex justify-content-center align-items-center flex-column">
                                <label class="form-label">Profile Picture</label>
                                <img src="/<?= $user["image"];?>" class="img-fluid mt-1 border border-2 border-primary rounded-circle" style="width: 150px; border-radius: 100%;" alt="...">
                                <input class="mt-2 ms-5 ps-4" type="file" name="image" accept="image/*">
                              </div>
                            </div>  
                            <div class="mb-3">
                                <div class="row">
                                <div class="col">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $user["name"]; ?>"/>
                                </div>
                                <div class="col">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $user["email"]; ?>" disabled />
                                </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-control" id="role" name="role" value="<?php echo $user["role"]; ?>">
                                <option value="">Select an option</option>
                                <option value="user" <?php echo ( $user["role"] === "user" ? "selected" : "" ); ?>>User</option>
                                <option value="editor"<?php echo ( $user["role"] === "editor" ? "selected" : "" ); ?>>Editor</option>
                                <option value="admin" <?php echo ( $user["role"] === "admin" ? "selected" : "" ); ?>>Admin</option>
                                </select>
                            </div>
                            <div class="d-grid">
                            <input type="hidden" id="id" name="id" value="<?php echo $user["id"]; ?>"/>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                            </form>
                            </div>
                        </div>
                        </div>
                    </div>
                  </div>
                  

                  <!-- delete trigger modal -->
                  <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#userDeleteModal-<?php echo $user["id"]; ?>">
                  <i class="bi bi-trash"></i>
                  </button>

                  <!-- delete user modal -->
                  <div class="modal fade" id="userDeleteModal-<?php echo $user["id"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">
                          Are you sure you want to delete this user?</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                          This action cannot be reversed.
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                          <form 
                            method="POST" 
                            action="/user/delete">
                              <input type="hidden" name="user_id" value="<?php echo $user["id"]; ?>" />
                                <button class="btn btn-sm btn-danger">
                                  <i class="bi bi-trash me-2"></i>Delete
                                </button>
                          </form>
                        </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <!-- <div class="text-center">
        <a href="/dashboard" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back to Dashboard</a
        >
      </div> -->
    </div>
</div>

<?php require "parts/footer.php"; ?>