<?php $student_list = array(); ?>

<div class="page-header">
  <h1><?php echo $course->id;?></h1>
  <h4><?php echo $course->title;?></h4>
</div>

<div class="row">
  <div class="col-sm-6">
    <legend><?php echo $course->id;?> Students List</legend>
    <div class="form-group">
      <div class="input-group">
        <input type="text" class="form-control input-sm" id="course-list-search">
        <span class="input-group-addon input-sm"><i class="glyphicon glyphicon-search"></i></span>
      </div>
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
                  <td><?php echo $p->user->id;?></td>
                  <td><?php echo $p->user->lastname;?>, <?php echo $p->user->firstname;?> <?php echo $p->user->middlename;?></td>
                  <td class="text-center">
                    <form method="post" action="/courses/remove_student">
                      <button type="submit" class="btn btn-danger btn-xs" role="button" title="Remove student"><i class="glyphicon glyphicon-remove"></i></button>
                      <input type="hidden" name="form_id" value="remove_student"/>
                      <input type="hidden" name="student_id" value="<?php echo $p->user->id;?>" />
                      <input type="hidden" name="course_id" value="<?php echo $course->id;?>" />
                    </form>
                  </td>
                </tr>
              </tr>
              <?php $student_list[] = $p->user->id;?>
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
      <div class="input-group">
        <input type="text" class="form-control input-sm">
        <span class="input-group-addon input-sm"><i class="glyphicon glyphicon-search"></i></span>
      </div>
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
            <?php foreach( $students as $student ): if ( !in_array($student->id, $student_list) ): ?>
              <tr>
                <td><?php echo $student->id;?></td>
                <td><?php echo $student->lastname;?>, <?php echo $student->firstname;?> <?php echo $student->middlename;?></td>
                <td class="text-center">
                  <form method="post" action="/courses/add_student">
                    <button type="submit" class="btn btn-success btn-xs" role="button" title="Add student"><i class="glyphicon glyphicon-plus"></i></button>
                    <input type="hidden" name="form_id" value="add_student"/>
                    <input type="hidden" name="student_id" value="<?php echo $student->id;?>" />
                    <input type="hidden" name="course_id" value="<?php echo $course->id;?>" />
                  </form>
                </td>
              </tr>
            <?php endif; endforeach; ?>
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