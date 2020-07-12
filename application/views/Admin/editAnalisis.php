<div class="right_col" role="main">


  <div class="row">
    <div class=" col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h3>Edit Analisis Konsumen</h3>


          <div class="clearfix"></div>
        </div>
        <br>
        <?php foreach($analisis as $key) {?>
          <?=form_open_multipart('Analisis/proses_ubah/'.$key->id_analisis)?>


          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> ID </label>
            <div class="col-sm-8">
              <input type="hidden" name="id_analisis" value="<?php echo $key->id_analisis ?>">
              <input type="text" name="id_analisis" class="form-control" placeholder="id_analisis"  value="<?php echo $key->id_analisis ?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> Nama </label>
            <div class="col-sm-8">
              <input type="hidden" name="nama" value="<?php echo $key->nama ?>">
              <input type="text" name="nama" class="form-control" placeholder="nama"  value="<?php echo $key->nama ?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> Usia </label>
            <div class="col-sm-8">
              <input type="hidden" name="usia" value="<?php echo $key->usia ?>">
              <input type="text" name="usia" class="form-control" placeholder="usia"  value="<?php echo $key->usia ?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> Tinggi Badan </label>
            <div class="col-sm-8">
              <input type="hidden" name="tinggi" value="<?php echo $key->tinggi ?>">
              <input type="text" name="tinggi" class="form-control" placeholder="tinggi"  value="<?php echo $key->tinggi ?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> Berat Badan </label>
            <div class="col-sm-8">
              <input type="hidden" name="berat_badan" value="<?php echo $key->berat_badan ?>">
              <input type="text" name="berat_badan" class="form-control" placeholder="berat_badan"  value="<?php echo $key->berat_badan ?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> Lemak Tubuh </label>
            <div class="col-sm-8">
              <input type="hidden" name="lemak_tubuh" value="<?php echo $key->lemak_tubuh ?>">
              <input type="text" name="lemak_tubuh" class="form-control" placeholder="lemak_tubuh"  value="<?php echo $key->lemak_tubuh ?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> Kadar Air </label>
            <div class="col-sm-8">
              <input type="hidden" name="kadar_air" value="<?php echo $key->kadar_air ?>">
              <input type="text" name="kadar_air" class="form-control" placeholder="kadar_air"  value="<?php echo $key->kadar_air ?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> Massa Otot </label>
            <div class="col-sm-8">
              <input type="hidden" name="massa_otot" value="<?php echo $key->massa_otot ?>">
              <input type="text" name="massa_otot" class="form-control" placeholder="massa_otot"  value="<?php echo $key->massa_otot ?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> Postur Tubuh </label>
            <div class="col-sm-8">
              <input type="hidden" name="postur_tubuh" value="<?php echo $key->postur_tubuh ?>">
              <input type="text" name="postur_tubuh" class="form-control" placeholder="postur_tubuh"  value="<?php echo $key->postur_tubuh ?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> BMR Kalori </label>
            <div class="col-sm-8">
              <input type="hidden" name="bmr_kalori" value="<?php echo $key->bmr_kalori ?>">
              <input type="text" name="bmr_kalori" class="form-control" placeholder="bmr_kalori"  value="<?php echo $key->bmr_kalori ?>" >
            </div>
          </div>

            <div class="form-group row">
            <label class="col-sm-3 col-form-label"> Usia Sel </label>
            <div class="col-sm-8">
              <input type="hidden" name="usia_sel" value="<?php echo $key->usia_sel ?>">
              <input type="text" name="usia_sel" class="form-control" placeholder="usia_sel"  value="<?php echo $key->usia_sel ?>" >
            </div>
          </div>


          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> Massa Tulang </label>
            <div class="col-sm-8">
              <input type="hidden" name="massa_tulang" value="<?php echo $key->massa_tulang ?>">
              <input type="text" name="massa_tulang" class="form-control" placeholder="massa_tulang"  value="<?php echo $key->massa_tulang ?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> Lemak Perut </label>
            <div class="col-sm-8">
              <input type="hidden" name="lemak_perut" value="<?php echo $key->lemak_perut ?>">
              <input type="text" name="lemak_perut" class="form-control" placeholder="lemak perut"  value="<?php echo $key->lemak_perut ?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label"> Tanggal </label>
            <div class="col-sm-8">
              <input type="hidden" name="tanggal" value="<?php echo $key->tanggal ?>">
              <input type="date" name="tanggal" class="form-control" placeholder="Tanggal"  value="<?php echo $key->tanggal ?>" >
            </div>
          </div>

          <div class="page-header">
            <input type="submit" class="btn btn-success" value="EDIT">&nbsp;&nbsp;

            <a href="<?php echo base_url()?>Analisis"><button type="button" class="btn btn-danger">KEMBALI</button></a>
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
