<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php 
    $id = $this->uri->segment(3, 0);
    $idmod = substr($id,0,2).'/'.substr($id,2,10);
    $arr_br = array(
        'BRANCH_ID' => $idmod,
    );
    $databr = $this->Model_online->findSingleDataWhere($arr_br,'m_branch');
    ?>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Pengeluaran Proyek</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('Dashboard')?>">Online Form</a></li>
              <li class="breadcrumb-item"><a href="<?= base_url('Project/')?>">Daftar Proyek</a></li>
              <li class="breadcrumb-item active"><?= $databr['BRANCH_NAME']; ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <div class="flashdata" data-flashdata="<?php echo $this->session->flashdata("flashdata");?>"></div>
    <!-- Inputkan dalemannya disini ++++ -->
    <!-- Inputkan dalemannya disini ++++ -->
    <!-- Inputkan dalemannya disini ++++ -->
    <!-- Inputkan dalemannya disini ++++ -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h3 class="card-title">Proyek <?= $databr['BRANCH_NAME']; ?></h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="col-12">
                            <div class="row">
                                <?php
                                $allowAdd = array('DP/002','DP/006','DP/007');
                                // if(in_array($this->session->userdata('DEPART_ID'), $allowAdd) && $this->session->userdata('LEAD_STATUS') == '4')
                                if($this->session->userdata('EMP_ID') == 'EMP/003/001')
                                {
                                ?>
                                <div class="col-6">
                                    <button type="button" data-toggle="modal" data-target="#modal-insert-pembayaran" class="btn btn-outline-primary">
                                    Tambahkan Data Proyek Baru
                                    </button>
                                </div>
                                <?php
                                // check ada proyek selesai atau tidak
                                $sqlcek = "select * 
                                from tr_project 
                                where BRANCH_ID = '".$databr['BRANCH_ID']."'
                                and PR_STATUS = '3' ";
                                $cekada = $this->db->query($sqlcek)->num_rows();
                                if($cekada>0){                                
                                ?>
                                    <div class="col-6 d-flex flex-row-reverse">
                                        <form role="form" action="<?php echo base_url().'Laporanoutletdone'?>" method="POST" enctype="multipart/form-data" target="_blank">
                                            <input type="hidden" name="outletId" value="<?= $databr['BRANCH_ID']; ?>">
                                            <button type="submit" class="btn btn-outline-success">
                                                Cetak Laporan Proyek Selesai
                                            </button>
                                        </form>
                                    </div>
                                <?php
                                }
                                ?>
                                <!-- modal Update -->
                                <div class="modal fade" id="modal-insert-pembayaran">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                        <form role="form" action="<?php echo base_url().'Project/AddProject'?>" method="POST" enctype="multipart/form-data">
                                        <div class="modal-header" style="background-color:#0275d8;">
                                            <h5 class="modal-title" style="color:white"> <strong>Proyek Baru</strong></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label>Nama Karyawan</label>
                                                    <input type="text" name="insEmpName" class="form-control" value="<?= $this->session->userdata('EMP_FULL_NAME');?>" readonly>
                                                    <input type="hidden" name="insEmp" class="form-control" value="<?= $this->session->userdata('EMP_ID');?>" readonly>
                                                    <input type="hidden" name="insBr" class="form-control" value="<?= $databr['BRANCH_ID']; ?>" readonly>
                                                    <input type="hidden" name="insBrCode" class="form-control" value="<?= $databr['BRANCH_CODE']; ?>" readonly>
                                                </div>
                                                <div class="col-6">
                                                    <label>Tanggal Pengajuan</label>
                                                    <input type="text" name="insTgl" class="form-control" value="<?= date('Y-m-d H:i:s');?>" readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label>Nama Proyek</label>
                                                    <input type="text" name="insProyek" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary"> <strong>Tambahkan</strong> </button>
                                        </div>
                                        </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <?php
                                }else{
                                ?>
                                <div class="col-6">
                                </div>
                                <div class="col-6 d-flex flex-row-reverse">
                                    <form role="form" action="<?php echo base_url().'Laporanoutletdone'?>" method="POST" enctype="multipart/form-data" target="_blank">
                                        <input type="hidden" name="outletId" value="<?= $databr['BRANCH_ID']; ?>">
                                        <button type="submit" class="btn btn-outline-success">
                                            Cetak Laporan Proyek Selesai
                                        </button>
                                    </form>
                                </div>
                                <?php 
                                }
                                ?>
                            </div>
                            <!-- tabel 2 -->
                            <div class="row mt-2">
                                <div class="col-12">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                    <a class="nav-link active" id="proyek-aktif-menu" data-toggle="pill" href="#proyek-aktif" role="tab" aria-controls="custom-content-above-home" aria-selected="true">Proyek Aktif</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link" id="proyek-selesai-menu" data-toggle="pill" href="#proyek-selesai" role="tab" aria-controls="custom-content-above-messages" aria-selected="false">Proyek Selesai</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="custom-content-above-tabContent">
                                    <div class="tab-pane fade show active" id="proyek-aktif" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
                                        <table class="table table-responsive table-bordered mt-2" style="width:100% ">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20rem;">Nama Proyek</th>
                                                    <th colspan="2" class="text-right" style="width: 30rem;">Pengajuan</th>
                                                    <th colspan="2" class="text-right" style="width: 30rem;" >Pengeluaran</th>
                                                    <th class="text-center" style="width: 4rem;">Print</th>
                                                    <th class="text-center" style="width: 4rem;">Edit</th>
                                                    <th class="text-center" style="width: 4rem;">#</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                
                                                foreach($all as $data):
                                                ?>
                                                <tr>
                                                    <td style="width: 20rem;"><?= $data['PR_NAME'] ?></td>
                                                    <td colspan="2" class="text-right" style="width: 30rem;"><?= number_format($data['PR_TOTAL']) ?></td>
                                                    <td colspan="2" class="text-right" style="width: 30rem;"><?= number_format($data['PR_PAID_TOTAL']) ?></td>
                                                    <td class="text-center" style="width: 4rem;">
                                                        <span data-toggle="tooltip" data-placement="top" title="Cetak Laporan Proyek">
                                                            <form role="form" action="<?php echo base_url().'Laporanproyek'?>" method="POST" enctype="multipart/form-data" target="_blank">
                                                                <input type="hidden" name="printId" value="<?= $data['PR_ID'] ?>">
                                                                <button type="submit" class="btn btn-default">
                                                                <i class="fas fa-sm fa-print"></i>
                                                                </button>
                                                            </form>
                                                        </span>
                                                    </td>
                                                    <td class="text-center" style="width: 4rem;">
                                                        <span data-toggle="tooltip" data-placement="top" title="Edit Data">
                                                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-update-<?= str_replace('/','',$data['PR_ID']); ?>">
                                                            <i class="fas fa-edit"></i>
                                                            </button>
                                                        </span>
                                                    </td>
                                                    <td class="text-center" style="width: 4rem;">
                                                    <?php
                                                        if (empty($data['DETAIL']) && empty($data['DETAIL_REAL']) && $data['PR_SUB_EMP'] == $this->session->userdata('EMP_ID')) {
                                                        ?>
                                                        <span data-toggle="tooltip" data-placement="top" title="Hapus Data">
                                                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-delete-<?= str_replace('/','',$data['PR_ID']) ?>">
                                                            <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </span>
                                                        <?php
                                                        }else{
                                                        ?>
                                                        <span data-toggle="tooltip" data-placement="top" title="Tampilkan Detail">
                                                            <button type="button" class="btn btn-default" data-toggle="collapse" data-target=".data-<?= str_replace('/','',$data['PR_ID']) ?>">
                                                            <i class="fas fa-search-plus"></i>
                                                            </button>
                                                        </span>
                                                        <?php 
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <!-- modal Delete Project-->
                                                <div class="modal fade" id="modal-delete-<?= str_replace('/','',$data['PR_ID']) ?>">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                        <form role="form" action="<?php echo base_url().'Project/DeleteProject'?>" method="POST" enctype="multipart/form-data">
                                                        <div class="modal-header" style="background-color:#d9534f;">
                                                            <h5 class="modal-title" style="color:white"> <strong>Delete - <?= $data['PR_NAME'] ?></strong></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label>Nama Proyek</label>
                                                                    <input type="text" name="delNama" class="form-control" value="<?= $data['PR_NAME'];?>" readonly>
                                                                    <input type="hidden" name="delId" class="form-control" value="<?= $data['PR_ID'];?>" readonly>
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
                                                <!-- modal Update -->
                                                <div class="modal fade" id="modal-update-<?= str_replace('/','',$data['PR_ID']); ?>">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                        <div class="modal-header" style="background-color:#5cb85c;">
                                                            <h5 class="modal-title" style="color:white"> <strong>Proyek <?= $data['PR_NAME']?></strong></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                        <div class="row">
                                                                <div class="col-12">
                                                                    <div class="card card-success card-outline card-outline-tabs">
                                                                        <div class="card-header p-0 border-bottom-0">
                                                                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                                                                <li class="nav-item">
                                                                                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#summary-<?= str_replace('/','',$data['PR_ID']); ?>" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">
                                                                                    Summary
                                                                                    </a>
                                                                                </li>
                                                                                <?php
                                                                                $allowAdd = array('DP/002','DP/006','DP/007');
                                                                                $allowStat = array('3','4');
                                                                                if(in_array($this->session->userdata('DEPART_ID'), $allowAdd) && in_array($this->session->userdata('LEAD_STATUS'), $allowStat))
                                                                                {
                                                                                ?>
                                                                                <li class="nav-item">
                                                                                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#detail-<?= str_replace('/','',$data['PR_ID']); ?>" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">
                                                                                    Detail Proyek
                                                                                    </a>
                                                                                </li>
                                                                                <?php 
                                                                                }elseif($this->session->userdata('DEPART_ID') == 'DP/003'){ 
                                                                                ?>
                                                                                <li class="nav-item">
                                                                                    <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#real-<?= str_replace('/','',$data['PR_ID']); ?>" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">
                                                                                    Pengeluaran
                                                                                    </a>
                                                                                </li>
                                                                                <?php 
                                                                                }
                                                                                if($this->session->userdata('EMP_ID') == $data['PR_SUB_EMP']){
                                                                                    ?>
                                                                                    <li class="nav-item">
                                                                                        <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#close-<?= str_replace('/','',$data['PR_ID']); ?>" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">
                                                                                        Tutup Proyek
                                                                                        </a>
                                                                                    </li>
                                                                                    <?php
                                                                                } 
                                                                                ?>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                                                                <div class="tab-pane fade active show" id="summary-<?= str_replace('/','',$data['PR_ID']); ?>" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                                                                    <form role="form" action="<?php echo base_url().'Project/AddDetail'?>" method="POST" enctype="multipart/form-data">
                                                                                    <div class="row">
                                                                                        <div class="col-12">
                                                                                            <label>Proyek</label>
                                                                                            <input type="text" name="insEmp" class="form-control" value="<?= $data['PR_NAME'];?>" readonly>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-6">
                                                                                            <label>Tgl Pengajuan</label>
                                                                                            <input type="text" name="insTgl" class="form-control" value="<?= date_format(date_create($data['PR_SUB_DATE']),"Y-m-d");?>" readonly>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <label>Last Update</label>
                                                                                            <input type="text" name="insTgl" class="form-control" value="<?= date_format(date_create($data['PR_LAST_UPDATE']),"Y-m-d");?>" readonly>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row mt-2">
                                                                                        <div class="col-6">
                                                                                            <label>Nama Pengaju</label>
                                                                                            <?php 
                                                                                            $arr_emp = array(
                                                                                                'EMP_ID' => $data['PR_SUB_EMP'],
                                                                                            );
                                                                                            $dataemp = $this->Model_online->findSingleDataWhere($arr_emp,'m_employee');
                                                                                            ?>
                                                                                            <input type="text" name="insEmpName" class="form-control" value="<?= $dataemp['EMP_FULL_NAME'];?>" readonly>
                                                                                            <input type="hidden" name="insEmp" class="form-control" value="<?= $data['PR_SUB_EMP'];?>" readonly>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <label>Total Proyek</label>
                                                                                            <input type="text" name="insTgl" class="form-control" value="<?= number_format($data['PR_TOTAL']);?>" readonly>
                                                                                        </div>
                                                                                    </div>
                                                                                    </form>
                                                                                </div>
                                                                                <?php 
                                                                                if(in_array($this->session->userdata('DEPART_ID'), $allowAdd) && in_array($this->session->userdata('LEAD_STATUS'), $allowStat))
                                                                                {
                                                                                ?>
                                                                                <div class="tab-pane fade" id="detail-<?= str_replace('/','',$data['PR_ID']); ?>" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                                                                                    <form role="form" action="<?php echo base_url().'Project/AddDetail'?>" method="POST" enctype="multipart/form-data">
                                                                                        <div class="row">
                                                                                            <div class="col-12">
                                                                                                <label>Keterangan</label>
                                                                                                <input type="text" name="insDtItem" class="form-control" required autocomplete="off">
                                                                                                <input type="hidden" name="insParId" value="<?= $data['PR_ID'] ?>" class="form-control" required autocomplete="off">
                                                                                                <input type="hidden" name="insBrCode" class="form-control" value="<?= $databr['BRANCH_CODE']; ?>" readonly>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row mt-2">
                                                                                            <div class="col-4">
                                                                                                <label>Quantity</label>
                                                                                                <input type="number" min="1" value="1" name="insQty" class="form-control" required>
                                                                                            </div>
                                                                                            <div class="col-8">
                                                                                                <label>Harga Satuan / Nominal</label>
                                                                                                <input type="text" name="insValue" class="form-control money" placeholder="Masukkan Nominal" autocomplete="off" required>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row mt-3">
                                                                                            <div class="col-12">
                                                                                                <button type="submit" class="btn btn-block btn-success"> <strong>Tambahkan</strong> </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                                <?php
                                                                                }elseif($this->session->userdata('DEPART_ID') == 'DP/003'){ 
                                                                                ?>
                                                                                <div class="tab-pane fade" id="real-<?= str_replace('/','',$data['PR_ID']); ?>" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
                                                                                    <form role="form" action="<?php echo base_url().'Project/AddReal'?>" method="POST" enctype="multipart/form-data">
                                                                                        <div class="row">
                                                                                            <div class="col-12">
                                                                                                <label>Keterangan</label>
                                                                                                <input type="text" name="insRlItem" class="form-control" required autocomplete="off">
                                                                                                <input type="hidden" name="insParId" value="<?= $data['PR_ID'] ?>" class="form-control" required autocomplete="off">
                                                                                                <input type="hidden" name="insBrCode" class="form-control" value="<?= $databr['BRANCH_CODE']; ?>" readonly>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row mt-2">
                                                                                            <div class="col-6">
                                                                                                <label>Nominal</label>
                                                                                                <input type="text" name="insRlValue" class="form-control money" placeholder="Masukkan Nominal" autocomplete="off" required>
                                                                                            </div>
                                                                                            <div class="col-6">
                                                                                                <div class="form-group">
                                                                                                    <label for="exampleInputFile">Lampiran</label>
                                                                                                    <div class="input-group">
                                                                                                        <div class="custom-file">
                                                                                                        <input type="file" name="insRlFoto" class="custom-file-input" id="exampleInputFile" required>
                                                                                                        <label class="custom-file-label" for="exampleInputFile">Pilih File</label>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row mt-3">
                                                                                            <div class="col-12">
                                                                                                <button type="submit" class="btn btn-block btn-success"> <strong>Tambahkan</strong> </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                                <?php 
                                                                                }
                                                                                if($this->session->userdata('EMP_ID') == $data['PR_SUB_EMP']){
                                                                                ?>
                                                                                <div class="tab-pane fade" id="close-<?= str_replace('/','',$data['PR_ID']); ?>" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
                                                                                    <?php
                                                                                    if($data['PR_PAID_TOTAL'] < $data['PR_TOTAL']){
                                                                                    ?>
                                                                                        <div class="alert alert-warning alert-dismissible">
                                                                                            <h5><i class="icon fas fa-exclamation-triangle"></i></i> Perhatian !</h5>
                                                                                            Total Pengeluaran Proyek Tercatat Lebih Kecil Dari Total Permintaan Proyek, 
                                                                                            Harap Cek Kembali Sebelum Menutup Proyek Ini
                                                                                        </div>
                                                                                    <?php
                                                                                    }elseif($data['PR_PAID_TOTAL'] > $data['PR_TOTAL']){
                                                                                    ?>
                                                                                        <div class="alert alert-danger alert-dismissible">
                                                                                            <h5><i class="icon fas fa-ban"></i> Perhatian !</h5>
                                                                                            Total Pengeluaran Proyek Tercatat Lebih Besar Dari Total Permintaan Proyek, 
                                                                                            Harap Cek Kembali Sebelum Menutup Proyek Ini
                                                                                        </div>
                                                                                    <?php    
                                                                                    }elseif($data['PR_PAID_TOTAL'] == $data['PR_TOTAL']){
                                                                                    ?>
                                                                                        <div class="alert alert-success alert-dismissible">
                                                                                            <h5><i class="icon fas fa-check"></i></i> Perhatian !</h5>
                                                                                            Total Pengeluaran Proyek Tercatat Sesuai Dengan Total Permintaan Proyek.
                                                                                        </div>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                    <form role="form" action="<?php echo base_url().'Project/CloseProject'?>" method="POST" enctype="multipart/form-data">
                                                                                        <div class="row">
                                                                                            <div class="col-12">
                                                                                                <label>Keterangan</label>
                                                                                                <input type="text" name="clName" value="<?= $data['PR_NAME'] ?>" class="form-control" readonly>
                                                                                                <input type="hidden" name="clId" value="<?= $data['PR_ID'] ?>" class="form-control" required autocomplete="off">
                                                                                                <input type="hidden" name="clIdEmp" value="<?= $this->session->userdata('EMP_ID') ?>" class="form-control" required autocomplete="off">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row mt-2">
                                                                                            <div class="col-6">
                                                                                                <label>Total Pengajuan</label>
                                                                                                <input type="text" name="clRlValue" value="<?= $data['PR_TOTAL'] ?>" class="form-control money" placeholder="Masukkan Nominal" autocomplete="off" readonly>
                                                                                            </div>
                                                                                            <div class="col-6">
                                                                                            <label>Total Pengeluaran</label>
                                                                                                <input type="text" name="clRlValue" value="<?= $data['PR_PAID_TOTAL'] ?>" class="form-control money" placeholder="Masukkan Nominal" autocomplete="off" readonly>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row mt-3">
                                                                                            <div class="col-12">
                                                                                                <button type="submit" class="btn btn-block btn-danger"> <strong>Tutup</strong> </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                                <?php 
                                                                                } 
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                        <!-- /.card -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <tr class="collapse data-<?= str_replace('/','',$data['PR_ID']) ?>">
                                                    <th class="table-secondary" style="width: 20rem;"></th>
                                                    <th class="table-primary" style="width: 20rem;">List Pengajuan</th>
                                                    <th class="table-primary text-right" style="width: 10rem;">Nominal</th>
                                                    <th class="table-success" style="width: 20rem;">List Pengeluaran</th>
                                                    <th class="table-success text-right" style="width: 10rem;">Nominal</th>
                                                    <th class="table-success text-center" style="width: 4rem;"><i class="fas fa-images"></i></th>
                                                    <th class="table-success text-center" style="width: 4rem;"><i class="fas fa-edit"></i></th>
                                                    <th class="table-success text-center" style="width: 4rem;">#</th>
                                                </tr>
                                                <?php 
                                                    $numdetail = count($data['DETAIL']);
                                                    $numpaid = count($data['DETAIL_REAL']);
                                                    $detail = $data['DETAIL'];
                                                    $real = $data['DETAIL_REAL'];
                                                    $terbaik = '';
                                                    if($numdetail>$numpaid){
                                                        $terbaik = $numdetail;
                                                    }else{
                                                        $terbaik = $numpaid;
                                                    }
                                                    for($i=0;$i< $terbaik;$i++){
                                                        ?>
                                                        <tr class="collapse data-<?= str_replace('/','',$data['PR_ID']) ?>">
                                                            <td class="table-secondary" style="width: 20rem;"></td>
                                                            <td class="align-middle" style="width: 20rem;"><?= empty($data['DETAIL'][$i]['DT_PRS_ITEM']) ? '' : $data['DETAIL'][$i]['DT_PRS_ITEM'] ?></td>
                                                            <td class="align-middle text-right" style="width: 10rem;"><?= empty($data['DETAIL'][$i]['DT_PRS_TOTAL']) ? '' : number_format($data['DETAIL'][$i]['DT_PRS_TOTAL'])?></td>
                                                            <td class="align-middle" style="width: 20rem;"><?= empty($data['DETAIL_REAL'][$i]['PRR_NOTE']) ? '' : $data['DETAIL_REAL'][$i]['PRR_NOTE'] ?></td>
                                                            <td class="align-middle text-right" style="width: 10rem;"><?= empty($data['DETAIL_REAL'][$i]['PRR_VALUE']) ? '' : number_format($data['DETAIL_REAL'][$i]['PRR_VALUE']) ?></td>
                                                            <td class="align-middle text-center" style="width: 2rem;">
                                                                    <?php 
                                                                    if(empty($data['DETAIL_REAL'][$i]['PRR_PHOTO'])){
                                                                        ?>
                                                                            
                                                                        <?php
                                                                    }else{
                                                                        ?>
                                                                        <span data-toggle="tooltip" data-placement="top" title="Lihat Foto">
                                                                            <a href="<?php echo base_url()?>assets/doc-proyek/<?= $data['DETAIL_REAL'][$i]['PRR_PHOTO']; ?>" target="_blank">
                                                                                <i class="fas fa-image"></i>
                                                                            </a>
                                                                        </span>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                            </td>
                                                            <?php 
                                                            $sqlbayar = "select *
                                                            from tr_project_real
                                                            where PR_ID = '".$data['PR_ID']."'
                                                            order by PRR_SUB_DATE DESC
                                                            LIMIT 1";
                                                            $databayar = $this->db->query($sqlbayar)->row();
                                                            $fixbayar = '1970-01-01 00:00:00';
                                                            if(empty($databayar)){
                                                                $fixbayar = '1970-01-01 00:00:00';
                                                            }else{
                                                                $fixbayar = $databayar->PRR_SUB_DATE;
                                                            }
                                                            // $tanggalbayar = '1970-01-01 00:00:00';
                                                            // if(empty($data['DETAIL_REAL'][$i]['PRR_ID'])){
                                                            //     $tanggalbayar = '1970-01-01 00:00:00';
                                                            // }else{
                                                            //     $tanggalbayar = $data['DETAIL_REAL'][$i]['PRR_SUB_DATE'];
                                                            // }
                                                            $datebyr = new DateTime($fixbayar);
                                                            $dateaju = new DateTime($data['DETAIL'][$i]['DT_PRS_UP_DATE']);
                                                            
                                                            if($data['DETAIL'][$i]['EMP_ID'] == $this->session->userdata('EMP_ID') && !empty($data['DETAIL'][$i]['DT_PRS_ITEM']) && $dateaju>$datebyr){
                                                            ?>
                                                                <td class="align-middle text-center" style="width: 2rem;">
                                                                    <span data-toggle="tooltip" data-placement="top" title="Edit Data">
                                                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-edit-<?= str_replace('/','',$data['DETAIL'][$i]['DT_PRS_ID']) ?>">
                                                                        <i class="fas fa-edit"></i>
                                                                        </button>
                                                                    </span>
                                                                </td>
                                                                <td class="align-middle text-center" style="width: 2rem;">
                                                                    <span data-toggle="tooltip" data-placement="top" title="Hapus Data">
                                                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-delete-<?= str_replace('/','',$data['DETAIL'][$i]['DT_PRS_ID']) ?>">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                        </button>
                                                                    </span>
                                                                </td>
                                                            <?php
                                                            }elseif($this->session->userdata('DEPART_ID') == 'DP/003' && !empty($data['DETAIL_REAL'][$i]['PRR_VALUE'])){
                                                                ?>
                                                                <td class="align-middle text-center" style="width: 2rem;"> 
                                                                    <span data-toggle="tooltip" data-placement="top" title="Hapus Data">
                                                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-fa-delete-<?= str_replace('/','',$data['DETAIL_REAL'][$i]['PRR_ID']) ?>">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                        </button>
                                                                    </span>
                                                                </td>
                                                                <td class="align-middle text-center" style="width: 2rem;">
                                                                    <span data-toggle="tooltip" data-placement="top" title="Edit Data">
                                                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-fa-edit-<?= str_replace('/','',$data['DETAIL_REAL'][$i]['PRR_ID']) ?>">
                                                                        <i class="fas fa-edit"></i>
                                                                        </button>
                                                                    </span>
                                                                </td>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <td class="align-middle text-center" style="width: 2rem;"> 
                                                                </td>
                                                                <td class="align-middle text-center" style="width: 2rem;">
                                                                </td>
                                                                <?php
                                                            }
                                                            ?>
                                                        </tr>
                                                        <?php 
                                                        if($data['DETAIL'][$i]['EMP_ID'] == $this->session->userdata('EMP_ID') && !empty($data['DETAIL'][$i]['DT_PRS_ITEM']))
                                                        {
                                                        ?>
                                                            <!-- modal Update Detail Project-->
                                                            <div class="modal fade" id="modal-edit-<?= str_replace('/','',$data['DETAIL'][$i]['DT_PRS_ID']) ?>">
                                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                    <form role="form" action="<?php echo base_url().'Project/UpdateDtProject'?>" method="POST" enctype="multipart/form-data">
                                                                    <div class="modal-header" style="background-color:#0275d8;">
                                                                        <h5 class="modal-title" style="color:white"> <strong>Edit - <?= $data['DETAIL'][$i]['DT_PRS_ITEM'] ?></strong></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <label>Keterangan</label>
                                                                                <input type="text" name="upNama" class="form-control" value="<?= $data['DETAIL'][$i]['DT_PRS_ITEM'];?>" required>
                                                                                <input type="hidden" name="upId" class="form-control" value="<?= $data['DETAIL'][$i]['DT_PRS_ID'];?>" required>
                                                                                <input type="hidden" name="upParId" class="form-control" value="<?= $data['PR_ID'];?>" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-6">
                                                                                <label>Quantity</label>
                                                                                <input type="number" name="upQty" min="1" class="form-control" value="<?= $data['DETAIL'][$i]['DT_PRS_QTY'];?>" required>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <label>Harga Satuan / Nominal</label>
                                                                                <input type="text" name="upValue" min="1" class="form-control money" value="<?= $data['DETAIL'][$i]['DT_PRS_VALUE'];?>" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary"> <strong>Tambahkan</strong> </button>
                                                                    </div>
                                                                    </form>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            <!-- modal Delete Detail Project-->
                                                            <div class="modal fade" id="modal-delete-<?= str_replace('/','',$data['DETAIL'][$i]['DT_PRS_ID']) ?>">
                                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                    <form role="form" action="<?php echo base_url().'Project/DeleteDtProject'?>" method="POST" enctype="multipart/form-data">
                                                                    <div class="modal-header" style="background-color:#d9534f;">
                                                                        <h5 class="modal-title" style="color:white"> <strong>Delete - <?= $data['DETAIL'][$i]['DT_PRS_ITEM'] ?></strong></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <label>Keterangan</label>
                                                                                <input type="text" name="delNama" class="form-control" value="<?= $data['DETAIL'][$i]['DT_PRS_ITEM'];?>" readonly>
                                                                                <input type="hidden" name="delId" class="form-control" value="<?= $data['DETAIL'][$i]['DT_PRS_ID'];?>" required>
                                                                                <input type="hidden" name="delParId" class="form-control" value="<?= $data['PR_ID'];?>" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-6">
                                                                                <label>Quantity</label>
                                                                                <input type="number" name="delQty" min="1" class="form-control" value="<?= $data['DETAIL'][$i]['DT_PRS_QTY'];?>" readonly>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <label>Harga Satuan / Nominal</label>
                                                                                <input type="text" name="delValue" min="1" class="form-control money" value="<?= $data['DETAIL'][$i]['DT_PRS_VALUE'];?>" readonly>
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
                                                        <?php
                                                        }elseif($this->session->userdata('DEPART_ID') == 'DP/003' && !empty($data['DETAIL_REAL'][$i]['PRR_VALUE']))
                                                        {
                                                        ?>
                                                            <!-- modal Update Detail Project-->
                                                            <div class="modal fade" id="modal-fa-edit-<?= str_replace('/','',$data['DETAIL_REAL'][$i]['PRR_ID']) ?>">
                                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                    <form role="form" action="<?php echo base_url().'Project/UpdateRealisasi'?>" method="POST" enctype="multipart/form-data">
                                                                    <div class="modal-header" style="background-color:#0275d8;">
                                                                        <h5 class="modal-title" style="color:white"><strong>Edit - <?= $data['DETAIL_REAL'][$i]['PRR_NOTE'] ?></strong></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <label>Keterangan</label>
                                                                                <input type="text" name="upNama" class="form-control" value="<?= $data['DETAIL_REAL'][$i]['PRR_NOTE'];?>" required>
                                                                                <input type="hidden" name="upId" class="form-control" value="<?= $data['DETAIL_REAL'][$i]['PRR_ID'];?>" required>
                                                                                <input type="hidden" name="upParId" class="form-control" value="<?= $data['PR_ID'];?>" required>            
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mt-2">
                                                                            <div class="col-12">
                                                                                <label>Nominal</label>
                                                                                <input type="text" name="upValue" class="form-control money" value="<?= number_format($data['DETAIL_REAL'][$i]['PRR_VALUE']);?>" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mt-2">
                                                                            <div class="col-12">
                                                                                <label>Lampiran</label>
                                                                                <div class="input-group">
                                                                                    <div class="custom-file">
                                                                                    <input type="file" name="upFoto" class="custom-file-input" id="exampleInputFile">
                                                                                    <label class="custom-file-label" for="exampleInputFile">Pilih File</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary"> <strong>Tambahkan</strong> </button>
                                                                    </div>
                                                                    </form>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            <!-- modal Delete Detail Project-->
                                                            <div class="modal fade" id="modal-fa-delete-<?= str_replace('/','',$data['DETAIL_REAL'][$i]['PRR_ID']) ?>">
                                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                    <form role="form" action="<?php echo base_url().'Project/DeleteRealisasi'?>" method="POST" enctype="multipart/form-data">
                                                                    <div class="modal-header" style="background-color:#d9534f;">
                                                                        <h5 class="modal-title" style="color:white"> <strong>Delete - <?= $data['DETAIL_REAL'][$i]['PRR_NOTE'] ?></strong></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                    <div class="row">
                                                                            <div class="col-12">
                                                                                <label>Keterangan</label>
                                                                                <input type="text" name="delNama" class="form-control" value="<?= $data['DETAIL_REAL'][$i]['PRR_NOTE'];?>" readonly>
                                                                                <input type="hidden" name="delId" class="form-control" value="<?= $data['DETAIL_REAL'][$i]['PRR_ID'];?>" readonly>
                                                                                <input type="hidden" name="delParId" class="form-control" value="<?= $data['PR_ID'];?>" readonly>            
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mt-2">
                                                                            <div class="col-12">
                                                                                <label>Nominal</label>
                                                                                <input type="text" name="delValue" class="form-control money" value="<?= number_format($data['DETAIL_REAL'][$i]['PRR_VALUE']);?>" readonly>
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
                                                        <?php 
                                                        }
                                                        ?>
                                                        <?php
                                                    }
                                                    ?>
                                                <?php
                                                endforeach;
                                                ?>
                                                <tr class="bg-success">
                                                    <th class="align-middle" style="width: 20rem;">Grand Total</th>
                                                    <th colspan="2" class="text-right align-middle" style="width: 30rem;"><?= is_null($allother) ? '0' : 'Rp. '.number_format($allother->TOTAL_AJU) ?></th>
                                                    <th colspan="2" class="text-right align-middle" style="width: 30rem;" ><?= is_null($allother) ? '0' : 'Rp. '.number_format($allother->TOTAL_BAYAR) ?></th>
                                                    <th class="text-center align-middle" style="width: 4rem;">
                                                        <span data-toggle="tooltip" data-placement="top" title="Cetak Laporan Outlet">
                                                            <form role="form" action="<?php echo base_url().'Laporanoutlet'?>" method="POST" enctype="multipart/form-data" target="_blank">
                                                                <input type="hidden" name="outletId" value="<?= $databr['BRANCH_ID']; ?>">
                                                                <button type="submit" class="btn btn-success">
                                                                    <i class="fas fa-sm fa-print"></i>
                                                                </button>
                                                            </form>
                                                        </span>
                                                    </th>
                                                    <th class="text-center align-middle" style="width: 4rem;">#</th>
                                                    <th class="text-center align-middle" style="width: 4rem;">#</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade show" id="proyek-selesai" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
                                        <table class="table table-responsive table-bordered mt-2" style="width:100% ">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20rem;">Nama Proyek</th>
                                                    <th colspan="2" class="text-right" style="width: 30rem;">Pengajuan</th>
                                                    <th colspan="2" class="text-right" style="width: 30rem;" >Pengeluaran</th>
                                                    <th class="text-center" style="width: 4rem;">Print</th>
                                                    <th class="text-center" style="width: 4rem;">#</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                
                                                foreach($alldone as $datadone):
                                                ?>
                                                <tr>
                                                    <td style="width: 20rem;"><?= $datadone['PR_NAME'] ?></td>
                                                    <td colspan="2" class="text-right" style="width: 30rem;"><?= number_format($datadone['PR_TOTAL']) ?></td>
                                                    <td colspan="2" class="text-right" style="width: 30rem;"><?= number_format($datadone['PR_PAID_TOTAL']) ?></td>
                                                    <td class="text-center" style="width: 4rem;">
                                                        <span data-toggle="tooltip" data-placement="top" title="Cetak Laporan Proyek">
                                                            <form role="form" action="<?php echo base_url().'Laporanproyek'?>" method="POST" enctype="multipart/form-data" target="_blank">
                                                                <input type="hidden" name="printId" value="<?= $datadone['PR_ID'] ?>">
                                                                <button type="submit" class="btn btn-default">
                                                                <i class="fas fa-sm fa-print"></i>
                                                                </button>
                                                            </form>
                                                        </span>
                                                    </td>
                                                    <td class="text-center" style="width: 4rem;">
                                                        <span data-toggle="tooltip" data-placement="top" title="Tampilkan Detail">
                                                            <button type="button" class="btn btn-default" data-toggle="collapse" data-target=".data-<?= str_replace('/','',$datadone['PR_ID']) ?>">
                                                            <i class="fas fa-search-plus"></i>
                                                            </button>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr class="collapse data-<?= str_replace('/','',$datadone['PR_ID']) ?>">
                                                    <th class="table-secondary" style="width: 20rem;"></th>
                                                    <th class="table-primary" style="width: 20rem;">List Pengajuan</th>
                                                    <th class="table-primary text-right" style="width: 10rem;">Nominal</th>
                                                    <th class="table-success" style="width: 20rem;">List Pengeluaran</th>
                                                    <th class="table-success text-right" style="width: 10rem;">Nominal</th>
                                                    <th class="table-success text-center" style="width: 4rem;"><i class="fas fa-images"></i></th>
                                                    <th class="table-success text-center" style="width: 4rem;">#</th>
                                                </tr>
                                                <?php 
                                                    $numdetail = count($datadone['DETAIL']);
                                                    $numpaid = count($datadone['DETAIL_REAL']);
                                                    $detail = $datadone['DETAIL'];
                                                    $real = $datadone['DETAIL_REAL'];
                                                    $terbaik = '';
                                                    if($numdetail>$numpaid){
                                                        $terbaik = $numdetail;
                                                    }else{
                                                        $terbaik = $numpaid;
                                                    }
                                                    for($i=0;$i< $terbaik;$i++){
                                                        ?>
                                                        <tr class="collapse data-<?= str_replace('/','',$datadone['PR_ID']) ?>">
                                                            <td class="table-secondary" style="width: 20rem;"></td>
                                                            <td class="align-middle" style="width: 20rem;"><?= empty($datadone['DETAIL'][$i]['DT_PRS_ITEM']) ? '' : $datadone['DETAIL'][$i]['DT_PRS_ITEM'] ?></td>
                                                            <td class="align-middle text-right" style="width: 10rem;"><?= empty($datadone['DETAIL'][$i]['DT_PRS_TOTAL']) ? '' : number_format($datadone['DETAIL'][$i]['DT_PRS_TOTAL'])?></td>
                                                            <td class="align-middle" style="width: 20rem;"><?= empty($datadone['DETAIL_REAL'][$i]['PRR_NOTE']) ? '' : $datadone['DETAIL_REAL'][$i]['PRR_NOTE'] ?></td>
                                                            <td class="align-middle text-right" style="width: 10rem;"><?= empty($datadone['DETAIL_REAL'][$i]['PRR_VALUE']) ? '' : number_format($datadone['DETAIL_REAL'][$i]['PRR_VALUE']) ?></td>
                                                            <td class="align-middle text-center" style="width: 2rem;">
                                                                    <?php 
                                                                    if(empty($datadone['DETAIL_REAL'][$i]['PRR_PHOTO'])){
                                                                        ?>
                                                                            
                                                                        <?php
                                                                    }else{
                                                                        ?>
                                                                        <span data-toggle="tooltip" data-placement="top" title="Lihat Foto">
                                                                            <a href="<?php echo base_url()?>assets/doc-proyek/<?= $datadone['DETAIL_REAL'][$i]['PRR_PHOTO']; ?>" target="_blank">
                                                                                <i class="fas fa-image"></i>
                                                                            </a>
                                                                        </span>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                            </td>
                                                            <td class="align-middle text-center" style="width: 2rem;">
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                <?php
                                                endforeach;
                                                ?>
                                                <tr class="bg-success">
                                                    <th class="align-middle" style="width: 20rem;">Grand Total</th>
                                                    <th colspan="2" class="text-right align-middle" style="width: 30rem;"><?= is_null($allotherdone) ? '0' : 'Rp. '.number_format($allotherdone->TOTAL_AJU);?></th>
                                                    <th colspan="2" class="text-right align-middle" style="width: 30rem;" ><?= is_null($allotherdone) ? '0' : 'Rp. '.number_format($allotherdone->TOTAL_BAYAR);?></th>
                                                    <th class="text-center align-middle" style="width: 4rem;">
                                                        <span data-toggle="tooltip" data-placement="top" title="Cetak Laporan Outlet">
                                                            <form role="form" action="<?php echo base_url().'Laporanoutletdone'?>" method="POST" enctype="multipart/form-data" target="_blank">
                                                                <input type="hidden" name="outletId" value="<?= $databr['BRANCH_ID']; ?>">
                                                                <button type="submit" class="btn btn-success">
                                                                    <i class="fas fa-sm fa-print"></i>
                                                                </button>
                                                            </form>
                                                        </span>
                                                    </th>
                                                    <th class="text-center align-middle" style="width: 4rem;">#</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
        
       
    </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->