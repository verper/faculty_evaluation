<h1 class="page-header">View per faculty</h1>

<div class="row form-group" id="toolbar">
  <div class="col-xs-12">
    <a class="btn btn-sm btn-primary pull-right" href="reports/overall"><i class="glyphicon glyphicon-eye-open"></i> View overall</a>
  </div>
</div>

<?php

  
?>

<div class="form-group text-center">
  <p>Fellowship Baptist College</p>
  <p>Rizal Street, Kabankalan City</p>
  <p><?php echo $college_name; ?></p>
</div>

<table class="table table-condensed table-striped">
  <thead>
  <tr>
    <th>Fullname</th>
    <th>Role</th>
    <th class="text-center">Student</th>
    <th class="text-center">Peer</th>
    <th class="text-center">Program Head</th>
    <th class="text-center">Dean</th>
  </tr>
  </thead>
  <tbody>
    <?php
      foreach( $faculties as $fac ):
        $fullname = $fac->lastname . ', ' . $fac->firstname . ' ' . $fac->middlename;
        $stud = '<a class="btn btn-primary btn-sm" href="reports/pdf/'.$fac->id.'/1" target="_blank"><i class="glyphicon glyphicon-print"></i> Print</a>';
        $peer = '<a class="btn btn-primary btn-sm" href="reports/pdf/'.$fac->id.'/2" target="_blank"><i class="glyphicon glyphicon-print"></i> Print</a>';
        $prog = '<a class="btn btn-primary btn-sm" href="reports/pdf/'.$fac->id.'/3" target="_blank"><i class="glyphicon glyphicon-print"></i> Print</a>';
        $dean = '<a class="btn btn-primary btn-sm" href="reports/pdf/'.$fac->id.'/4" target="_blank"><i class="glyphicon glyphicon-print"></i> Print</a>';

        if ( $fac->role == '3' ) {
          $stud = 'NA';
          $prog = 'NA';
        }
    ?>
    <tr>
      <td><?php echo $fullname; ?></td>
      <td><?php echo strtoupper($fac->rolename); ?></td>
      <td class="text-center"><?php echo $stud;?></td>
      <td class="text-center"><?php echo $peer;?></td>
      <td class="text-center"><?php echo $prog;?></td>
      <td class="text-center"><?php echo $dean;?></td>
    <?php endforeach; ?>
  </tbody>
</table>