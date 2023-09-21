<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<link rel="stylesheet" href="css/style.css">
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  margin: 0;
}

html {
  box-sizing: border-box;
}

*, *:before, *:after {
  box-sizing: inherit;
}

.column {
  float: left;
  width: 33.3%;
  margin-bottom: 16px;
  padding: 0 8px;
}
.detail {
  border-radius: 20px;
  font-size: 15px;
  background: greenyellow;
  padding: 20px;
  float:left;
  width: 350px;
  height: 230px;
 
}
.photo {

  float: right;
  width: 50px;
  height: 50px;
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  margin: 8px;
}

.about-section {
  
  padding: 250px;
  
  background-color: #474e5d;
  color: white; 
}

.container {
  padding: 0 16px;
}

.container::after, .row::after {
  content: "";
  clear: both;
  display: table;
}

.title {
  color: grey;
}

.button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
}

.button:hover {
  background-color: #555;
}

@media screen and (max-width: 650px) {
  .column {
    width: 50%;
    display: block;
  }
}
</style>
</head>
<body>
<?php include 'components/user_header.php'; ?>

<div class="about-section">
  <h1 style="font-size:50px;text-align:center;" >About Us Page</h1>

  
  <p class="detail">Stationery <br>is so much more Whether it's supplies for your office, or materials for your next art projet, we are here to help you
    get the job done.From writing instruments, office essentials, pantry supplies to 
    technology products, we'll get you things you need to get things, 
    done, so you can aactually focus on more important stuff-such 
    as your work.
    <br><br>
    
  </p></h4>

</div>
<h2 style="text-align:center">Our Team</h2>
<div class="row">
  <div class="column">
    <div class="card">
      <img src="images/raj.jpg" alt="Raj" style="width:50%">
      <div class="container">
        <h2>Raj Krishna Silwal</h2>
        
        <p>Programmer </p>
        <p> Front End Developer</p>
        <p>sabalsilwal51@gmail.com.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <img src="images/roshan.jpg" alt="Roshan" style="width:50%">
      <div class="container">
        <h2>Roshan Gajurel</h2>
        
        <p>Programmer</p>
        <p> Front End Developer</p>
        <p>roshangajurel@gmial.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>
  
</div>
<?php include 'components/footer.php'; ?>

</body>
</html>
