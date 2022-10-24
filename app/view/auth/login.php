<?php $this->make('common/header'); ?>
<div class="container" style="margin-top:30px">
          <div class="col-md-10 col-md-offset-1">
              <div class="panel panel-default">
                  <div class="panel-heading"><h3 class="panel-title"><strong>Login Form </strong></h3>
                      <!-- <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div> -->
                  </div>

                  <div class="panel-body">
                      <form role="form" action="login" method="post">
                        <?php if (isset($error)): ?>
                          <div class="alert alert-danger fade in">
                            <a class="close" data-dismiss="alert" href="#">×</a><?php echo $error; ?>
                          </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <input type="text" name="email_address" id="email_address" class="form-control " placeholder="Email Address" tabindex="3">
                            <h6 style="color: #FF0000;"><?php echo $email_error;?></h6>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="password" class="form-control " placeholder="Password" tabindex="3">
                        </div>

                        <button type="submit" class="btn btn-success">Login</button>

                        <hr style="margin-top:10px;margin-bottom:10px;" >

                        <div class="form-group">
                            <div style="font-size:85%">
                                No Account?
                                <a href="signup">
                                    Signup here.
                                </a>
                            </div>
                        </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
</body>
</html>