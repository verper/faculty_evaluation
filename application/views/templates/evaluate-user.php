<div class="page-header">
	<div class="row">
		<div class="col-sm-6">
			<h4>User ID: <?php echo $title;?></h4>
 			<h4>Faculty: <?php echo $faculty->lastname . ', ' . $faculty->firstname . ' ' . $faculty->middlename;?></h4>
		</div>
		<div class="col-sm-6">
			<h4>S.Y. <?php echo $period['sy'];?>-<?php echo $period['sy']+1;?></h4>
			<h4>Semester: <?php echo $period['sem'];?></h4>
		</div>
	</div>
</div>

<legend><?php echo $form->form->title;?></legend>
<br/>
<form method="post" action="<?php echo base_url();?>evaluate/process_evaluation">
<?php if (!empty($form->categories)): ?>
<?php foreach($form->categories as $cat): ?>
	<h5><strong><?php echo $cat->title;?></strong></h5>
	<div class="table-responsive">
		<table class="table table-hover table-striped table-bordered" style="margin-bottom: 60px">
			<?php if ($cat->questions): foreach($cat->questions as $que) :?>
				<tr>
					<td style="vertical-align:bottom;"><?php echo $que->title;?></td>
					<td width="25%">
						<select name="ans[<?php echo $que->id;?>]" class="form-control input-sm" max="5" min="1" required>
							<option disabled value="" selected>- Click to rate -</option>
							<option value="5">5- Very good/ Highly Satisfactory</option>
							<option value="4">4- Good/Moderately Satisfactory</option>
							<option value="3">3- Average/Fair/Needs Improvement</option>
							<option value="2">2- Poor/Unsatisfactory</option>
							<option value="1">1- Very Poor/ Highly Unsatisfactory</option>
						</select>
					</td>
				</tr>
			<?php endforeach; endif;?>
		</table>
	</div>
<?php endforeach;?>

<h5>Comments <small>(optional)</small></h5>
	<div class="form-group">
		<textarea class="form-control" name="comments" placeholder="Comments..."></textarea>
	</div>
	<div class="form-group text-center">
		<input class="btn btn-primary" type="submit" value="Submit evaluation" />
		<input type="hidden" name="form_id" value="process_evaluation"/>
		<input type="hidden" name="form_used" value="<?php echo $form->form->id;?>"/>
		<input type="hidden" name="faculty" value="<?php echo $faculty->id;?>"/>
	</div>
<?php endif; ?>
</form>