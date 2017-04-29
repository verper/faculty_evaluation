<h1 class="page-header">Courses <a class="btn btn-primary pull-right" href="#addNewModal" data-toggle="modal">Add</a></h1>

<?php $this->load->view('templates/inner/search_filter.php'); ?>

<div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="form" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">New Course</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label>Course Code</label>
              <input class="form-control nospace text-uppercase" type="text" name="code" placeholder="Course Code" required/>
            </div>

            <div class="form-group">
              <label>Course Title</label>
              <input class="form-control text-uppercase" type="text" name="title" placeholder="Course title" required/>
            </div>

            <div class="form-group">
              <label>Program</label>
              <select class="form-control" name="program" required>
                <option disabled selected>- Select Program -</option>
                <?php foreach($programs as $program): ?>
                  <option value="<?php echo $program->id?>"><?php echo $program->title;?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label>Faculty</label>
              <select class="form-control" name="faculty" required>
                <option disabled selected>- Select Faculty -</option>
                <?php foreach($faculty as $fac): ?>
                  <option value="<?php echo $fac->id;?>"><?php echo $fac->lastname;?>, <?php echo $fac->firstname;?> <?php echo $fac->middlename;?></option>
                <?php endforeach; ?>  
              </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <input class="btn btn-primary" type="submit" value="Add" />
          <input type="hidden" value="new_course" name="form_id" />
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
        <th>Faculty</th>
        <th>Program</th>
        <th>College</th>
        <th>Students</th>
        <th style="">Actions</th>
      </tr>
    </thead>
    <tbody>

      <?php if ( $courses ): ?>
        <?php foreach( $courses as $course ): ?>
          <tr>
            <td><?php echo $course->id; ?></td>
            <td><?php echo $course->title; ?></td>
            <td><?php echo $course->lastname; ?>, <?php echo $course->firstname; ?> <?php echo $course->middlename; ?></td>
            <td><?php echo $course->program; ?></td>
            <td><?php echo $course->college; ?></td>
            <td><a href="<?php echo base_url();?>courses/<?php echo $course->id;?>">Students</a></td>
            <td><div class="btn-group">
                  <a class="btn btn-info btn-xs" title="Edit" href="#edit-course-<?php echo $course->id;?>" data-toggle="modal"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a class="btn btn-danger btn-xs" title="Remove" href="#remove-course-<?php echo $course->id;?>" data-toggle="modal"><i class="glyphicon glyphicon-trash"></i></a>
                  
                  <div class="modal fade" id="edit-course-<?php echo $course->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <form method="post" action="">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Edit <?php echo $course->title;?></h4>
                          </div>
                          <div class="modal-body">
                            <div class="form-group">
                              <label>Course Code</label>
                              <input class="form-control nospace text-uppercase" type="text" name="code" placeholder="Course Code" value="<?php echo $course->id;?>" required/>
                            </div>

                            <div class="form-group">
                              <label>Course Title</label>
                              <input class="form-control text-uppercase" type="text" name="title" placeholder="Course title" value="<?php echo $course->title;?>" required/>
                            </div>

                            <div class="form-group">
                              <label>Program</label>
                              <select class="form-control" name="program" required>
                                <option disabled selected>- Select Program -</option>
                                <?php foreach($programs as $program): ?>
                                  <?php $selected = $program->id == $course->program ? 'selected' : ''; ?>
                                  <option value="<?php echo $program->id?>" <?php echo $selected;?>><?php echo $program->title;?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>

                            <div class="form-group">
                              <label>Faculty</label>
                              <select class="form-control" name="faculty" required>
                                <option disabled selected>- Select Faculty -</option>
                                <?php foreach($faculty as $fac): ?>
                                  <?php $selected = ($fac->id == $course->assigned) ? 'selected' : ''; ?>
                                  <option value="<?php echo $fac->id;?>" <?php echo $selected;?>><?php echo $fac->lastname;?>, <?php echo $fac->firstname;?> <?php echo $fac->middlename;?></option>
                                <?php endforeach; ?>  
                              </select>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <input class="btn btn-primary" type="submit" value="Save" />
                            <input type="hidden" value="edit_course" name="form_id" />
                            <input type="hidden" value="<?php echo $course->id; ?>" name="course_id" />
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <div class="modal fade" id="remove-course-<?php echo $course->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title">Remove <?php echo $course->title;?></h4>
                        </div>
                        <div class="modal-body">
                          Are you sure you want to remove <strong><?php echo $course->id;?> <?php echo $course->title;?></strong>?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                          <a class="btn btn-primary" href="<?php echo base_url();?>courses/delete/<?php echo $course->id;?>">Yes</a>
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
          <td colspan="5">No courses found.</td>
        </tr>
      <?php endif; ?>

    </tbody>
  </table>
</div>