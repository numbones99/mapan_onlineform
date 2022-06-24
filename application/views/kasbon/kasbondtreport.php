<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3 class="m-0 text-dark"> Detail Realisasi Kasbon : <?= $dtkasbon['DET_KB_ID'];?></h3>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Online Form</a></li>
              <li class="breadcrumb-item">Kasbon</li>
              <li class="breadcrumb-item active">Detail Realiasasi</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <!-- Inputkan dalemannya disini ++++ -->
    <!-- Inputkan dalemannya disini ++++ -->
    <!-- Inputkan dalemannya disini ++++ -->
    <!-- Inputkan dalemannya disini ++++ -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Detail Kasbon</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <input class="form-control" type="text" name="" id="" value="<?= $dtkasbon['DET_KB_ITEM'];?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Nominal Pengajuan</label>
                                        <input class="form-control" type="text" name="" id="" value="<?= 'Rp. '.number_format($dtkasbon['DET_KB_VALUE']);?>" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Nominal Realisasi</label>
                                        <input class="form-control" type="text" name="" id="" value="<?= 'Rp. '.number_format($dtkasbon['DET_KB_END_VALUE']);?>" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Selisih</label>
                                        <input class="form-control" type="text" name="" id="" value="<?= 'Rp. '.number_format($dtkasbon['DET_KB_DIFF']);?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                    <button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#modal-insert"><strong>Tambahkan Data</strong></button>      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal insert -->
            <div class="modal fade" id="modal-insert">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <form role="form" action="<?php echo base_url().'Kasbon/insReal'?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-header" style="background-color:#5cb85c;">
                        <h5 class="modal-title" style="color:white"> <strong>Tambahkan Keterangan</strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" name="insRealName" class="form-control" value="">
                                    <input type="hidden" name="insDetKBID" class="form-control" value="<?= $dtkasbon['DET_KB_ID'];?>">
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nominal</label>
                                    <input type="text" name="insRealValue" class="form-control money" value="">
                                </div>
                            </div>
                            <hr>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="exampleInputFile">Foto Nota / Lampiran Pendukung</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                        <input type="file" name="insNota" class="custom-file-input" id="exampleInputFile" accept="image/png, image/gif, image/jpeg, image/jpg">
                                        <label class="custom-file-label" for="exampleInputFile">Klik Untuk Pilih File</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success"> <strong>Tambahkan</strong> </button>
                    </div>
                    </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal insert-->
            <div class="row">
                <!-- Data Kasbon Baru column -->
                <div class="col-lg-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Data Realisasi</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID Realisasi</th>
                                        <th>Keterangan</th>
                                        <th>Nominal</th>
                                        <th>File foto</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 1;
                                foreach($dtreal as $dtreal) :
                                ?>
                                <tr>
                                    <td><?= $dtreal['REAL_ID']; ?></td>
                                    <td><?= $dtreal['REAL_NAME']; ?></td>
                                    <td><?= number_format($dtreal['REAL_VALUE']); ?></td>
                                    <td>
                                    <a href="<?php echo base_url()?>assets/doc-kasbon/<?= $dtreal['REAL_PHOTO']; ?>" target="_blank"><img src="<?php echo base_url()?>assets/doc-kasbon/<?= $dtreal['REAL_PHOTO']; ?>" width="75px"></a>
                                    </td>
                                    <td class="text-center">
                                    <span data-toggle="tooltip" data-placement="top" title="Edit">
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-update-<?= str_replace('/','',$dtreal['REAL_ID']); ?>"><i class="fas fa-edit"></i></button>
                                    </span>
                                    <span data-toggle="tooltip" data-placement="top" title="Hapus Data">
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-delete-<?= str_replace('/','',$dtreal['REAL_ID']); ?>"><i class="fas fa-trash"></i></button>
                                    </span>
                                    </td>
                                </tr>
                                
                                <!-- modal update -->
                                <div class="modal fade" id="modal-update-<?= str_replace('/','',$dtreal['REAL_ID']); ?>">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                        <form role="form" action="<?php echo base_url().'Kasbon/upReal'?>" method="POST" enctype="multipart/form-data">
                                        <div class="modal-header" style="background-color:#f0ad4e;">
                                            <h5 class="modal-title" style="color:white"> <strong>Edit Detail Realisasi</strong></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label>Keterangan</label>
                                                        <input type="text" name="upNama" class="form-control" value="<?= $dtreal['REAL_NAME'];?>">
                                                        <input type="hidden" name="upIDReal" class="form-control" value="<?= $dtreal['REAL_ID'];?>">
                                                        <input type="hidden" name="insDetKBID" class="form-control" value="<?= $dtkasbon['DET_KB_ID'];?>">
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="col-lg-8">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">Foto Nota / Lampiran Pendukung</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                            <input type="file" name="upNota" class="custom-file-input" id="exampleInputFile" accept="image/png, image/gif, image/jpeg, image/jpg">
                                                            <label class="custom-file-label" for="exampleInputFile">Klik Untuk Pilih File</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Nominal</label>
                                                        <input type="text" name="upValue" class="form-control money" value="<?= $dtreal['REAL_VALUE']; ?>">
                                                        <input type="hidden" name="upValueAwal" class="form-control money" value="<?= $dtreal['REAL_VALUE']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-warning"> <strong>Kirim</strong> </button>
                                        </div>
                                        </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal Update-->
                                <!-- modal Delete -->
                                <div class="modal fade" id="modal-delete-<?= str_replace('/','',$dtreal['REAL_ID']); ?>">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                        <form role="form" action="<?php echo base_url().'Kasbon/delReal'?>" method="POST" enctype="multipart/form-data">
                                        <div class="modal-header" style="background-color:#d9534f;">
                                            <h5 class="modal-title" style="color:white"> <strong>Hapus Data ?</strong></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label>Keterangan</label>
                                                        <input type="text" name="delNama" class="form-control" value="<?= $dtreal['REAL_NAME'];?>">
                                                        <input type="hidden" name="delIDReal" class="form-control" value="<?= $dtreal['REAL_ID'];?>">
                                                        <input type="hidden" name="delDetKBID" class="form-control" value="<?= $dtkasbon['DET_KB_ID'];?>">
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="col-lg-8">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">Foto Nota / Lampiran Pendukung</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                            <input type="file" name="delNota" class="custom-file-input" id="exampleInputFile" accept="image/png, image/gif, image/jpeg, image/jpg" readonly>
                                                            <label class="custom-file-label" for="exampleInputFile">Klik Untuk Pilih File</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Nominal</label>
                                                        <input type="text" name="delValue" class="form-control money" value="<?= $dtreal['REAL_VALUE']; ?>">
                                                        <input type="hidden" name="delValueAwal" class="form-control money" value="<?= $dtreal['REAL_VALUE']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger"> <strong>Hapus</strong> </button>
                                        </div>
                                        </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal Update-->

                                <?php
                                endforeach;
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <?php
                            
                            if(count($dtreal)>0){
                            ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    
                                    <div class="form-group">
                                        <a class="btn btn-block btn-info" href="<?php echo base_url()?>Kasbon/report/<?= str_replace('/','',$dtkasbon['KB_ID']);?>"><strong>Simpan</strong></a>                                
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
           
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->