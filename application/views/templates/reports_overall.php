<style>
@page {
  margin: 0.5in;
}
table {
  width: 100%;
  margin-bottom: 0;
  font-family: arial;font-size: 12;
}
th {
  text-align: left;
}
td {
  border: 1px solid #eee;
}
.text-right {
  text-align: right;
}
.text-center {
  text-align: center;
}
p {
  margin: 0;
}
#pdfhead {
  display: none;
}
@media print {
  #toolbar {
    display: none;
  }
  .form-group {
    margin-bottom: 25px;
    font-family: arial;font-size: 12;
  }
  h1.page-header {
    font-family: arial;font-size: 14;
    display: none;
  }
  #pdfhead {
    display: block;
  }
  #pdfhead td {
    border: none;
  }
}
</style>

<h1 class="page-header">Overall Report</h1>
<div id="pdfhead"><?php $this->load->view('templates/pdf_header'); ?></div>

<div class="row form-group" id="toolbar">
  <div class="col-xs-12">
    <a class="btn btn-sm btn-primary" href="reports/overall/pdf" target="_blank"><i class="glyphicon glyphicon-print"></i> Print</a>
    <a class="btn btn-sm btn-primary pull-right" href="reports/faculty"><i class="glyphicon glyphicon-eye-open"></i> View per faculty</a>
  </div>
</div>

<table class="table table-condensed table-striped">
  <thead>
  <tr>
    <th>Fullname</th>
    <th>Role</th>
    <th class="text-right">Student</th>
    <th class="text-right">Peer</th>
    <th class="text-right">Program Head</th>
    <th class="text-right">Dean</th>
    <th class="text-right"><strong>Total</strong></th>
  </tr>
  </thead>
  <tbody>
    <?php
      foreach( $faculties as $fac ):
        $fullname = $fac->lastname . ', ' . $fac->firstname . ' ' . $fac->middlename;
        $student = $this->forms->get_user_form('1');
        $peer = $this->forms->get_user_form('2');
        $program_head = $this->forms->get_user_form('3');
        $dean = $this->forms->get_user_form('4');

        $stud = $this->evaluation->general_average($student->form->id, $fac->id);
        $peer = $this->evaluation->general_average($peer->form->id, $fac->id);
        $head = $this->evaluation->general_average($program_head->form->id, $fac->id);
        $dean = $this->evaluation->general_average($dean->form->id, $fac->id);
        $total = 0;
        $total = ($stud + $peer + $head + $dean) / 4;
        $total = is_float($total) ? number_format($total, 2) + 0 : $total;

        if ( $fac->role == '3' ) {
          $total = ($peer + $dean) / 2;
          $total = is_float($total) ? number_format($total, 2) + 0 : $total;
          $stud = '<small>NA</small>';
          $head = '<small>NA</small>';
        }
    ?>
    <tr>
      <td><?php echo $fullname; ?></td>
      <td><?php echo strtoupper($fac->rolename); ?></td>
      <td class="text-right"><?php echo $stud;?></td>
      <td class="text-right"><?php echo $peer;?></td>
      <td class="text-right"><?php echo $head;?></td>
      <td class="text-right"><?php echo $dean;?></td>
      <td class="text-right"><strong><?php echo $total;?></strong></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>