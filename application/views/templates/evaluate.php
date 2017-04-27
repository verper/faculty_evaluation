<?php global $logged_in;  ?>

<h1 class="page-header">Evaluate faculties</h1>

<?php if ( $logged_in->role == '1' ): // STUDENT TYPE ?>
<div class="row">
    <?php if (isset($faculties)): ?>
      <?php foreach( $faculties as $faculty ): 
        if ($this->courses->check_student_course($faculty->id, $logged_in->id)): 
      ?>
        <div class="form-group col-sm-4" style="min-height: 200px;">
          <div class="media">
            <div class="media-left">
              <div class="profile-userpic"><img src="<?php echo base_url();?>media/<?php echo $faculty->photo;?>" class="media-object" alt="<?php echo $faculty->lastname . ', ' . $faculty->firstname . ' '.$faculty->middlename;?>" style="width:80px"></div>
            </div>
            <div class="media-body">
              <h4 class="media-heading text-primary"><?php echo $faculty->lastname . ', ' . $faculty->firstname . ' '.$faculty->middlename;?></h4>
              <?php $subject = $this->courses->student_course($faculty->id, $logged_in->id); ?>
              <h5><strong><?php echo $subject->id;?></strong></h5>
              <p><?php echo $subject->title;?></p>
              <?php if ( $this->evaluation->evaluation_access($logged_in->id, $faculty->id) ): ?>
                <a class="btn btn-primary btn-sm" href="/evaluate/<?php echo $faculty->id;?>"><i class="glyphicon glyphicon-pencil"></i> Evaluate</a>
              <?php else: ?>
                <span class="label label-success"><i class="glyphicon glyphicon-ok"></i> Finished</span>
              <?php endif?>
            </div>
          </div>
        </div>
      <?php endif; endforeach; ?>
    <?php else: ?>
      <div class="alert alert-warning">No faculties found for you to evaluate.</div>
    <?php endif; ?>
</div>
<?php endif; ?>


<?php if ( $logged_in->role == '2' ): // PEER TO PEER TYPE  ?>
<div class="row">
    <?php if (isset($faculties)): ?>
      <?php foreach( $faculties as $faculty ): ?>
        <div class="form-group col-sm-4" style="min-height: 200px;">
          <div class="media">
            <div class="media-left">
              <div class="profile-userpic"><img src="<?php echo base_url();?>media/<?php echo $faculty->target->photo;?>" class="media-object" alt="<?php echo $faculty->target->lastname . ', ' . $faculty->target->firstname . ' '.$faculty->target->middlename;?>" style="width:80px"></div>
            </div>
            <div class="media-body">
              <h4 class="media-heading text-primary"><?php echo $faculty->target->lastname . ', ' . $faculty->target->firstname . ' '.$faculty->target->middlename;?></h4>
              <?php $subject = $this->courses->student_course($faculty->id, $logged_in->id); ?>
              <?php
                $schedule = date('M d, Y', strtotime($faculty->date));
                $today = date('M d, Y');
              ?>
              <p>Schedule: <?php echo $schedule == $today ? 'TODAY' : date('M d, Y', strtotime($faculty->date));?></p>

              <?php if ( $schedule == $today ): ?>
                  <?php if ($this->evaluation->evaluation_access($logged_in->id, $faculty->target->id)): ?>
                      <a class="btn btn-primary btn-sm" href="/evaluate/<?php echo $faculty->target->id;?>"><i class="glyphicon glyphicon-pencil"></i> Evaluate</a>
                  <?php else: ?>
                      <span class="label label-success">Finished</span>
                  <?php endif; ?>
              <?php elseif( $schedule < $today ): ?>
                  <?php if ($this->evaluation->evaluation_access($logged_in->id, $faculty->target->id)): ?>
                      <span class="label label-danger">Expired</span>
                  <?php else: ?>
                      <span class="label label-success">Finished</span>
                  <?php endif; ?>
              <?php elseif ( $schedule > $today ): ?>
                  <?php if ($this->evaluation->evaluation_access($logged_in->id, $faculty->target->id)): ?>
                      <span class="label label-warning">Pending</span>
                  <?php else: ?>
                      <span class="label label-success">Finished</span>
                  <?php endif; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="alert alert-warning">No faculties found for you to evaluate.</div>
    <?php endif; ?>
