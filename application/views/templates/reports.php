<h1 class="page-header">Reports</h1>

<?php 
  global $logged_in;
?>


<?php
 if ( $logged_in->role == '3' ) {
    $fid = isset($_GET['form']) ? $_GET['form'] : '2';
    $fid = !in_array($fid, array('2','4')) ? '' : $fid;
    $form  = $this->forms->get_user_form($fid);
 }
 elseif( $logged_in->role == '2' ) {
    $fid = isset($_GET['form']) ? $_GET['form'] : '1';
    $fid = !in_array($fid, array('1','2','3','4')) ? '' : $fid;
    $form  = $this->forms->get_user_form($fid);
 }
?>

<ul class="nav nav-tabs">
<?php if ($logged_in->role == '3'): ?>
  <li class="<?php echo $fid == 2 ? 'active' : '';?>"><a href="reports?form=2">Peer</a></li>
  <li class="<?php echo $fid == 4 ? 'active' : '';?>"><a href="reports?form=4">Dean</a></li>
  <?php elseif ($logged_in->role == '2'): ?>
  <li class="<?php echo $fid == 1 ? 'active' : '';?>"><a href="reports?form=1">Student</a></li>
  <li class="<?php echo $fid == 2 ? 'active' : '';?>"><a href="reports?form=2">Peer</a></li>
  <li class="<?php echo $fid == 3 ? 'active' : '';?>"><a href="reports?form=3">Program Head</a></li>
  <li class="<?php echo $fid == 4 ? 'active' : '';?>"><a href="reports?form=4">Dean</a></li>
  <?php endif;?>
</ul>
<br>

<?php if ($form): ?>
  <form action="<?php echo base_url();?>reports/pdf" method="post" style="display:inline-block" target="_blank">
    <div class="form-group">
      <a class="btn btn-primary btn-sm" href="reports/pdf/<?php echo $logged_in->id;?>/<?php echo $fid;?>" target="_blank"><i class="glyphicon glyphicon-print"></i> Print ratings</a>
    </div>
  </form>
  <form action="" method="post" style="display:none">
    <input type="hidden" name="form_id" value="pdf_comments">
    <input type="hidden" name="form" value="1">
    <div class="form-group">
      <button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-comment"></i> Print comments</button>
    </div>
  </form>

  <legend><?php echo $form->form->title;?></legend>
  <br/><br/>
  <?php if (!empty($form->categories)): ?>
  <?php foreach($form->categories as $cat): ?>
    <h5><strong><?php echo $cat->title;?></strong></h5>
    <div class="table-responsive">
      <table class="table table-hover table-striped table-bordered" style="margin-bottom: 60px">
        <?php if ($cat->questions): ?>
          <?php foreach($cat->questions as $que) :?>
            <tr>
              <td style="vertical-align:bottom;"><?php echo $que->title;?></td>
              <td width="10%" class="text-center">
                <?php echo $this->evaluation->question_total($form->form->id, $que->id, $logged_in->id); ?>
              </td>
            </tr>
          <?php endforeach;?>
          <tr>
            <td class="text-right"><strong>Total</strong></td>
            <td class="text-center"><strong><?php echo $this->evaluation->category_total($form->form->id, $cat->id, $logged_in->id);?></strong></td>
          </tr>
        <?php endif;?>
      </table>
    </div>
  <?php endforeach;?>

  <table class="table table-hover table-striped table-bordered" style="margin-bottom: 60px">
    <tr>
      <td><strong>General Average</strong></td>
      <td width="10%" class="text-center"><strong><?php echo $this->evaluation->general_average($form->form->id, $logged_in->id);?></strong></td>
    </tr>
  </table>

  <legend>Comments</legend>
    <div class="form-group">
      <?php if ( $this->evaluation->get_comments($logged_in->id) ): ?>
        <table class="table table-hover table-striped table-bordered">
        <?php foreach($this->evaluation->get_comments($logged_in->id) as $comment): ?>
          <tr><td><?php echo $comment->comments; ?></td></tr>
        <?php endforeach;?>
        </table>
      <?php else: ?>
        No comments.
      <?php endif; ?>
    </div>
  <?php endif; ?>

<?php else: ?>
  <div class="alert alert-danger">Please select from the tabs.</div>
<?php endif;?>

