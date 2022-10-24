<?php $this->make('common/header'); ?>
<div class="container" style="margin-top:30px">
          <div class="col-md-10 col-md-offset-1">
              <div class="panel panel-default">
                  <div class="panel-heading"><h3 class="panel-title"><strong>Change Password Form </strong></h3>
                      <!-- <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div> -->
                      <!-- <a href="/act2_mvc/public/css/bootstrap.min.css">css</a> -->
                  </div>

                  <div class="panel-body">
                      <form role="form" action="<?php echo '../change_pass/' . $id;?>" method="post">
                      <?php if(isset($error)): ?>
                        <?php echo $error; ?>
                      <?php endif; ?>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="password" name="old_password" id="opassword" class="form-control " placeholder="*Old Password" tabindex="5">
                                    <h6 style="color: #FF0000;"><?php echo $opass_error;?></h6>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="new_password" id="npassword" class="form-control " placeholder="*New Password" tabindex="5">
                                    <h6 style="color: #FF0000;"><?php echo $npass_error;?></h6>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirm_password" id="cpassword" class="form-control " placeholder="*Confirm New Password" tabindex="5">
                                    <h6 style="color: #FF0000;"><?php echo $cpass_error;?></h6>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Change Pass</button>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php if ($_SESSION['user']['type'] == 'user'): ?>
                                  <a href="homepage">
                                      Back
                                  </a>
                        <?php endif; ?>
                        <hr style="margin-top:10px;margin-bottom:10px;" >
                      </form>
                  </div>
              </div>
          </div>
      </div>
</body>
</html>