<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Login </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Place favicon.ico in the root directory -->
        <link rel="icon" href="<?php echo base_url();?>/assets/assetshome/img/core-img/icon3.png">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/vendor.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/app.css">
        <link rel="stylesheet" href="<?php echo base_url();?>aset/css/style.css">
        <!-- Theme initialization -->
        <script>
            var themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
            {};
            var themeName = themeSettings.themeName || '';
            if (themeName)
            {
                document.write('<link rel="stylesheet" id="theme-style" href="<?php echo base_url();?>assets/css/login/app-' + themeName + '.css">');
            }
            else
            {
                document.write('<link rel="stylesheet" id="theme-style" href="<?php echo base_url();?>assets/css/login/app.css">');
            }
        </script>
    </head>
    <body style="background-image:url(<?= base_url('aset/img/bg6.jpg') ?>)">
        <div class="auth">
            
        
        <!-- <div class="img" style="background-image: url('assets/bg.jpg')"> -->
            <div class="auth-container">
                <div class="card">
                    <header class="auth-header">
                            <h3>Silahkan Masuk</h3>
                    </header>
                    <div class="auth-content">
                        <!-- <p class="text-center">Masuk</p> -->
                        <?php echo form_open('Login/aksi_login'); ?>
                            <div class="form-group">
                                <p align="center"><label for="username">Username</label></p>
                                <input type="text" class="form-control underlined" name="username" id="username" placeholder="Username" required> </div>
                            <div class="form-group">
                                <p align="center"><label for="password">Password</label></p>
                                <input type="password" class="form-control underlined" name="password" id="password" placeholder="Password" required> </div>
                            <!-- <div class="form-group">
                                <label for="remember">
                                    <input class="checkbox" id="remember" type="checkbox">
                                    <span>Remember me</span>
                                </label>
                                <a href="reset.html" class="forgot-btn pull-right">Forgot password?</a>
                            </div> -->
                            <font color="Green"><?php echo validation_errors()?></font>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary">Masuk</button>
                            </div><!-- 
                             <div class="form-group">
                                <a href="<?=site_url ()?>welcome" class="btn btn-block btn-danger">Kembali
                                </a>
                            </div> -->


                            <?php echo form_close(); ?>
                             <div class="form-group">
                                <!-- <p class="text-muted text-center">Do not have an account?
                                    <a href="<?php echo base_url('Login/register') ?>">Sign Up!
                                    </a>
                                    </p> -->
                            </div> 
                        </form>
                    </div>
                </div>
                <!-- <div class="text-center">
                    <a href="index.html" class="btn btn-secondary btn-sm">
                        <i class="fa fa-arrow-left"></i> Back to dashboard </a>
                </div> -->
            </div>
        </div>
        </div>
        <!-- Reference block for JS -->
        <div class="ref" id="ref">
            <div class="color-primary"></div>
            <div class="chart">
                <div class="color-primary"></div>
                <div class="color-secondary"></div>
            </div>
        </div>
        <script>
            (function(i, s, o, g, r, a, m)
            {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function()
                {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
            ga('create', 'UA-80463319-4', 'auto');
            ga('send', 'pageview');
        </script>
        <script src="<?php echo base_url()?>assets/js/vendor.js"></script>
        <script src="a<?php echo base_url()?>assets/js/app.js"></script>
    </body>
</html>
