<?php 

$database = connectToDB();

$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

if (
    empty($name) ||
    empty($email) ||
    empty($password) ||
    empty($confirm_password)
) {
    $_SESSION["signuperror"] = "All the fields are required";
        // redirect back to signup page
        $_SESSION['signup_modal'] = true;
        header("Location: /");
        exit;
} else if ( $password !== $confirm_password) {
        $_SESSION["signuperror"] = "Your password is not matched";
        // redirect back to signup page
        $_SESSION['signup_modal'] = true;
        header("Location: /");
        exit;
} else {
    //panggil function yg check if email dah ada lom
    $user = getUserByEmail( $email ); 

    //check is user exists or not
    if ( $user ) {
        $_SESSION["signuperror"] = "The email provided already exists in our system";
            // redirect back to signup page
            $_SESSION['signup_modal'] = true;
            header("Location: /");
            exit;
    } else {
    $sql = "INSERT INTO users (`name`, `email`, `password`) VALUES (:name, :email, :password)";
    // prepare
    $query = $database->prepare( $sql );
    // execute
    $query->execute([
        "name" => $name,
        "email" => $email,
        "password" => password_hash( $password, PASSWORD_DEFAULT )
    ]);
    

    // set success message
    $_SESSION["success"] = "Account created succesfully! Please login with your email and password";

    // redirect to login.php
    $_SESSION['login_modal'] = true;
    header("Location: /");
    exit;
}

}
