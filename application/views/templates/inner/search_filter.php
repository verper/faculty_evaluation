<div class="form-group row">
  <div class="col-sm-6 col-md-5">
    <div class="form-group">
      <form method="get" action="">
        <div class="input-group">          
          <span class="input-group-addon input-sm"><i class="glyphicon glyphicon-search"></i></span>
          <input type="text" class="form-control input-sm" name="q" placeholder="Search" value="<?php echo isset($_GET['q']) ? $_GET['q']: '' ;?>">
          <span class="input-group-btn">
            <button class="btn btn-primary btn-sm input-sm" type="submit" role="button">Search</button>
          </span>         
        </div>
      </form>
    </div>
  </div>
</div>