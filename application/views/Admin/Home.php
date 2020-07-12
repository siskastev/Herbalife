<div class="right_col" role="main">


  <div class="row">


    <div class=" col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h3>Herbalife</h3>

          <div class="clearfix"></div>
        </div>
        <div class="row">
       <?php foreach($cake as $p){ ?>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="kotak" style="width: 100%">
            <a href="#"></a>
            <a href="#"><img class="img-thumbnail" src="<?php echo base_url() . 'Upload/'.$p->gambar ?>"/></a>
            <div class="card-body">
              <center>
                <h3 class="card-title">
                  <a href="#"><?php echo $p->nama; ?></a>
                </h3>
              </center>
            </div>
          </div>
        </div>
        <?php } ?>
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