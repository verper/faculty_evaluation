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
}
td {
  border: 1px solid #eee;
}
td:last-child {
  text-align: center;
}
</style>
</head>
<body>


<?php 
  $fullname = $logged_in->lastname .', ' . $logged_in->firstname . ' ' . $logged_in->middlename;
?>

<table style="font-family: arial;font-size: 12;">
  <tr>
    <td>Name: <?php echo $fullname; ?></td>
    <td>Department:</td>
  </tr>
  <tr>
    <td>Rank: <?php echo strtoupper($logged_in->rolename);?></td>
    <td>Employment Status:</td>
  </tr>
  <tr>
    <td>Period of Evaluation:</td>
    <td style="font-size: 14"><strong>Gen. Average: <?php echo $this->evaluation->general_average($form->form->id, $logged_in->id);?></strong></td>
  </tr>
</table>


<?php if ($form): ?>
  <h5 style="text-align:center"><?php echo $form->form->title;?></h5>

  <?php if (!empty($form->categories)): ?>
  <?php foreach($form->categories as $cat): ?>
      <table style="font-family: arial;font-size: 11;margin-bottom:20px">
        <tr>       
          <th style="text-align:left;font-size: 13"><strong><?php echo $cat->title;?></strong></th>
          <th style="text-align:center;font-size: 13"><strong><?php echo $this->evaluation->category_total($form->form->id, $cat->id, $logged_in->id);?></strong></th>
        </tr>
        <?php if ($cat->questions): ?>
          <?php foreach($cat->questions as $que) :?>
            <tr>
              <td style="vertical-align:bottom;"><?php echo $que->title;?></td>
              <td width="10%" style="text-align:center">
                <?php echo $this->evaluation->question_total($form->form->id, $que->id, $logged_in->id); ?>
              </td>
            </tr>
          <?php endforeach;?>
        <?php endif;?>
      </table>
  <?php endforeach;?>
  <?php endif; ?>
<?php endif;?>


</body>
</html>