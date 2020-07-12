<div class="right_col" role="main">


  <div class="row">


    <div class=" col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2><span class="fa fa-list"></span> Add Produk </h2>
          <div class="clearfix"></div>
        </div>
        <br>
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
          <?php echo form_open_multipart("Produk/simpanProduk"); ?>
          <div class="form-group row">
            <label for="nama_produk" class="col-sm-3 col-form-label"> Nama Produk </label>
            <div class="col-sm-8">
              <input type="text" name="nama_produk" class="form-control" placeholder="Nama Produk" value="<?php echo set_value('nama_produk'); ?>" >
              <?php echo  form_error('nama_produk') ?>
            </div>
          </div>
    
          <div class="form-group row">
            <label for="keterangan" class="col-sm-3 col-form-label"> Keterangan </label>
            <div class="col-sm-8">
              <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" value="<?php echo set_value('keterangan'); ?>" >
              <?php echo  form_error('keterangan') ?>
            </div>
          </div>

           <div class="form-group row">
            <label for="usia" class="col-sm-3 col-form-label"> Usia </label>
            <div class="col-sm-8">
              <input type="text" name="usia" class="form-control" placeholder="Usia" value="<?php echo set_value('usia'); ?>" >
              <?php echo  form_error('usia') ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="lemak_tubuh" class="col-sm-3 col-form-label"> lemak_tubuh </label>
            <div class="col-sm-8">
              <input type="text" name="lemak_tubuh" class="form-control" placeholder="lemak_tubuh" value="<?php echo set_value('lemak_tubuh'); ?>" >
              <?php echo  form_error('lemak_tubuh') ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="massa_tulang" class="col-sm-3 col-form-label"> massa_tulang </label>
            <div class="col-sm-8">
              <input type="text" name="massa_tulang" class="form-control" placeholder="massa_tulang" value="<?php echo set_value('massa_tulang'); ?>" >
              <?php echo  form_error('massa_tulang') ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="lemak_perut" class="col-sm-3 col-form-label"> lemak_perut </label>
            <div class="col-sm-8">
              <input type="text" name="lemak_perut" class="form-control" placeholder="lemak_perut" value="<?php echo set_value('lemak_perut'); ?>" >
              <?php echo  form_error('lemak_perut') ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="image" class="col-sm-3 col-form-label"> Image </label>
            <div class="col-sm-8">
              <input type="file" name="image" class="form-control" placeholder="image" value="<?php echo set_value('image'); ?>" >
              <?php echo  form_error('image') ?>
            </div>
          </div>
          <!-- 
            <a href="<?php echo base_url()?>Produk"><button type="button" class="btn btn-danger">TAMBAH</button></a> -->
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