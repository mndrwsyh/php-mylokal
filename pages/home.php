<?php
$database = connectToDB();
    
  if ( !isUserLoggedIn() ) {
  $sql = "SELECT * FROM states LIMIT 3";
  } else {
  $sql = "SELECT * FROM states";
  }
  $query = $database->prepare( $sql );
  $query->execute();
  $states = $query->fetchAll();   


  $sql = "SELECT * FROM users";
  $query = $database->prepare( $sql );
  $query->execute();
  $users = $query->fetch();

  
  $sql = "SELECT reviews.*, users.name, users.image FROM reviews JOIN users ON reviews.users_id = users.id ORDER BY reviews.id DESC";
  $query = $database->prepare( $sql );
  $query->execute();

  $reviews = $query->fetchAll();
?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MyLokal</title>
    <link href="style.css" rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <!--header start-->
    <div id="header">
      <header class="fixed-header bg-body-tertiary p-2">
        <div class="logo">
          <h2 class="mt-1 text-decoration-none text-primary">
            <a href="/" id="logo">MyLokal</a>
          </h2>
        </div>
        <div class="nav">
          <a href="#travel" class="mt-2">Travel</a>
          <a href="#review" class="mt-2">Reviews</a>
          <!-- <div data-bs-theme="dark"> -->
          <button
            type="button"
            class="btn btn-dark bg-transparent border-0"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            <?php if ( isUserLoggedIn()) : ?>
              <img src="<?php echo $_SESSION["user"]["image"]; ?>" class="ms-0 mt-1 border border-2 border-primary rounded-circle" style="width: 40px; border-radius: 100%;" alt="...">
            <?php else : ?>
            <i class="bi bi-gear text-dark fs-2"></i>
            <?php endif; ?>
            

          </button>
          <ul class="dropdown-menu">
            <?php if ( isAdmin()) : ?>
              <li>
                <a class="dropdown-item" href="/users"
                  ><i class="bi bi-pencil me-2"></i>Users</a
                >
              </li>
            <?php endif; ?>
            <?php if ( isUserLoggedIn()) : ?>
              <li>
                <a class="dropdown-item" href="/account"
                  ><i class="bi bi-person me-2"></i>My Account</a
                >
              </li>
            <?php endif; ?>
            <?php if ( isUserLoggedIn()) : ?>
              <li>
                <a class="dropdown-item" href="/favourites"
                  ><i class="bi bi-heart me-2"></i>Favourites</a
                >
              </li>
            <?php endif; ?>
            <?php if ( isUserLoggedIn()) : ?>
            <li>
              <hr class="dropdown-divider" />
            </li>
            <?php endif; ?>
            <!-- Button trigger modal -->
            <?php if ( isUserLoggedIn()) : ?>
              <li>
                <a class="dropdown-item pt-1" href="/logout"
                  ><i class="bi bi-box-arrow-left me-2"></i>Log Out</a
                >
              </li>
            <?php else: ?>
              <li>
                <a
                  class="dropdown-item"
                  class="bg-transparent"
                  data-bs-toggle="modal"
                  data-bs-target="#exampleModal"
                  >
                  <i class="bi bi-box-arrow-right me-2"></i>Log In</a
                >
              </li>
            <?php endif; ?>
          </ul>
        </div>
        <!-- </div> -->
      </header>
    </div>

    <!-- login modal -->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog mt-5 pt-5">
        <div class="modal-content bg-transparent border-0">
          <div
            class="card rounded shadow-sm mx-auto my-4"
            style="max-width: 500px"
          >
            <div class="card-body" style="width: 450px; min-height: 400px">
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
              <!--display error-->
              <div class="mt-3">
              <?php require "parts/message_loginerror.php"; ?>
              <!--display success-->
              <?php require "parts/message_success.php"; ?>
            </div>
              <h5 class="card-title text-center mb-3 py-3 border-bottom">
                Login To Your Account
              </h5>
              <!-- login form-->
              <form action="/auth/login" method="POST">
                <div class="mb-3">
                  <label for="email" class="form-label">Email address</label>
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                  />
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                  />
                </div>
                <div class="d-grid">
                  <button type="submit" class="btn btn-primary btn-fu">
                    Login
                  </button>
                </div>
              </form>
              <div class="text-center gap-3 mx-auto pt-1">
                <a
                  href="#"
                  class="text-decoration-none small"
                  data-bs-toggle="modal"
                  data-bs-target="#newModal"
                  >Don't have an account? Register now!
                  <i class="bi bi-arrow-right-circle"></i
                ></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- register modal -->
    <div
      class="modal fade"
      id="newModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog mt-5 pt-2">
        <div class="modal-content bg-transparent border-0">
          <div
            class="card rounded shadow-sm mx-auto my-4"
            style="max-width: 500px"
          >
            <div class="card-body" style="width: 450px; min-height: 560px">
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
              <?php require "parts/message_signuperror.php"; ?>
              <!--display success-->
              <h5 class="card-title text-center mb-3 py-3 border-bottom">
                Create A New Account
              </h5>
              <!-- login form-->
              <form action="/auth/signup" method="POST">
                <div class="mb-3">
                  <label for="email" class="form-label">Name</label>
                  <input
                    type="name"
                    class="form-control"
                    id="name"
                    name="name"
                  />
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email address</label>
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                  />
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                  />
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Confirm Password</label>
                  <input
                    type="password"
                    class="form-control"
                    id="confirm_password"
                    name="confirm_password"
                  />
                </div>
                <div class="d-grid">
                  <button type="submit" class="btn btn-primary btn-fu">
                    Sign Up
                  </button>
                </div>
              </form>
              <div class="text-center gap-3 mx-auto pt-1">
                <a
                  href="/signup"
                  class="text-decoration-none small"
                  data-bs-toggle="modal"
                  data-bs-target="#exampleModal"
                  >Already have an account? Log in here!
                  <i class="bi bi-arrow-right-circle"></i
                ></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- header end -->

    <!--travel start-->
    <div id="travel">
      <div class="container pt-4 mt-5">
      <!--display success-->
      <div class="travel-title text-center mt-5 mb-5">
      <h4 class="text-muted"><?php echo ( isUserLoggedIn() ? "Hello, " . $_SESSION["user"]["name"] : ""); ?></h4>
          <h1>Explore The Top Destinations In Malaysia!</h1>
          <p>
            Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem
            ipsum
          </p>
        </div>
        <div class="row pt-3">
          <!--1st card-->
          <?php foreach ( $states as $state ) : ?>
          <div class="col-4 mb-4">
            <div class="card">
              <!--like button-->
              <!-- <button
                class="btn btn-sm btn-light position-absolute rounded-circle m-2"
              >
                <i class="bi bi-heart"></i>
              </button> -->
              <!--end like button-->
              <img
                src="<?= $state["image"];?>"
                style="height: 250px;"
                class="card-img-top"
                alt="..."
              />
              <div class="card-body">
                <h3 class="card-title mb-3"><?= $state["name"];?></h3>
                <div class="d-flex justify-content-between align-items-center">
                  <button
                    type="button"
                    class="btn btn-sm btn-outline-secondary"
                  >
                    <?php if ( !isUserLoggedIn()) : ?>
                      <div 
                      data-bs-toggle="modal"
                      data-bs-target="#exampleModal"
                      >
                      View
                    </div>
                    <?php  else : ?>
                    <a
                      href="<?= $state["url"];?>"
                      class="text-decoration-none text-body-secondary"
                      >View</a
                    >
                    <?php endif; ?>
                  </button>
                  <small class="text-body-secondary">Find out what to do in <?= $state["name"];?>!</small>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
          <?php if ( !isUserLoggedIn()) : ?>
            <div 
            class="btn btn-primary btn-lg rounded-5 mt-2 p-2"
            style="width:150px; margin-left: 590px"
            data-bs-toggle="modal"
            data-bs-target="#exampleModal"
            >
            View More
          </div>
          <?php endif; ?>
          <!--2ndst card-->
          
        </div>
      </div>
    </div>
    <!--travel end-->

    <!--Review start-->
    <div id="review">
      <div class="container pt-4 mt-5"  style="width:1000px;">
        <div class="travel-title text-center mt-5 pt-3">
          <h1>Leave Your Reviews Here!</h1>
          <p>
            Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem
            ipsum
          </p>
        </div>
        <!--display error-->
          <?php require "parts/message_reviewerror.php"; ?>
          <!--display success-->
          <?php require "parts/message_reviewsuccess.php"; ?>
        
        <form
          method="POST"
          action="/review/add"
          enctype="multipart/form-data"
          class="mt-5 d-flex align-items-center gap-2"
        >
          <input
            type="text"
            id="review-text"
            name="review-text"
            class="form-control border-secondary-subtle"
            placeholder="Type your review..."
          />
          <select
            class="p-2 rounded-2 border-secondary-subtle"
            id="review-rating"
            name="review-rating"
          >
            <option value="five">⭐⭐⭐⭐⭐</option>
            <option value="four">⭐⭐⭐⭐</option>
            <option value="three">⭐⭐⭐</option>
            <option value="two">⭐⭐</option>
            <option value="one">⭐</option>
          </select>
          <button class="btn btn-primary <?php echo ( !isUserLoggedIn() ? "disabled" : ""); ?>">Submit</button>
        </form>
      
        
        <?php foreach ($reviews as $index => $review) : ?>
          <div class="card mt-4 mb-4 pb-0">
            <div class="card-body">
              <div class="d-flex justify-content-between">
              <span><i class="bi bi-quote fs-2 text-muted"></i></span>
              <span class="fs-4">
              <?php if ($review["rating"]=="five") {?>
                ⭐⭐⭐⭐⭐

              <?php } else if ($review["rating"]=="four") {?>
                ⭐⭐⭐⭐

              <?php } else if ($review["rating"]=="three") {?>
                ⭐⭐⭐

              <?php } else if ($review["rating"]=="two") {?>
                ⭐⭐

              <?php } else { ($review["rating"]=="one") ?>
                ⭐
              <?php } ?>
              </span>
              </div>
              <figure>
                <blockquote class="blockquote ms-1 mb-3">
                  <p><?= $review["text"];?></p>
                </blockquote>
                <div class="d-flex ms-1 mb-0">
                  <img src="<?php echo $review["image"]; ?>" class="me-2" style="width: 30px; height: 30px; border-radius: 100%;" alt="...">
                  <p class="text-secondary"><?= $review["name"];?></p>
                </div>
                
                <?php if (isAdmin()) : ?>
                <div class="d-flex justify-content-end align-items-end">
                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-danger btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#userDeleteModal-<?php echo $review["id"]; ?>">
                  <i class="bi bi-trash me-2"></i> Delete
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="userDeleteModal-<?php echo $review["id"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">
                          Are you sure you want to delete this review?</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                          This action cannot be reversed.
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                          <form 
                            method="POST" 
                            action="/review/delete">
                              <input type="hidden" name="user_id" value="<?php echo $review["id"]; ?>" />
                                <button class="btn btn-sm btn-danger">
                                  <i class="bi bi-trash me-2"></i>Delete
                                </button>
                          </form>
                        </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php endif; ?>
              </figure>
            </div>
          </div> 
        <?php endforeach; ?>
      </div>
    </div>
    <!--Review end-->

      <!--footer start-->
    <footer id="footer" class="mt-5 pt-4 pb-4 text-center bg-primary text-white">
      <p class="m-0">© MyLokal 2025</p>
    </footer>
    <!--footer end-->


  </body>


<?php if (isset($_SESSION['login_modal']) && $_SESSION['login_modal']) { ?>
<script>
  const loginModal = new bootstrap.Modal(document.getElementById('exampleModal')); 
  loginModal.show();
</script>
<?php unset($_SESSION['login_modal']); ?>
<?php } else if (isset($_SESSION['signup_modal']) && $_SESSION['signup_modal']) { ?>
<script>
  const signupModal = new bootstrap.Modal(document.getElementById('newModal')); 
  signupModal.show();
</script>
<?php unset($_SESSION['signup_modal']); ?>
<?php } ?>

</html>
    
