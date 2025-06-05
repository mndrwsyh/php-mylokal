<?php

    $database = connectToDB();
    
    $text = $_POST["review-text"];
    $rating = $_POST["review-rating"];
    $users_id = $_SESSION["user"]["id"];

    
    if (empty($text) || empty($rating) ) {
        $_SESSION["reviewerror"] = "You cannot send an empty review.";
        header("Location: /#review");
        exit;
    } 
    $sql = "INSERT INTO reviews (`text`, `rating`, `users_id`) VALUES (:text, :rating, :users_id)";
    $query = $database->prepare($sql);
    $query -> execute([ 
        "text" => $text,
        "rating" => $rating,
        "users_id" => $users_id
    ]);
    $_SESSION["reviewsuccess"] = "Your review has been posted!";
    
    header("Location: /#review");
    exit;
?>


