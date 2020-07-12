<div class="right_col" role="main">


  <div class="row">


    <div class=" col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h3>DATA PRODUK</h3>

          <div class="clearfix"></div>
        </div>
        <br>

        <a href="<?php echo base_url(). "Produk/addProduk"; ?>"><button class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>TAMBAH</button></a> <br><br>

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
                  <th>Nama Produk</th>
                  <th>Image</th>
                  <th>Keterangan</th> 
                  <th>Usia</th>
                  <th>Lemak Tubuh</th>
                  <th>Massa Tulang</th>
                  <th>Lemak Perut</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;
                foreach ($produkherbal as $key) 
                {
                   //$harga = number_format($key->harga,0,',','.');

                 ?>
                 <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $key->nama_produk;?></td>
                  <td><img src="<?php echo base_url('Upload/'.$key->image) ?>" style="width: 100px;height: 100px;"></td>
                  <td><?php echo $key->keterangan;?></td>
                  <td><?php echo $key->usia;?></td>
                  <td><?php echo $key->lemak_tubuh;?></td>
                  <td><?php echo $key->massa_tulang;?></td>
                  <td><?php
                   echo $key->lemak_perut;?></td>
                   <td>
                    <a href="<?= base_url() ?>Produk/ubahProduk/<?= $key->id_produk?>" class="btn btn-success"><span class="glyphicon glyphicon-edit"> Edit</span></a></button> &emsp;
                    <a href="<?= base_url() ?>Produk/hapus_produk/<?= $key->id_produk?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"> Delete</span></a></button>
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