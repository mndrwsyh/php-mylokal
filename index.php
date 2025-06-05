<?php
//start the session
session_start();

require "includes/functions.php";
//global variable = $_
//figure out what path the user is visiting
$path = $_SERVER["REQUEST_URI"];
//remove all query string from url
$path = parse_url( $path, PHP_URL_PATH);

//once u figure out the path, then need to load the relevant content based on the path

//fir switch, sequence?? doesnt matter, for else if semau tu matter
switch ($path) {
  //pages routes
  case '/account':
    require "pages/account.php";
    break;
  case '/favourites':
    require "pages/favourites.php";
    break;
  case '/users':
    require "pages/users.php";
    break;
  case '/logout':
    require "pages/logout.php";
    break;
  case '/johor':
    require "pages/johor.php";
    break;
  case '/kedah':
    require "pages/kedah.php";
    break;
  case '/kelantan':
    require "pages/kelantan.php";
    break;
  case '/melaka':
    require "pages/melaka.php";
    break;
  case '/negeri_sembilan':
    require "pages/negeri_sembilan.php";
    break;
  case '/pahang':
    require "pages/pahang.php";
    break;
  case '/penang':
    require "pages/penang.php";
    break;
  case '/perak':
    require "pages/perak.php";
    break;
  case '/perlis':
    require "pages/perlis.php";
    break;
  case '/sabah':
    require "pages/sabah.php";
    break;
  case '/sarawak':
    require "pages/sarawak.php";
    break;
  case '/selangor':
    require "pages/selangor.php";
    break;
  case '/terengganu':
    require "pages/terengganu.php";
    break;
  case '/kuala_lumpur':
    require "pages/kuala_lumpur.php";
    break;

    //action routes
  case '/auth/login':
    require "includes/auth/do_login.php";
    break;
  case '/auth/signup':
    require "includes/auth/do_signup.php";
    break;

    //setup action route for delete user
    case '/user/delete':
      require "includes/user/delete.php";
      break;
    case '/user/img/update':
      require "includes/user/img_update.php";
      break;
    case '/user/name/update':
      require "includes/user/name_update.php";
      break;
    case '/user/update':
      require "includes/user/update.php";
      break;
      
    //for post
    case '/post/add':
      require "includes/post/add.php";
      break;
    case '/post/delete':
      require "includes/post/delete.php";
      break;
    case '/post/liked':
      require "includes/post/liked.php";
      break;
    case '/post/update':
      require "includes/post/update.php";
      break;

    //for review
    case '/review/add':
      require "includes/review/add.php";
      break;
    case '/review/delete':
      require "includes/review/delete.php";
      break;

  default:
  require "pages/home.php";
    break;
}
