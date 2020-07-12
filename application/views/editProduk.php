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
            <label class="col-sm-3 col-form-label"> Kode Produk </label>
            <div class="col-sm-8">
              <input type="hidden" name="kode_produk" value="<?php echo $key->kode_produk ?>">
              <input type="text" name="kode_produk" class="form-control" placeholder="Kode Produk"  value="<?php echo $key->kode_produk ?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> Keterangan </label>
            <div class="col-sm-8">
              <input type="hidden" name="keterangan" value="<?php echo $key->keterangan ?>">
              <input type="text" name="keterangan" class="form-control" placeholder="Keterangan"  value="<?php echo $key->keterangan ?>" >
            </div>
          </div>

          <div class="page-header">
            <input type="submit" class="btn btn-success" value="EDIT">&nbsp;&nbsp;

            <a href="<?php echo base_url()?>Gejala/DataGejala"><button type="button" class="btn btn-danger">KEMBALI</button></a>
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