</div>
<?php endif; ?>


<?php if ( $logged_in->role == '3' ): // PROGRAM HEAD TYPE  ?>
<legend>
  <h3><?php echo $faculties->id;?></h3>
  <h4><?php echo $faculties->title;?></h4>
</legend>
<div class="row">
    <?php if (isset($faculties->courses)): ?>
      <?php foreach( $faculties->courses as $faculty ): ?>
        <div class="form-group col-sm-4" style="min-height: 200px;">
          <div class="media">
            <div class="media-left">
              <div class="profile-userpic"><img src="<?php echo base_url();?>media/<?php echo $faculty->assigned->photo;?>" class="media-object" alt="<?php echo $faculty->assigned->lastname . ', ' . $faculty->assigned->firstname . ' '.$faculty->assigned->middlename;?>" style="width:80px"></div>
            </div>
            <div class="media-body">
              <h4 class="media-heading text-primary"><?php echo $faculty->assigned->lastname . ', ' . $faculty->assigned->firstname . ' '.$faculty->assigned->middlename;?></h4>
              <h5><strong><?php echo $faculty->id;?></strong></h5>
              <p><?php echo $faculty->title;?></p>
              <?php if ( $this->evaluation->evaluation_access($logged_in->id, $faculty->assigned->id) ): ?>
                <a class="btn btn-primary btn-sm" href="/evaluate/<?php echo $faculty->assigned->id;?>"><i class="glyphicon glyphicon-pencil"></i> Evaluate</a>
              <?php else: ?>
                  <span class="label label-success"><i class="glyphicon glyphicon-ok"></i> Finished</span>
              <?php endif?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="alert alert-warning">No faculties found for you to evaluate.</div>
    <?php endif; ?>
</div>
<?php endif; ?>


<?php if ( $logged_in->role == '4' ): // DEAN TYPE  ?>
<legend>
  <h3><?php echo $faculties->id;?></h3>
  <h4><?php echo $faculties->title;?></h4>
</legend>
<div class="row">
    <?php if (isset($faculties->programs)): ?>
      <?php foreach( $faculties->programs as $faculty ): ?>
        <div class="form-group col-sm-4" style="min-height: 200px;">
          <div class="media card">
            <div class="media-left">
              <div class="profile-userpic"><img src="<?php echo base_url();?>media/<?php echo $faculty->supervisor->photo;?>" class="media-object" alt="<?php echo $faculty->supervisor->lastname . ', ' . $faculty->supervisor->firstname . ' '.$faculty->supervisor->middlename;?>" style="width:80px"></div>
            </div>
            <div class="media-body">
              <h4 class="media-heading text-primary"><?php echo $faculty->supervisor->lastname . ', ' . $faculty->supervisor->firstname . ' '.$faculty->supervisor->middlename;?></h4>
              <h5 class="text-primary"><?php echo strtoupper($faculty->supervisor->rolename);?></h5>
              <h5><strong><?php echo isset($faculty->program)?'('.$faculty->program.') ':''; ?><?php echo $faculty->id;?></strong></h5>
              <h6><?php echo $faculty->title;?></h6>
              <?php if ( $this->evaluation->evaluation_access($logged_in->id, $faculty->supervisor->id) ): ?>
                <a class="btn btn-primary btn-sm" href="/evaluate/<?php echo $faculty->supervisor->id;?>"><i class="glyphicon glyphicon-pencil"></i> Evaluate</a>
              <?php else: ?>
                  <span class="label label-success"><i class="glyphicon glyphicon-ok"></i> Finished</span>
              <?php endif?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="alert alert-warning">No faculties found for you to evaluate.</div>
    <?php endif; ?><pre class="hide"><?php var_dump($faculties->programs);?></pre>
</div>
<?php endif; ?>