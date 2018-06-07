<?php
  require_once('./php/database.php');
  session_start(); // Init session

  if (!empty($_POST)) {
    if (empty($_POST['user']) || empty($_POST['password'])) {
      echo "<script>alert('Username or Password is empty')</script>";
    } else {
      $username = mysqli_real_escape_string($conn, $_POST['user']);
      $password = mysqli_real_escape_string($conn, $_POST['password']);
      $sql = "SELECT * FROM login WHERE username = '$username'";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
          $stored_password = $row['password'];
          if (password_verify($password, $stored_password)) {
            // return true;
            $_SESSION['name'] = $row['name'];
            $_SESSION['userId'] = $row['userId'];
            $_SESSION['username'] = $username;
            header('Location: about.php');
          } else {
            // return false;
            echo "<script>alert('Username or Password is invalid')</script>";
          }
        }
      } else {
        echo "<script>alert('User is not registered')</script>";
      }
    }
    mysqli_close($conn);
  }
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" type="image/png" href="img/favicon.png">

    <title>Tilltro</title>
  </head>

  <body>

    <?php
      if (!isset($_SESSION['username'])){
    ?>
    <div class="modal" id="loginModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <img src="img/logo.png" alt="Tilltro logo" class="logo">
            <h2 class="modal-title">Log In Tilltro</h2>
          </div>

          <!-- Modal body (hide when user is logged in to prevent invoke from dev tools) -->
          <div class="modal-body">
            <form action="about.php" method="POST">
              <div class="form-group">
                <label for="user">Username:</label>
                <input id="user" type="text" name="user" class="form-control">
              </div>
              <div class="form-group">
                <label for="pwd">Password:</label>
                <input id="pwd" type="password" name="password" class="form-control">
              </div>
              <div class="form-group form-check">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox"> Remember me
                </label>
              </div>
              <div class="modal-text">
                Don't have an account yet?
                <a class="link-brand" href="register.php">Sign Up</a> now!
              </div>
              <div class="button-group">
                <button type="submit" class="btn-normal btn-normal--brand">Log In</button>
                <button type="button" class="btn-normal btn-normal--default" data-dismiss="modal">Close</button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
    <?php
      }
    ?>

    <div class="container">
      <header class="header">
        <a href="/">
          <img src="img/logo.png" alt="Tilltro logo" class="logo">
        </a>

        <form action="search.php?go" method="POST" class="search">
          <input type="text" name="search" class="search__input" placeholder="Search">
          <button class="search__button">
            <svg class="search__icon">
              <use xlink:href="img/sprite.svg#icon-magnifying-glass"></use>
            </svg>
          </button>
        </form>

        <nav class="user-nav">
          <?php
            if (!isset($_SESSION['username'])){
          ?>
          <!-- If user is not logged in -->
          <div class="user-nav__user">
            <a href="#" data-toggle="modal" data-target="#loginModal">Log In / Register</a>
          </div>
          <?php
          }
          ?>


          <?php
            if (isset($_SESSION['username'])){
              $name = $_SESSION['name']
          ?>
          <div class="user-nav__icon-box">
            <a href="bookmarks.php">
              <svg class="user-nav__icon">
                <use xlink:href="img/sprite.svg#icon-bookmark"></use>
              </svg>
            </a>
          </div>
          <!-- If user logged in -->
          <div class="user-nav__user" id="open-dropdown">
            <div class="dropdown">
              <img src="img/placeholder-person.jpg" alt="User photo" class="user-nav__user-photo">
              <span class="user-nav__user-name"><?php echo "<span>$name</span>"; ?></span>

              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a href="profile.php" class="dropdown-item">View Profile</a>
                <a href="logout.php" class="dropdown-item">Log Out</a>
              </div>
            </div>
          </div>
          <?php
          }
          ?>

        </nav>
      </header>


      <div class="content">
        <nav class="sidebar">
          <ul class="side-nav">
            <li class="side-nav__item">
              <a href="/" class="side-nav__link">
                <svg class="side-nav__icon">
                  <use xlink:href="img/sprite.svg#icon-home"></use>
                </svg>
                <span>Home</span>
              </a>
            </li>
            <li class="side-nav__item side-nav__item--active">
              <a href="#" class="side-nav__link">
                <svg class="side-nav__icon">
                  <use xlink:href="img/sprite.svg#icon-aircraft-take-off"></use>
                </svg>
                <span>About</span>
              </a>
            </li>
            <li class="side-nav__item">
              <a href="hotel.php" class="side-nav__link">
                <svg class="side-nav__icon">
                  <use xlink:href="img/sprite.svg#icon-key"></use>
                </svg>
                <span>Hotels</span>
              </a>
            </li>
            <li class="side-nav__item">
              <a href="tour.php" class="side-nav__link">
                <svg class="side-nav__icon">
                  <use xlink:href="img/sprite.svg#icon-map"></use>
                </svg>
                <span>Tours</span>
              </a>
            </li>
          </ul>

          <div class="legal">
            &copy; 2018 by Tilltro. All rights reserved.
          </div>
        </nav>



        <main class="detail-view">
          <div class="gallery">
            <figure class="gallery__item">
              <img src="img/cover-1.jpg" class="gallery__photo">
            </figure>
            <figure class="gallery__item">
              <img src="img/cover-2.jpg" class="gallery__photo">
            </figure>
            <figure class="gallery__item">
              <img src="img/cover-4.jpg" class="gallery__photo">
            </figure>
          </div>

          <div class="overview">
            <h1 class="overview__heading overview__heading--home">
              Tilltro &mdash; About Us
            </h1>
          </div>

          <div class="detail">
            <div class="page-about">
              <h2 class="page-about__heading">
                Our Mission
              </h2>
              <p class="page-about__paragraph">
                Originally founded in Singapore and launched in 2018, Tilltro started out as a simple website for people to seek affordable
                and exciting tours. We have now grown into a much bigger, more
                meaningful platform that allows people to discover great places to travel through recommendations from the community. Tilltro
                has been made possible because of the passionate, avid travellers constantly sharing new places to explore as well as a
                wide network of community around the world putting their heart and souls into offering tours for the travellers registered
                with us. If you loved travelling and is adventurous by heart, Tilltro would be the best platform out there for your availability!
              </p>
            </div>
          </div>

          <div class="cta">
            <h2 class="cta__book-now">
              Continue Browsing
            </h2>
            <a href="/" class="btn-fancy btn-fancy--brand">
              Back To Home
            </a>
          </div>

      </div>


      </main>
    </div>
    </div>

    <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="js/popper.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/index.js" type="text/javascript"></script>
  </body>

</html>
