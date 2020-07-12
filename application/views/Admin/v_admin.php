<!DOCTYPE html>
<html>
<head>
	<title>Membuat login dengan codeigniter | www.malasngoding.com</title>
</head>
<body>
	<h1>Login berhasil !</h1>
	<h2>Hai, <?php echo $this->session->userdata("nama"); ?></h2>
	<a href="<?php echo base_url('login/logout'); ?>">Logout</a>
</body>
</html>

 <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo base_url()?>Gejala" class="site_title"><i class="fa fa-heart"></i> <span>SISTEM PAKAR</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <br>
                <img src="<?php echo base_url('Gambar/admin.png') ?>" class="img-circle" width="80" height="80">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $this->session->userdata("nama");?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
                  <li><a href="<?php echo base_url();?>Users"><i class="fa fa-user"></i> User</a>
                  <li><a><i class="fa fa-list-alt"></i> Produk <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url();?>Produk/DataProduk">Data Produk</a></li>
                      <li><a href="<?php echo base_url();?>Produk/Paket">Paket Produk</a></li>
                    </ul>
                  </li>
                  <li><a href="<?php echo base_url();?>Penyakit/DataPenyakit"><i class="fa fa-desktop"></i> Data Penyakit </a>
                  </li>
                </ul>
              </div>

            </div>
          </div>
        </div>