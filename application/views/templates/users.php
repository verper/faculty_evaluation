<h1 class="page-header">Users <a class="btn btn-primary pull-right" href="/users/add">Add</a></h1>

<?php $this->load->view('templates/inner/search_filter.php'); ?>

<div class="table-responsivee">
  <table id="users-table-list" class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th onclick="sortTable(0)">User ID</th>
        <th onclick="sortTable(1)">Last name</th>
        <th onclick="sortTable(2)">First name</th>
        <th onclick="sortTable(3)">Middle name</th>
        <th onclick="sortTable(4)">Role</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ( $users ): ?>
        <?php foreach($users as $user): ?>
          <tr>
            <td><?php echo $user->id; ?></td>
            <td><?php echo $user->lastname; ?></td>
            <td><?php echo $user->firstname; ?></td>
            <td><?php echo $user->middlename; ?></td>
            <td><?php echo strtoupper($user->rolename); ?></td>
            <td><div class="btn-group">
                  <div class="btn-group">
                    <a href="#" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      Action
                      <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu pull-right">
                      <li><a class=""><i class="glyphicon glyphicon-eye-open"></i> View </a></li>
                      <li><a class="" title="Edit" href="/users/edit/<?php echo $user->id;?>"><i class="glyphicon glyphicon-pencil"></i> Edit</a></li>
                      <li><a class="" title="Remove" href="#remove-<?php echo $user->id;?>" data-toggle="modal"><i class="glyphicon glyphicon-trash"></i> Delete</a></li>
                     </ul>
                  </div>
                </div>
                <div class="modal fade" id="remove-<?php echo $user->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="myModalLabel">Remove <?php echo $user->id.' '.$user->lastname.','.$user->firstname.' '.$user->middlename;?></h4>
                        </div>
                        <div class="modal-body">
                          Are you sure you want to remove <strong><?php echo $user->id.' '.$user->lastname.','.$user->firstname.' '.$user->middlename;?></strong>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                          <a class="btn btn-primary" href="/users/delete/<?php echo $user->id;?>">Yes</a>
                        </div>
                      </div>
                    </div>
                  </div>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="6">No users found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>


<script>
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("users-table-list");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.getElementsByTagName("TR");
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++; 
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>