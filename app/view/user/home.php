<?php $this->make('common/header'); ?>
<div class="container">
   <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href=""><span class="glyphicon glyphicon-home"></span><i> <?php echo htmlspecialchars($_SESSION['user']['first_name']);?></i></a>
      </div>
      <div>
        <ul class="nav navbar-nav">
          <li><a href="../contact/"><span class="glyphicon glyphicon-user"></span> My Contacts</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">

          <li><a href="../user/logout"><span class="glyphicon glyphicon-log-out"></span></a></li>
        </ul>
      </div>
    </div>
  </nav>

  <br><br>
  <div class="container-fluid well span6">
    <div class="row-fluid">
          <div class="span2" >
            <img src="https://pbs.twimg.com/profile_images/420242044808749056/ajqa1Xz_.jpeg" class="img-circle">
          </div>

          <div class="span8">
              <h3><?php echo htmlspecialchars($user['full_name']);?></h3>
              <h5><span class="glyphicon glyphicon-envelope"></span> <?php echo htmlspecialchars($user['email_address']);?></h5>
              <h5><span class="glyphicon glyphicon-phone"></span> <?php echo htmlspecialchars($user['contact_number']);?></h5>
              <h6>Address: <?php echo htmlspecialchars($user['address']);?></h6>

              <h6>Date created: <?php echo htmlspecialchars($user['created_at']);?></h6>
              <h6>Date updated: <?php echo htmlspecialchars($user['update_at']);?></h6>
          </div>

          <div class="span2">
              <div class="btn-group">
                  <a class="btn dropdown-toggle btn-info" data-toggle="dropdown" href="#">
                      Action
                      <span class="icon-cog icon-white"></span><span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                      <li><a href="<?php echo 'edit_page/' . $_SESSION['user']['id'];?>"><span class="glyphicon glyphicon-user"></span> Update Profile</a></li>
                      <li><a href="<?php echo 'change_pass_page/' . $_SESSION['user']['id'];?>"><span class="glyphicon glyphicon-cog"></span> Change Password</a></li>
                  </ul>
              </div>
          </div>
    </div>
  </div>
</div>
</body>
</html>