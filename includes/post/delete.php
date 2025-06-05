<?php


    $database = connectToDB();

    // get the user_id from the form
    $user_id = $_POST["user_id"];
    
    // delete the post
    if(empty($user_id)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']); 
        exit;
    }

    $sql = "DELETE FROM posts WHERE id = :id";
    $query = $database->prepare( $sql );
    $query->execute([
        "id" => $user_id
    ]);

    $_SESSION["success"] = "Post has been deleted.";
    header('Location: ' . $_SERVER['HTTP_REFERER']); 
    exit;
?>