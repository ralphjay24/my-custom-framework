<?php $this->make('common/header'); ?>
<div class="container" style="margin-top:30px">
          <div class="col-md-10 col-md-offset-1">
              <div class="panel panel-default">
                  <div class="panel-heading"><h3 class="panel-title"><strong>Contact-Update Form </strong></h3>
                      <!-- <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div> -->
                      <!-- <a href="/act2_mvc/public/css/bootstrap.min.css">css</a> -->
                  </div>

                  <div class="panel-body">
                      <form role="form" action="<?php echo '../edit/' . $edit['id'];?>" method="post">
                        <?php echo $error; ?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="text" name="name" id="name" class="form-control " placeholder="*Name" tabindex="5" value="<?php echo htmlspecialchars($edit['name']);?>">
                                    <h6 style="color: #FF0000;"><?php echo $name_error;?></h6>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="address" id="address" class="form-control " placeholder="Address" tabindex="5" value="<?php echo htmlspecialchars($edit['address']);?>">
                                    <!-- <h6 style="color: #FF0000;"><?php //echo $address_error;?></h6> -->
                                </div>
                                <div class="form-group">
                                    <input type="text" name="phone_number" id="cpassword" class="form-control " placeholder="Phone Number" tabindex="5" value="<?php echo htmlspecialchars($edit['phone_number']);?>">
                                    <!-- <h6 style="color: #FF0000;"><?php //echo $phone_error;?></h6> -->
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Update</button>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <a href="./">
                                      Back
                                  </a>
                        <hr style="margin-top:10px;margin-bottom:10px;" >
                      </form>
                  </div>
              </div>
          </div>
      </div>
</body>
</html>