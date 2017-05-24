<?php $user = $this->session->userdata('logged_in'); ?>

<!-- SIDEBAR USERPIC -->
<div class="profile-userpic">
	<img src="<?php echo base_url();?>media/<?php echo $user->photo;?>" class="img-responsive" alt="">
</div>
<!-- END SIDEBAR USERPIC -->
<!-- SIDEBAR USER TITLE -->
<div class="profile-usertitle">
	<div class="profile-usertitle-name">
		<?php echo $user->firstname . ' ' . $user->middlename . ' ' . $user->lastname; ?>
	</div>
	<div class="profile-usertitle-job">
		<?php echo $user->rolename;?>
	</div>
	<h6 class="text-primary">
		<?php echo $user->id;?>
	</h6>
</div>
<!-- END SIDEBAR USER TITLE -->
<!-- SIDEBAR BUTTONS -->
<div class="profile-userbuttons">
	<a class="btn btn-danger btn-xs" href="<?php echo base_url();?>profile">Profile</a>
</div>
<!-- END SIDEBAR BUTTONS -->
<!-- SIDEBAR MENU -->
<?php
	$dashboard = false;
	$evaluate = false;
	$colleges = false;
	$programs = false;
	$courses = false;
	$users = false;
	$forms = false;
	$evaluation = false;
	$reports = false;

	$role = $user->role;
	// 1 = student
	// 2 = faculty
	// 3 = program head
	// 4 = dean
	// 5 = admin or HRDO
	switch($role) {
		case 1: 
			$evaluate = true;
			break;
		case 2:
			$evaluate = true;
			$reports = true;
			break;
		case 3:
			$evaluate = true;
			break;
		case 4:
			$evaluate = true;
			// $colleges = true;
			// $programs = true;
			// $courses = true;
			$evaluation = true;
			$reports = true;
			break;
		case 5:
			$colleges = true;
			$programs = true;
			$courses = true;
			$users = true;
			$forms = true;
			$evaluation = true;
			$reports = true;
			break;
	}
?>
<div class="profile-usermenu">
<ul class="nav">
	<?php if ($dashboard): ?>
	<li class="<?php echo $this->uri->segment(1) == 'dashboard' ?'active':'';?>"><a href="<?php echo base_url();?>dashboard"><i class="glyphicon glyphicon-dashboard"></i> Dashboard</a></li>
	<?php endif; ?>
	<?php if ($evaluate): ?>
	<li class="<?php echo $this->uri->segment(1) == 'evaluate' ?'active':'';?>"><a href="<?php echo base_url();?>evaluate"><i class="glyphicon glyphicon-user"></i> Evaluate</a></li>
	<?php endif; ?>
	<?php if ($colleges||$programs||$courses): ?>
	<li class="<?php //echo in_array($this->uri->segment(1), array('colleges','programs','courses')) ?'active':'';?>"><a class="" href="javascript:void(0);" data-toggle="collapse" data-target="#school-menu" aria-expanded="false" aria-controls="navbar"><i class="glyphicon glyphicon-tower"></i> School <i class="glyphicon glyphicon-chevron-down pull-right" style="margin-top:3px"></i></a>
		<div class="collapse <?php echo in_array($this->uri->segment(1), array('colleges','programs','courses')) ?'in':'';?>" id="school-menu">
			<ul class="nav nav-pills nav-stacked">
				<?php if ($colleges): ?>
				<li class="<?php echo $this->uri->segment(1) == 'colleges' ?'active':'';?>"><a href="<?php echo base_url();?>colleges" style="padding-left:35px"><i class="glyphicon glyphicon-arrow-right"></i> Colleges</a></li>
				<?php endif; ?>
				<?php if ($programs): ?>
				<li class="<?php echo $this->uri->segment(1) == 'programs' ?'active':'';?>"><a href="<?php echo base_url();?>programs" style="padding-left:35px"><i class="glyphicon glyphicon-arrow-right"></i> Programs</a></li>
				<?php endif; ?>
				<?php if ($courses): ?>
				<li class="<?php echo $this->uri->segment(1) == 'courses' ?'active':'';?>"><a href="<?php echo base_url();?>courses" style="padding-left:35px"><i class="glyphicon glyphicon-arrow-right"></i> Courses</a></li>
				<?php endif; ?>
			</ul>	
		</div> 
	</li>
	<?php endif; ?>
	<?php if ($users): ?>
	<li class="<?php echo $this->uri->segment(1) == 'users' ?'active':'';?>"><a href="<?php echo base_url();?>users"><i class="glyphicon glyphicon-user"></i> Users</a></li>
	<?php endif; ?>
	<?php if ($forms): ?>
	<li class="<?php echo $this->uri->segment(1) == 'forms' ?'active':'';?>"><a href="<?php echo base_url();?>forms"><i class="glyphicon glyphicon-file"></i> Forms</a></li>
	<?php endif;?>
	<?php if ($evaluation): ?>
	<li class="<?php echo $this->uri->segment(1) == 'evaluation' ?'active':'';?>"><a href="<?php echo base_url();?>evaluation"><i class="glyphicon glyphicon-stats"></i> Evaluation</a></li>
	<?php endif; ?>
	<?php if ($reports): ?>
	<li class="<?php echo $this->uri->segment(1) == 'reports' ?'active':'';?>"><a href="<?php echo base_url();?>reports"><i class="glyphicon glyphicon-blackboard"></i> Reports</a></li>
	<?php endif; ?>
</ul>
</div>
<!-- END MENU -->