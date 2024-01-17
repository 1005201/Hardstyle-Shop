<?php

include "connection.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hardstyle Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="stylen.css">
</head>
<?php

//header
include "header.php";

?>
<body>
<div class="video-container">
    <div class="video">
        <iframe width="610" height="365" src="https://www.youtube.com/embed/RNdz9AinbUg?si=2_J5IYPV-xJ4dN-1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    </div>
    <h4>Code Black feat. Matthew Steeper - Never Be Forgotten</h4>
</div>
<div class="video-container">
    <div class="video">
        <iframe width="610" height="365" src="https://www.youtube.com/embed/WQoN6fUcmb8?si=r1cuX6TwLMdVFxUH" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    </div>
    <h4>Code Black feat. Elle Vee - Wild Ones</h4>
</div>
</body>
<?php

//footer
include "footer.php";

?>
</html>