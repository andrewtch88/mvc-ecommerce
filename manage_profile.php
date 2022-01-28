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
          <div class="errormsg">
            <?php
              if (isset($_GET["error"]))
              {
                if ($_GET["error"] == "empty_input")
                  echo "<p>*Fill in all fields!<p>";

                else if ($_GET["error"] == "invalid_uid")
                  echo "<p>*Choose a proper username!</p>";

                else if ($_GET["error"] == "invalidemail")
                  echo "<p>*Choose a proper email!</p>";

                else if ($_GET["error"] == "passwords_dont_match")
                  echo "<p>*Passwords doesn't match!</p>";

                else if ($_GET["error"] == "stmtfailed")
                  echo "<p>*Something went wrong, please try again!</p>";

                else if ($_GET["error"] == "username_taken")
                  echo "<p>*Username already taken!</p>";

                else if ($_GET["error"] == "none")
                  echo "<p class='bold' style='color: green'>Profile updated!</p>";
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
                echo "<input name='id' type='hidden' value='$memberID'/>";
                echo"<input class='white-text' name='username' type='text' value='$username'/>";
                ?>
                <label class='cyan-text' for="username">Enter New Username</label>
                <span class="helper-text grey-text" data-error="Min 5, Max 12 characters" data-success="correct">Min 5, Max 12 characters</span>
              </div>
            </div>
            <div class="row">
              <div class="input-field s6">
                <i class="material-icons prefix">email</i>
                <?php
                echo "<input class='white-text' name='email' type='text' value='$email'/>";
                ?>
                <label class='cyan-text' for="email">Enter New Email</label>
                <span class="helper-text white-text" data-error="wrong" data-success="correct"></span>
              </div>
            </div>
            <div class="row" id="pwd">
              <div class="input-field s6">
                <i class="material-icons prefix"> password</i>
                <input class='white-text' name="pwd" type="password" class="validate" minlength="6" maxlength="20">
                <label class='cyan-text' for="password">Enter New Password</label>
                <span class="helper-text grey-text" data-error="Min 8, Max 20 characters" data-success="correct">Min 8, Max 20 characters</span>
              </div>
            </div>
            <div class="row" id="repeat_pwd">
              <div class="input-field s6">
                <i class="material-icons prefix"> password</i>
                <input class='white-text' name="repeat_pwd" type="password" class="validate" maxlength="14">
                <label class='cyan-text' for="repeat_pwd"> Repeat New Password</label>
              </div>
            </div>
          <br>
          <p class="center-align">
          <button id="update_acc" type="submit" name="update" class="btn orange darken-4">Update Account</button>
          </p>
          </form>
        </div>        
      </div>
    </div>
  </div>
</body>
<?php include "footer.php"; ?>

<script>
  var id =  document.getElementsByName("id")[0];
  var submitBtn = document.getElementById("update_acc");

  $(document).ready(
  () => {
    id.disabled = true;
    submitBtn.disabled = true;
  }
);

function confirm_edit(btn)
{
  id.disabled = !id.disabled;

  if (id.disabled)
  {
    submitBtn.disabled = true;
    btn.textContent = "Edit"
  } else
  {
    submitBtn.disabled = false;
    btn.textContent = "Done"
  }
}

</script>
</html>