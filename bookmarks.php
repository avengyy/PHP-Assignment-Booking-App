<?php
  require_once('./php/database.php');
  session_start(); // Init session

  if ($_SESSION['userId']) {
    $userId = $_SESSION['userId'];
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

    <title>RedCloud &mdash; Bookmarks</title>
  </head>

  <body>


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
            if (isset($_SESSION['username'])){
              $name = $_SESSION['name']
          ?>
          <div class="user-nav__icon-box user-nav__icon-box--active">
            <a href="bookmarks.php">
              <svg class="user-nav__icon user-nav__icon--active">
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

          <div class="overview">
            <h1 class="overview__heading">
              Bookmarks
            </h1>
          </div>

          <div class="detail">
            <div class="page-package">

              <?php
                $sql = "SELECT hotelId FROM hotel_login WHERE userId = $userId";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_array($result)) {
                    $hotelId = $row['hotelId'];
                    $query = "SELECT * FROM hotels WHERE id = $hotelId";
                    $res = mysqli_query($conn, $query);

                    if (mysqli_num_rows($res) > 0) {
                      while ($row = mysqli_fetch_array($res)) {
                        $title = $row['title'];
                        $loc = $row['location'];
                        $des = $row['description'];
                        $rate = $row['rating'];
                        $imagePath = $row['mainImagePath'];
                        echo "<div class='package-card'>";
                        echo "<img src='$imagePath' class='package-card__img'>";
                        echo "<div class='package-card__details'>";
                        echo "<div class='package-card__heading'>$title</div>";
                        echo "<div class='package-card__paragraph'>$loc</div>";
                        echo "<a href='hotel-detail.php?id=$hotelId' class='btn-inline btn-inline--card'>";
                        echo "View Details <span>&rarr;</span>";
                        echo "</a>";
                        echo "</div>";
                        echo "</div>";

                      }
                    }
                  }
                }

                $sql = "SELECT tourId FROM tour_login WHERE userId = $userId";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_array($result)) {
                    $tourId = $row['tourId'];
                    $query = "SELECT * FROM tours WHERE id = $tourId";
                    $res = mysqli_query($conn, $query);

                    if (mysqli_num_rows($res) > 0) {
                      while ($row = mysqli_fetch_array($res)) {
                        $title = $row['title'];
                        $loc = $row['location'];
                        $des = $row['description'];
                        $rate = $row['rating'];
                        $imagePath = $row['mainImagePath'];
                        echo "<div class='package-card'>";
                        echo "<img src='$imagePath' class='package-card__img'>";
                        echo "<div class='package-card__details'>";
                        echo "<div class='package-card__heading'>$title</div>";
                        echo "<div class='package-card__paragraph'>$loc</div>";
                        echo "<a href='tour-detail.php?id=$tourId' class='btn-inline btn-inline--card'>";
                        echo "View Details <span>&rarr;</span>";
                        echo "</a>";
                        echo "</div>";
                        echo "</div>";

                      }
                    }
                  }
                }

                mysqli_close($conn);
              ?>
            </div>
          </div>

          <div class="cta">
            <button class="btn">
              <span class="btn__visible">Book now</span>
              <span class="btn__invisible">Coming Soon</span>
            </button>
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

<?php
  }
?>