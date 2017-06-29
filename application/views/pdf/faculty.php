<html>
<head>
  <title> <?php echo $title; ?> </title>

<style type="text/css">
@page {
  margin: 0.5in;
}
table {
  width: 100%;
  margin-bottom: 0;
  font-family: arial;
  font-size: 12px;
}
.text-center { text-align: center; }
.text-left { text-align: left; }
.text-right { text-align: right; }
.text-uppercase { text-transform: uppercase; }
.v-top { vertical-align: top; }

#rating-scale {
  border: 1px solid;
  margin: 0 10px;
  padding: 5px;
}
</style>
</head>
<body>

<?php $this->load->view('templates/pdf_header'); ?>
<table>
  <tr><td class="text-center"><strong><?php echo strtoupper($heading);?> EVALUATION RESULTS</strong></td></tr>
</table>
<br>
<?php 
  $fullname = $logged_in->lastname .', ' . $logged_in->firstname . ' ' . $logged_in->middlename;
?>

<table style="font-family: arial;font-size: 12;">
  <tr>
    <td width="50%"><strong>Name:</strong> <?php echo $fullname; ?></td>
    <td width="50%"><strong>Department:</strong></td>
  </tr>
  <tr>
    <td width="50%"><strong>Rank:</strong> <?php echo strtoupper($logged_in->rolename);?></td>
    <td width="50%"><strong>Employment Status:</strong></td>
  </tr>
  <tr>
    <td width="50%"><strong>Period of Evaluation:</strong> <?php echo $period['sy'];?>-<?php echo $period['sy']+1;?></td>
    <td width="50%"></td>
  </tr>
</table>
<br>

<table>
  <tr><td><strong>Number of <?php echo $heading;?>'s Respondents:</strong> <?php echo $respondents;?></td></tr>
  <tr><td><strong>Subjects Represented:</strong> <?php echo $courses;?></td></tr>
</table>
<br>

<?php if ($form): ?>
  <?php if (!empty($form->categories)): ?>
    <table>
      <tr>
        <td width="50%" class="v-top">
          <strong>RESULTS</strong>
          <table>
            <tr> <th>Sub-areas</th> <th class="text-right">Rating</th> </tr>
            <?php foreach($form->categories as $cat): ?>           
                  <tr>       
                    <td><?php echo $cat->title;?></td>
                    <td class="text-right"><?php echo $this->evaluation->category_total($form->form->id, $cat->id, $logged_in->id);?></td>
                  </tr>
            <?php endforeach;?>
            <tr>
              <td class="text-center"><strong>Overall Rating</strong></td>
              <td class="text-right"><strong><?php echo $this->evaluation->general_average($form->form->id, $logged_in->id);?></strong></td>
            </tr>
          </table>
        </td>
        <td width="50%" class="v-top">
          <table id="rating-scale">
            <tr><td class="text-center" colspan="2"><strong>RATING SCALE</strong></td></tr>
            <tr>
              <td class="text-center"><strong>Numerical Rating</strong></td>
              <td><strong>Integration</strong></td>
            </tr>
            <tr><td class="text-center">4.20 - 5.00</td> <td>Excellent</td></tr>
            <tr><td class="text-center">3.40 - 4.19</td> <td>Very Satisfactory</td></tr>
            <tr><td class="text-center">2.60 - 3.39</td> <td>Satisfactory</td></tr>
            <tr><td class="text-center">1.80 - 2.59</td> <td>Fair</td></tr>
            <tr><td class="text-center">1.00 - 1.79</td> <td>Needs Improvement</td></tr>
          </table>
        </td>
      </tr>
    </table>
  <?php endif; ?>
<?php endif;?>
<br>

<table>
  <tr><td><strong><?php echo strtoupper($heading);?>S' COMMENTS</strong></td></tr>
  <?php if ($comments): ?>
    <?php foreach( $comments as $c ): ?>
      <tr><td><?php echo $c->comments;?></td></tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr><td>No comments.</td></tr>
  <?php endif; ?>
</table>

</body>
</html>