<?php 
session_start();
if(!isset($_SESSION['user']))
{
	header("Location: index.php");
}
?>
    <?php include "includes/header.php"?>
     <?php include "functions.php"?>
    <?php include "includes/Topbar.php"?>
   <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <form class="form-horizontal" role="form" method="post">
        <fieldset>
        
          <!-- Form Name -->
          <legend>Add New Event Address</legend>
          <p id="success1" class="bg-success">
                <?php
                addNewEvent();
                ?>
        </p>
          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="eventname">Event Name</label>
            <div class="col-sm-9">
              <input type="text" name="eventname" class="form-control" required>
            </div>
          </div>
          
          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="date">Date and Time</label>
            <div class="col-sm-9">
              <input type="datetime-local" name="date" class="form-control" required>
            </div>
          </div>
          
          
          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="address">Address</label>
            <div class="col-sm-9">
              <input type="text" name="address" class="form-control" required>
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="locality">Locality</label>
            <div class="col-sm-9">
              <input type="text" name="locality" class="form-control" required>
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="city">City</label>
            <div class="col-sm-9">
              <input type="text" name="city" class="form-control" required>
            </div>
          </div>
         <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="mobileno">Point of Contact</label>
            <div class="col-sm-9">
              <input type="text" name="mobileno" class="form-control">
            </div>
            </div>

          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="pull-right">
                <button type="submit" class="btn btn-primary" name="add">Add</button>
              </div>
            </div>
          </div>

        </fieldset>
      </form>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
  <?php include "includes/footer.php"?>