<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OG Tech - Manage Users Panel</title>
  <?php
    include "header.php"; 
    include "static/pages/side_nav.html";
    include "static/pages/admin_nav.php";
  ?>
</head>
<body>
  <div class="container" style="margin-top: 150px">
    <h3 class="page-title">Manage Users</h3>

    <!-- users list start -->
    <div class="rounded-card-parent center" style="margin-bottom: 100px">
      <div class="card rounded-card">
        <div class="card-content white-text">
          <span class="card-title orange-text bold">Users List - Sorted by latest 
            <button class='deep-orange btn'><a href="admin_manage_users.php"><i class='material-icons white-text'>refresh</i></a>
            </button>
          </span>

          <!-- search member input field start -->
          <form id="search_user" action="admin_manage_users.php" method="POST">
            <div class="row" style="margin: 0px;">
              <div class="input-field col s3" style = "color:azure">
                <input name="search_member" id="search_member" type="text" class="validate white-text" maxlength="20">
                <label for="search_member">Search member by name</label>
                <div class="errormsg">
                  <?php
                    if (isset($_GET["error"]))
                    {
                      if ($_GET["error"] == "emptysearch")
                      echo "<p>Empty Input!</p>";
                    }
                    ?>
                </div>
              </div>
            </div>
          </form>

          <!-- search member input field end -->
          
          <!-- search member result list start -->
          <form action="" method="GET">
            <table class="responsive-table center" id="pagination">
              <thead class="text-primary center">
                <tr>
                  <th>MemberID</th>
                  <th>Username</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $oper = new adminContr;
                  $oper->usersList();
                ?>
              </tbody>
            </table>
            <div class="col-md-12 center text-center">
              <span class="left" id="total_reg"></span>
              <ul class="pagination pager" id="myPager"></ul>
            </div>
          </form>
        <!-- serach member result list end -->
        </div>
      </div>
    </div>
    <!-- users list end -->

    <!-- selected member details start -->
    <?php if (isset($_GET["inspect"])) { ?>
      <div class="rounded-card-parent center">
        <div class="card rounded-card">
          <div class="card-content white-text">
            <span class="card-title orange-text bold">Selected Member Details</span>
            <table class="responsive-table">
              <form action="admin_manage_users.php" method="GET">
                <thead class="text-primary center">
                  <tr><th>MemberID</th><th>Username</th><th>Email</th><th>Privilege Level</th></tr>
                </thead>
                <tbody>
                  <?php $oper->showInspectedUser(); ?>
                </tbody>
              </form>
            </table>
          </div>
        </div>
      </div>
    <?php } ?>

    <div class="rounded-card-parent" style="margin-top: 100px">
      <div class="card rounded-card">
        <div class="card-content">
          <span class="card-title orange-text bold">Create User</span>
          <form id="create" name="create" action="" method="post">
            <div class="row">
              <div class="input-field col s8 white-text">
                <i class="material-icons prefix">account_circle</i>
                <input name="username" id="username" type="text" class="validate white-text" minlength="5" maxlength="12">
                <span class="helper-text grey-text" data-error="Min 5, Max 12 characters" data-success="Min 5, Max 12 characters">Min 5, Max 12 characters</span>
                <label for="username" class="white-text"> Username</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s8 white-text">
                <i class="material-icons prefix"> password</i>
                <input name="pwd" id="pwd" type="password" class="validate white-text" minlength="8" maxlength="20">
                <span class="helper-text grey-text" data-error="Min 8, Max 20 characters" data-success="Min 8, Max 20 characters">Min 8, Max 20 characters</span>
                <label for="pwd" class="white-text"> Password</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s8 white-text">
                <i class="material-icons prefix"> password</i>
                <input name="repeat_pwd" id="repeat_pwd" type="password" class="validate white-text" maxlength="14">
                <label for="repeat_pwd" class="white-text"> Repeat Password</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s8 white-text">
                <i class="material-icons prefix white-text">assignment_ind</i>
                <select id="level" name="level">
                  <option value="" disabled selected>Choose your option</option>
                  <option value=1>Member</option>
                  <option value=2>Admin</option>
                </select>
                <label class="white-text">Privilege Level</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s8 white-text">
                <i class="material-icons prefix">email</i>
                <input name="email" id="email" type="email" class="validate white-text" maxlength="25">
                <label for="email" class="white-text">Email</label>
                <span class="helper-text white-text" data-error="wrong" data-success="correct"></span>
                <div id="message" class="errormsg">
              
                </div>
              </div>
            </div>
            <input class="btn orange btn-block z-depth-5" type="submit" name="submit_user" id="submit_user" value="Create User">
          </form>
        </div>
      </div> 
    </div>
  </div>
</body>
<script>
  $(document).ready(function(){
    $('select').formSelect();

    $("#create").submit(function(e) {
      event.preventDefault();
      var username = $("#username").val();
      var pwd = $("#pwd").val();
      var repeat_pwd = $("#repeat_pwd").val();
      var level = $("#level").val();
      var email = $("#email").val();
      var submit = $("#submit_user").val();
      $("#message").load("includes/admin.inc.php", {
        username: username,
        pwd: pwd,
        repeat_pwd: repeat_pwd,
        level: level,
        email: email,
        submit: submit
      });
    })

  });
</script>

<?php include "footer.php"; ?>
</html>