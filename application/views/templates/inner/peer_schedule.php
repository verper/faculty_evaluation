<script type="text/javascript" src="/assets/js/jquery-datepicker.js" charset="UTF-8"></script>

<div class="row">
  <div class="col-sm-12">
    <legend>Peer to Peer Schedule <a class="btn btn-primary btn-sm pull-right" href="#new-schedule-container" data-toggle="collapse">Add</a></legend>
    <div class="row collapse" id="new-schedule-container">
      <div class="col-xs-12">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">Schedule a Peer to Peer evaluation</h3>
          </div>
          <form method="post" action="<?php echo base_url();?>evaluation/peer_schedule">
            <div class="panel-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Date of Evaluation</label>
                    <div id="sched-dp" class="box-shadow"></div>
                    <input type="hidden" id="sched-dp-value" name="schedule">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Faculty that will evaluate</label>
                    <select name="evaluator" class="form-control" required/>
                      <option selected disabled value="">-Select faculty-</option>
                      <?php foreach($faculties as $faculty): ?>
                        <option value="<?php echo $faculty->id;?>"><?php echo $faculty->lastname . ', ' . $faculty->firstname . ' ' . $faculty->middlename?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Faculty to be evaluated</label>
                    <select name="subject" class="form-control" required/>
                      <option selected disabled value="">-Select faculty-</option>
                      <?php foreach($faculties as $faculty): ?>
                        <option value="<?php echo $faculty->id;?>"><?php echo $faculty->lastname . ', ' . $faculty->firstname . ' ' . $faculty->middlename?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="panel-footer">
              <div class="row">
                <div class="col-xs-12">
                  <input class="btn btn-primary pull-right" type="submit" value="Post Schedule"/>
                </div>
              </div>
            </div>
            <input type="hidden" name="form_id" value="peer_schedule"/>
          </form>
        </div>   
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-stiped table-hovered table-condensed agenda">
        <thead>
          <th>Date</th>
          <th>Evaluator</th>
          <th>Subject</th>
          <th class="text-center">Status</th>
          <th>Action</th>
        </thead>
        <tbody>
          <?php if ( !empty($schedules) ): ?>
          <?php $count = 1; ?>
            <?php foreach($schedules as $sched):?>
              <tr>
                <td class="agenda-date"><div class="dayofmonth"><?php echo date('d', strtotime($sched->date));?></div>
                    <div class="dayofweek"><?php echo date('l', strtotime($sched->date));?></div>
                    <div class="shortdate text-muted"><?php echo date('F, Y', strtotime($sched->date));?></div>
                </td>
                <td><?php echo $sched->source->lastname .', ' . $sched->source->firstname . ' ' . $sched->source->middlename;?></td>
                <td><?php echo $sched->target->lastname .', ' . $sched->source->firstname . ' ' . $sched->source->middlename;?></td>
                <td class="text-center">
                    <?php
                      $schedule = date('M d, Y', strtotime($sched->date));
                      $today = date('M d, Y');
                      global $logged_in;
                    ?>
                    <?php if ( $schedule == $today ): ?>
                        <?php if ($this->evaluation->evaluation_access($logged_in->id, $sched->target->id)): ?>
                            <span class="label label-info center-block">TODAY</span>
                        <?php else: ?>
                            <span class="label label-success center-block">Finished</span>
                        <?php endif; ?>
                    <?php elseif( $schedule < $today ): ?>
                        <?php if ($this->evaluation->evaluation_access($logged_in->id, $sched->target->id)): ?>
                            <span class="label label-danger center-block">Expired</span>
                        <?php else: ?>
                            <span class="label label-success center-block">Finished</span>
                        <?php endif; ?>
                    <?php elseif ( $schedule > $today ): ?>
                        <?php if ($this->evaluation->evaluation_access($logged_in->id, $sched->target->id)): ?>
                            <span class="label label-warning center-block">Pending</span>
                        <?php else: ?>
                            <span class="label label-success center-block">Finished</span>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
                <td><?php $modal_id = uniqid();?>
                  <a class="btn btn-primary btn-xs" title="Edit" data-toggle="modal" href="#change-modal-<?php echo $count;?>"><i class="glyphicon glyphicon-pencil"></i></a>
                  <div class="modal fade" tabindex="-1" role="dialog" id="change-modal-<?php echo $count;?>">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title">Change schedule</h4>
                        </div>
                        <form action="<?php echo base_url();?>evaluation/update_schedule" method="post">
                          <div class="modal-body">
                            <div class="form-group">
                              <label class="control-label">Date</label>
                              <div class="change-sched box-shadow" id="change-sched-picker-<?php echo $count;?>" data-target="sched-val-<?php echo $count;?>" data-initial="<?php echo date('m/d/Y', strtotime($sched->date));?>"></div>
                              <input class="change-sched-input" data-picker="change-sched-picker-<?php echo $count;?>" type="hidden" name="schedule" id="sched-val-<?php echo $count;?>" value=""/>
                            </div>

                            <div class="form-group">
                              <label class="control-label">Evaluator</label>
                              <select class="form-control" name="evaluator" required>
                                <option selected disabled value="">-Select faculty-</option>
                                <?php foreach($faculties as $faculty): ?>
                                  <?php $selected = $faculty->id == $sched->source->id ? 'selected':'';?>
                                  <option value="<?php echo $faculty->id;?>" <?php echo $selected;?>><?php echo $faculty->lastname . ', ' . $faculty->firstname . ' ' . $faculty->middlename?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>

                            <div class="form-group">
                              <label class="control-label">Subject</label>
                              <select class="form-control" name="subject" required>
                                <option selected disabled value="">-Select faculty-</option>
                                <?php foreach($faculties as $faculty): ?>
                                  <?php $selected = $faculty->id == $sched->target->id ? 'selected':'';?>
                                  <option value="<?php echo $faculty->id;?>" <?php echo $selected;?>><?php echo $faculty->lastname . ', ' . $faculty->firstname . ' ' . $faculty->middlename?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input class="btn btn-primary" type="submit" value="Submit changes" />
                          </div>
                          <input type="hidden" name="form_id" value="update_schedule" />
                          <input type="hidden" name="sched_id" value="<?php echo $sched->id;?>" />
                        </form>
                      </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                  </div><!-- /.modal -->
                </td>
              </tr>
            <?php $count++;?>
            <?php endforeach?>
          <?php else: ?>
          <tr>
            <td cols="4">No schedules found.</td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>   
  </div>
</div>

<script type="text/javascript">
(function($){
    $('#sched-dp').datepicker({
        inline: true,
        altField: '#sched-dp-value',
        changeYear: true,
        changeMonth: true
    });

    $('#sched-dp-value').change(function(){
        $('#sched-dp').datepicker('setDate', $(this).val());
    });

    if ( $('.change-sched').length > 0 ) {
      $('.change-sched').each(function(){
        $(this).datepicker({
            inline: true,
            altField: '#' + $(this).data('target'),
            changeYear: true,
            changeMonth: true
        });
      });
    }

    if ( $('.change-sched-input').length > 0 ) {
      $('.change-sched-input').each(function(){
            $picker = $('#' + $(this).data('picker'));
            $picker.datepicker('setDate', $picker.data('initial'));       

            $(this).change(function(){
              $('#' + $(this).data('picker')).datepicker('setDate', $(this).val());       
            });
      });
    }
})(jQuery);
</script>