<div class="right_col" role="main">


  <div class="row">


    <div class=" col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h3>DATA COACH</h3>

          <div class="clearfix"></div>
        </div>
        <br>

        <table class="table table-striped table-bordered data">
          <thead>
            <tr class="bg-group">
              <th width="5px">NO</th>
              <th>Firstname</th>
              <th>Lastname</th>
              <th>Address</th>
              <th>Usia</th>
              <th>No.Telepon </th>
              <th>Image </th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $i=1;
            foreach ($users as $key) 
            {


             ?>
             <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $key->firstname;?></td>
              <td><?php echo $key->lastname;?></td>
              <td><?php echo $key->address;?></td>
              <td><?php echo $key->usia;?></td>
              <td><?php echo $key->telp;?></td>
              <td>
            <image src="<?php echo base_url('Upload/'.$key->image) ?>" alt="" height="100" width="100">
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