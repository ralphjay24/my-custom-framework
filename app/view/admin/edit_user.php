<?php $this->make('common/header'); ?>
<div class="container" style="margin-top:30px">
          <div class="col-md-10 col-md-offset-1">
              <div class="panel panel-default">
                  <div class="panel-heading"><h3 class="panel-title"><strong>Update Form </strong></h3>
                      <!-- <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div> -->
                      <!-- <a href="/act2_mvc/public/css/bootstrap.min.css">css</a> -->
                  </div>

                  <div class="panel-body">
                      <form role="form" action="<?php echo '../edit_user/' . $edit['id'];?>" method="post">
                      <?php if(isset($error)): ?>
                        <?php echo $error; ?>
                      <?php endif; ?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="*First Name" tabindex="1" value="<?php echo htmlspecialchars($edit['first_name']);?>">
                                    <h6 style="color: #FF0000;"><?php echo $fname_error;?></h6>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <input type="text" name="middle_name" id="middle_name" class="form-control" placeholder="Middle Name" tabindex="1" value="<?php echo htmlspecialchars($edit['middle_name']);?>">
                              </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <input type="text" name="last_name" id="last_name" class="form-control " placeholder="*Last Name" tabindex="2" value="<?php echo htmlspecialchars($edit['last_name']);?>">
                                    <h6 style="color: #FF0000;"><?php echo $lname_error;?></h6>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="text" name="address" id="display_name" class="form-control " placeholder="Address" tabindex="3" value="<?php echo htmlspecialchars($edit['address']);?>">
                        </div>
                        <div class="form-group">
                            <input type="text" name="contact_number" id="display_name" class="form-control " placeholder="Contact Number" tabindex="3" value="<?php echo htmlspecialchars($edit['contact_number']);?>">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email_address" id="email_address" class="form-control " placeholder="*Email Address" tabindex="4" value="<?php echo htmlspecialchars($edit['email_address']);?>">
                            <h6 style="color: #FF0000;"><?php echo $email_error;?></h6>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control " placeholder="*Password" tabindex="5">
                                    <h6 style="color: #FF0000;"><?php echo $pass_error;?></h6>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label><i><h5>Input admin password for your authorization.</h5></i></label>
                                </div>
                            </div>
                        </div>
                        <?php if ($_SESSION['user']['id'] != $edit['id']): ?>
                        <div class="input-group">
                            <div class="checkbox" style="margin-top: 0px;">
                                <label>
                                    <input id="user" type="radio" name="type" value="user" <?php echo htmlspecialchars($edit['user']);?>> User
                                </label>
                                <label>
                                    <input id="admin" type="radio" name="type" value="admin" <?php echo htmlspecialchars($edit['admin']);?>> Admin
                                </label>
                            </div>
                            <h6 style="color: #FF0000;"><i>**Note: Default user type is user.</i></h6>
                        </div>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-success">Update</button>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php if ($_SESSION['user']['type'] == 'admin'): ?>
                                  <a href="../">
                                      Back to Admin page
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