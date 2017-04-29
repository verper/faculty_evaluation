<div class="form-group"><div id="form-message"></div></div>

<div id="form-container">
<h4 class="page-header">
  <form method="post" action="forms/edit_form" id="edit-form">
    <div class="form-group">
      <label class="control-label">Form title</label>
      <div class="input-group">
        <input class="form-control" name="title" value="<?php echo $data->title;?>" placeholder="Form title" required/>
        <span class="input-group-btn">
          <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Save</button>
        </span>
      </div>
    </div>
    <input type="hidden" name="form_id" value="edit_form" />
    <input type="hidden" name="data_id" value="<?php echo $data->id;?>" />
  </form>
</h4>

<div id="form-content" class="nav form-group">
  <?php $count = 0; ?>
  <?php foreach($categories as $cat): ?>
    <!--<form method="post" action="" id="form-cat-<?php echo $cat->id;?>">-->
      <div class="form-group box-shadow" id="category-container-<?php echo $cat->id;?>">
        <form method="post" action="<?php echo base_url();?>forms/update_questions" class="category-form">
          <div class="input-group">
            <span class="input-group-btn">
              <a class="btn btn-default input-sm btn-sm" href="#cat-<?php echo $cat->id;?>" data-toggle="collapse" aria-expanded="false" aria-controls="navbar"><i class="glyphicon glyphicon-menu-down"></i></a>
            </span>
            <input type="text" class="form-control input-sm" name="category" value="<?php echo $cat->title;?>" placeholder="Category title" />
            <span class="input-group-btn">
              <button type="submit" class="btn btn-success input-sm btn-sm" title="Save category"><i class="glyphicon glyphicon-ok"></i></button>
            </span>
            <span class="input-group-btn">
              <a class="btn btn-danger input-sm btn-sm" title="Remove category" data-toggle="modal" href="#modal-<?php echo $cat->id;?>"><i class="glyphicon glyphicon-remove"></i></a>
            </span>
            <div class="modal fade" id="modal-<?php echo $cat->id;?>" tabindex="" role="dialog" aria-labelledby="modal-<?php echo $cat->id;?>Label">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to remove category: <strong><?php echo $cat->title;?>?</strong><br/>
                    NOTE: You cannot undo removal after you choose "Yes".
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary delete-confirm" data-category="<?php echo $cat->id;?>">Yes</a>                
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="collapse category-title" id="cat-<?php echo $cat->id;?>">
            <div class="panel panel-default">
              <div class="panel-body">
                <blockquote class=""><small><i class="glyphicon glyphicon-exclamation-sign"></i> Leave the box empty to remove question. Empty boxes will be considered as null and will not be added to the form.</small></blockquote>
                <?php foreach( $cat->questions as $que ): ?>
                    <div class="form-group row">
                      <div class="col-xs-12">
                        <textarea class="form-control input-sm" name="que[<?php echo $que->id;?>]" placeholder="Type question here..."><?php echo $que->title;?></textarea>
                      </div>
                    </div>
                <?php endforeach;?>
              </div>
              <div class="panel-footer">
                <a class="btn btn-xs btn-primary new-question" data-category="<?php echo $cat->id;?>"><i class="glyphicon glyphicon-plus"></i> Add question</a>
                <button type="submit" class="btn btn-xs btn-success save-category" data-category="<?php echo $cat->id;?>"><i class="glyphicon glyphicon-ok"></i> Save </button>
              </div>
            </div>
          </div>
          <input type="hidden" name="form_id" value="update_questions" />
          <input type="hidden" name="data_id" value="<?php echo $data->id;?>" />
          <input type="hidden" name="cat_id" value="<?php echo $cat->id;?>" />
          <input type="hidden" name="remove_que" value="" />
        </form>

        <form method="post" action="<?php echo base_url();?>forms/delete_category" id="delete-category-<?php echo $cat->id;?>">
          <input type="hidden" name="form_id" value="delete_category"/>
          <input type="hidden" name="data_id" value="<?php echo $data->id;?>"/>
          <input type="hidden" name="category_id" value="<?php echo $cat->id;?>"/>
        </form>
      </div>
    <!--</form>-->
  <?php endforeach; ?>
</div>

<div class="form-group">
  <form id="new-category" action="<?php echo base_url();?>forms/add_category/" method="post">
    <div class="input-group">
      <input type="text" class="form-control input-sm" name="category" placeholder="Type here for new category" id="new-category-content" required/>
      <span class="input-group-btn">
        <button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-plus"></i> Add category</button>
      </span>
    </div>
    <input type="hidden" name="data_id" value="<?php echo $data->id;?>" />
    <input type="hidden" name="form_id" value="new_category" />
  </form>
</div>

<br/>
</div><!-- #form-container -->


<script type="text/javascript">
(function($){
  $(document).ready(function(e){
    $('.new-question').click(function(e){ e.preventDefault();
      $cat = $(this).data('category');
      $('#cat-' + $cat + ' .panel-body').append('<div class="form-group"><textarea class="form-control input-sm" name="que[new][]" placeholder="Type question here..."></textarea></div>');
    });

    $('.delete-confirm').click(function(e){
      $cat = $(this).data('category');
      $('form#delete-category-' + $cat).submit();
      e.preventDefault();
    });

    $('#status-cb').change(function(){
      $('#edit-form').submit();
    });

    $('.remove-question').click(function(e){
      e.preventDefault();
      console.log(1);
      $container = $(this).parents('.form-control');
      $container.remove();
    });

    //$document
  });
})(jQuery);
</script>