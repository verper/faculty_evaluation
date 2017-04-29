<h1 class="page-header">Programs <a class="btn btn-primary pull-right" href="#addNewModal" data-toggle="modal">Add</a></h1>

<?php $this->load->view('templates/inner/search_filter.php'); ?>

<div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="form" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">New Programs</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label>Program Code</label>
              <input class="form-control nospace text-uppercase" type="text" name="code" placeholder="Program Code" required/>
            </div>

            <div class="form-group">
              <label>Program Title</label>
              <input class="form-control text-uppercase" type="text" name="program" placeholder="Program Title" required/>
            </div>

            <div class="form-group">
              <label>College</label>
              <select class="form-control" name="college" required>
                <option disabled selected value="">- Select College -</option>
                <?php foreach($colleges as $college): ?>
                  <option value="<?php echo $college->id;?>"><?php echo $college->title;?></option>
                <?php endforeach?>
              </select>
            </div>

            <div class="form-group">
              <label>Program Head</label>
              <select class="form-control" name="supervisor" required>
                <option disabled selected value="">- Select Program Head -</option>
                <?php foreach($supervisors as $supervisor): ?>
                  <option value="<?php echo $supervisor->id;?>"><?php echo $supervisor->lastname;?>, <?php echo $supervisor->firstname;?></option>
                <?php endforeach?>
              </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <input class="btn btn-primary" type="submit" value="Add" />
          <input type="hidden" value="new_program" name="form_id" />
        </div>
      </form>
    </div>
  </div>
</div>

<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Code</th>
        <th>Title</th>
        <th>Program Head</th>
        <th>College</th>
        <th>Courses</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>

      <?php if ( $programs ): ?>
        <?php foreach( $programs as $program ): ?>
          <tr>
            <td><?php echo $program->id; ?></td>
            <td><?php echo $program->title; ?></td>
            <td><?php echo $program->lastname; ?>, <?php echo $program->firstname; ?> <?php echo $program->middlename; ?></td>
            <td><?php echo $program->college->id; ?></td>
            <td><a href="<?php echo base_url();?>courses?q=<?php echo $program->id;?>">Courses</a></td>
            <td><div class="btn-group">
                  <a class="btn btn-info btn-xs" title="Edit" href="#edit-program-<?php echo $program->id;?>" data-toggle="modal"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a class="btn btn-danger btn-xs" title="Remove" href="#remove-program-<?php echo $program->id;?>" data-toggle="modal"><i class="glyphicon glyphicon-trash"></i></a>
                  
                  <div class="modal fade" id="edit-program-<?php echo $program->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <form method="post" action="">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Edit <?php echo $program->title;?></h4>
                          </div>
                          <div class="modal-body">
                              <div class="form-group">
                                <label>Program Code</label>
                                <input class="form-control nospace text-uppercase" type="text" name="code" placeholder="Program Code" value="<?php echo $program->id;?>" required/>
                              </div>
                              <div class="form-group">
                                <label>Program Title</label>
                                <input class="form-control text-uppercase" type="text" name="program" placeholder="Program Title" value="<?php echo $program->title;?>" required/>
                              </div>

                              <div class="form-group">
                                <label>College</label>
                                <select class="form-control" name="college" required>
                                  <option disabled selected value="">- Select College -</option>
                                  <?php foreach($colleges as $college): ?>
                                    <?php $selected = ($college->id == $program->college->id) ? 'selected':'';?>
                                    <option value="<?php echo $college->id;?>" <?php echo $selected;?>><?php echo $college->title;?></option>
                                  <?php endforeach?>
                                </select>
                              </div>

                              <div class="form-group">
                                <label>Program Head</label>
                                <select class="form-control" name="supervisor" required>
                                  <option disabled selected value="">- Select Program Head -</option>
                                  <?php foreach($supervisors as $supervisor): ?>
                                    <?php $selected = ($supervisor->id == $program->supervisor) ? 'selected':'';?>
                                    <option value="<?php echo $supervisor->id;?>" <?php echo $selected;?>><?php echo $supervisor->lastname;?>, <?php echo $supervisor->firstname;?></option>
                                  <?php endforeach?>
                                </select>
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <input class="btn btn-primary" type="submit" value="Save" />
                            <input type="hidden" value="edit_program" name="form_id" />
                            <input type="hidden" value="<?php echo $program->id; ?>" name="program_id" />
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <div class="modal fade" id="remove-program-<?php echo $program->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title">Remove <?php echo $program->title;?></h4>
                        </div>
                        <div class="modal-body">
                          Are you sure you want to remove <strong><?php echo $program->title;?></strong>?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                          <a class="btn btn-primary" href="<?php echo base_url();?>programs/delete/<?php echo $program->id;?>">Yes</a>
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
          <td colspan="5">No programs found.</td>
        </tr>
      <?php endif; ?>

    </tbody>
  </table>
</div>