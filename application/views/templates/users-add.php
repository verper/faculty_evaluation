<div class="form-group row">
  <a class="btn btn-link btn-sm" href="<?php echo base_url();?>users"><< Back</a>
</div>

<?php
  $userid     = isset($user) ? $user->id : '';
  $lastname   = isset($user) ? $user->lastname : '';
  $firstname  = isset($user) ? $user->firstname : '';
  $middlename = isset($user) ? $user->middlename : '';
  $roleid       = isset($user) ? $user->role : '';
  $form_id    = isset($user) ? 'edit_user' : 'new_user';

  global $logged_in;
?>

<h1 class="page-header"><?php echo isset($user)? 'Edit ' . $lastname . ', ' . $firstname . ' ' . $middlename : 'New User'; ?></h1>

<div class="container-fluid">
  <form class="form" method="post" action="">
    <div class="form-group">
      <label class="control-label">User ID</label>
      <input class="form-control nospace" type="text" name="userid" placeholder="User ID" value="<?php echo $userid;?>" required/>
    </div>

    <div class="form-group">
      <label class="control-label">Last name</label>
      <input class="form-control text-uppercase" type="text" name="lastname" placeholder="Last name" value="<?php echo $lastname;?>" required/>
    </div>

    <div class="form-group">
      <label class="control-label">First name</label>
      <input class="form-control text-uppercase" type="text" name="firstname" placeholder="First name" value="<?php echo $firstname;?>" />
    </div>

    <div class="form-group">
      <label class="control-label">Middle name</label>
      <input class="form-control text-uppercase" type="text" name="middlename" placeholder="Middle name" value="<?php echo $middlename;?>" />
    </div>

    <?php if ( $logged_in->role != '2' ) :?>
    <div class="form-group">
      <label class="control-label">Role</label>
      <select class="form-control" name="role" required>
        <?php foreach($roles as $role): ?>
          <?php $selected = ($roleid == $role->id) ? 'selected' : ''; ?>
          <option value="<?php echo $role->id;?>" <?php echo $selected;?>><?php echo strtoupper($role->title);?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <?php endif; ?>

    <div class="form-group">
      <input class="btn btn-primary" type="submit" value="Save" />
      <input type="hidden" name="form_id" value="<?php echo $form_id;?>" />
      <input type="hidden" name="user_id" value="<?php echo $userid;?>" />
    </div>
  </form>
  <hr>
  <?php if (isset($user)): ?>
    <legend>Reset password</legend>
    <p><i class="glyphicon glyphicon-exclamation-sign"></i> After reseting this user's password his password will be the same as his user id.</p>
    <form method="post" action="<?php echo base_url();?>users/reset_password">
      <button class="btn btn-primary btn-sm" role="button" type="submit">Resset password</button>
      <input type="hidden" name="form_id" value="reset_password"/>
      <input type="hidden" name="user_id" value="<?php echo $userid;?>"/>
    </form>
  <?php endif;?>
</div>