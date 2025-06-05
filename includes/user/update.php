<?php

    $database = connectToDB();

    $name = $_POST["name"];
    $role = $_POST["role"];
    $id = $_POST["id"];
    $image = $_FILES["image"];

    if ( empty($name) || empty($role) || empty($id) ) {
        $_SESSION["error"] = "All fields are required. Users failed to update.";
        header("Location: /users");
        exit;
    }

    if (!empty( $image["name"] )) {
        //where is the upload folder
        $target_folder = "uploads/";
        //add image name to upload folder path
        $target_path = $target_folder . basename( $image["name"] );
        //move the file to the uploads folder
        move_uploaded_file( $image["tmp_name"] , $target_path );

        
    $sql = "UPDATE users SET name = :name, role = :role, image = :image WHERE id=:id";
    $query = $database->prepare( $sql );
    $query->execute([
        "name" => $name,
        "role" => $role,
        "image" => $target_path,
        "id" => $id
    ]);

    } else {

    $sql = "UPDATE users SET name = :name, role = :role WHERE id=:id";
    $query = $database->prepare( $sql );
    $query->execute([
        "name" => $name,
        "role" => $role,
        "id" => $id
    ]);

    }

    $_SESSION["success"] = "User has been updated.";
    header("Location: /users"); 
    exit;
?>