<div class="right_col" role="main">


  <div class="row">
    <div class=" col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h3>Edit Produk</h3>


          <div class="clearfix"></div>
        </div>
        <br>
        <?php foreach($produk as $key) {?>
          <?=form_open_multipart('Produk/proses_ubah/'.$key->id_produk)?>


          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> Nama Produk </label>
            <div class="col-sm-8">
              <input type="hidden" name="id_produk" value="<?php echo $key->id_produk ?>">
              <input type="text" name="nama_produk" class="form-control" placeholder="Nama Produk"  value="<?php echo $key->nama_produk ?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> Keterangan </label>
            <div class="col-sm-8">
              <input type="hidden" name="keterangan" value="<?php echo $key->keterangan ?>">
              <input type="text" name="keterangan" class="form-control" placeholder="Keterangan"  value="<?php echo $key->keterangan ?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> usia </label>
            <div class="col-sm-8">
              <input type="hidden" name="usia" value="<?php echo $key->usia ?>">
              <input type="text" name="usia" class="form-control" placeholder="usia"  value="<?php echo $key->usia ?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> lemak_tubuh </label>
            <div class="col-sm-8">
              <input type="hidden" name="lemak_tubuh" value="<?php echo $key->lemak_tubuh ?>">
              <input type="text" name="lemak_tubuh" class="form-control" placeholder="lemak_tubuh"  value="<?php echo $key->lemak_tubuh ?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> massa_tulang </label>
            <div class="col-sm-8">
              <input type="hidden" name="massa_tulang" value="<?php echo $key->massa_tulang ?>">
              <input type="text" name="massa_tulang" class="form-control" placeholder="massa_tulang"  value="<?php echo $key->massa_tulang ?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> lemak_perut </label>
            <div class="col-sm-8">
              <input type="hidden" name="lemak_perut" value="<?php echo $key->lemak_perut ?>">
              <input type="text" name="lemak_perut" class="form-control" placeholder="lemak_perut"  value="<?php echo $key->lemak_perut ?>" >
            </div>
          </div>

          <div class="form-group row">
            <label for="image" class="col-sm-3 col-form-label"> Image </label>
            <div class="col-sm-8">
              <img src="<?php echo base_url('Upload/'.$key->image) ?>" style="width: 50px;height: 50px;">
              <input type="file" name="image" class="form-control" placeholder="image" value="<?php echo set_value('image'); ?>" >
              <br>
              <?php echo  form_error('image') ?>
            </div>
          </div>

          <div class="page-header">
            <input type="submit" class="btn btn-success" value="EDIT">&nbsp;&nbsp;

            <a href="<?php echo base_url()?>Produk"><button type="button" class="btn btn-danger">KEMBALI</button></a>
          </div>

          <?php echo form_close(); ?>

          <?php
        }
        ?>
        <div class="clearfix"></div>


      </div>
    </div>

  </div>
</div>

</div>
