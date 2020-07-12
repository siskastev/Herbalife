<div class="right_col" role="main">


  <div class="row">


    <div class=" col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h3>DATA  HASIL HITUNG</h3>

          <div class="clearfix"></div>
        </div>
        <br>

        <?php echo form_open_multipart('Analisis/simpanhasilAnalisis/'.$id);?>
        <div class="table-responsive">
          <table class="table table-striped table-bordered">
            <thead>
              <tr class="bg-group">
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
              <tr>
                 <td><input type="text" name="usia" value="<?php if($coba['usia']['muda'] > $coba['usia']['dewasa'] && $coba['usia']['muda']>$coba['usia']['tua']){
                  echo 'MUDA';
                }elseif($coba['usia']['muda']<$coba['usia']['dewasa'] && $coba['usia']['dewasa']>$coba['usia']['tua']){
                  echo 'DEWASA';
                }elseif($coba['usia']['muda']<$coba['usia']['tua'] && $coba['usia']['dewasa']<$coba['usia']['tua']){
                  echo 'TUA';
                }?>"></td>

                <td><input type="text" name="lemak_tubuh" value="<?php if($coba['lemak_tubuh']['kurang'] > $coba['lemak_tubuh']['tinggi'] && $coba['lemak_tubuh']['kurang']>$coba['lemak_tubuh']['normal']){
                  echo 'KURANG';
                }elseif($coba['lemak_tubuh']['kurang']<$coba['lemak_tubuh']['normal'] && $coba['lemak_tubuh']['tinggi']<$coba['lemak_tubuh']['normal']){
                  echo 'NORMAL';
                }elseif($coba['lemak_tubuh']['kurang']<$coba['lemak_tubuh']['tinggi'] && $coba['lemak_tubuh']['tinggi']>$coba['lemak_tubuh']['normal']){
                  echo 'TINGGI';
                }?>"></td>

                <td><input type="text" name="kadar_air" value="<?php if($coba['kadar_air']['kurang'] > $coba['kadar_air']['tinggi'] && $coba['kadar_air']['kurang']>$coba['kadar_air']['normal']){
                  echo 'KURANG';
                }elseif($coba['kadar_air']['kurang']<$coba['kadar_air']['normal'] && $coba['kadar_air']['tinggi']<$coba['kadar_air']['normal']){
                  echo 'NORMAL';
                }elseif($coba['kadar_air']['kurang']<$coba['kadar_air']['tinggi'] && $coba['kadar_air']['tinggi']>$coba['kadar_air']['normal']){
                  echo 'TINGGI';
                }?>"></td>

                <td><input type="text" name="postur_tubuh" value="<?php if($coba['postur_tubuh']['kurus'] > $coba['postur_tubuh']['gemuk'] && $coba['postur_tubuh']['kurus']>$coba['postur_tubuh']['ideal']){
                  echo 'KURUS';
                }elseif($coba['postur_tubuh']['kurus']<$coba['postur_tubuh']['ideal'] && $coba['postur_tubuh']['gemuk']<$coba['postur_tubuh']['ideal']){
                  echo 'IDEAL';
                }elseif($coba['postur_tubuh']['kurus']<$coba['postur_tubuh']['gemuk'] && $coba['postur_tubuh']['gemuk']>$coba['postur_tubuh']['ideal']){
                  echo 'GEMUK';
                }?>"></td>

                <td><input type="text" name="massa_tulang" value="<?php if($coba['massa_tulang']['kurang'] > $coba['massa_tulang']['tinggi'] && $coba['massa_tulang']['kurang']>$coba['massa_tulang']['normal']){
                  echo 'KURANG';
                }elseif($coba['massa_tulang']['kurang']<$coba['massa_tulang']['normal'] && $coba['massa_tulang']['tinggi']<$coba['massa_tulang']['normal']){
                  echo 'NORMAL';
                }elseif($coba['massa_tulang']['kurang']<$coba['massa_tulang']['tinggi'] && $coba['massa_tulang']['tinggi']>$coba['massa_tulang']['normal']){
                  echo 'TINGGI';
                }?>"></td>

                <td><input type="text" name="lemak_perut" value="<?php if($coba['lemak_perut']['rendah'] > $coba['lemak_perut']['tinggi'] && $coba['lemak_perut']['rendah']>$coba['lemak_perut']['medium']){
                  echo 'RENDAH';
                }elseif($coba['lemak_perut']['rendah']<$coba['lemak_perut']['medium'] && $coba['lemak_perut']['tinggi']<$coba['lemak_perut']['medium']){
                  echo 'MEDIUM';
                }elseif($coba['lemak_perut']['rendah']<$coba['lemak_perut']['tinggi'] && $coba['lemak_perut']['tinggi']>$coba['lemak_perut']['medium']){
                  echo 'TINGGI';
                }?>"></td>
                
                <td>
                  <input type="hidden" name="fk_id_analisis" value="<?php echo $id ?>">
                  <input type="text" name="shake" value="<?php if($shake > 0 && $shake <=35){
                    echo "Tidak Butuh";
                  }elseif($shake > 30 && $shake <=55){
                    echo "Butuh";
                  }elseif($shake >50 && $shake <=100){
                    echo "Sangat Butuh";
                  }?>" readonly></td>

                  <td><input type="text" name="aloe" value="<?php if($aloe > 0 && $aloe <=35){
                    echo "Tidak Butuh";
                  }elseif($aloe > 30 && $aloe <=55){
                    echo "Butuh";
                  }elseif($aloe >50 && $aloe <=100){
                    echo "Sangat Butuh";
                  }?>" readonly></td>

                  <td><input type="text" name="thermo" value="<?php if($thermo > 0 && $thermo <=35){
                    echo "Tidak Butuh";
                  }elseif($thermo > 30 && $thermo <=55){
                    echo "Butuh";
                  }elseif($thermo >50 && $thermo <=100){
                    echo "Sangat Butuh";
                  }?>" readonly></td>

                  <td><input type="text" name="nrg" value="<?php if($nrg > 0 && $nrg <=35){
                    echo "Tidak Butuh";
                  }elseif($nrg > 30 && $nrg <=55){
                    echo "Butuh";
                  }elseif($nrg >50 && $nrg <=100){
                    echo "Sangat Butuh";
                  }?>" readonly></td>

                  <td><input type="text" name="ppp" value="<?php if($ppp > 0 && $ppp <=35){
                    echo "Tidak Butuh";
                  }elseif($ppp > 30 && $ppp <=55){
                    echo "Butuh";
                  }elseif($ppp >50 && $ppp <=100){
                    echo "Sangat Butuh";
                  }?>" readonly></td>

                  <td><input type="text" name="mixed" value="<?php if($mixed > 0 && $mixed <=35){
                    echo "Tidak Butuh";
                  }elseif($mixed > 30 && $mixed <=55){
                    echo "Butuh";
                  }elseif($mixed >50 && $mixed <=100){
                    echo "Sangat Butuh";
                  }?>" readonly></td>

                </tr>
              </tbody>
            </table>
            <br>
            <center>
            <input type="submit" name="submit" value="SIMPAN">
          </center>
            <?php echo form_close(); ?>

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