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


      $tourId = $_GET['tourId'];
      if($_SESSION['userId']) {
        if (isset($_GET['tourId'])) {
          $userId = $_SESSION['userId'];
          $sql = "DELETE FROM tour_login WHERE userId = $userId AND tourId = $tourId";
          $result = mysqli_query($conn, $sql);
          if ($result) {
            echo "<script>alert('Removed from bookmarks');
            setTimeout(function() {
              window.location.href = 'tour-detail.php?id=$tourId';
            }, 500)</script>";
          }
          if (mysqli_affected_rows($conn) == 0) {
            echo "<script>
            alert('Failed to remove from bookmarks');
            setTimeout(function() {
              window.location.href = 'tour-detail.php?id=$tourId';
            }, 500)</script>";
          }
        }
      } else {
        header("Location: tour-detail.php?id='$tourId'");
      }
  ?>
  <div class="spinner"></div>
</body>
</html>

