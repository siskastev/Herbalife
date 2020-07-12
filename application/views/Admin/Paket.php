<div class="right_col" role="main">


  <div class="row">


    <div class=" col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h3>DATA PAKET</h3>

          <div class="clearfix"></div>
        </div>
        <br>

        <a href="<?php echo base_url(). "Paket/addPaket"; ?>"><button class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>TAMBAH</button></a> <br><br>

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

            <table class="table table-striped table-bordered data">
              <thead>
                <tr class="bg-group">
                  <th width="5px">NO</th>
                  <th>Nama Paket</th>
                  <th>Keterangan</th>
                  <th>Manfaat</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                foreach ($paket as $key) 
                {
                   //$harga = number_format($key->harga,0,',','.');

                 ?>
                 <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $key->nama_paket;?></td>
                  <td><?php echo $key->keterangan_paket;?></td>
                  <td><?php echo $key->manfaat_paket;?></td>
                  <td><img src="<?php echo base_url('Upload/'.$key->image) ?>" style="width: 50px;height: 50px;"></td>
                  <td>
                    <a href="<?= base_url() ?>Paket/ubahPaket/<?= $key->id_paket?>" class="btn btn-success"><span class="glyphicon glyphicon-edit"> Edit</span></a></button> &emsp;
                    <a href="<?= base_url() ?>Paket/hapus_paket/<?= $key->id_paket?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"> Delete</span></a></button>
                  </td>
                </tr>
                <?php
                $i++;
              }
              ?>
            </tbody>
          </table>

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