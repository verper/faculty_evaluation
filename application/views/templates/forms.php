<h1 class="page-header">Forms <a class="btn btn-primary pull-right" href="#addNewModal" data-toggle="modal">Add</a></h1>

<div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="form" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">New Form</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label class="control-label">Title</label>
              <input class="form-control" name="title" placeholder="Form title" required/>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <input class="btn btn-primary" type="submit" value="Add" />
          <input type="hidden" value="new_form" name="form_id" />
        </div>
      </form>
    </div>
  </div>
</div>

<div class="table-responsivee">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Title</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($forms as $form): ?>
        <tr>
          <td style="vertical-align: middle;"><?php echo $form->title;?></td>
          <td style="vertical-align: middle;"><a class="btn btn-info btn-xs" href="<?php echo base_url();?>forms/<?php echo $form->id;?>">Edit</a> <a class="btn btn-danger btn-xs">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>