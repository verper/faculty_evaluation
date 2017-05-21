<?php $student_list = array(); ?>

<div class="page-header">
  <h1><?php echo $course->id;?></h1>
  <h4><?php echo $course->title;?></h4>
  <h5>Instructor: <?php echo $course->faculty->lastname . ', ' . $course->faculty->firstname . ' ' . $course->faculty->middlename;?></h5>
</div>

<div class="row">
  <div class="col-sm-6">
    <legend><?php echo $course->id;?> Students List <a class="btn btn-sm btn-primary pull-right" data-target="#add-bulk" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Add bulk</a></legend>
    
    <div class="modal fade" tabindex="-1" role="dialog" id="add-bulk">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Upload bulk students</h4>
          </div>
          <form action="courses/bulk" method="post" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="form-group">
                <label>Upload CSV file</label>
                <input class="form-control" type="file" name="bulk_add_file">
              </div>
              <div class="form-group">
                <a class="btn-link" href=""><i class="glyphicon glyphicon-download-alt"></i> Download sample csv file or edit this file and upload</a>
              </div>
              <div class="form-group">
                <p><i class="glyphicon glyphicon-exclamation-sign"></i> New students from the uploaded list will be automatically added to the system.</p>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <input class="btn btn-primary" type="submit" value="Upload">
              <input type="hidden" name="form_id" value="bulk_users">
              <input type="hidden" name="course_id" value="<?php echo $course->id;?>">
            </div>
          </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="form-group">
      <form action="" method="get">
        <div class="input-group">
          <input type="hidden" name="q" value="<?php echo isset($_GET['q']) ? $_GET['q'] : '';?>">
          <input type="text" class="form-control input-sm" id="course-list-search" name="p" value="<?php echo isset($_GET['p']) ? $_GET['p'] : '';?>">
          <span class="input-group-btn"><button class="btn btn-primary btn-sm" type="submit"><i class="glyphicon glyphicon-search"></i></button></span>
        </div>
      </form>
    </div>    
    <div class="table-responsive">
      <table class="table table-striped table-hover table-condensed table-bordered" id="course-list">
        <thead>
          <tr>
            <th>ID</th>
            <th>Full name</th>
            <th style="width: 1px">Actions</th>
          </tr>
        </thead>
        <tbody>

          <?php if ( $present ): ?>
            <?php foreach( $present as $p ):?>
              <tr>
                <tr>
                  <td><?php echo $p->id;?></td>
                  <td><?php echo $p->lastname;?>, <?php echo $p->firstname;?> <?php echo $p->middlename;?></td>
                  <td class="text-center">
                    <form method="post" action="<?php echo base_url();?>courses/remove_student">
                      <button type="submit" class="btn btn-danger btn-xs" role="button" title="Remove student"><i class="glyphicon glyphicon-remove"></i></button>
                      <input type="hidden" name="form_id" value="remove_student"/>
                      <input type="hidden" name="student_id" value="<?php echo $p->id;?>" />
                      <input type="hidden" name="course_id" value="<?php echo $course->id;?>" />
                    </form>
                  </td>
                </tr>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5">No students found for this course.</td>
            </tr>
          <?php endif; ?>

        </tbody>
      </table>
    </div>
  </div>

  <div class="col-sm-6">
    <legend>Complete Students List</legend>
    <div class="form-group">
      <form action="" method="get">
        <div class="input-group">
          <input type="hidden" name="p" value="<?php echo isset($_GET['p']) ? $_GET['p'] : '';?>">
          <input type="text" class="form-control input-sm" name="q" value="<?php echo isset($_GET['q']) ? $_GET['q'] : '';?>">
          <span class="input-group-btn"><button class="btn btn-primary btn-sm" type="submit"><i class="glyphicon glyphicon-search"></i></button></span>
        </div>
      </form>
    </div> 
    <div class="table-responsive">
      <table class="table table-striped table-hover table-condensed table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Full name</th>
            <th style="width: 1px">Actions</th>
          </tr>
        </thead>
        <tbody>

          <?php if ( $students ): ?>
            <?php foreach( $students as $student ):  ?>
              <tr>
                <td><?php echo $student->id;?></td>
                <td><?php echo $student->lastname;?>, <?php echo $student->firstname;?> <?php echo $student->middlename;?></td>
                <td class="text-center">
                  <form method="post" action="<?php echo base_url();?>courses/add_student">
                    <button type="submit" class="btn btn-success btn-xs" role="button" title="Add student"><i class="glyphicon glyphicon-plus"></i></button>
                    <input type="hidden" name="form_id" value="add_student"/>
                    <input type="hidden" name="student_id" value="<?php echo $student->id;?>" />
                    <input type="hidden" name="course_id" value="<?php echo $course->id;?>" />
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5">No students found.</td>
            </tr>
          <?php endif; ?>

        </tbody>
      </table>
    </div>
  </div>
  </div>
</div>

<script type="text/javascript">
// jQuery(function($) {    
//     $('#course-list-search').on('keyup', function() {
//       var rex = new RegExp($(this).val(), 'i');
//         $('#course-list tbody').hide();
//         $('#course-list tbody').filter(function() {
//             return rex.test($(this).text());
//         }).show();
//     });
// });
</script>

<script>
function myFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("course-list-search");
  filter = input.value.toUpperCase();
  table = document.getElementById("course-list");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}
</script>