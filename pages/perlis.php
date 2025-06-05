<?php

if ( !isUserLoggedIn() ) {
  header("Location: /home"); 
    exit;
}

$database = connectToDB();
    
  $sql = "SELECT posts.*, states.name, categories.name FROM posts 
  JOIN states ON posts.states_id = states.id 
  JOIN categories ON posts.categories_id = categories.id 
  WHERE states.name = 'Perlis' 
  ORDER BY posts.id ASC";
  
  $query = $database->prepare( $sql );
  
  $query->execute();
  
  $posts = $query->fetchAll();  


?>
<?php require "parts/header_back.php"; ?>

  <div id="intro">
    <div class="d-flex flex-column align-items-center container mt-4">
      <h1>Perlis Indera Kayangan</h1>
      <p class="text-secondary">
        Discover the most popular places in Perlis!
      </p>
    </div>
  </div>

<?php require "parts/state_content.php"; ?>
 
<?php require "parts/footer.php"; ?>
