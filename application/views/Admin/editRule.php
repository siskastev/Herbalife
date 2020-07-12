<div class="right_col" role="main">


  <div class="row">
    <div class=" col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h3>Edit Rule</h3>


          <div class="clearfix"></div>
        </div>
        <br>
        <?php foreach($rule as $key) {?>
        <?=form_open_multipart('Rule/proses_ubah/'.$key->id_rule)?>

<div class="form-group row">
         <label for="usia" class="col-sm-3 col-form-label"> Usia </label>
         <div class="col-sm-8">
          <select name="usia" id="usia" class="form-control" required="">
            <option value="">Pilih</option>
            <option value="muda"<?php if ($key->usia == "muda"){echo 'selected';
          }?>>Muda</option>
          <option value="dewasa"<?php if ($key->usia == "dewasa"){echo 'selected';
        }?>>Dewasa</option>
        <option value="tua"<?php if ($key->usia == "tua"){echo 'selected';
      }?>>Tua</option>
    </select>
  </div>
</div>

<div class="form-group row">
         <label for="lemak_tubuh" class="col-sm-3 col-form-label"> Lemak Tubuh </label>
         <div class="col-sm-8">
          <select name="lemak_tubuh" id="lemak_tubuh" class="form-control" required="">
            <option value="">Pilih</option>
            <option value="kurang"<?php if ($key->lemak_tubuh == "kurang"){echo 'selected';
          }?>>Kurang</option>
          <option value="normal"<?php if ($key->lemak_tubuh == "normal"){echo 'selected';
        }?>>Normal</option>
        <option value="tinggi"<?php if ($key->lemak_tubuh == "tinggi"){echo 'selected';
      }?>>Tinggi</option>
    </select>
  </div>
</div>

<div class="form-group row">
         <label for="massa_tulang" class="col-sm-3 col-form-label"> Massa Tulang </label>
         <div class="col-sm-8">
          <select name="massa_tulang" id="massa_tulang" class="form-control" required="">
            <option value="">Pilih</option>
            <option value="kurang"<?php if ($key->massa_tulang == "kurang"){echo 'selected';
          }?>>Kurang</option>
          <option value="normal"<?php if ($key->massa_tulang == "normal"){echo 'selected';
        }?>>Normal</option>
        <option value="tinggi"<?php if ($key->massa_tulang == "tinggi"){echo 'selected';
      }?>>Tinggi</option>
    </select>
  </div>
</div>

<div class="form-group row">
         <label for="lemak_perut" class="col-sm-3 col-form-label"> Lemak Perut </label>
         <div class="col-sm-8">
          <select name="lemak_perut" id="lemak_perut" class="form-control" required="">
            <option value="">Pilih</option>
            <option value="rendah"<?php if ($key->lemak_perut == "rendah"){echo 'selected';
          }?>>Rendah</option>
          <option value="normal"<?php if ($key->lemak_perut == "normal"){echo 'selected';
        }?>>Normal</option>
        <option value="tinggi"<?php if ($key->lemak_perut == "tinggi"){echo 'selected';
      }?>>Tinggi</option>
    </select>
  </div>
</div>

<div class="form-group row">
         <label for="shake" class="col-sm-3 col-form-label"> Shake </label>
         <div class="col-sm-8">
          <select name="shake" id="shake" class="form-control" required="">
            <option value="">Pilih</option>
            <option value="tidak_butuh"<?php if ($key->shake == "tidak_butuh"){echo 'selected';
          }?>>Tidak Butuh</option>
          <option value="butuh"<?php if ($key->shake == "butuh"){echo 'selected';
        }?>>Butuh</option>
        <option value="sangat_butuh"<?php if ($key->shake == "sangat_butuh"){echo 'selected';
      }?>>Sangat Butuh</option>
    </select>
  </div>
</div>

<div class="form-group row">
         <label for="aloe" class="col-sm-3 col-form-label"> Aloe </label>
         <div class="col-sm-8">
          <select name="aloe" id="aloe" class="form-control" required="">
            <option value="">Pilih</option>
            <option value="tidak_butuh"<?php if ($key->aloe == "tidak_butuh"){echo 'selected';
          }?>>Tidak Butuh</option>
          <option value="butuh"<?php if ($key->aloe == "butuh"){echo 'selected';
        }?>>Butuh</option>
        <option value="sangat_butuh"<?php if ($key->aloe == "sangat_butuh"){echo 'selected';
      }?>>Sangat Butuh</option>
    </select>
  </div>
</div>

<div class="form-group row">
         <label for="thermo" class="col-sm-3 col-form-label"> Thermo </label>
         <div class="col-sm-8">
          <select name="thermo" id="thermo" class="form-control" required="">
            <option value="">Pilih</option>
            <option value="tidak_butuh"<?php if ($key->thermo == "tidak_butuh"){echo 'selected';
          }?>>Tidak Butuh</option>
          <option value="butuh"<?php if ($key->thermo == "butuh"){echo 'selected';
        }?>>Butuh</option>
        <option value="sangat_butuh"<?php if ($key->thermo == "sangat_butuh"){echo 'selected';
      }?>>Sangat Butuh</option>
    </select>
  </div>
</div>

<div class="form-group row">
         <label for="nrg" class="col-sm-3 col-form-label"> Nrg Tea </label>
         <div class="col-sm-8">
          <select name="nrg" id="nrg" class="form-control" required="">
            <option value="">Pilih</option>
            <option value="tidak_butuh"<?php if ($key->nrg == "tidak_butuh"){echo 'selected';
          }?>>Tidak Butuh</option>
          <option value="butuh"<?php if ($key->nrg == "butuh"){echo 'selected';
        }?>>Butuh</option>
        <option value="sangat_butuh"<?php if ($key->nrg == "sangat_butuh"){echo 'selected';
      }?>>Sangat Butuh</option>
    </select>
  </div>
</div>

<div class="form-group row">
         <label for="ppp" class="col-sm-3 col-form-label"> PPP </label>
         <div class="col-sm-8">
          <select name="ppp" id="ppp" class="form-control" required="">
            <option value="">Pilih</option>
            <option value="tidak_butuh"<?php if ($key->ppp == "tidak_butuh"){echo 'selected';
          }?>>Tidak Butuh</option>
          <option value="butuh"<?php if ($key->ppp == "butuh"){echo 'selected';
        }?>>Butuh</option>
        <option value="sangat_butuh"<?php if ($key->ppp == "sangat_butuh"){echo 'selected';
      }?>>Sangat Butuh</option>
    </select>
  </div>
</div>

 <div class="form-group row">
         <label for="mixed_fiber" class="col-sm-3 col-form-label"> Mixed Fiber </label>
         <div class="col-sm-8">
          <select name="mixed_fiber" id="mixed_fiber" class="form-control" required="">
            <option value="">Pilih</option>
            <option value="tidak_butuh"<?php if ($key->mixed_fiber == "tidak_butuh"){echo 'selected';
          }?>>Tidak Butuh</option>
          <option value="butuh"<?php if ($key->mixed_fiber == "butuh"){echo 'selected';
        }?>>Butuh</option>
        <option value="sangat_butuh"<?php if ($key->mixed_fiber == "sangat_butuh"){echo 'selected';
      }?>>Sangat Butuh</option>
    </select>
  </div>
</div>


<div class="page-header">
  <input type="submit" class="btn btn-success" value="EDIT">&nbsp;&nbsp;

  <a href="<?php echo base_url()?>Rule"><button type="button" class="btn btn-danger">KEMBALI</button></a>
</div>

<?php echo form_close(); ?>

<?php
}
?>
<div class="clearfix"></div>


</div>
</div>

</div>
</div>

</div>
