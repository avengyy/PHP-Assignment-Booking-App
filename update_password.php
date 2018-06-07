<?php
  require_once('./php/database.php');
  session_start();

  if ($_SESSION['username']) {
    if (!empty($_POST)) {
      if (isset($_POST['password']) && isset($_POST['confirmPassword'])) {
        $id = $_SESSION['userId'];
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $options = [
          'cost' => 10,
          'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];

        $hash_password = password_hash($password, PASSWORD_BCRYPT, $options);

        $sql = "UPDATE login SET password='$hash_password' WHERE userId='$id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_affected_rows($conn) > 0) {
          echo "<script>alert('Password updated!');</script>";
          header('Location: profile.php');
        } else {
          echo "<script>alert('Password update failed')</script>";
          header('Location: profile.php');
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

    <title>Tilltro</title>
  </head>

  <body>
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
          <div class="user-nav__user user-nav__user--active" id="open-dropdown">
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
            &copy; 2018 by Tilltro. All rights reserved.
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
              Update Password
            </h1>
          </div>

          <form action="update_password.php" method="POST">
            <div class="detail">
              <div class="register-form">
                <div class="form-group">
                  <label for="pwd">New Password:</label>
                  <input id="pwd" type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="cfmPwd">Confirm New Password:</label>
                  <input id="cfmPwd" type="password" name="confirmPassword" class="form-control" required>
                </div>
              </div>
            </div>

            <div class="cta">
              <!-- <h2 class="cta__book-now">
              Want to know more about us? Click the button below now!
            </h2> -->
              <button type="submit" id="submitBtn" class="btn-fancy btn-fancy--brand">
                Update Password
              </button>
              <a href="profile.php" class="btn-fancy btn-fancy--default">
                Cancel
              </a>
            </div>
          </form>
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

<?php
  }
?>