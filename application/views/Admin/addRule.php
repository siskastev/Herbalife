<div class="right_col" role="main">


  <div class="row">


    <div class=" col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2><span class="fa fa-list"></span> Add Rule </h2>
          <div class="clearfix"></div>
        </div>
        <br>
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
          <?php echo form_open_multipart("Rule/simpanRule"); ?>

          <div class="form-group row">
           <label for="usia" class="col-sm-3 col-form-label"> Usia </label>
           <div class="col-sm-8">
            <select name="usia" id="usia" class="form-control">
              <option value="muda">Muda</option>
              <option value="dewasa">Dewasa</option>
              <option value="tua">Tua</option>
            </select>
          </div>
        </div>

        <div class="form-group row">
           <label for="lemak_tubuh" class="col-sm-3 col-form-label"> Lemak Tubuh </label>
           <div class="col-sm-8">
            <select name="lemak_tubuh" id="lemak_tubuh" class="form-control">
              <option value="kurang">Kurang</option>
              <option value="normal">Normal</option>
              <option value="tinggi">Tinggi</option>
            </select>
          </div>
        </div>

        <div class="form-group row">
           <label for="massa_tulang" class="col-sm-3 col-form-label"> Massa Tulang </label>
           <div class="col-sm-8">
            <select name="massa_tulang" id="massa_tulang" class="form-control">
              <option value="kurang">Kurang</option>
              <option value="normal">Normal</option>
              <option value="tinggi">Tinggi</option>
            </select>
          </div>
        </div>

         <div class="form-group row">
           <label for="lemak_perut" class="col-sm-3 col-form-label"> Lemak Perut </label>
           <div class="col-sm-8">
            <select name="lemak_perut" id="lemak_perut" class="form-control">
              <option value="rendah">Rendah</option>
              <option value="medium">Normal</option>
              <option value="tinggi">Tinggi</option>
            </select>
          </div>
        </div>

         <div class="form-group row">
           <label for="shake" class="col-sm-3 col-form-label"> Shake </label>
           <div class="col-sm-8">
            <select name="shake" id="shake" class="form-control">
              <option value="tidak_butuh">Tidak Butuh</option>
              <option value="butuh">Butuh</option>
              <option value="sangat_butuh">Sangat Butuh</option>
            </select>
          </div>
        </div>

        <div class="form-group row">
           <label for="aloe" class="col-sm-3 col-form-label"> Aloe </label>
           <div class="col-sm-8">
            <select name="aloe" id="aloe" class="form-control">
              <option value="tidak_butuh">Tidak Butuh</option>
              <option value="butuh">Butuh</option>
              <option value="sangat_butuh">Sangat Butuh</option>
            </select>
          </div>
        </div>

         <div class="form-group row">
           <label for="thermo" class="col-sm-3 col-form-label"> Thermo </label>
           <div class="col-sm-8">
            <select name="thermo" id="thermo" class="form-control">
              <option value="tidak_butuh">Tidak Butuh</option>
              <option value="butuh">Butuh</option>
              <option value="sangat_butuh">Sangat Butuh</option>
            </select>
          </div>
        </div>

         <div class="form-group row">
           <label for="nrg" class="col-sm-3 col-form-label"> Nrg Tea </label>
           <div class="col-sm-8">
            <select name="nrg" id="nrg" class="form-control">
              <option value="tidak_butuh">Tidak Butuh</option>
              <option value="butuh">Butuh</option>
              <option value="sangat_butuh">Sangat Butuh</option>
            </select>
          </div>
        </div>

         <div class="form-group row">
           <label for="ppp" class="col-sm-3 col-form-label"> PPP </label>
           <div class="col-sm-8">
            <select name="ppp" id="ppp" class="form-control">
              <option value="tidak_butuh">Tidak Butuh</option>
              <option value="butuh">Butuh</option>
              <option value="sangat_butuh">Sangat Butuh</option>
            </select>
          </div>
        </div>

        <div class="form-group row">
           <label for="mixed_fiber" class="col-sm-3 col-form-label"> Mixed Fiber </label>
           <div class="col-sm-8">
            <select name="mixed_fiber" id="mixed_fiber" class="form-control">
              <option value="tidak_butuh">Tidak Butuh</option>
              <option value="butuh">Butuh</option>
              <option value="sangat_butuh">Sangat Butuh</option>
            </select>
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