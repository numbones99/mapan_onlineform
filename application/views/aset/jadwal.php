<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Jadwal</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Online Form</a></li>
              <li class="breadcrumb-item">Perbaikan Aset</li>
              <li class="breadcrumb-item active">Jadwal</li>
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
        if($this->session->userdata('LEAD_STATUS')=='2'){
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <div class="row">
                        <div class="col-lg-6">
                        <h3 class="card-title">Jadwal Hari Ini</h3>
                        </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" name="insTgl" class="form-control float-right" id="tanggal">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                </div>
                            </div>
                        </div>
                    
                    <div class="row">
                        <div class="col-12">
                        
                            <table class="table table-sm table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">No. </th>
                                    <th scope="col">Pengaju</th>
                                    <th scope="col">Branch</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                                <tbody class="jadwalteknisi">

                                </tbody>
                            </table>
                        </div>
                    </div>                

                    <?php
                    $i=0;
                    foreach($jadwal as $jadwal):
                    ?>

                    <div class="modal fade" id="modal-detail-<?= str_replace('/','',$jadwal['RP_ID'])?>">
                        <div class="modal-dialog modal-lg modal-dialog-centeredx">
                           <div class="modal-content">
                                <div class="modal-header" style="background-color:#5cb85c;color:white;">
                                    <h5 class="modal-title ">Detail - <?= $jadwal['RP_ID']?></h5>                 
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-jadwal-<?= str_replace('/','',$jadwal['RP_ID'])?>" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">
                                                    Jadwal
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-aset-<?= str_replace('/','',$jadwal['RP_ID'])?>" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">
                                                    Aset
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                                <div class="tab-pane fade show active" id="custom-jadwal-<?= str_replace('/','',$jadwal['RP_ID'])?>" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                                    <div class="row" style="padding-top: 1rem;">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Nama</label>
                                                                <input type="text" name="insID" class="form-control" value="<?= $jadwal['EMP_FULL_NAME'];?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Lokasi</label>
                                                                <input type="text" name="insID" class="form-control" value="<?= $jadwal['BRANCH_NAME'];?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Jadwal Mulai</label>
                                                                <input type="text" name="insID" class="form-control" value="<?= $jadwal['RP_STR_DATE'];?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Jadwal Selesai</label>
                                                                <input type="text" name="insID" class="form-control" value="<?= $jadwal['RP_END_DATE'];?>" readonly>
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
                                                                    'RP_ID' => $jadwal['RP_ID'],
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
                                                <div class="tab-pane fade" id="custom-aset-<?= str_replace('/','',$jadwal['RP_ID'])?>" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                                                    <!-- start row -->
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <table class="mb-0 table table-striped" style="table-layout: fixed;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 10%;">#</th>
                                                                        <th>Nama Aset</th>
                                                                        <th style="width: 15%;">
                                                                        <i class="fas fa-search-plus"></i>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                $where = array(
                                                                    'RP_ID' => $jadwal['RP_ID'],
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
                                                                            <a data-toggle="collapse" href="#data-<?= str_replace('/','',$detail['DET_RP_ID'])?>" role="button" aria-expanded="true" aria-controls="collapseExample">
                                                                            <i class="fas fa-search-plus"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="collapse" id="data-<?= str_replace('/','',$detail['DET_RP_ID'])?>">
                                                                            <p>Kerusakan : <?= $detail['DET_RP_REASON']?></p>
                                                                        </td>
                                                                        <td class="collapse" id="data-<?= str_replace('/','',$detail['DET_RP_ID'])?>">
                                                                            <a href="<?php echo base_url()?>assets/doc-repair/<?= $detail['DET_RP_PHOTO']?>" target="_blank"><i class="far fa-file-image"></i></a>
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
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-block btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    endforeach;
                    ?>
                      
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <!-- <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-summary">
                        Summary Kasbon
                        </button> -->
                    </div>
                </div><!-- /.card -->
            </div><!--/col-->
        </div>
        <?php 
        }
        else{
        ?>
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <div class="row">
                        <div class="col-lg-6">
                        <h3 class="card-title">Jadwal Hari Ini</h3>
                        </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <?php
                            if($this->session->userdata('EMP_ID')=='EMP/006/006'){
                            ?>
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="text" name="insTgl" class="form-control float-right" id="tanggalall">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                        <form role="form" action="<?php echo base_url().'Aset/cronEmail'?>" method="POST" enctype="multipart/form-data">
                                                <button class="btn btn-block btn-success" type="submit" formaction="<?php echo base_url().'Aset/cronEmail'?>">Kirim Ulang Email</button>
                                        </form>
                                </div>
                            </div>
                            <?php
                            }else{
                            ?>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" name="insTgl" class="form-control float-right" id="tanggalall">
                                </div>
                            </div>
                            <?php } 
                            ?>
                        </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-sm table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">No. </th>
                                    <th scope="col">Pengaju</th>
                                    <th scope="col">Branch</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                                <tbody class="jadwalteknisi">

                                </tbody>
                            </table>
                        </div>
                    </div>                

                    <?php
                    $i=0;
                    foreach($jadwalall as $jadwalall):
                    ?>

                    <div class="modal fade" id="modal-detail-<?= str_replace('/','',$jadwalall['RP_ID'])?>" >
                        <div class="modal-dialog modal-lg">
                           <div class="modal-content">
                                <div class="modal-header" style="background-color:#5bc0de;color:white;">
                                    <h5 class="modal-title ">Detail - <?= $jadwalall['RP_ID']?></h5>                 
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-jadwal-<?= str_replace('/','',$jadwalall['RP_ID'])?>" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">
                                                    Jadwal
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-aset-<?= str_replace('/','',$jadwalall['RP_ID'])?>" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">
                                                    Aset
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                                <div class="tab-pane fade show active" id="custom-jadwal-<?= str_replace('/','',$jadwalall['RP_ID'])?>" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                                    <div class="row" style="padding-top: 1rem;">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Nama</label>
                                                                <input type="text" name="insID" class="form-control" value="<?= $jadwalall['EMP_FULL_NAME'];?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Lokasi</label>
                                                                <input type="text" name="insID" class="form-control" value="<?= $jadwalall['BRANCH_NAME'];?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Jadwal Mulai</label>
                                                                <input type="text" name="insID" class="form-control" value="<?= $jadwalall['RP_STR_DATE'];?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Jadwal Selesai</label>
                                                                <input type="text" name="insID" class="form-control" value="<?= $jadwalall['RP_END_DATE'];?>" readonly>
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
                                                                    'RP_ID' => $jadwalall['RP_ID'],
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
                                                <div class="tab-pane fade" id="custom-aset-<?= str_replace('/','',$jadwalall['RP_ID'])?>" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                                                    <!-- start row -->
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <table class="mb-0 table table-striped" style="table-layout: fixed;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 10%;">#</th>
                                                                        <th>Nama Aset</th>
                                                                        <th style="width: 15%;">
                                                                        <i class="fas fa-search-plus"></i>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                $where = array(
                                                                    'RP_ID' => $jadwalall['RP_ID'],
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
                                                                            <a data-toggle="collapse" href="#data-<?= str_replace('/','',$detail['DET_RP_ID'])?>" role="button" aria-expanded="true" aria-controls="collapseExample">
                                                                            <i class="fas fa-search-plus"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="collapse" id="data-<?= str_replace('/','',$detail['DET_RP_ID'])?>">
                                                                            <p>Kerusakan : <?= $detail['DET_RP_REASON']?></p>
                                                                        </td>
                                                                        <td class="collapse" id="data-<?= str_replace('/','',$detail['DET_RP_ID'])?>">
                                                                            <a href="<?php echo base_url()?>assets/doc-repair/<?= $detail['DET_RP_PHOTO']?>" target="_blank"><i class="far fa-file-image"></i></a>
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
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-block btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    endforeach;
                    ?>
                      
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <!-- <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-summary">
                        Summary Kasbon
                        </button> -->
                    </div>
                </div><!-- /.card -->
            </div><!--/col-->
        </div>
        <?php
        } 
        ?>
        <!-- /row tampilan data-->
    </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->