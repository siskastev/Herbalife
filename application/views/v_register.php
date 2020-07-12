<?php 
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('header.php')
?> 
<div class="right_col" role="main">


  <div class="row">

    <div class=" col-xs-12">
      <div class="x_panel">
 <!--        <div class="x_title">
          <h2><span class="fa fa-birthday-cake"></span> Register </h2>
          <div class="clearfix"></div>
        </div> -->
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
          <?php echo form_open_multipart("Login/simpanBiodata"); ?>
          <div class="form-group row">
            <label for="firstname" class="col-sm-3 col-form-label"> Firstname </label>
            <div class="col-sm-8">
              <input type="text" name="firstname" class="form-control" placeholder="Firtname" required="">
            </div>
          </div>
          
          <div class="form-group row">
            <label for="lastname" class="col-sm-3 col-form-label"> Lastname </label>
            <div class="col-sm-8">
              <input type="text" name="lastname" class="form-control" placeholder="Lastname" required="">
            </div>
          </div>

          <div class="form-group row">
            <label for="address" class="col-sm-3 col-form-label">Address</label>
            <div class="col-sm-8">
               <textarea name="address" class="form-control" placeholder="Address" required=""></textarea>
            </div>
          </div>

           <div class="form-group row">
            <label for="usia" class="col-sm-3 col-form-label">Usia</label>
            <div class="col-sm-8">
               <textarea name="usia" class="form-control" placeholder="usia" required=""></textarea>
            </div>
          </div>

          <div class="form-group row">
            <label for="telp" class="col-sm-3 col-form-label">Telp </label>
            <div class="col-sm-8">
             <input type="text" name="telp" class="form-control" placeholder="Telp" required="">
            </div>
          </div>
          
          <div class="form-group row">
          <label for="username" class="col-sm-3 col-form-label"> Username </label>
            <div class="col-sm-8">
              <input type="text" name="username" class="form-control" placeholder="username" required="">
            </div>
          </div>

           <div class="form-group row">
            <label for="password" class="col-sm-3 col-form-label">Password</label>
            <div class="col-sm-8">
              <input type="text" name="password" class="form-control" placeholder="Password" required="">
            </div>
          </div>

          <div class="form-group row">
            <label for="image" class="col-sm-3 col-form-label">Image </label>
            <div class="col-sm-8">
              <input type="file" name="image" class="form-control" placeholder="Gambar" required="">
            </div>
          </div><br>
          <center><button type="submit" class="btn btn-primary" name="submit"><span class="oi oi-person"></span> TAMBAH </button></center>
        </div>
        <?php echo form_close(); ?>
        <div class="col-sm-1"></div>
        <!-- </form> -->

        <div class="clearfix"></div>


      </div>
    </div>

  </div>
</div>

<!--===============================================================================================-->  
<script src="<?php echo base_url();?>assetsLogin/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="<?php echo base_url();?>assetsLogin/vendor/bootstrap/js/popper.js"></script>
<script src="<?php echo base_url();?>assetsLogin/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="<?php echo base_url();?>assetsLogin/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="<?php echo base_url();?>assetsLogin/vendor/tilt/tilt.jquery.min.js"></script>
<script >
  $('.js-tilt').tilt({
    scale: 1.1
  })
</script>
<!--===============================================================================================-->
<script src="<?php echo base_url();?>assetsLogin/js/main.js"></script>

