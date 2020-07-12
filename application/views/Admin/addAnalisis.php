<div class="right_col" role="main">


  <div class="row">


    <div class=" col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2><span class="fa fa-list"></span> Add Analisis </h2>
          <div class="clearfix"></div>
        </div>
        <br>
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
          <?php echo form_open_multipart("Analisis/simpanAnalisis"); ?>

          <div class="form-group row">
            <label for="nama" class="col-sm-3 col-form-label"> Nama </label>
            <div class="col-sm-8">
              <input type="text" name="nama" class="form-control" placeholder="nama" value="<?php echo set_value('nama'); ?>" >
              <?php echo  form_error('nama') ?>
            </div>
          </div>
         
          <div class="form-group row">
            <label for="usia" class="col-sm-3 col-form-label"> Usia </label>
            <div class="col-sm-8">
              <input type="text" name="usia" class="form-control" placeholder="usia" value="<?php echo set_value('usia'); ?>" >
              <?php echo  form_error('usia') ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="tinggi" class="col-sm-3 col-form-label"> Tinggi Badan </label>
            <div class="col-sm-8">
              <input type="text" name="tinggi" class="form-control" placeholder="tinggi" value="<?php echo set_value('tingii'); ?>" >
              <?php echo  form_error('tinggi') ?>
            </div>
          </div>
    
          <div class="form-group row">
            <label for="berat_badan" class="col-sm-3 col-form-label"> Berat Badan </label>
            <div class="col-sm-8">
              <input type="text" name="berat_badan" class="form-control" placeholder="berat_badan" value="<?php echo set_value('berat_badan'); ?>" >
              <?php echo  form_error('berat_badan') ?>
            </div>
          </div>

           <div class="form-group row">
            <label for="lemak_tubuh" class="col-sm-3 col-form-label"> Lemak Tubuh</label>
            <div class="col-sm-8">
              <input type="text" name="lemak_tubuh" class="form-control" placeholder="lemak_tubuh" value="<?php echo set_value('lemak_tubuh'); ?>" >
              <?php echo  form_error('lemak_tubuh') ?>
            </div>
          </div>

           <div class="form-group row">
            <label for="kadar_air" class="col-sm-3 col-form-label">Kadar Air </label>
            <div class="col-sm-8">
              <input type="text" name="kadar_air" class="form-control" placeholder="kadar_air" value="<?php echo set_value('kadar_air'); ?>" >
              <?php echo  form_error('kadar_air') ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="massa_otot" class="col-sm-3 col-form-label">Massa Otot </label>
            <div class="col-sm-8">
              <input type="text" name="massa_otot" class="form-control" placeholder="Massa otot" value="<?php echo set_value('massa_otot'); ?>" >
              <?php echo  form_error('massa_otot') ?>
            </div>
          </div>

           <div class="form-group row">
            <label for="postur_tubuh" class="col-sm-3 col-form-label">Postur Tubuh </label>
            <div class="col-sm-8">
              <input type="text" name="postur_tubuh" class="form-control" placeholder="postur_tubuh" value="<?php echo set_value('postur_tubuh'); ?>" >
              <?php echo  form_error('postur_tubuh') ?>
            </div>
          </div>

           <div class="form-group row">
            <label for="bmr_kalori" class="col-sm-3 col-form-label">BMR Kalori </label>
            <div class="col-sm-8">
              <input type="text" name="bmr_kalori" class="form-control" placeholder="bmr_kalori" value="<?php echo set_value('bmr_kalori'); ?>" >
              <?php echo  form_error('bmr_kalori') ?>
            </div>
          </div>

           <div class="form-group row">
            <label for="usia_sel" class="col-sm-3 col-form-label">Usia Sel </label>
            <div class="col-sm-8">
              <input type="text" name="usia_sel" class="form-control" placeholder="usia_sel" value="<?php echo set_value('usia_sel'); ?>" >
              <?php echo  form_error('usia_sel') ?>
            </div>
          </div>

           <div class="form-group row">
            <label for="massa_tulang" class="col-sm-3 col-form-label">Massa Tulang </label>
            <div class="col-sm-8">
              <input type="text" name="massa_tulang" class="form-control" placeholder="Massa Tulang" value="<?php echo set_value('massa_tulang'); ?>" >
              <?php echo  form_error('massa_tulang') ?>
            </div>
          </div>

           <div class="form-group row">
            <label for="lemak_perut" class="col-sm-3 col-form-label">Lemak Perut </label>
            <div class="col-sm-8">
              <input type="text" name="lemak_perut" class="form-control" placeholder="lemak_perutL" value="<?php echo set_value('lemak_perut'); ?>" >
              <?php echo  form_error('lemak_perut') ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="tanggal" class="col-sm-3 col-form-label">Tanggal </label>
            <div class="col-sm-8">
              <input type="date" name="tanggal" class="form-control" placeholder="lemak_perutL" value="<?php echo set_value('tanggal'); ?>" >
              <?php echo  form_error('tanggal') ?>
            </div>
          </div>

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