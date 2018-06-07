<?php
  require_once('./php/database.php');
  session_start();

  // Prevent logged in users to access this page via URL after loggin in
  if (isset($_SESSION['username'])) {
    header('Location: /');
  }

  if (!empty($_POST)) {
    if (isset($_POST['register_user']) && isset($_POST['register_pw'])) {
      $name = mysqli_real_escape_string($conn, $_POST['register_name']);
      $username = mysqli_real_escape_string($conn, $_POST['register_user']);
      $password = mysqli_real_escape_string($conn, $_POST['register_pw']);
      $email = mysqli_real_escape_string($conn, $_POST['register_email']);

      $options = [
        'cost' => 10,
        'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
      ];

      $hash_password = password_hash($password, PASSWORD_BCRYPT, $options);

      $sql = "INSERT INTO login (name, username, password, email)
      VALUES ('$name', '$username', '$hash_password', '$email')";

      if (mysqli_query($conn, $sql)) {
        header('Location: /');
        echo "<script>alert('Registration Success');</script>";
      } else {
        header('Location: register.php');
        echo "<script>alert('Registration Failed')</script>";
      }
    }
  }

  mysqli_close($conn);

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

    <title>RedCloud</title>
  </head>

  <body>
    <?php
      if (!isset($_SESSION['username'])) {
    ?>
    <div class="modal" id="loginModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <img src="img/logo.png" alt="redcloud logo" class="logo">
            <h2 class="modal-title">Log In RedCloud</h2>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <form action="index.php" method="POST">
              <div class="form-group">
                <label for="login_user">Username:</label>
                <input id="login_user" type="text" name="user" class="form-control">
              </div>
              <div class="form-group">
                <label for="login_pwd">Password:</label>
                <input id="login_pwd" type="password" name="password" class="form-control">
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
          <img src="img/logo.png" alt="redcloud logo" class="logo">
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
          <div class="user-nav__user">
            <a href="#" data-toggle="modal" data-target="#loginModal">Log In / Register</a>
          </div>

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
                <a href="#" class="dropdown-item">View Profile</a>
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
            <li class="side-nav__item side-nav__item--active">
              <a href=/ class="side-nav__link">
                <svg class="side-nav__icon">
                  <use xlink:href="img/sprite.svg#icon-home"></use>
                </svg>
                <span>Home</span>
              </a>
            </li>
            <li class="side-nav__item">
              <a href="about.php" class="side-nav__link">
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
            &copy; 2018 by RedCloud. All rights reserved.
          </div>
        </nav>



        <main class="detail-view">
          <div class="gallery">
            <?php
              $i = rand(1,4);
            ?>
            <figure class="gallery__item">
              <img src="img/cover-<?php echo "$i" ?>.jpg" class="gallery__photo">
            </figure>
          </div>

          <div class="overview">
            <h1 class="overview__heading overview__heading--home">
              Sign Up
            </h1>
          </div>

          <?php
            if (!isset($_SESSION['username'])) {
          ?>
          <form action="register.php" method="POST">
            <div class="detail">
              <div class="register-form">
                <div class="form-group">
                  <label for="name">Full name:</label>
                  <input id="name" type="text" name="register_name" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="user">Username:</label>
                  <input id="user" type="text" name="register_user" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="email">Email address:</label>
                  <input id="email" type="email" name="register_email" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="pwd">Password:</label>
                  <input id="pwd" type="password" name="register_pw" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="cfmPwd">Confirm Password:</label>
                  <input id="cfmPwd" type="password" name="register_cpw" class="form-control" required>
                </div>
              </div>
            </div>

            <div class="cta">
              <button type="submit" id="submitBtn" class="btn-fancy btn-fancy--brand">
                Sign Up
              </button>

            </div>
          </form>
          <?php
            }
          ?>
      </div>


      </main>
    </div>
    </div>

    <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="js/popper.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/index.js" type="text/javascript"></script>

    <script>
      'use strict';
      window.addEventListener('load', function () {
        const password = document.querySelector('#pwd');
        const confirm = document.querySelector('#cfmPwd');
        const btn = document.querySelector('#submitBtn');

        confirm.addEventListener('blur', event => {
          if (event.target.value !== password.value) {
            alert('Password entered did not match!');
            password.value = '';
            event.target.value = '';
            btn.disabled = true;
            setTimeout(() => {
              btn.disabled = false;
            }, 1000)
          }
        });
      }, false)
    </script>
  </body>

</html>