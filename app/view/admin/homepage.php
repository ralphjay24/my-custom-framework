<?php $this->make('common/header'); ?>
<div class="container">
   <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="">CONTACT - ADMIN</a>
      </div>
      <div>
        <ul class="nav navbar-nav">

        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#"><span class="glyphicon glyphicon-user"></span> Admin, <i> <?php echo htmlspecialchars($_SESSION['user']['first_name']);?></i></a></li>
          <li><a href="index"><span class="glyphicon glyphicon-home"></span></a></li>
          <li><a href="../user/logout"><span class="glyphicon glyphicon-log-out"></span></a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="row">
      <div class="table-responsive">
      <ul class="pager"><li class="next"><a href="../user/signup"><span class="glyphicon glyphicon-plus"></span> Add User</a></li></ul>
      <?php if (isset($error)): ?>
        <div class="alert alert-danger">
          <a class="close" data-dismiss="alert" href="#">×</a><?php echo $error; ?>
        </div>
      <?php endif; ?>
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Full Name</th>
              <th>Address</th>
              <th>Contact</th>
              <th>Email Address</th>
              <th>User Type</th>
              <th>Date Created</th>
              <th>Date Updated</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="myTable">
          <?php
              $count = 1;
              if (!empty($users)):
                  foreach ($users as $u):
          ?>
                      <tr>
                        <td><?php echo htmlspecialchars($count);?></td>
                        <td><?php echo htmlspecialchars($u['full_name']);?></td>
                        <td><?php echo htmlspecialchars($u['address']);?></td>
                        <td><?php echo htmlspecialchars($u['contact_number']);?></td>
                        <td><?php echo htmlspecialchars($u['email_address']);?></td>
                        <td><?php echo htmlspecialchars($u['type']);?></td>
                        <td><?php echo htmlspecialchars($u['created_at']);?></td>
                        <td><?php echo htmlspecialchars($u['update_at']);?></td>
                        <td>

                          <!-- <a href="#"><span class="glyphicon glyphicon-cog"></span></a>&nbsp;&nbsp; -->
                          <a href="<?php echo 'edit_user_page/' . $u['id'];?>">
                              <button id="btnRemover" type="button" data-container="body" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                <span class="glyphicon glyphicon-edit"></span>
                              </button>
                          </a>
                          <?php if ($_SESSION['user']['id'] == $u['id'] || $u['type'] == 'admin'):?>
                              <!-- <a href="<?php //echo 'delete.php?id=' . $u['id'] . '&q=user';?>" onclick="return confirm('Are sure you want to delete this user?')"> -->
                                  <button id="btnRemover" type="button" data-container="body" class="btn btn-default btn-danger btn-sm disabled" data-toggle="tooltip" data-placement="bottom" title="Can't Delete">
                                    <span class="glyphicon glyphicon-trash"></span>
                                  </button>
                              <!-- </a> -->
                          <?php else: ?>
                            <form action="delete_user" method="post" role="form">
                                  <input type="hidden" value="<?php echo htmlspecialchars($u['id']);?>" name="id">
                                  <button type="submit" class="btn btn-danger" onclick="return confirm('Are sure you want to delete this user?')" title="Delete">
                                    <span class="glyphicon glyphicon-trash"></span>
                                  </button>
                            </form>
                          <?php endif;?>

                        </td>

                      </tr>
          <?php
                  $count++;
                  endforeach;
              else:
          ?>
                  <tr><td colspan="10" align="center">No Results Found.</td></tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
      <div class="col-md-12 text-center">
      <ul class="pagination pagination-lg pager" id="myPager"></ul>
      </div>
  </div>
</div>
</body>
</html>