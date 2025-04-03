<?php 



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/signupSty.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup_form</title>
    <style>
      body{
        background-color: dimgray;
      }
    </style>
</head>
<body>
<form class="signup" method="post" >
<h3 style="padding:0;" >Registar your Information  </h3>
  <div class="">
    <label for="" class="">First name: </label>
    <input type="text" id="" value="" placeholder="First Name" style="width: 150px; height: 20px;" required><br><br>
  <div class="">
    </div>
  </div>
  <div class="">
    <label for="" class="">Last name:</label>
    <input type="text" class="" id="" value="" placeholder="Last Name" style="width: 150px; height: 20px;" required> <br><br>
   Gender: <input type="radio" value="sex" name="sex" id="">Male
   <input type="radio" value="sex" name="sex" id="">Female
   <input type="radio" value="sex" name="sex" id="">Other <br><br>
   
   
   
  </div>
  <div class="">
    <label for="" class="form-label">  Email: </label>
      <input type="text" class="" id="" aria-describedby="validationTooltipEmailPrepend" style="width: 160px; height: 20px;" placeholder="Email" required><br><br>
  </div>
  Password: 
  <input type="password" name="pass" id="" placeholder="Enter your Password" style="height: 20px; width: 150px;" required><br><br>
  Confirm Password: <input type="password", id="" style="width: 150px; height: 20px" placeholder="Confirm your Password" required><br> <br>
  <div class="">
    <button class="but" type="submit"> Submit</button>
  </div>
</form>
</body>
</html>