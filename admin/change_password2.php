<?php include('header2.php'); ?>
<?php include('../session.php'); ?>

<body id="login">
  <style>
    /* Add the following CSS to center the .container */
    body, html {
      height: 100%; /* Ensure full height for the viewport */
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      background-image: url('./images/3.png'); /* Add your image path here */
      background-size: cover; /* Ensure the background image covers the entire page */
      background-position: center center; /* Center the background image */
      background-attachment: fixed; /* Optional, makes the background fixed */
      background-color: #f4f4f4; /* Fallback background color if image fails to load */
    }

    .container {
      width: 100%;
      max-width: 400px; /* Adjust width as needed */
      padding: 20px;
      background-color: white;
      border-radius: 8px; /* Optional for rounded corners */
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Optional for a subtle shadow */
    }
  </style>

  <div class="container">
    <?php
      $query = mysqli_query($conn, "select * from staff where staff_id = '$session_id'") or die(mysqli_error());
      $row = mysqli_fetch_array($query);
    ?>    

    <center>
      <form id="change_password" class="form-signin" method="post">
        <h3 class="form-signin-heading"><i class="icon-lock"></i> Change Password</h3>
        <input type="hidden" id="password" name="password" value="<?php echo $row['password']; ?>" placeholder="Current Password">
        <input type="hidden" id="current_password" name="current_password" placeholder="Current Password" value="12345" required>
        <input type="password" id="new_password" name="new_password" placeholder="New Password" required>
        <input type="password" id="retype_password" name="retype_password" placeholder="Re-type Password" required>
        <br>
        <a href="logout.php" title="Click to Edit" class="btn btn-primary">Back</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="submit" data-placement="right" id="save" name="save" class="btn btn-success"><i class="icon-save icon-large"></i> Save</button>

        <script>
          jQuery(document).ready(function() {
            jQuery("#change_password").submit(function(e) {
              e.preventDefault();

              var password = jQuery('#password').val();
              var current_password = jQuery('#current_password').val();
              var new_password = jQuery('#new_password').val();
              var retype_password = jQuery('#retype_password').val();

              if (password != current_password) {
                $.jGrowl("Password does not match with your current password  ", { header: 'Change Password Failed' });
              } else if (new_password != retype_password) {
                $.jGrowl("Password does not match with your new password  ", { header: 'Change Password Failed' });
              } else if ((password == current_password) && (new_password == retype_password)) {
                var formData = jQuery(this).serialize();
                $.ajax({
                  type: "POST",
                  url: "update_password.php",
                  data: formData,
                  success: function(html) {
                    $.jGrowl("Your password has been changed successfully", { header: 'Change Password Success' });
                    var delay = 2000;
                    setTimeout(function() { window.location = 'dashboard.php' }, delay);
                  }
                });
              }
            });
          });
        </script>
      </form>
    </center>
  </div> <!-- /container -->

  <?php include('footer.php'); ?>
  <?php include('script.php'); ?>
</body>
</html>
