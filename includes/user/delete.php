<?php

    $database = connectToDB();

    $user_id = $_POST["user_id"];

    if(empty($user_id)) {
        header("Location: /users");
        exit;
    }

    // delete anything related to the user first, then delete the user

    $sql = "DELETE FROM liked WHERE users_id = :id";
    $query = $database->prepare( $sql );
    $query->execute([
        "id" => $user_id
    ]);
    
    $sql = "DELETE FROM reviews WHERE users_id = :id";
    $query = $database->prepare( $sql );
    $query->execute([
        "id" => $user_id
    ]);
    
    $sql = "DELETE FROM posts WHERE users_id = :id";
    $query = $database->prepare( $sql );
    $query->execute([
        "id" => $user_id
    ]);
    
    $sql = "DELETE FROM users WHERE id = :id";
    $query = $database->prepare( $sql );
    $query->execute([
        "id" => $user_id
    ]);
    
    $_SESSION["success"] = "User successfully deleted.";
    header("Location: /users"); 
    exit;
?>