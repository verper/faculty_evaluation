<h1 class="page-header">Colleges <a class="btn btn-primary pull-right" href="#addNewModal" data-toggle="modal">Add</a></h1>

<div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="form" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">New College</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label>College Code</label>
              <input class="form-control nospace text-uppercase" type="text" name="code" placeholder="College Code" required/>
            </div>

            <div class="form-group">
              <label>College Title</label>
              <input class="form-control text-uppercase" type="text" name="college" placeholder="College Title" required/>
            </div>

            <div class="form-group">
              <label>Dean</label>
              <select class="form-control" name="dean" required>
                <option disabled selected value="">- Select Dean -</option>
                <?php foreach($deans as $dean): ?>
                  <option value="<?php echo $dean->id;?>"><?php echo $dean->lastname;?>, <?php echo $dean->firstname;?></option>
                <?php endforeach?>
              </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <input class="btn btn-primary" type="submit" value="Add" />
          <input type="hidden" value="new_college" name="form_id" />
        </div>
      </form>
    </div>
  </div>
</div>

<?php $this->load->view('templates/inner/search_filter.php'); ?>

<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Code</th>
        <th>Title</th>
        <th>Dean</th>
        <th>Programs</th>
        <th style="width:1px;">Actions</th>
      </tr>
    </thead>
    <tbody>

      <?php if ( $colleges ): ?>
        <?php foreach( $colleges as $college ): ?>
          <tr>
            <td><?php echo $college->id; ?></td>
            <td><?php echo $college->title; ?></td>
            <td><a href="/users/edit/<?php echo $college->userid;?>"><?php echo $college->lastname; ?>, <?php echo $college->firstname; ?> <?php echo $college->middlename; ?></a></td>
            <td><a href="/programs?q=<?php echo $college->id;?>">Programs</a></td>
            <td><div class="btn-group btn-group-justified">
                  <a class="btn btn-info btn-xs" title="Edit" href="#edit-college-<?php echo $college->id;?>" data-toggle="modal"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a class="btn btn-danger btn-xs" title="Remove" href="#remove-college-<?php echo $college->id;?>" data-toggle="modal"><i class="glyphicon glyphicon-trash"></i></a>
                  
                  <div class="modal fade" id="edit-college-<?php echo $college->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <form method="post" action="">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Edit <?php echo $college->title;?></h4>
                          </div>
                          <div class="modal-body">
                              <div class="form-group">
                                <label>College Code</label>
                                <input class="form-control nospace text-uppercase" type="text" name="code" placeholder="College Code" value="<?php echo $college->id; ?>" required/>
                              </div>  

                              <div class="form-group">
                                <label>College Title</label>
                                <input class="form-control text-uppercase" type="text" name="college" placeholder="College Title" value="<?php echo $college->title; ?>" required/>
                              </div>

                              <div class="form-group">
                                <label>Dean</label>
                                <select class="form-control" name="dean" required>
                                  <option disabled selected value="">- Select Dean -</option>
                                  <?php foreach($deans as $dean): ?>
                                    <?php $selected = ($dean->id == $college->dean) ? 'selected' : '';?>
                                    <option value="<?php echo $dean->id;?>" <?php echo $selected;?>><?php echo $dean->lastname;?>, <?php echo $dean->firstname;?></option>
                                  <?php endforeach?>
                                </select>
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <input class="btn btn-primary" type="submit" value="Save" />
                            <input type="hidden" value="edit_college" name="form_id" />
                            <input type="hidden" value="<?php echo $college->id; ?>" name="college_id" />
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <div class="modal fade" id="remove-college-<?php echo $college->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title">Remove <?php echo $college->title;?></h4>
                        </div>
                        <div class="modal-body">
                          Are you sure you want to remove <strong><?php echo $college->title;?></strong>?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                          <a class="btn btn-primary" href="/colleges/delete/<?php echo $college->id;?>">Yes</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> 
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="5">No colleges found.</td>
        </tr>
      <?php endif; ?>

    </tbody>
  </table>
</div>