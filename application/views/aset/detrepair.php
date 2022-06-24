<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Detail Perbaikan Aset</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Online Form</a></li>
              <li class="breadcrumb-item">Perbaikan Aset</li>
              <li class="breadcrumb-item active">Detail Perbaikan Aset</li>
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
            <!-- open row edit -->
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Detail Perbaikan Aset - <?= $repair['RP_ID'];?> </h3>
                        </div>                           
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="<?php echo base_url().'Aset/insDet'?>" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6" data-select2-id="29">
                                        <div class="form-group">
                                        <label for="exampleInputEmail1">Ruangan</label>
                                        <input type="hidden" name="insID" value="<?= $repair['RP_ID']?>">
                                        <select class="form-control select2bs4" id="selruang" name="insRuang" style="width: 100%;" required>
                                            <option disabled selected="selected" value="">Silahkan Pilih Ruangan</option>
                                            <?php foreach($ruang as $ruang) :?>
                                            <option value="<?= $ruang['RUANG_ID'] ?>"><?= $ruang['RUANG_NAME'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                        </div>
                                    </div><!--endcol-->
                                    <div class="col-md-6" data-select2-id="29">
                                        <div class="form-group">
                                        <label for="exampleInputEmail1">Aset</label>
                                        <select class="form-control select2bs4" id="selaset" name="insAsset" style="width: 100%;" required>
                                            <option disabled selected="selected" value="">Silahkan Pilih Aset</option>
                                        </select>
                                        </div>
                                    </div><!--endcol-->
                                </div><!--endrow-->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Keterangan</label>
                                            <input type="hidden" name="insID" class="form-control" value="<?= $repair['RP_ID'];?>" autocomplete="off" required>
                                            <textarea class="form-control" name="insReason" rows="4" placeholder="Silahkan Masukkan Deskripsi Kerusakan / Alasan Perbaikan" style="resize:none" required></textarea>
                                        </div>
                                    </div><!--endcol-->
                                    
                                </div><!--endrow-->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="upfoto">Update Foto Kerusakan</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                <input type="file" name="insFoto" class="custom-file-input" required>
                                                <label class="custom-file-label" for="exampleInputFile">Pilih File Foto</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--endcol-->
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info" style="float:right">Masukkan Data</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
            <!-- open row tampilan data -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-6">
                                <h3 class="card-title">Data Detail Perbaikan Aset - <?= $repair['RP_ID'];?></h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover text-center">
                                <thead>
                                <tr>
                                    <th>ID Detail</th>
                                    <th>Aset</th>
                                    <th>Keterangan</th>
                                    <th>Foto Kerusakan</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody class="">
                                    <?php foreach($dtrepair as $dtrepair) :
                                    $where = array(
                                    'ASSET_CODE' => $dtrepair['ASSET_CODE'],   
                                    );
                                    $asset = $this->Model_online->findSingleDataWhere($where,'m_asset');  
                                    ?>
                                    <tr>
                                        <td><?= $dtrepair['DET_RP_ID']; ?></td>
                                        <td><?= $dtrepair['ASSET_CODE'].' - '.$asset['ASSET_NAME']; ?></td>
                                        <td class="text-justify"><?= $dtrepair['DET_RP_REASON']; ?></td>
                                        <td><a href="<?php echo base_url()?>assets/doc-repair/<?= $dtrepair['DET_RP_PHOTO']; ?>" target="_blank"><img src="<?php echo base_url()?>assets/doc-repair/<?= $dtrepair['DET_RP_PHOTO']; ?>" width="75px"></a></td>
                                        <td>
                                            <div class="btn-group">
                                                <span data-toggle="tooltip" data-placement="top" title="Hapus Pengajuan">
                                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-update-<?= str_replace('/','',$dtrepair['DET_RP_ID']); ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button> 
                                                </span>                                        
                                                <span data-toggle="tooltip" data-placement="top" title="Hapus Pengajuan">
                                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-delete-<?= str_replace('/','',$dtrepair['DET_RP_ID']); ?>">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button> 
                                                </span>
                                            </div>
                                        </td>
                                        <!-- modal delete -->
                                        <div class="modal fade" id="modal-delete-<?= str_replace('/','',$dtrepair['DET_RP_ID']); ?>">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form role="form" action="<?php echo base_url().'Aset/delDet'?>" method="POST" enctype="multipart/form-data">
                                                        <div class="modal-header" style="background-color:#dc3545;color:white;">
                                                            <h5 class="modal-title ">Hapus Permintaan - <?= $dtrepair['DET_RP_ID']; ?></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="delnama">ID Detail</label>
                                                                        <input type="text" name="delID" class="form-control" value="<?= $dtrepair['DET_RP_ID']; ?>" readonly>
                                                                        <input type="hidden" name="delIDrp" class="form-control" value="<?= $dtrepair['RP_ID']; ?>" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="delnama">Nama Aset</label>
                                                                        <input type="text" name="delNama" class="form-control" value="<?= $dtrepair['ASSET_CODE'].' - '.$asset['ASSET_NAME']; ?>" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label for="delharga">Alasan</label>
                                                                        <textarea class="form-control" name="delReason" rows="4" placeholder="Silahkan Masukkan Deskripsi Kerusakan / Alasan Perbaikan" style="resize:none" readonly><?= $dtrepair['DET_RP_REASON']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal delete-->
                                        <!-- modal update -->
                                        <div class="modal fade" id="modal-update-<?= str_replace('/','',$dtrepair['DET_RP_ID']); ?>">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form role="form" action="<?php echo base_url().'Aset/upDet'?>" method="POST" enctype="multipart/form-data">
                                                        <div class="modal-header" style="background-color:#FFC107;">
                                                            <h5 class="modal-title">Update Permintaan <?= $dtrepair['DET_RP_ID']; ?></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label for="delnama">Nama Ruang</label>
                                                                        <select class="form-control select2bs4 selruang2" name="upRuang" style="width: 100%;">
                                                                            <?php
                                                                            $whereRuang = array(
                                                                                'ASSET_CODE' => $dtrepair['ASSET_CODE'],    
                                                                            );
                                                                            $ruangbaru = $this->Model_online->findSingleDataWhere($whereRuang,'m_asset');
                                                                            ?>
                                                                            <option selected disabled value="">Silahkan Pilih Ruangan</option>
                                                                            <?php
                                                                            $i = 2;
                                                                            foreach($ruangan as $i) : 
                                                                            ?>
                                                                            <option <?php ($i->RUANG_ID==$ruangbaru['RUANG_ID']) ? 'selected="selected" disabled' : '' ?> value="<?= $i->RUANG_ID ?>"><?= $i->RUANG_NAME ?></option>
                                                                            <?php endforeach; 
                                                                            $i+1;
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-8">
                                                                    <div class="form-group">
                                                                        <label for="delnama">Nama Aset</label>
                                                                        <input type="hidden" name="upIDDet" class="form-control" value="<?= $dtrepair['DET_RP_ID']; ?>" readonly>
                                                                        <input type="hidden" name="upID" class="form-control" value="<?= $dtrepair['RP_ID']; ?>" readonly>
                                                                        <select class="form-control select2bs4 selaset2" name="upAsset" style="width: 100%;" required>
                                                                            <option selected="selected" value="<?= $dtrepair['ASSET_CODE']; ?>"><?= $dtrepair['ASSET_CODE'].' - '.$asset['ASSET_NAME']; ?></option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label for="delharga">Alasan</label>
                                                                        <textarea class="form-control" name="upReason" rows="4" placeholder="Silahkan Masukkan Deskripsi Kerusakan / Alasan Perbaikan" style="resize:none" required><?= $dtrepair['DET_RP_REASON']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label for="upfoto">Update Foto Kerusakan</label>
                                                                        <div class="input-group">
                                                                            <div class="custom-file">
                                                                            <input type="file" name="upFoto" class="custom-file-input">
                                                                            <label class="custom-file-label" for="exampleInputFile">Pilih File Foto</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div><!--endcol-->
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-warning">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal Update-->   
                                    </tr>
                                    <?php endforeach?>
                                
                                
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <?php
                        if(count($dtrepair2) !='0'){
                        ?>
                        <div class="card-footer">
                            <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-default">
                                Ajukan Permintaan Perbaikan Aset Ke Building & Maintenance
                            </button>
                        </div>
                        <?php
                        }
                        ?>
                        
                    </div>
                    <!-- /.card -->
                </div><!--/col-->
                <!-- modal atasan -->
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form role="form" action="<?php echo base_url().'Aset/insApp'?>" method="POST" enctype="multipart/form-data">
                                <div class="modal-header" style="background-color:#28a745;color:white;">
                                    <h5 class="modal-title">Summary Permintaan Perbaikan Aset ID - <?= $repair['RP_ID'];?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Nama Karyawan</label>
                                                <input type="text" class="form-control"  value="<?= $this->session->userdata('EMP_FULL_NAME');?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>ID Perbaikan</label>
                                                <input type="text" name='rpid' class="form-control" value="<?= $repair['RP_ID'];?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Jumlah Permintaan</label>
                                                <input type="text" class="form-control money" value="<?= count($dtrepair2);?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table id="example2" class="table table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Asset</th>
                                                    <th>Alasan Perbaikan</th>
                                                </tr>
                                                </thead>
                                                <tbody class="">
                                                <?php
                                                $i=1;
                                                ?>
                                                <?php foreach($dtrepair2 as $item) :
                                                $where2 = array(
                                                'ASSET_CODE' => $dtrepair['ASSET_CODE'],   
                                                );
                                                $asset2 = $this->Model_online->findSingleDataWhere($where2,'m_asset');  
                                                ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $item['ASSET_CODE'].' - '.$asset2['ASSET_NAME']; ?></td>
                                                    <td><?= $item['DET_RP_REASON']; ?></td>
                                                </tr>
                                                
                                                <?php endforeach?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Kirim</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>
            <!-- /row tampilan data-->
    </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->