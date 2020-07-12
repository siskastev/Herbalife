<div class="right_col" role="main">


  <div class="row">


    <div class=" col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h3>DATA  ANALISIS</h3>
         
          <div class="clearfix"></div>
        </div>
        <br>

        <a href="<?php echo base_url(). "Analisis/addAnalisis"; ?>"><button class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>TAMBAH</button></a> <br><br>

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
            <table class="table table-striped table-bordered data">
              <thead>
                <tr>
                  <th width="5px">ID Analisis</th>
                  <th>Nama</th>
                  <th>Usia</th>
                  <th>Tinggi Badan</th> 
                  <th>Berat Badan</th>
                  <th>Lemak Tubuh</th>
                  <th>Kadar Air</th>
                  <th>Massa otot</th>
                  <th>Postur Tubuh</th>
                  <th>BMR Kalori</th>
                  <th>Usia Sel</th>
                  <th>Massa Tulang</th>
                  <th>Lemak Perut</th>
                  <th>Tanggal</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                foreach ($analisis as $key) { ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $key->nama;?></td>
                  <td><?php echo $key->usia;?></td>
                  <td><?php echo $key->tinggi;?></td>
                  <td><?php echo $key->berat_badan;?></td>
                  <td><?php echo $key->lemak_tubuh;?></td>
                  <td><?php echo $key->kadar_air;?></td>
                  <td><?php echo $key->massa_otot;?></td>
                  <td><?php echo $key->postur_tubuh;?></td>
                  <td><?php echo $key->bmr_kalori;?></td>
                  <td><?php echo $key->usia_sel;?></td>
                  <td><?php echo $key->massa_tulang;?></td>
                  <td><?php echo $key->lemak_perut;?></td>
                  <td><?php echo date('d / M / y');?></td>
                  <td>

                    <a href="<?= base_url() ?>Analisis/ubahAnalisis/<?= $key->id_analisis?>" class="btn btn-success"><span class="glyphicon glyphicon-edit"> Edit</span></a></button> &emsp;
                    <a href="<?= base_url() ?>Analisis/hasil_analisis/<?= $key->id_analisis?>" class="btn btn-success"><span class="glyphicon glyphicon-save"> Hasil Analisis</span></a></button>
                    <a href="<?= base_url() ?>Analisis/hapus_Analisis/<?= $key->id_analisis?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"> Delete</span></a></button>
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