<?php 

$database = connectToDB();

// get all the data from the login page
$email = $_POST["email"];
$password = $_POST["password"];
$id = $_POST["id"];

if (
    empty($email) ||
    empty($password) 
) {
    $_SESSION["loginerror"] = "All fields are required";
    // redirect back to login page
    $_SESSION['login_modal'] = true;
    header("Location: /");
    exit;
} else {
    $user = getUserByEmail( $email ); 

    //check if the user exist or not
    if ( $user ){
        // check if password correct or not
        if ( password_verify( $password, $user["password"] ) ) {
            // store the user data in the session storage to login the user
            $_SESSION["user"] = $user;

            // set success message
            $_SESSION["success"] = "Welcome back, ". $user["name"] . "!";

            // redirect user back to index php
            header("Location: /");
            exit;
        } else {
            $_SESSION["loginerror"] = "The password provided is incorrect";
        
            // redirect back to login page
            $_SESSION['login_modal'] = true;
            header("Location: /");
            exit;
        }
    } else {
        $_SESSION["loginerror"] = "The email provided does not exist";

        // redirect back to login page
        $_SESSION['login_modal'] = true;
        header("Location: /");
        exit;
    }

}
