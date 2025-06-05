<?php 

//connect to database
function connectToDB() {
$host = "127.0.0.1";
$database_name = "MYLOKAL";
$database_user = "root";
$database_password = "";

$database = new PDO(
    "mysql:host=$host;dbname=$database_name", 
    $database_user, 
    $database_password
);

return $database;
}

//get user data by email
function getUserByEmail( $email ) {

    $database = connectToDB();
    //5. get the user data by email
    //5.1 SQL
    $sql = "SELECT * FROM users WHERE email = :email";
    //5.2 prepare
    $query = $database->prepare( $sql );
    //5.3 execute
    $query->execute ([
        "email" => $email
    ]);
    //5.4 fetch
    $user = $query->fetch();
    
return $user;
}

//check if user is logged in
function isUserLoggedIn() {
    return isset( $_SESSION["user"]);
}

//check if current user is admin
function isAdmin() {
    // check if user's session is available or not
    if ( isset( $_SESSION['user'] ) ) {
        // check if user is an admin
        if ( $_SESSION['user']['role'] === 'admin' ) {
            return true;
        } 
    } 
        
    return false;
}

//check if current user is editor or admin
function isEditor() {
    return isset ($_SESSION["user"]) && ($_SESSION["user"]["role"] === "admin" || $_SESSION["user"]["role"] === 'editor' ? true : false);
}