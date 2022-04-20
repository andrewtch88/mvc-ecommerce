<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OG Tech - Manage Account</title>
  <?php include "header.php"; ?>
</head>
<body>
<h3 class="page-title grid" style="margin-top: 50px;">Manage Personal Profile</h3>
  <div class="grid">


    <div class="rounded-card-parent black">
      <div class="card rounded-card black" style="width: 650px; ">
        <div class="row">
          <button id="edit" style="text-align:left" class="btn orange " onclick="confirm_edit(this)" style="margin-right: 20px">Edit</button>
          <div class="errormsg bold"><p id="msg" class="red-text"></p></div>

          <div class="errormsg">
            <?php
              if (isset($_GET["error"]))
              {
                if ($_GET["error"] == "empty_input")
                  echo "<script>document.getElementById('msg').innerHTML = '*Fill in all fields!';</script>";

                else if ($_GET["error"] == "invalid_uid")
                  echo "<script>document.getElementById('msg').innerHTML = '*Choose a proper username!';</script>";

                else if ($_GET["error"] == "passwords_dont_match")
                  echo "<script>document.getElementById('msg').innerHTML = '*Passwords doesn't match!';</script>";

                else if ($_GET["error"] == "stmtfailed")
                  echo "<script>document.getElementById('msg').innerHTML = '*Something went wrong, please try again!';</script>";

                else if ($_GET["error"] == "username_taken")
                  echo "<script>document.getElementById('msg').innerHTML = '*Username already taken!';</script>";

                else if ($_GET["error"] == "none")
                {
                  echo "<script>document.getElementById('msg').className = 'green-text';</script>";
                  echo "<script>document.getElementById('msg').innerHTML = 'Profile updated!';</script>";
                }
              }

            ?>
          </div>
        </div>
        <div class="card-content grey darken-4 white-text">
          <form class="s12" action="includes/manage_profile.inc.php" method="POST">
            <div class="row">
              <div class="input-field s6">
                <i class="material-icons prefix">account_circle</i>
                <?php
                echo "<input disabled name='id' type='hidden' value='$memberID'/>";
                echo"<input disabled class='validate white-text' minlength='5' maxlength='12' name='username' id='username' type='text' value='$username'/>";
                ?>
                <label class='cyan-text' for="username">Enter New Username</label>
                <span class="helper-text grey-text" data-error="Min 5, Max 12 characters" data-success="Min 5, Max 12 characters">Min 5, Max 12 characters</span>
              </div>
            </div>
            <div class="row">
              <div class="input-field s6">
                <i class="material-icons prefix">email</i>
                <?php
                echo "<input disabled class='white-text validate' name='email' id='email' type='email' value='$email'/>";
                ?>
                <label class='cyan-text' for="email">Enter New Email</label>
                <span class="helper-text white-text" data-error="wrong" data-success="correct"></span>
              </div>
            </div>
            <div class="row">
              <div class="input-field s6">
                <i class="material-icons prefix"> password</i>
                <input disabled class='white-text validate' name="pwd" id="pwd" type="password" minlength="8" maxlength="20">
                <label class='cyan-text' for="pwd">Enter New Password</label>
                <span class="helper-text grey-text" data-error="Min 8, Max 20 characters" data-success="Min 8, Max 20 characters">Min 8, Max 20 characters</span>
              </div>
            </div>
            <div class="row">
              <div class="input-field s6">
                <i class="material-icons prefix"> password</i>
                <input disabled class='white-text validate' name="repeat_pwd" id="repeat_pwd" type="password" maxlength="20">
                <label class='cyan-text' for="repeat_pwd"> Repeat New Password</label>
              </div>
            </div>
          <br>
          <p class="center-align">
          <button disabled id="update_acc" type="submit" name="update" class="btn orange darken-4">Update Account</button>
          </p>
          </form>
        </div>        
      </div>
    </div>
  </div>
</body>
<?php include "footer.php"; ?>

<script>
  // disable and enable input fields
  var id =  document.getElementsByName("id")[0];
  var username =  document.getElementsByName("username")[0];
  var email =  document.getElementsByName("email")[0];
  var pwd =  document.getElementsByName("pwd")[0];
  var repeatPwd =  document.getElementsByName("repeat_pwd")[0];
  var submitBtn = document.querySelector("#update_acc");

function confirm_edit(btn)
{
  id.disabled = !id.disabled;

  if (id.disabled)
  {
    username.disabled = true;
    email.disabled = true;
    pwd.disabled = true;
    repeatPwd.disabled = true;
    submitBtn.disabled = true;
    btn.textContent = "Edit"
  } else
  {
    username.disabled = false;
    email.disabled = false;
    pwd.disabled = false;
    repeatPwd.disabled = false;
    submitBtn.disabled = false;
    btn.textContent = "Done"
  }
}

// timed message 
setTimeout(fade_in, 2500);

function fade_in() {
  $("#msg").fadeIn().delay(2500).fadeOut();
}

</script>
</html>