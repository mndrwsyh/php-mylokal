<?php

    $database = connectToDB();
    
    $image = $_FILES["image"];
    $user_id = $_POST["user_id"];

    
     if (!empty( $image["name"] )) {
        //where is the upload folder
        $target_folder = "uploads/";
        //add image name to upload folder path
        $target_path = $target_folder . basename( $image["name"] );
        //move the file to the uploads folder
        move_uploaded_file( $image["tmp_name"] , $target_path );

        $sql = "UPDATE users SET image = :image WHERE id=:id";
    $query = $database->prepare( $sql );
    $query->execute([
        "image" => $target_path,
        "id" => $user_id
    ]);

    $_SESSION["user"]["image"] = $target_path;
}

    $_SESSION["success"] = "User image has been updated!";
    
    header("Location: /account");
    exit;
?>


