<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Detail & Timeline</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Online Form</a></li>
              <li class="breadcrumb-item">Perbaikan Aset</li>
              <li class="breadcrumb-item active">Timeline</li>
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
        <!-- open row tampilan data -->
        <?php
        $Ymdhis = date('Y-m-d H:i:s');
        $usrnow = $this->session->userdata('EMP_ID');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-12">
                                <h3 class="card-title">Data Detail Perbaikan Aset - <?= $repair['RP_ID'];?></h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <?php
                    if($repair['RP_STAT']=='3' && $repair['RP_STR_DATE'] < $Ymdhis && $repair['EMP_ID']== $this->session->userdata('EMP_ID')){
                    ?>
                        <table id="example3" class="table table-bordered table-hover text-center">
                            <thead>
                            <tr>
                                <th>ID Detail</th>
                                <th>Aset</th>
                                <th>Keterangan</th>
                                <th>Foto Aset</th>
                                <th>Foto Akhir</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="">
                                <?php foreach($dtrepair as $item) :
                                $where = array(
                                'ASSET_CODE' => $item['ASSET_CODE'],   
                                );
                                $asset = $this->Model_online->findSingleDataWhere($where,'m_asset');  
                                ?>
                                <tr>
                                    <td><?= $item['DET_RP_ID']; ?></td>
                                    <td><?= $item['ASSET_CODE'].' - '.$asset['ASSET_NAME']; ?></td>
                                    <td class="text-justify"><?= $item['DET_RP_REASON']; ?></td>
                                    <td><a href="<?php echo base_url()?>assets/doc-repair/<?= $item['DET_RP_PHOTO']; ?>" target="_blank"><img src="<?php echo base_url()?>assets/doc-repair/<?= $item['DET_RP_PHOTO']; ?>" width="75px"></a></td>
                                    <td><a href="<?php echo base_url()?>assets/doc-repair/<?= $item['DET_RP_REV_PHOTO']; ?>" target="_blank"><img src="<?php echo base_url()?>assets/doc-repair/<?= $item['DET_RP_REV_PHOTO']; ?>" width="75px"></a></td>
                                    <td>
                                        <?php 
                                        if($item['DET_RP_REV_PHOTO']==''){
                                        ?>
                                        <div class="btn-group">
                                            <span data-toggle="tooltip" data-placement="top" title="Tambahkan Foto">
                                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-insert-<?= str_replace('/','',$item['DET_RP_ID']); ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button> 
                                            </span>
                                        </div>
                                        <?php 
                                        }else{
                                        ?>
                                        <div class="btn-group">
                                            <span data-toggle="tooltip" data-placement="top" title="Update Foto">
                                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-update-<?= str_replace('/','',$item['DET_RP_ID']); ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button> 
                                            </span>
                                        </div>
                                        <?php 
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <!-- Modal Insert foto akhir -->
                                <div class="modal fade" id="modal-insert-<?= str_replace('/','',$item['DET_RP_ID']); ?>">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form role="form" action="<?php echo base_url().'Aset/insFoto'?>" method="POST" enctype="multipart/form-data">
                                                <div class="modal-header" style="background-color:#5bc0de;color:white;">
                                                    <h5 class="modal-title">Tambahkan Foto Aset <?= $item['DET_RP_ID']; ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="upfoto">Tambahkan Foto Aset</label>
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                    <input type="hidden" name="detid" value="<?= $item['DET_RP_ID']?>">
                                                                    <input type="hidden" name="rpid" value="<?= $item['RP_ID']?>">
                                                                    <input type="file" name="upFoto" class="custom-file-input" required>
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
                                <!-- /.modal -->
                                <!-- Modal Update foto akhir -->
                                <div class="modal fade" id="modal-update-<?= str_replace('/','',$item['DET_RP_ID']); ?>">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form role="form" action="<?php echo base_url().'Aset/upFoto'?>" method="POST" enctype="multipart/form-data">
                                                <div class="modal-header" style="background-color:#5bc0de;color:white;">
                                                    <h5 class="modal-title">Update Foto Aset <?= $item['DET_RP_ID']; ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="upfoto">Update Foto Aset</label>
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                    <input type="hidden" name="detid" value="<?= $item['DET_RP_ID']?>">
                                                                    <input type="hidden" name="rpid" value="<?= $item['RP_ID']?>">
                                                                    <input type="file" name="upFoto" class="custom-file-input" required>
                                                                    <label class="custom-file-label" for="exampleInputFile">Pilih File Foto</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!--endcol-->
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" formaction="<?php echo base_url().'Aset/upFoto'?>" class="btn btn-warning">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->

                                <?php endforeach?>
                            </tbody>
                        </table>
                    <?php
                    }else{
                    ?>
                        <table id="example2" class="table table-bordered table-hover text-center">
                            <thead>
                            <tr>
                                <th>ID Detail</th>
                                <th>Aset</th>
                                <th>Keterangan</th>
                                <th>Foto Aset</th>
                                <th>Foto Akhir</th>
                            </tr>
                            </thead>
                            <tbody class="">
                                <?php foreach($dtrepair as $item) :
                                $where = array(
                                'ASSET_CODE' => $item['ASSET_CODE'],   
                                );
                                $asset = $this->Model_online->findSingleDataWhere($where,'m_asset');  
                                ?>
                                <tr>
                                    <td><?= $item['DET_RP_ID']; ?></td>
                                    <td><?= $item['ASSET_CODE'].' - '.$asset['ASSET_NAME']; ?></td>
                                    <td class="text-justify"><?= $item['DET_RP_REASON']; ?></td>
                                    <td><a href="<?php echo base_url()?>assets/doc-repair/<?= $item['DET_RP_PHOTO']; ?>" target="_blank"><img src="<?php echo base_url()?>assets/doc-repair/<?= $item['DET_RP_PHOTO']; ?>" width="75px"></a></td>
                                    <td><a href="<?php echo base_url()?>assets/doc-repair/<?= $item['DET_RP_REV_PHOTO']; ?>" target="_blank"><img src="<?php echo base_url()?>assets/doc-repair/<?= $item['DET_RP_REV_PHOTO']; ?>" width="75px"></a></td>
                                </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                    <?php
                    }
                    ?>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                    <?php
                    $cekus_wr = array(
                        'EMP_ID' => $this->session->userdata('EMP_ID'),
                        'RP_ID' => $repair['RP_ID'],
                    );
                    $cekus = $this->Model_online->countRowWhere('tr_repair_sch',$cekus_wr);
                    $arr_cek = array(
                        "DET_RP_REV_PHOTO" => null,
                        "RP_ID" => $repair['RP_ID'],
                    );
                    $cek_foto = $this->Model_online->countRowWhere('tr_detail_repair',$arr_cek);
                    if($cek_foto==0 && $repair['RP_STAT']=='3' && $repair['RP_STR_DATE'] < $Ymdhis && $repair['EMP_ID']== $this->session->userdata('EMP_ID')){
                    ?>
                    <div class="row">
                        <button type="button" data-toggle="modal" data-target="#modal-review" class="btn btn-block btn-info">
                            Masukkan Review
                        </button>
                    </div>
                        <!-- Modal Deny -->
                        <div class="modal fade" id="modal-review">
                            <div class="modal-dialog modal-lg ">
                                <div class="modal-content">
                                <form role="form" action="<?php echo base_url().'Aset/insReview'?>" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header text-center" style="background-color:#5cb85c;color:white;">
                                        <h5 class="modal-title text-center">Berikan Review</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <div class="row">
                                            <div class="col-12">
                                                    <style>
                                                        div.stars {
                                                            width: 270px;
                                                            display: inline-block
                                                        }

                                                        .mt-200 {
                                                            margin-top: 200px
                                                        }

                                                        input.star {
                                                            display: none
                                                        }

                                                        label.star {
                                                            float: right;
                                                            padding: 10px;
                                                            font-size: 36px;
                                                            color: #4A148C;
                                                            transition: all .2s
                                                        }

                                                        input.star:checked~label.star:before {
                                                            content: '\f005';
                                                            color: #FD4;
                                                            transition: all .25s
                                                        }

                                                        input.star-5:checked~label.star:before {
                                                            color: #FE7;
                                                            text-shadow: 0 0 20px #952
                                                        }

                                                        input.star-1:checked~label.star:before {
                                                            color: #F62
                                                        }

                                                        label.star:hover {
                                                            transform: rotate(-15deg) scale(1.3)
                                                        }

                                                        label.star:before {
                                                            content: '\f006';
                                                            font-family: FontAwesome
                                                        }
                                                    </style>
                                                    <div class="stars">
                                                        <input class="star star-5" id="star-5" type="radio" name="star" value="5" required/> 
                                                        <label class="star star-5" for="star-5"></label> 
                                                        <input class="star star-4" id="star-4" type="radio" name="star" value="4"/> 
                                                        <label class="star star-4" for="star-4"></label> 
                                                        <input class="star star-3" id="star-3" type="radio" name="star" value="3"/> 
                                                        <label class="star star-3" for="star-3"></label> 
                                                        <input class="star star-2" id="star-2" type="radio" name="star" value="2"/> 
                                                        <label class="star star-2" for="star-2"></label> 
                                                        <input class="star star-1" id="star-1" type="radio" name="star" value="1"/> 
                                                        <label class="star star-1" for="star-1">
                                                        </label> 
                                                    </div>
                                                    <input type="hidden" name="repairid" value="<?= $repair['RP_ID']?>">
                                            </div>
                                                
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="delnama">Waktu Datang</label>
                                                    <input type="text" name="insArrival" class="form-control float-right" id="tanggalwaktu" required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="delnama">Waktu Selesai</label>
                                                    <input type="text" name="insFinish" class="form-control float-right" id="tanggalwaktu2" required>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <textarea class="form-control" name="insReason" rows="3" placeholder="Silahkan Masukkan Komentar" style="resize:none" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" formaction="<?php echo base_url().'Aset/insReview'?>" class="btn btn-success">Lanjutkan</button>
                                    </div>
                                </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    <?php
                    }elseif($repair['RP_STAT']==5 && ($cekus>0 || $usrnow == 'EMP/006/006') ){
                    ?>
                    <div class="row">
                        <button type="button" data-toggle="modal" data-target="#modal-cek" class="btn btn-block btn-success">
                            Lihat Review
                        </button>
                    </div>
                        <!-- Modal Deny -->
                        <div class="modal fade" id="modal-cek">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header text-center" style="background-color:#5cb85c;color:white;">
                                        <h5 class="modal-title text-center">Hasil Review</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <?php
                                    $arr_emp = array(
                                        'EMP_ID' =>  $repair['EMP_ID'],
                                    );
                                    $dataemp = $this->Model_online->findSingleDataWhere($arr_emp,'m_employee');         
                                    $arr_dep = array(
                                        'DEPART_ID' =>  $dataemp['DEPART_ID'],
                                    );
                                    $datadep = $this->Model_online->findSingleDataWhere($arr_dep,'m_department');   
                                    $arr_br = array(
                                        'BRANCH_ID' =>  $datadep['BRANCH_ID'],
                                    );
                                    $databr = $this->Model_online->findSingleDataWhere($arr_br,'m_branch');   
                                    $arr_repair = array(
                                        'RP_ID' => $repair['RP_ID'],
                                    );
                                    $datarep = $this->Model_online->findSingleDataWhere($arr_repair,'tr_repair');
                                    ?>
                                        <div class="row">
                                            <div class="col-12">
                                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-summary" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Summary</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-review" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Review</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-aset" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Aset</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                                    <div class="tab-pane fade show active" id="custom-tabs-four-summary" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                                        <div class="row" style="padding-top: 1rem;">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label>Nama Pengaju</label>                              
                                                                    <input type="text" name='namaReim' class="form-control" value="<?= $dataemp['EMP_FULL_NAME'];?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label>Department</label>
                                                                    <input type="text" name='namaReim' class="form-control" value="<?= $datadep['DEPART_NAME'];?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label>Branch</label>
                                                                    <input type="text" name='namaReim' class="form-control" value="<?= $databr['BRANCH_NAME'];?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label>Tanggal Pengajuan</label>
                                                                    <input type="text" name='namaReim' class="form-control" value="<?= $datarep['RP_SUB_DATE'];?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label>Tanggal Penjadwalan</label>
                                                                    <input type="text" name='namaReim' class="form-control" value="<?= $datarep['RP_APP_DATE'];?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="tab-pane fade" id="custom-tabs-four-review" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                                        <div class="row" style="padding-top: 1rem;">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label>Rating</label>
                                                                    <input type="text" name='namaReim' class="form-control" value="<?= $datarep['RP_RATE'].' dari 5 Bintang';?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label>Waktu Visit Teknisi</label>
                                                                    <input type="text" name='namaReim' class="form-control" value="<?= $datarep['RP_ARRIVAL'];?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label>Waktu Selesai Teknisi</label>
                                                                    <input type="text" name='namaReim' class="form-control" value="<?= $datarep['RP_FINISH'];?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label>Komentar</label>
                                                                    <textarea class="form-control" name="insReason" rows="2" placeholder="Silahkan Masukkan Komentar" style="resize:none" readonly><?= $datarep['RP_RATE_COMMENT'];?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <table class="mb-0 table table-striped" style="table-layout: fixed;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 10%;">#</th>
                                                                            <th>Nama Teknisi</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php
                                                                    $arr_jadwal = array(
                                                                        'RP_ID' => $repair['RP_ID'],
                                                                    );
                                                                    $jadwaltek = $this->Model_online->findAllDataWhere($arr_jadwal,'tr_repair_sch');
                                                                    $no= 1;
                                                                    foreach($jadwaltek as $jadwaltek):
                                                                        $arr_emp = array(
                                                                            'EMP_ID' => $jadwaltek['EMP_ID'],
                                                                        );
                                                                        $emp = $this->Model_online->findSingleDataWhere($arr_emp,'m_employee');
                                                                    ?>
                                                                        <tr>
                                                                            <td><?= $no++ ?></td>
                                                                            <td><?= $emp['EMP_FULL_NAME']?></td>
                                                                        </tr>
                                                                    <?php
                                                                    endforeach;
                                                                    ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="tab-pane fade" id="custom-tabs-four-aset" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                                                        <!-- start row -->
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <table class="mb-0 table table-striped" style="table-layout: fixed;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 10%;">#</th>
                                                                            <th>Nama Aset</th>
                                                                            <th style="width: 15%;">
                                                                            <i class="fas fa-tools"></i>
                                                                            </th>
                                                                            <th style="width: 15%;">
                                                                            <i class="fas fa-check"></i>
                                                                            </th>
                                                                            <th style="width: 15%;">
                                                                            <i class="fas fa-search-plus"></i>
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php
                                                                    $where = array(
                                                                        'RP_ID' => $repair['RP_ID'],
                                                                    );
                                                                    $detail = $this->Model_online->findAllDataWhere($where,'tr_detail_repair');
                                                                    $no= 1;
                                                                    foreach($detail as $detail):
                                                                        $arr_asset = array(
                                                                            'ASSET_CODE' => $detail['ASSET_CODE'],
                                                                        );
                                                                        $asset = $this->Model_online->findSingleDataWhere($arr_asset,'m_asset');
                                                                    ?>
                                                                        <tr>
                                                                            <td><?= $no++?></td>
                                                                            <td><?= $asset['ASSET_CODE'].' - '.$asset['ASSET_NAME']?></td>
                                                                            <td>
                                                                                <a href="<?php echo base_url()?>assets/doc-repair/<?= $detail['DET_RP_PHOTO']?>" target="_blank"><i class="far fa-file-image"></i></a>
                                                                            </td>
                                                                            <td>
                                                                                <a href="<?php echo base_url()?>assets/doc-repair/<?= $detail['DET_RP_REV_PHOTO']?>" target="_blank"><i class="far fa-file-image"></i></a>
                                                                            </td>
                                                                            <td>
                                                                                <a data-toggle="collapse" href="#data-<?= str_replace('/','',$detail['DET_RP_ID'])?>" role="button" aria-expanded="true" aria-controls="collapseExample">
                                                                                <i class="fas fa-search-plus"></i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="5" class="collapse" id="data-<?= str_replace('/','',$detail['DET_RP_ID'])?>">
                                                                                <p>Kerusakan : <?= $detail['DET_RP_REASON']?></p>
                                                                            </td>
                                                                        </tr>
                                                                    <?php
                                                                    endforeach;
                                                                    ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <!-- end row -->
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>                                    
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    <?php
                    }
                    ?>
                    </div>
                </div><!-- /.card -->
            </div><!--/col-->
        </div>
        <!-- /row tampilan data-->
        <!-- open row timeline -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Timeline Pengajuan Perbaikan Aset ID - <?= $repair['RP_ID'];?></h3> 
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="timeline">
                            <!-- timeline item -->
                            <div>
                                <i class="fas fa-envelope bg-blue"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> <?= date("d-m-Y | H:i:s",strtotime($repair['RP_SUB_DATE'])) ?></span>
                                    <h3 class="timeline-header"><a href="#">Pengajuan Awal Perbaikan Aset ID : <?= $repair['RP_ID'];?> </a></h3>
                                    <div class="timeline-body">
                                    Perbaikan <?= count($dtrepair); ?> Item
                                    </div>
                                </div>
                            </div>
                            <!-- END timeline item -->
                            <!-- timeline item -->
                            <div>
                                <?php
                                if($repair['RP_STAT'] == '1'){
                                    $status = 'Menunggu Persetujuan Building & Maintenance';
                                    $statusWarna = 'fa-paper-plane bg-yellow';
                                }elseif($repair['RP_STAT'] == '2'){
                                    $status = 'Permohonan Ditolak';
                                    $statusWarna = 'fa-times-circle bg-red';
                                }elseif($repair['RP_STAT'] == '3' && $repair['RP_STR_DATE'] < $Ymdhis){
                                    $status = 'Menunggu Kelangkapan Foto Aset Setelah Perbaikan dan Review';
                                    $statusWarna = 'fa-comment-dots bg-yellow';
                                }elseif($repair['RP_STAT'] == '3'){
                                    $status = 'Telah Disetujui & Menunggu Visit Perbaikan Tanggal <strong>'.$repair['RP_STR_DATE'].'</strong> Sampai <strong>'.$repair['RP_END_DATE'].'</strong>';
                                    $statusWarna = 'fa-user-check bg-green';
                                }elseif($repair['RP_STAT'] == '5'){
                                    $status = 'Perbaikan & Review Telah Selesai';
                                    $statusWarna = 'fa-user-check bg-green';
                                }
                                ?>
                                <i class="fas <?= $statusWarna?>"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> <?= $repair['RP_APP_DATE'] == '' ? 'Menunggu Persetujuan ' :  $repair['RP_APP_DATE'];?> </span>
                                    <h3 class="timeline-header">
                                    <a href="#">Approval ID :  <?= $repair['RP_ID'] ?></a></h3>
                                    <div class="timeline-body">
                                    <?php 
                                    echo $status;
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <i class="fas fa-clock bg-gray"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /row timeline -->
    </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->