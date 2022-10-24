<?php $this->make('common/header'); ?>
    <div class="container" style="margin-top:30px">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title"><strong>Registration Form </strong></h3>
                    <!-- <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div> -->
                </div>

                <div class="panel-body">
                    <form role="form" action="signup" method="post">
                      <?php echo $error; ?>
                      <div class="row">
                          <div class="col-xs-12 col-sm-4 col-md-4">
                              <div class="form-group">
                                  <input type="text" name="first_name" id="first_name" class="form-control" placeholder="*First Name" tabindex="1">
                                  <h6 style="color: #FF0000;"><?php echo $fname_error;?></h6>
                              </div>
                          </div>
                          <div class="col-xs-12 col-sm-4 col-md-4">
                              <div class="form-group">
                                  <input type="text" name="middle_name" id="middle_name" class="form-control" placeholder="Middle Name" tabindex="1">
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-4 col-md-4">
                              <div class="form-group">
                                  <input type="text" name="last_name" id="last_name" class="form-control " placeholder="*Last Name" tabindex="2">
                                  <h6 style="color: #FF0000;"><?php echo $lname_error;?></h6>
                              </div>
                          </div>
                      </div>

                      <div class="form-group">
                          <input type="text" name="address" id="display_name" class="form-control " placeholder="Address" tabindex="3">
                      </div>
                      <div class="form-group">
                          <input type="text" name="contact_number" id="display_name" class="form-control " placeholder="Contact Number" tabindex="3">
                      </div>
                      <div class="form-group">
                          <input type="text" name="email_address" id="email_address" class="form-control " placeholder="*Email Address" tabindex="4">
                          <h6 style="color: #FF0000;"><?php echo $email_error;?></h6>
                      </div>
                      <div class="row">
                          <div class="col-xs-12 col-sm-6 col-md-6">
                              <div class="form-group">
                                  <input type="password" name="password" id="password" class="form-control " placeholder="*Password" tabindex="5">
                                  <h6 style="color: #FF0000;"><?php echo $pass_error;?></h6>
                              </div>
                          </div>
                          <div class="col-xs-12 col-sm-6 col-md-6">
                              <div class="form-group">
                                  <input type="password" name="password_confirmation" id="password_confirmation" class="form-control " placeholder="*Confirm Password" tabindex="6">
                                  <h6 style="color: #FF0000;"><?php echo $cpass_error;?></h6>
                              </div>
                          </div>
                      </div>

                      <div class="input-group">
                          <div class="checkbox" style="margin-top: 0px;">
                              <label>
                                  <input id="user" type="radio" name="type" value="user" checked="checked"> User
                              </label>
                              <label>
                                  <input id="admin" type="radio" name="type" value="admin"> Admin
                              </label>
                              <h6 style="color: #FF0000;"><i>**Note: Default user type is user.</i></h6>
                          </div>
                      </div>

                      <button type="submit" class="btn btn-success">Signup</button>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <?php if ($_SESSION['user']['type'] == 'admin'): ?>
                                <a href="../admin/">
                                    Back to Admin page
                                </a>
                      <?php endif; ?>

                      <hr style="margin-top:10px;margin-bottom:10px;" >
                      <?php if (empty($_SESSION['user'])): ?>
                      <div class="form-group">
                          <div style="font-size:85%">
                              Already have an account!
                              <a href="login">
                                  Login here.
                              </a>
                          </div>
                      </div>
                      <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>