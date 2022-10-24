<?php $this->make('common/header'); ?>
<div class="container">
    <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="../user/homepage"><span class="glyphicon glyphicon-home"></span><i> <?php echo htmlspecialchars($_SESSION['user']['first_name']);?></i></a>
      </div>
      <div>
        <ul class="nav navbar-nav">
          <li class="active"><a href="../contact/"><span class="glyphicon glyphicon-user"></span> My Contacts</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">

          <li><a href="../user/logout"><span class="glyphicon glyphicon-log-out"></span></a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="row">
      <div class="table-responsive">
      <ul class="pager"><li class="next"><a href="add"><span class="glyphicon glyphicon-plus"></span> Add Contact</a></li></ul>
      <?php if (isset($error)): ?>
        <div class="alert alert-danger">
          <a class="close" data-dismiss="alert" href="#">×</a><?php echo $error; ?>
        </div>
      <?php endif; ?>
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Address</th>
              <th>Phone number</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="myTable">
          <?php
              $count = 1;
              if (!empty($contacts)):
                  foreach ($contacts as $contact):
          ?>
                      <tr>
                        <td><?php echo htmlspecialchars($count);?></td>
                        <td><?php echo htmlspecialchars($contact['name']);?></td>
                        <td><?php echo htmlspecialchars($contact['address']);?></td>
                        <td><?php echo htmlspecialchars($contact['phone_number']);?></td>
                        <td>

                          <!-- <a href="#"><span class="glyphicon glyphicon-cog"></span></a>&nbsp;&nbsp; -->
                          <a href="<?php echo 'edit_page/' . $contact['id'];?>">
                              <button id="btnRemover" type="button" data-container="body" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                <span class="glyphicon glyphicon-edit"></span>
                              </button>
                          </a>

                            <form action="delete" method="post" role="form">
                                  <input type="hidden" value="<?php echo htmlspecialchars($contact['id']);?>" name="id">
                                  <button type="submit" class="btn btn-danger" onclick="return confirm('Are sure you want to delete this contact?')" title="Delete">
                                    <span class="glyphicon glyphicon-trash"></span>
                                  </button>
                            </form>
                        </td>
                      </tr>
          <?php
                  $count++;
                  endforeach;
              else:
          ?>
                  <tr><td colspan="5" align="center">No Results Found.</td></tr>
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