<?php


    $database = connectToDB();

    $user_id = $_POST["user_id"];
    
    // 3. delete the review
    $sql = "DELETE FROM reviews WHERE id = :id";
    $query = $database->prepare( $sql );
    $query->execute([
        "id" => $user_id
    ]);

    $_SESSION["reviewsuccess"] = "Review has been deleted.";
    header("Location: /#review"); 
    exit;
?>