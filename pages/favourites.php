<?php

if ( !isUserLoggedIn() ) {
  header("Location: /home"); 
    exit;
}

$database = connectToDB();
    
$sql = "SELECT liked.*, posts.*, states.name AS states_name, categories.name  
FROM liked 
JOIN posts ON liked.posts_id = posts.id 
JOIN states ON posts.states_id = states.id 
JOIN categories ON posts.categories_id = categories.id 
WHERE liked.users_id = :users_id";
            
$query = $database->prepare( $sql );

$query->execute([
    "users_id" => $_SESSION["user"]["id"]   
]);

$liked = $query->fetchAll(); 


?>



<?php require "parts/header_back.php"; ?>

    <!-- fav act start-->
    <div id="favourites">
            <h1 class="mt-4 text-center">Favourites</h1>
    </div>


        <div id="activities">
            <div class="ms-5 mt-5 text-secondary">
            <div class="container">
          <?php require "parts/message_success.php"; ?>
            <h4>Activities</h4>
          <!--display success-->
            <div class="row pt-3">
          <!--card-->
            <?php foreach ($liked as $post): ?>
            <?php if ($post["categories_id"] === 1): ?>
                <div class="col-3 mb-4">
                <div class="card">
                    <!--like button-->
                <div>
                    <form 
                    method="POST"
                    action="/post/liked">
                    <input type="hidden" name="post_liked" value="<?php echo $liked ? 1 : 0; ?>">
                    <input type="hidden" name="id" value="<?php echo $post["id"] ?>">

                    <?php if (!$liked) {?>
                    <button class="btn btn-sm btn-light position-absolute rounded-circle m-2">
                        <i class="bi bi-heart"></i>
                    </button>

                    <?php } else { ?>
                    <button class="btn btn-sm btn-light position-absolute rounded-circle m-2">
                        <i class="bi bi-heart-fill text-danger"></i>
                    </button>
                    <?php } ?>
                    </form>
                </div>
                <!--end like button-->
                <img src="<?= $post["image"];?>" class="card-img-top" alt="Food Image" style="height:250px;">
                <div class="card-body"> 
                    <h4 class="card-title mb-3"><?= $post["title"];?></h4>
                    <p class="card-text mb-2">
                        <?php if ($post["rating"]=="five") {?>
                        ⭐⭐⭐⭐⭐

                        <?php } else if ($post["rating"]=="four") {?>
                        ⭐⭐⭐⭐

                        <?php } else if ($post["rating"]=="three") {?>
                        ⭐⭐⭐

                        <?php } else if ($post["rating"]=="two") {?>
                        ⭐⭐

                        <?php } else { ($post["rating"]=="one") ?>
                        ⭐
                        <?php } ?>
                    </p> 
                    <p class="card-text"><?= $post["content"];?></p> 
                    <?php if ( isEditor()) : ?>
                    <div class="d-flex justify-content-start align-items-start gap-2 mb-3"> 
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#foodEditModal-<?php echo $post["id"]; ?>">Edit</button> 

                            <!--edit user modal-->
                            <div
                                class="modal fade"
                                id="foodEditModal-<?php echo $post["id"]; ?>"
                                tabindex="-1"
                                aria-labelledby="exampleModalLabel"
                                aria-hidden="true"
                            >
                                <div class="modal-dialog mt-5" style="margin-left: 480px;">
                                <div class="modal-content bg-transparent border-0">
                                    <div
                                    class="card rounded shadow-sm mx-auto"
                                    style="min-width: 550px; max-width:600px;"
                                    >
                                    <div class="card-body" style="width: 600px; min-height: 570px">
                                        <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                        ></button>
                                        <!--display error-->
                                        <?php require "parts/message_error.php"; ?>
                                        <h5 class="card-title text-center mb-3 py-3 border-bottom">
                                        Edit Post
                                        </h5>
                                        <!-- edit post-->
                                        <form action="/post/update" method="POST" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <!-- Select State -->
                                            <select name="state_id" hidden>
                                            <option value="<?= $post["states_id"];?>" selected ><?= $post["states_id"];?></option>
                                            </select>

                                            <!-- Select Category -->
                                            <select name="category_id" hidden>
                                            <option value="2" selected>Food</option>
                                            
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="post-title" class="form-label">Name/Title</label>
                                            <input type="text" class="form-control" id="post-title" name="post-title" value="<?php echo $post["title"]; ?>"/>
                                        </div>
                                        <div class="mb-3">
                                        <div class="mb-3">
                                            <select
                                            class="p-2 rounded-2 border-secondary-subtle"
                                            id="post-rating"
                                            name="post-rating"
                                            >
                                            <option value="five" <?php echo ( $post["rating"] === "five" ? "selected" : "" ); ?>>⭐⭐⭐⭐⭐</option>
                                            <option value="four" <?php echo ( $post["rating"] === "four" ? "selected" : "" ); ?>>⭐⭐⭐⭐</option>
                                            <option value="three" <?php echo ( $post["rating"] === "three" ? "selected" : "" ); ?>>⭐⭐⭐</option>
                                            <option value="two" <?php echo ( $post["rating"] === "two" ? "selected" : "" ); ?>>⭐⭐</option>
                                            <option value="one" <?php echo ( $post["rating"] === "one" ? "selected" : "" ); ?>>⭐</option>
                                            </select>
                                        </div>
                                            <label for="post-content" class="form-label">Description</label>
                                            <textarea
                                            class="form-control"
                                            id="post-content"
                                            rows="6"
                                            name="post-content"
                                            ><?php echo $post["content"]; ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                        <label class="form-label">Image</label>          
                                            <div>
                                            <img src="/<?= $post["image"];?>" class="img-fluid" style="height:150px">
                                            </div>
                                            <input type="file" name="image" accept="image/*">
                                        </div>
                                        <div class="text-end">
                                        <input type="hidden" id="id" name="id" value="<?php echo $post["id"]; ?>"/>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                        </form>
                                        <div class="text-center gap-3 mx-auto pt-1">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-danger btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#foodDeleteModal-<?php echo $post["id"]; ?>">Delete
                            </button>

                            <!-- delete user modal -->
                            <div class="modal fade" id="foodDeleteModal-<?php echo $post["id"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                    Are you sure you want to delete this post?</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                    This action cannot be reversed.
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                    <form 
                                        method="POST" 
                                        action="/post/delete">
                                        <input type="hidden" name="user_id" value="<?php echo $post["id"]; ?>" />
                                            <button class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash me-2"></i> Delete
                                            </button>
                                    </form>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            <!--button end-->
                        </div>
                    <?php endif; ?>
                    <h6 class="text-secondary">Location: <?php echo $post["states_name"] ?></h6>
                </div> 
                </div> 
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>


    <!-- fav food start -->
        <div id="food">
            <div class=" mt-5 text-secondary">
            <div class="container">
            <h4>Restaurants/Food</h4>
          <!--display success-->
            <div class="row pt-3">
          <!--card-->
            <?php foreach ($liked as $post): ?>
            <?php if ($post["categories_id"] === 2): ?>
                <div class="col-3 mb-4">
                <div class="card">
                    <!--like button-->
                <div>
                    <form 
                    method="POST"
                    action="/post/liked">
                    <input type="hidden" name="post_liked" value="<?php echo $liked ? 1 : 0; ?>">
                    <input type="hidden" name="id" value="<?php echo $post["id"] ?>">

                    <?php if (!$liked) {?>
                    <button class="btn btn-sm btn-light position-absolute rounded-circle m-2">
                        <i class="bi bi-heart"></i>
                    </button>

                    <?php } else { ?>
                    <button class="btn btn-sm btn-light position-absolute rounded-circle m-2">
                        <i class="bi bi-heart-fill text-danger"></i>
                    </button>
                    <?php } ?>
                    </form>
                </div>
                <!--end like button-->
                <img src="<?= $post["image"];?>" class="card-img-top" alt="Food Image" style="height:250px;">
                <div class="card-body"> 
                    <h4 class="card-title mb-3"><?= $post["title"];?></h4>
                    <p class="card-text mb-2">
                        <?php if ($post["rating"]=="five") {?>
                        ⭐⭐⭐⭐⭐

                        <?php } else if ($post["rating"]=="four") {?>
                        ⭐⭐⭐⭐

                        <?php } else if ($post["rating"]=="three") {?>
                        ⭐⭐⭐

                        <?php } else if ($post["rating"]=="two") {?>
                        ⭐⭐

                        <?php } else { ($post["rating"]=="one") ?>
                        ⭐
                        <?php } ?>
                    </p> 
                    <p class="card-text"><?= $post["content"];?></p> 
                    <?php if ( isEditor()) : ?>
                    <div class="d-flex justify-content-start align-items-start gap-2 mb-3"> 
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#foodEditModal-<?php echo $post["id"]; ?>">Edit</button> 

                            <!--edit user modal-->
                            <div
                                class="modal fade"
                                id="foodEditModal-<?php echo $post["id"]; ?>"
                                tabindex="-1"
                                aria-labelledby="exampleModalLabel"
                                aria-hidden="true"
                            >
                                <div class="modal-dialog mt-5" style="margin-left: 480px;">
                                <div class="modal-content bg-transparent border-0">
                                    <div
                                    class="card rounded shadow-sm mx-auto"
                                    style="min-width: 550px; max-width:600px;"
                                    >
                                    <div class="card-body" style="width: 600px; min-height: 570px">
                                        <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                        ></button>
                                        <!--display error-->
                                        <?php require "parts/message_error.php"; ?>
                                        <h5 class="card-title text-center mb-3 py-3 border-bottom">
                                        Edit Post
                                        </h5>
                                        <!-- edit post-->
                                        <form action="/post/update" method="POST" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <!-- Select State -->
                                            <select name="state_id" hidden>
                                            <option value="<?= $post["states_id"];?>" selected ><?= $post["states_id"];?></option>
                                            </select>

                                            <!-- Select Category -->
                                            <select name="category_id" hidden>
                                            <option value="2" selected>Food</option>
                                            
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="post-title" class="form-label">Name/Title</label>
                                            <input type="text" class="form-control" id="post-title" name="post-title" value="<?php echo $post["title"]; ?>"/>
                                        </div>
                                        <div class="mb-3">
                                        <div class="mb-3">
                                            <select
                                            class="p-2 rounded-2 border-secondary-subtle"
                                            id="post-rating"
                                            name="post-rating"
                                            >
                                            <option value="five" <?php echo ( $post["rating"] === "five" ? "selected" : "" ); ?>>⭐⭐⭐⭐⭐</option>
                                            <option value="four" <?php echo ( $post["rating"] === "four" ? "selected" : "" ); ?>>⭐⭐⭐⭐</option>
                                            <option value="three" <?php echo ( $post["rating"] === "three" ? "selected" : "" ); ?>>⭐⭐⭐</option>
                                            <option value="two" <?php echo ( $post["rating"] === "two" ? "selected" : "" ); ?>>⭐⭐</option>
                                            <option value="one" <?php echo ( $post["rating"] === "one" ? "selected" : "" ); ?>>⭐</option>
                                            </select>
                                        </div>
                                            <label for="post-content" class="form-label">Description</label>
                                            <textarea
                                            class="form-control"
                                            id="post-content"
                                            rows="6"
                                            name="post-content"
                                            ><?php echo $post["content"]; ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                        <label class="form-label">Image</label>          
                                            <div>
                                            <img src="/<?= $post["image"];?>" class="img-fluid" style="height:150px">
                                            </div>
                                            <input type="file" name="image" accept="image/*">
                                        </div>
                                        <div class="text-end">
                                        <input type="hidden" id="id" name="id" value="<?php echo $post["id"]; ?>"/>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                        </form>
                                        <div class="text-center gap-3 mx-auto pt-1">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            

                            <button type="button" class="btn btn-danger btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#foodDeleteModal-<?php echo $post["id"]; ?>">Delete
                            </button>

                            <!-- delete user modal -->
                            <div class="modal fade" id="foodDeleteModal-<?php echo $post["id"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                    Are you sure you want to delete this post?</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                    This action cannot be reversed.
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                    <form 
                                        method="POST" 
                                        action="/post/delete">
                                        <input type="hidden" name="user_id" value="<?php echo $post["id"]; ?>" />
                                            <button class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash me-2"></i> Delete
                                            </button>
                                    </form>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            <!--button end-->
                    </div>
                    <?php endif; ?>
                    <h6 class="text-secondary">Location: <?php echo $post["states_name"] ?></h6>
                </div> 
                </div> 
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
    

<?php require "parts/footer.php"; ?>