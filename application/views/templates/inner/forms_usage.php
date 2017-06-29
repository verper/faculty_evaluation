<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Period of Evaluation <a href="javascript:void(0)" data-toggle="collapse" data-target="#form-sem-container"><i class="glyphicon glyphicon-menu-down pull-right"></i></a></h3>
  </div>
  <form class="form-horizontal collapse in" method="post" id="form-sem-container" action="<?php echo base_url();?>evaluation/sched">
    <div class="panel-body" aria-expanded="true">
        <div class="form-group row">
          <label class="control-label col-sm-2">S.Y.:</label>
          <div class="col-sm-4">
            <select class="form-control" name="sy" onchange="$('#sy2').val( parseInt(this.value) + 1 )">
              <?php
                $date = date('Y') - 4;
                for($i=0; $i<10; $i++){
                  $s = $date == $sched['sy'] ? 'selected' : '';
                  echo '<option value="'.$date.'" '.$s.'>'.$date .'</option>';
                  $date++;
                }
              ?>
            </select>
          </div>
          <div class="col-sm-4"><input id="sy2" class="form-control disabled" disabled value="<?php echo $sched['sy'] + 1;?>"></input></div>
        </div>
        <div class="form-group row">
          <label class="control-label col-sm-2">Semester:</label>
          <div class="col-sm-4">
            <select class="form-control" name="semester">
              <option <?php echo $sched['sem']=="1st"? "selected":'';?>>1st</option>
              <option <?php echo $sched['sem']=="2nd"? "selected":'';?>>2nd</option>
            </select>
          </div>
        </div>
    </div>
    <div class="panel-footer">
      <div class="row">
        <div class="col-xs-12">
          <input class="btn btn-primary pull-right" type="submit" value="Save">
        </div>
      </div>
    </div>
  </form>
</div>

<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Form usage <a href="javascript:void(0)" data-toggle="collapse" data-target="#form-user-container"><i class="glyphicon glyphicon-menu-down pull-right"></i></a></h3>
      </div>
      <form class="form-horizontal collapse in" method="post" action="<?php echo base_url();?>evaluation/form_usage" id="form-user-container" aria-expanded="true">       
        <div class="panel-body">
          <div class="alert alert-dismissible alert-info">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><i class="glyphicon glyphicon-exclamation-sign"></i></strong> Select the form to be used by the evaluator according to its position.
          </div>          
          <?php foreach($roles as $role): ?>
            <?php if ($role->id != 5): ?>            
            <div class="form-group row">
              <label class="control-label col-sm-2"><?php echo strtoupper($role->title);?></label>
              <div class="col-sm-10">
                <select class="form-control" name="form[<?php echo $role->id;?>]" requried/>
                  <option disabled selected value="">- Select form -</option>
                  <?php foreach($forms as $form): ?>
                    <?php $selected = $role_form[$role->id] == $form->id ? 'selected' : '';?>
                    <option value="<?php echo $form->id;?>" <?php echo $selected;?>><?php echo $form->title;?></option>
                  <?php endforeach;?>
                </select>
              </div>
            </div>
            <?php endif;?>            
          <?php endforeach; ?>
        </div>
        <div class="panel-footer">
          <div class="row">
            <div class="col-xs-12">
              <input class="btn btn-primary pull-right" type="submit" value="Save"/>
            </div>
          </div>
        </div>
        <input type="hidden" name="form_id" value="form_usage" required/>
      </form>
    </div>    
  </div>
</div>