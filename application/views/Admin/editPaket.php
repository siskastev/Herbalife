<div class="right_col" role="main">


  <div class="row">
    <div class=" col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h3>Edit Paket</h3>


          <div class="clearfix"></div>
        </div>
        <br>
        <?php foreach($paket as $key) {?>
          <?=form_open_multipart('Paket/proses_ubah/'.$key->id_paket)?>


          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> Nama Paket </label>
            <div class="col-sm-8">
              <input type="hidden" name="nama_paket" value="<?php echo $key->nama_paket ?>">
              <input type="text" name="nama_paket" class="form-control" placeholder="Nama Paket"  value="<?php echo $key->nama_paket ?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> Keterangan Paket </label>
            <div class="col-sm-8">
              <input type="hidden" name="keterangan_paket" value="<?php echo $key->keterangan_paket ?>">
              <input type="text" name="keterangan_paket" class="form-control" placeholder="keterangan_paket"  value="<?php echo $key->keterangan_paket ?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> Manfaat Paket </label>
            <div class="col-sm-8">
              <input type="hidden" name="manfaat_paket" value="<?php echo $key->manfaat_paket ?>">
              <input type="text" name="manfaat_paket" class="form-control" placeholder="manfaatn_paket"  value="<?php echo $key->manfaat_paket ?>" >
            </div>
          </div>

           <div class="form-group row">
            <label for="image" class="col-sm-3 col-form-label"> Image </label>
            <div class="col-sm-8">
              <input type="file" name="image" class="form-control" placeholder="image" value="<?php echo set_value('image'); ?>" >
              <?php echo  form_error('image') ?>
            </div>
          </div>

          <div class="page-header">
            <input type="submit" class="btn btn-success" value="EDIT">&nbsp;&nbsp;

            <a href="<?php echo base_url()?>Paket/DataPaket"><button type="button" class="btn btn-danger">KEMBALI</button></a>
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
