<?php

if (isset($_GET['id'])) {

  $id = $_GET['id'];

  require_once('./php/database.php');
  session_start(); // Init session

  if (!empty($_POST)) {
    if (empty($_POST['user']) || empty($_POST['password'])) {
      echo "<script>
      alert('Username or Password is empty');
      window.location.href = 'hotel-detail.php?id=$id';
      </script>";
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
            header("Location: hotel-detail.php?id=$id");
          } else {
            // return false;
            echo "<script>
            alert('Username or Password is invalid');
            window.location.href = 'hotel-detail.php?id=$id';
            </script>";
          }
        }
      } else {
        echo "<script>
        alert('User is not registered');
        window.location.href = 'hotel-detail.php?id=$id';
        </script>";
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

    <title>RedCloud &mdash; Hotels</title>

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
            <img src="img/logo.png" alt="redcloud logo" class="logo">
            <h2 class="modal-title">Log In RedCloud</h2>
          </div>

          <!-- Modal body (hide when user is logged in to prevent invoke from dev tools) -->
          <div class="modal-body">
            <form action="hotel-detail.php?id=<?php echo "$id" ?>" method="POST">
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
            <li class="side-nav__item side-nav__item--active">
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
            <figure class="gallery__item">
              <img src="img/hotel-1.jpg" alt="Photo of hotel 1" class="gallery__photo">
            </figure>
            <figure class="gallery__item">
              <img src="img/hotel-2.jpg" alt="Photo of hotel 2" class="gallery__photo">
            </figure>
            <figure class="gallery__item">
              <img src="img/hotel-3.jpg" alt="Photo of hotel 3" class="gallery__photo">
            </figure>
          </div>

          <?php
            // Load data from SQL
            $sql = "SELECT * FROM hotels WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_array($result)) {
                $title = $row['title'];
                $loc = $row['location'];
                $des = $row['description'];
                $stars = $row['stars'];
                $rate = $row['rating'];
                $imagePath = $row['mainImagePath'];
                $locationEncoded = urlencode($loc);
                $googleMapUrl = "https://www.google.com/maps/search/?api=1&query='$locationEncoded'";
              }
          ?>

          <div class="overview">
            <h1 class="overview__heading">
              <?php echo "$title"; ?>
            </h1>

            <div class="overview__stars">
              <?php
                $count = 0;
                while($count < $stars) {
                  echo "<svg class='overview__icon-star'>
                          <use xlink:href='img/sprite.svg#icon-star'></use>
                        </svg>";
                  $count++;
                }
              ?>
            </div>

            <div class="overview__location">
              <svg class="overview__icon-location">
                <use xlink:href="img/sprite.svg#icon-location-pin"></use>
              </svg>
              <a href="<?php echo "$googleMapUrl"; ?>" class="btn-inline"><?php echo "$loc"; ?></a>
            </div>

            <div class="overview__rating">
              <div class="overview__rating-average"><?php echo "$rate"; ?></div>
              <!-- <div class="overview__rating-count">429 votes</div> -->
            </div>
          </div>

          <div class="detail">
            <div class="description">
              <p class="paragraph">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi nisi dignissimos debitis ratione sapiente saepe. Accusantium
                cumque, quas, ut corporis incidunt deserunt quae architecto voluptate.
              </p>
              <p class="paragraph">
                Accusantium cumque, quas, ut corporis incidunt deserunt quae architecto voluptate delectus, inventore iure aliquid aliquam.
              </p>
              <ul class="list">
                <li class="list__item">Close to the beach</li>
                <li class="list__item">Breakfast included</li>
                <li class="list__item">Free airport shuttle</li>
                <li class="list__item">Free wifi in all rooms</li>
                <li class="list__item">Air conditioning and heating</li>
                <li class="list__item">Pets allowed</li>
                <li class="list__item">We speak all languages</li>
                <li class="list__item">Perfect for families</li>
              </ul>
              <div class="recommend">
                <p class="recommend__count">
                  Lucy and 3 other friends recommend this hotel.
                </p>
                <div class="recommend__friends">
                  <img src="img/user-3.jpg" alt="Friend 1" class="recommend__photo">
                  <img src="img/user-4.jpg" alt="Friend 2" class="recommend__photo">
                  <img src="img/user-5.jpg" alt="Friend 3" class="recommend__photo">
                  <img src="img/user-6.jpg" alt="Friend 4" class="recommend__photo">
                </div>
              </div>
            </div>
          </div>


          <div class="cta">
            <?php
              $type = '';
              $userId = $_SESSION['userId'];
              $sql = "SELECT * FROM hotel_login WHERE userId = $userId AND hotelId = $id";
              $result = mysqli_query($conn, $sql);

              if (mysqli_num_rows($result) > 0) {
                $type = 'Remove';
                $action = strtolower($type);
              } else {
                $type = 'Add';
                $action = strtolower($type);
              }

              echo "<h2 class='cta__book-now'>$type to bookmarks now!</h2>";
              echo "<a href='$action-hotel.php?hotelId=$id' class='btn-fancy btn-fancy--brand'>
                      <span class='btn__visible'>$type Bookmark</span>
                    </a>";
            ?>
          </div>


          <?php
            // End if database has results
            } else {
          ?>
          <div class="overview">
            <h1 class="overview__heading">
              ERROR 500 NO RESULTS FOUND
            </h1>
          </div>

          <div class="detail">
              &nbsp;
          </div>

          <div class="cta">
            <h2 class="cta__book-now">
              OOPS LOOKS LIKE AN ERROR OCCURED
            </h2>
            <a href="hotel.php" class="btn-fancy btn-fancy--brand">
              <span class="btn__visible">Return</span>
            </a>
          </div>

          <?php
            } // End else no result
          ?>
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

<?php
}
?>