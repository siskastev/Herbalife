<div class="right_col" role="main">


  <div class="row">


    <div class=" col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h3>DATA  HASIL KONSUMEN DAN REKOMENDASI PEMILIHAN PRODUK</h3>
          <div class="clearfix"></div>

        </div>
        <br>

        <?php if ($this->session->flashdata('success')) {?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php  } elseif($this->session->flashdata('hapus')) {?>
          <!-- validation message to display after form is submitted -->
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('hapus'); ?> 
            </div>
          <?php } elseif($this->session->flashdata('error')) {?>
            <!-- validation message to display after form is submitted -->
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <?php echo $this->session->flashdata('error'); ?> 
              </div>
            <?php } ?>
             <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr class="bg-group" width="5px">
                <h4> Tabel Keterangan </h4>
                 <th><center>Usia</center></th>
                  <th><center>Lemak Tubuh</center></th>
                  <th><center>Kadar Air</center></th>
                  <th><center>Postur Tubuh</center></th>
                  <th><center>Massa Tulang</center></th>
                  <th><center>Lemak Perut</center></th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                foreach ($getData as $key) 
                {
                   //$harga = number_format($key->harga,0,',','.');

                 ?>
                 <tr>
                  <td><p><b>Muda</b> = 18 Tahun - 30 Tahun
                  <br><b>Dewasa</b> = 25 Tahun - 55 Tahun
                  <br><b>Tua</b>    = 50 Tahun - 80 Tahun
                  </p></td>

                  <td><p><b>Kurang</b> = 0% - 22%
                  <br><b>Normal</b> = 21% - 24%
                  <br><b>Tinggi</b>    = 23% - 26%
                  </p></td>

                  <td><p><b>Kurang</b> = 1% - 50%
                  <br><b>Normal</b> = 45% - 60%
                  <br><b>Tinggi</b>    = 55% - 100%
                  </p></td>

                  <td><p><b>Gemuk</b> = 1 - 4
                  <br><b>Ideal</b> = 3 - 7
                  <br><b>Kurus</b>    = 6 - 9
                  </p></td>

                  <td><p><b>Rendah</b> = 0 - 1,95
                  <br><b>Ideal</b> = 1,9 - 2,45
                  <br><b>Tinggi</b>    = 2,4 - 2,95
                  </p></td>

                  <td><p><b>Sehat</b> = 1 - 5
                  <br><b>Medium</b> = 4 - 10
                  <br><b>Tinggi</b>    = 9 - 15
                  </p></td>

                  </td>
                </tr>
                <?php
                $i++;
              }
              ?>
            </tbody>
          </table>
        </div>
            <h4> Tabel Hasil Analisa: </h4>
            <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr class="bg-group" width="5px">
                  <th>Nama</th>
                  <th>Usia</th>
                  <th>Lemak Tubuh</th>
                  <th>Kadar Air</th>
                  <th>Postur Tubuh</th>
                  <th>Massa Tulang</th>
                  <th>Lemak Perut</th>
                  <th>Shake</th>
                  <th>Aloe</th>
                  <th>Thermo</th>
                  <th>Nrg Tea</th>
                  <th>PPP</th>
                  <th>Mixed Fiber</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                foreach ($getData as $key) 
                {
                   //$harga = number_format($key->harga,0,',','.');

                 ?>
                 <tr>
                  <td><?php echo $key->nama; ?></td>
                  <td><?php echo $key->getusia.'<br>'.
                  $key->usia.'<br>';
                  if ($key->usia == "MUDA") {
                    echo "18 - 30";
                  }elseif ($key->usia == "DEWASA") {
                    echo "25 - 55";
                  }elseif ($key->usia == "TUA") {
                    echo "50 - 80";
                  }?></td>

                  <td><?php echo $key->getlemaktubuh.'<br>'.
                  $key->lemak_tubuh.'<br>';
                  if ($key->lemak_tubuh == "KURANG") {
                    echo "1 - 22";
                  }elseif ($key->lemak_tubuh == "NORMAL") {
                    echo "21 - 24";
                  }elseif ($key->lemak_tubuh == "TINGGI") {
                    echo "23 - 26";
                  }?></td>

                  <td><?php echo $key->getkadarair.'<br>'.
                  $key->kadar_air.'<br>';
                  if ($key->kadar_air == "KURANG") {
                    echo "1 - 50";
                  }elseif ($key->kadar_air == "NORMAL") {
                    echo "45 - 60";
                  }elseif ($key->kadar_air == "TINGGI") {
                    echo "55 - 100";
                  }?></td>

                  <td><?php echo $key->getposturtubuh.'<br>'.
                  $key->postur_tubuh.'<br>';
                  if ($key->postur_tubuh == "GEMUK") {
                    echo "1 - 4";
                  }elseif ($key->postur_tubuh == "IDEAL") {
                    echo "3 - 7";
                  }elseif ($key->postur_tubuh == "KURUS") {
                    echo "6 - 9";
                  }?></td>

                  <td><?php echo $key->getmassatulang.'<br>'.
                  $key->massa_tulang.'<br>';
                  if ($key->massa_tulang == "RENDAH") {
                    echo "0 - 1,95";
                  }elseif ($key->massa_tulang == "IDEAL") {
                    echo "1,9 - 2,45";
                  }elseif ($key->massa_tulang == "TINGGI") {
                    echo "2,4 - 2,95";
                  }?></td>

                  <td><?php echo $key->getlemakperut.'<br>'.
                  $key->lemak_perut.'<br>';
                  if ($key->lemak_perut == "SEHAT") {
                    echo "1 - 5";
                  }elseif ($key->lemak_perut == "MEDIUM") {
                    echo "4 - 10";
                  }elseif ($key->lemak_perut == "TINGGI") {
                    echo "9 - 15";
                  }?></td>
                  <td><?php echo $key->shake;?></td>
                  <td><?php echo $key->aloe;?></td>
                  <td><?php echo $key->thermo;?></td>
                  <td><?php echo $key->nrg;?></td>
                  <td><?php echo $key->ppp;?></td>
                  <td><?php echo $key->mixed_fiber;?></td>

                  </td>
                </tr>
                <?php
                $i++;
              }
              ?>
            </tbody>
          </table>
        </div>

          <div class="clearfix"></div>


        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url();?>assets_datatables\DataTables\assets_ajax\js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets_datatables\DataTables\assets_ajax\js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets_datatables\DataTables\assets_ajax\js/jquery.dataTables.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $('.data').DataTable();
  });
</script>