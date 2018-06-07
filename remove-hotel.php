<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>RedCloud</title>

  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <?php
    session_start();
    require_once('./php/database.php');


    // Check where user added bookmark from
    if (isset($_GET['hotelId'])) {
      $hotelId = $_GET['hotelId'];
      if($_SESSION['userId']) {
        $userId = $_SESSION['userId'];
        $sql = "DELETE FROM hotel_login WHERE userId = $userId AND hotelId = $hotelId";
        $result = mysqli_query($conn, $sql);
        if ($result) {
          echo "<script>alert('Removed from bookmarks');
          setTimeout(function() {
            window.location.href = 'hotel-detail.php?id=$hotelId';
          }, 500)</script>";
        }
        if (mysqli_affected_rows($conn) == 0) {
          echo "<script>
          alert('Failed to remove from bookmarks');
          setTimeout(function() {
            window.location.href = 'hotel-detail.php?id=$hotelId';
          }, 500)</script>";
        }
      } else {
        header("Location: hotel-detail.php?id='$hotelId'");
      }
    }
  ?>
  <div class="spinner"></div>
</body>
</html>

