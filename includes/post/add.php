<?php

    $database = connectToDB();


    $title = $_POST["post-title"];
    $content = $_POST["post-content"];
    $rating = $_POST["post-rating"];
    $image = $_FILES["image"];
    $state_id = $_POST['state_id'];
    $categories_id = $_POST['category_id'];
    
    
    if (empty($title) || empty($content) || empty($image) ) {
        $_SESSION['error'] = "You must fill in all the fields to post.";
        header('Location: ' . $_SERVER['HTTP_REFERER']); 
        exit;
    } 

    if ( !empty( $image )) {
        //where the upload folder is
        $target_folder = "uploads/";
        //add image name to upload folder path
        $target_path = $target_folder . date( "YmdHisv" ) . "_" . basename( $image["name"] );
        //move the file to the uploads folder
        move_uploaded_file( $image["tmp_name"] , $target_path );
    }

    $sql = "INSERT INTO posts (`title`, `content`, `image`, `rating`, `states_id`, `categories_id`, `users_id`) VALUES (:title, :content, :image, :rating, :states_id, :categories_id, :user_id)";
    $query = $database->prepare($sql);
    $query -> execute([ 
        "title" => $title,
        "content" => $content,
        "rating" => $rating,
        "image" => isset( $target_path ) ? $target_path : "",
        "states_id" => $state_id,
        "categories_id" => $categories_id,
        "user_id" => $_SESSION["user"]["id"]
    ]);
    
    $_SESSION["success"] = "Your post has been posted!";
    
    header('Location: ' . $_SERVER['HTTP_REFERER']); 
    exit;
   

    



    // TODO: 4. create the user account. You need to assign the role to the user
    /*
        role options:
        - user
        - editor
        - admin

*/ 
?>


