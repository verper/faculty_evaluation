<!--<h1 class="page-header">Profile</h1>-->
<?php global $logged_in; ?>

<legend>Profile</legend>
<form class="form-horizontal" method="post" action="<?php echo base_url();?>profile/update" enctype="multipart/form-data">
  <div class="form-group row">
    <label class="control-label col-sm-2"></label>
    <div class="col-sm-10">
      <div class="profile-userpic">
        <?php clearstatcache(); ?>
        <?php $image = !file_exists('media/'.$logged_in->photo) ? 'default.png' : $logged_in->photo;?>
        <img src="<?php echo base_url();?>media/<?php echo $image;?>" id="current_image" class="img-responsive lazy-img" date-src="" alt="" style="width:150px;height:150px;">
      </div>
    </div>
  </div>

  <div class="form-group row">
    <label class="control-label col-sm-2">Photo</label>
    <div class="col-sm-10">
      <input class="form-control" type="file" id="image" name="photo"/>
      <span class="help-block"><small>Maximum of 150KB image size.</small></span>
    </div>
  </div>

  <div class="form-group row">
    <label class="control-label col-sm-2">User ID (School ID)</label>
    <div class="col-sm-10">
      <input class="form-control" type="text" name="userid" placeholder="User ID (School ID)" value="<?php echo $logged_in->id;?>" required/>
    </div>
  </div>

  <div class="form-group row">
    <label class="control-label col-sm-2">Last name</label>
    <div class="col-sm-10">
      <input class="form-control" type="text" name="lastname" placeholder="Last name" value="<?php echo $logged_in->lastname;?>" required/>
    </div>
  </div>

  <div class="form-group row">
    <label class="control-label col-sm-2">First name</label>
    <div class="col-sm-10">
      <input class="form-control" type="text" name="firstname" placeholder="First name" value="<?php echo $logged_in->firstname;?>" required/>
    </div>
  </div>

  <div class="form-group row">
    <label class="control-label col-sm-2">Middle name</label>
    <div class="col-sm-10">
      <input class="form-control" type="text" name="middlename" placeholder="Middle name" value="<?php echo $logged_in->middlename;?>" >
    </div>
  </div>

  <div class="form-group row">
    <label class="control-label col-sm-2">&nbsp;</label>
    <div class="col-sm-10">
      <input class="btn btn-primary" type="submit" value="Save profile"/>
      <input type="hidden" name="form_id" value="update_profile" />
    </div>
  </div>
</form>
<br/>
<br/>
<form class="form-horizontal" method="post" action="<?php echo base_url();?>profile/change_password">
  <legend>Change password</legend>
  <div class="form-group row">
    <label class="control-label col-sm-2">Current Password</label>
    <div class="col-sm-10">
      <input class="form-control" type="password" name="current" placeholder="********" required/>
    </div>
  </div>

  <div class="form-group row">
    <label class="control-label col-sm-2">New Password</label>
    <div class="col-sm-10">
      <input class="form-control" type="password" name="new" placeholder="********" required/>
    </div>
  </div>

  <div class="form-group row">
    <label class="control-label col-sm-2">Confirm New Password</label>
    <div class="col-sm-10">
      <input class="form-control" type="password" name="confirm" placeholder="********" required/>
    </div>
  </div>

  <div class="form-group row">
    <label class="control-label col-sm-2"></label>
    <div class="col-sm-10">
      <input class="btn btn-primary" type="submit" value="Change password"/>
      <input type="hidden" name="form_id" value="change_password">
    </div>
  </div>
</form>


<script type="text/javascript">
(function($){
  $(document).on("change", "#image", function(event) {
    var current = $(this).val();
    var ext = $(this).val().split('.').pop().toLowerCase();
    
    if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
      $(this).val('');
        alert('Invalid image format!');
    }
    else if (this.files && this.files[0]){
      var reader = new FileReader();

      reader.onload = function (e){
        $('#current_image').attr('src', e.target.result);
      }

      reader.readAsDataURL(this.files[0]);
    }
  });
})(jQuery);
</script>