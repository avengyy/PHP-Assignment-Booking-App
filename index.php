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
            header('Location: /');
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

    <title>RedCloud</title>
  </head>

  <body>

    <?php
      // Hide when user is logged in to prevent invoke from dev tools
      if (!isset($_SESSION['username'])){
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
          <?php
            // Check session for logged in
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
            // Check session for logged in
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
            <li class="side-nav__item side-nav__item--active">
              <a href="/" class="side-nav__link">
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
              $i = rand(1,4); // Randomize image
            ?>
            <figure class="gallery__item">
              <img src="img/cover-<?php echo "$i" ?>.jpg" class="gallery__photo">
            </figure>
          </div>

          <div class="overview">
            <h1 class="overview__heading overview__heading--home">
              RedCloud &mdash; Your all-in-one booking platform
            </h1>
          </div>

          <div class="detail">
            <div class="page-home">
              <div class="page-home__item">
                <div class="card">
                  <div class="card__img-wrapper">
                    <img src="img/hotel-<?php echo "$i" ?>.jpg" alt="" class="card__img">
                  </div>
                  <div class="card__details">
                    <h3 class="card__detail-title">Hotels</h3>
                    <p class="card__detail-description">
                      Find &amp; Book the finest hotel for your holiday travel or staycations!
                    </p>
                  </div>
                  <div class="card__button">
                    <a href="hotel.php" class="btn-fancy btn-fancy--brand">
                      View More
                    </a>
                  </div>
                </div>
              </div>

              <div class="page-home__item">
                <div class="card">
                  <div class="card__img-wrapper">
                    <img src="img/tour-<?php echo "$i" ?>.jpg" alt="" class="card__img">
                  </div>
                  <div class="card__details">
                    <h3 class="card__detail-title">Tours</h3>
                    <p class="card__detail-description">
                      Find &amp; Book the finest travel packages for your favourite holiday seasons!
                    </p>
                  </div>
                  <div class="card__button">
                    <a href="tour.php" class="btn-fancy btn-fancy--brand">
                      View More
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="cta">
            <h2 class="cta__book-now">
              Want to know more about us? Click the button below now!
            </h2>
            <a href="about.php" class="btn-fancy btn-fancy--brand">
              About Us
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