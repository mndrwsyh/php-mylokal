<?php 

$database = connectToDB();


$_SESSION["user"]["name"] = $_POST["user_name"];
$id = $_POST["user_id"];

    $sql = "UPDATE users SET name = :name WHERE id=:id";
    $query = $database->prepare( $sql );
    $query->execute([
        "name" => $_SESSION["user"]["name"],
        "id" => $id
    ]);

$_SESSION["success"] = "User name has been updated.";
header("Location: /account");
exit;


?>