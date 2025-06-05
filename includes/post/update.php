<?php

    $database = connectToDB();


    $title = $_POST["post-title"];
    $content = $_POST["post-content"];
    $rating = $_POST["post-rating"];
    $image = $_FILES["image"];
    $id = $_POST["id"];
    $state_id = $_POST['state_id'];
    $categories_id = $_POST['category_id'];
    

    if (empty($title) || empty($content) || empty($rating)) {
        $_SESSION["error"] = "All fields are required. Post failed to update.";
        header('Location: ' . $_SERVER['HTTP_REFERER']); 
        exit;
    }

    if (!empty( $image["name"] )) {
        //where is the upload folder
        $target_folder = "uploads/";
        //add image name to upload folder path
        $target_path = $target_folder . basename( $image["name"] );
        //move the file to the uploads folder
        move_uploaded_file( $image["tmp_name"] , $target_path );

        $sql = "UPDATE posts SET title = :title, content = :content, image = :image, states_id = :states_id, categories_id = :categories_id, rating = :rating WHERE id=:id";
    $query = $database->prepare( $sql );
    $query->execute([
        "title" => $title,
        "content" => $content,
        "image" => $target_path,
        "states_id" => $state_id,
        "categories_id" => $categories_id,
        "rating" => $rating,
        "id" => $id
    ]);

    } else {
        $sql = "UPDATE posts SET title = :title, content = :content, states_id = :states_id, categories_id = :categories_id, rating = :rating WHERE id=:id";
    $query = $database->prepare( $sql );
    $query->execute([
        "title" => $title,
        "content" => $content,
        "states_id" => $state_id,
        "categories_id" => $categories_id,
        "rating" => $rating,
        "id" => $id
    ]);
    }

    $_SESSION["success"] = "Post has been updated.";
    header('Location: ' . $_SERVER['HTTP_REFERER']); 
    exit;

?>