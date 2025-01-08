<?php

$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$comment = $_POST["comment"];
$special_order = filter_input(INPUT_POST, "special_order", FILTER_VALIDATE_BOOL);
if (is_bool($special_order) || is_null($special_order)) {
  if (is_null($special_order)) {
    $special_order = "Feedback";
  } else {
    $special_order = "Special order";
  }
}

class form_data {
  public $time;
  public $date;
  public $first_name;
  public $last_name;
  public $email;
  public $phone;
  public $comment;
  public $special_order;

  function __construct($time, $date, $first_name, $last_name, $email, $phone, $comment, $special_order) {
    $this->time = $time;
    $this->date = $date;
    $this->first_name = $first_name;
    $this->last_name = $last_name;
    $this->email = $email;
    $this->phone = $phone;
    $this->comment = $comment;
    $this->special_order = $special_order;
  }
}

$t = time();
$input_data = new form_data($t, date("Y-m-d", $t), $first_name, $last_name, $email, $phone, $comment, $special_order);

$data = array();

$datain = fopen('./form_data/feedback_orders.dat', 'r');
while(($buffer = fgetcsv($datain, null, ',')) !== false) {
  array_push($data, new form_data($buffer[0], $buffer[1], $buffer[2], $buffer[3], $buffer[4], $buffer[5], $buffer[6], $buffer[7]));
}

array_push($data, $input_data);

$dataout = fopen('./form_data/feedback_orders.dat', 'w');

foreach ($data as $datum) {
  fwrite($dataout, $datum->time . "," . $datum->date . "," . $datum->first_name . "," . $datum->last_name . "," . $datum->email . "," . $datum->phone . "," . $datum->comment . "," . $datum->special_order . "\n");
}
fclose($dataout);
?>

<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <title>Bloom Valley Nursery</title>
  <link href="./css/style.css" rel="stylesheet">
  <meta content="" name="description">

  <meta content="" property="og:title">
  <meta content="" property="og:type">
  <meta content="" property="og:url">
  <meta content="" property="og:image">
  <meta content="" property="og:image:alt">

  <link href="./img/icon/BloomValleyNurseryIconCG.ico" rel="icon" sizes="any">
  <link href="./img/icon/BloomValleyNurseryIconCG.svg" rel="icon" type="image/svg+xml">
  <link href="./img/icon/BloomValleyNurseryIconCG.png" rel="apple-touch-icon">

  <link href="site.webmanifest" rel="manifest">
  <meta content="#f7f7f7" name="theme-color">
</head>

<body>
  <script>
    let first_name = <?php echo json_encode($first_name); ?>;
    let last_name = <?php echo json_encode($last_name); ?>;
    let email = <?php echo json_encode($email); ?>;
    let phone = <?php echo json_encode($phone); ?>;
    let comment = <?php echo json_encode($comment); ?>;
    let special_order = <?php echo json_encode($special_order); ?>;
    const form_submission = {
      firstName: first_name,
      lastName: last_name,
      email: email,
      phone: phone,
      comment: comment,
      special_order: special_order,
    };
    localStorage.setItem('formSubmission', JSON.stringify(form_submission));
  </script>
<header class="header">
  <nav class="navigation_bar">
    <div class="logo_container">
      <img alt="Bloom Valley Nursery Logo" class="header_logo" src="./img/icon/BloomValleyNurseryIconCG.png">
      <h1 class="header_text">Bloom Valley Nursery</h1>
    </div>
    <ul class="navigation_bar_menu">
      <li class="navigation_bar_item">
        <a class="header_link" href="./index.html">Home</a>
      </li>
      <li class="navigation_bar_item">
        <a class="header_link" href="./gallery.html">Gallery</a>
      </li>
      <li class="navigation_bar_item">
        <a class="header_link" href="./about.html">About Us</a>
      </li>
      <li class="navigation_bar_item">
        <a class="header_link" href="./tree_planting.html">Tree Planting Events</a>
      </li>
    </ul>
    <div role="button" aria-label="Navigation menu" class="hamburger_menu">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </div>
  </nav>
</header>
<main class="content">
  <h1>Thank you for your order / feedback, <?=$first_name?>!</h1>
  <p>Email: <?=$email?></p>
  <p>Phone: <?=$phone?></p>
  <p>Message: <?=$comment?></p>
  <p>Special order or feedback? <?=$special_order?></p>
</main>
<footer class="footer">
  <div class="social_links">
    <a class="social_link" href="https://www.facebook.com/bloomvalleynursery" target="_blank"><img class="social_img" alt="Facebook" src="./img/social/Facebook_Logo_Primary.png"/></a>
    <a class="social_link" href="https://www.instagram.com/bloomvalleynursery/" target="_blank"><img class="social_img" alt="Instagram" src="./img/social/Instagram_Glyph_Gradient.png"/></a>
    <a class="social_link" href="https://twitter.com/bloomvalleynursery" target="_blank"><img class="social_img" alt="X" src="./img/social/logo-black.png"/></a>
    <a class="social_link" href="https://youtube.com/@bloomvalleynursery" target="_blank"><img class="social_img" alt="Youtube" src="./img/social/youtube_social_icon_red.png"/></a>
  </div>
  <h2>Signup For Our Newsletter</h2>
  <form class="newsletter" action="javascript:alert('Thanks for subscribing!');">
    <label for="signup_email"></label>
    <input class="form_text" id="signup_email" placeholder="Enter Your Email Address" type="email" required/>
    <input class="form_button" type="submit" value="Subscribe"/>
  </form>
  <div class="footer_links">
    <a class="footer_link" href="./index.html">Home</a>
    <a class="footer_link" href="./gallery.html">Gallery</a>
    <a class="footer_link" href="./about.html">About Us</a>
    <a class="footer_link" href="./tree_planting.html">Tree Planting Events</a>
  </div>
</footer>
<script src="./js/hamburger.js"></script>
</body>

</html>
