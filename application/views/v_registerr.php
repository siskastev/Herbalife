<div class="right_col" role="main">


  <div class="row">


    <div class=" col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2><span class="fa fa-birthday-cake"></span> Register </h2>
          <div class="clearfix"></div>
        </div>
        <br>
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
          <?php echo form_open_multipart("Login/simpanBiodata"); ?>
          <div class="form-group row">
            <label for="firstname" class="col-sm-3 col-form-label"> Firstname </label>
            <div class="col-sm-8">
              <input type="text" name="firstname" class="form-control" placeholder="Firtname" value="<?php echo set_value('firstname'); ?>" >
              <?php echo  form_error('firstname') ?>
            </div>
          </div>
          
          <div class="form-group row">
            <label for="lastname" class="col-sm-3 col-form-label"> Lastname </label>
            <div class="col-sm-8">
              <input type="text" name="Lastname" class="form-control" placeholder="Lastname" value="<?php echo set_value('lastname'); ?>" >
              <?php echo  form_error('lastname') ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="address" class="col-sm-3 col-form-label">Address</label>
            <div class="col-sm-8">
              <input type="text" name="address" class="form-control" placeholder="address" value="<?php echo set_value('address'); ?>" >
              <?php echo  form_error('address') ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="telp" class="col-sm-3 col-form-label">Telp </label>
            <div class="col-sm-8">
              <textarea name="telp" class="form-control" placeholder="telp"> <?php echo set_value('telp'); ?></textarea>
              <?php echo  form_error('telp') ?>
            </div>
          </div>

          <label for="username" class="col-sm-3 col-form-label"> Username </label>
            <div class="col-sm-8">
              <input type="text" name="username" class="form-control" placeholder="username" value="<?php echo set_value('username'); ?>" >
              <?php echo  form_error('username') ?>
            </div>
          </div>

           <div class="form-group row">
            <label for="password" class="col-sm-3 col-form-label">Password</label>
            <div class="col-sm-8">
              <input type="text" name="password" class="form-control" placeholder="Password" value="<?php echo set_value('password'); ?>" >
              <?php echo  form_error('password') ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="image" class="col-sm-3 col-form-label">Image </label>
            <div class="col-sm-8">
              <input type="file" name="image" class="form-control" placeholder="Gambar">
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