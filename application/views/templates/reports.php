<h1 class="page-header">Reports</h1>

<?php 
  global $logged_in;
?>

<ul class="nav nav-tabs">
  <li class="active"><a href="#student" data-toggle="tab" aria-expanded="true">Student</a></li>
  <li class=""><a href="#peer" data-toggle="tab" aria-expanded="false">Peer</a></li>
  <li class=""><a href="#program-head" data-toggle="tab" aria-expanded="false">Program Head</a></li>
  <li class=""><a href="#dean" data-toggle="tab" aria-expanded="false">Dean</a></li>
</ul>
<div id="myTabContent" class="tab-content">
  <div class="tab-pane fade active in" id="student">
    <br>
    <form action="<?php echo base_url();?>reports/pdf" method="post" style="display:inline-block" target="_blank">
      <input type="hidden" name="form_id" value="pdf_report">
      <input type="hidden" name="form" value="1">
      <div class="form-group">
        <button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-print"></i> Print ratings</button>
      </div>
    </form>
    <form action="" method="post" style="display:inline-block">
      <input type="hidden" name="form_id" value="pdf_comments">
      <input type="hidden" name="form" value="1">
      <div class="form-group">
        <button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-comment"></i> Print comments</button>
      </div>
    </form>

    <?php 
      $form  = $this->forms->get_user_form('1');
    ?>
    <?php if ($form): ?>
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
    <?php endif;?>
  </div>
  <div class="tab-pane fade" id="peer">
    <br>
    <form action="<?php echo base_url();?>reports/pdf" method="post" style="display:inline-block" target="_blank">
      <input type="hidden" name="form_id" value="pdf_report">
      <input type="hidden" name="form" value="2">
      <div class="form-group">
        <button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-print"></i> Print ratings</button>
      </div>
    </form>
    <form action="" method="post" style="display:inline-block">
      <input type="hidden" name="form_id" value="pdf_comments">
      <input type="hidden" name="form" value="2">
      <div class="form-group">
        <button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-comment"></i> Print comments</button>
      </div>
    </form>
    <?php 
      $form  = $this->forms->get_user_form('2');
    ?>
    <?php if ($form): ?>
      <legend><?php echo $form->form->title;?></legend>
      <br/>
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
    <?php endif;?>
  </div>
  <div class="tab-pane fade" id="program-head">
    <br>
    <form action="<?php echo base_url();?>reports/pdf" method="post" style="display:inline-block" target="_blank">
      <input type="hidden" name="form_id" value="pdf_report">
      <input type="hidden" name="form" value="3">
      <div class="form-group">
        <button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-print"></i> Print ratings</button>
      </div>
    </form>
    <form action="" method="post" style="display:inline-block">
      <input type="hidden" name="form_id" value="pdf_comments">
      <input type="hidden" name="form" value="3">
      <div class="form-group">
        <button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-comment"></i> Print comments</button>
      </div>
    </form>
    <?php 
      $form  = $this->forms->get_user_form('3');
    ?>
    <?php if ($form): ?>
      <legend><?php echo $form->form->title;?></legend>
      <br/>
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
    <?php endif;?>
  </div>
  <div class="tab-pane fade" id="dean">
    <br>
    <form action="<?php echo base_url();?>reports/pdf" method="post" style="display:inline-block" target="_blank">
      <input type="hidden" name="form_id" value="pdf_report">
      <input type="hidden" name="form" value="4">
      <div class="form-group">
        <button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-print"></i> Print ratings</button>
      </div>
    </form>
    <form action="" method="post" style="display:inline-block">
      <input type="hidden" name="form_id" value="pdf_comments">
      <input type="hidden" name="form" value="4">
      <div class="form-group">
        <button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-comment"></i> Print comments</button>
      </div>
    </form>
    <?php 
      $form  = $this->forms->get_user_form('4');
    ?>
    <?php if ($form): ?>
      <legend><?php echo $form->form->title;?></legend>
      <br/>
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
    <?php endif;?>
  </div>
</div>