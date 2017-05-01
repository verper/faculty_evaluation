<h1 class="page-header">Reports Overall</h1>

<table class="table table-condensed table-striped">
  <thead>
    <th>Fullname</th>
    <th>Role</th>
    <th class="text-right">Student</th>
    <th class="text-right">Peer</th>
    <th class="text-right">Program Head</th>
    <th class="text-right">Dean</th>
    <th class="text-right"><strong>Total</strong></th>
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