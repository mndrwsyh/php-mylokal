<?php

$database = connectToDB();

$post_liked = $_POST["post_liked"];
$id = $_POST["id"];
$user_id = $_SESSION["user"]["id"];

if (!$post_liked) {
    $sql = "INSERT INTO liked (posts_id,users_id) VALUES (:posts_id, :users_id)";

    $query = $database->prepare($sql);

    $query->execute([
        "users_id" => $user_id,
        "posts_id" => $id
]); 
$_SESSION["success"] = "Post has been added to <a href='/favourites' class='text-black'>favourites</a>.";

} else {
    $sql = "DELETE FROM liked WHERE posts_id = :posts_id AND users_id = :users_id";

    $query = $database->prepare($sql);

    $query->execute([
        "users_id" => $user_id,
        "posts_id" => $id
]);
$_SESSION["success"] = "Post has been removed from favourites.";

}

header('Location: ' . $_SERVER['HTTP_REFERER']); 
    exit;

?>