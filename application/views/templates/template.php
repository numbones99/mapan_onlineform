<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Online Form</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Online Form</a></li>
              <li class="breadcrumb-item active">Menu</li>
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
      
      <?php
      //cek pass dengan session id login jika 11111 maka muncul
      $idEmp = $this->session->userdata('EMP_ID');
      $whereEmp = array(
        'EMP_ID' => $idEmp,
      );
      $dataEmp = $this->Model_online->findSingleDataWhere($whereEmp,'m_employee');
      $passLama = $dataEmp['EMP_PASS'];
      $empStat = $dataEmp['EMP_STATUS'];
      if($passLama == '11111' || $empStat=='99'){
      ?>
      <div class="row">
        <div class="col-lg-6 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
            <h3>Ganti Password</h3>
            <p>Ganti Password Anda Terlebih Dahulu Untuk Menggunakan Aplikasi</p>
            </div>
            <div class="icon">
            <i class="fas fa-file"></i>
            </div>
            <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modal-single">
            Ganti Password <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>  
        </div>
      </div>
      <?php
      }else{
            
      ?>
      <?php
      if(($this->session->userdata('BRANCH_ID')=='BR/0009' || $this->session->userdata('BRANCH_ID')=='BR/0022') && $this->session->userdata('EMP_ID')!='EMP/006/006'){
      ?>
      <div class="row">
        <div class="col-lg-12 col-12">
          <div class="card card-outline card-success">
              <div class="card-header">
                <h3 class="card-title">Finance & Accounting Online Form</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="small-box bg-success">
                      <div class="inner">
                        <h4> <strong>Reimburse/Claim/Pengeluaran Oprs</strong> </h4>
                        <p>Pengajuan Pengeluaran Dana</p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-file"></i>
                      </div>
                      <a href="<?php echo base_url().'Reimbursement'?>" class="small-box-footer">
                      Ke Halaman Reimburse <i class="fas fa-arrow-circle-right"></i>
                      </a>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="small-box bg-warning">
                      <div class="inner">
                        <h4> <strong>Kasbon</strong> </h4>
                        <p>Pengajuan Kasbon Operasional</p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-hand-holding-usd"></i>
                      </div>
                      <a href="<?php echo base_url().'Kasbon'?>" class="small-box-footer">
                      Ke Halaman Kasbon <i class="fas fa-arrow-circle-right"></i>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="small-box bg-primary">
                      <div class="inner">
                        <h4> <strong>Pengeluaran Proyek</strong> </h4>
                        <p>Menu Pengeluaran Proyek</p>
                      </div>
                      <div class="icon">
                      <i class="fas fa-hard-hat"></i>
                      </div>
                      <a href="<?php echo base_url().'Project'?>" class="small-box-footer">
                      Ke Halaman Proyek <i class="fas fa-arrow-circle-right"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
          </div>
            <!-- /.card -->
        </div>
      </div>
      <?php
      if($this->session->userdata('LEAD_STATUS')>3 || $this->session->userdata('DEPART_ID')=='DP/006' || $this->session->userdata('EMP_ID') == 'EMP/007/002'){
      ?>
      <div class="row">
        <div class="col-lg-12 col-12">
          <div class="card card-outline card-info">
              <div class="card-header">
                <h3 class="card-title">Building & Maintenance Online Form</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="small-box bg-info">
                      <div class="inner">
                        <h4> <strong>Perbaikan Aset</strong> </h4>
                        <p>Permintaan Perbaikan Aset</p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-tools"></i>
                      </div>
                      <a href="<?php echo base_url().'Aset'?>" class="small-box-footer">
                      Ke Halaman Perbaikan Aset <i class="fas fa-arrow-circle-right"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
          </div>
            <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-12">
          <div class="card card-outline card-info">
              <div class="card-header">
                <h3 class="card-title">Information & Technology Online Form</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="small-box bg-info">
                      <div class="inner">
                        <h4> <strong>Permintaan / Perbaikan Aset</strong> </h4>
                        <p>Permintaan / Perbaikan Aset</p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-tools"></i>
                      </div>
                      <a href="<?php echo base_url().'Aset'?>" class="small-box-footer">
                      Kembali <i class="fas fa-arrow-circle-right"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
          </div>
            <!-- /.card -->
        </div>
      </div>
      <?php
      }?>
      <?php 
      }else{
      ?>
      <div class="row">
        <div class="col-lg-12 col-12">
          <div class="card card-outline card-info">
              <div class="card-header">
                <h3 class="card-title">Building & Maintenance Online Form</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="small-box bg-info">
                      <div class="inner">
                        <h4> <strong>Perbaikan Aset</strong> </h4>
                        <p>Permintaan Perbaikan Aset</p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-tools"></i>
                      </div>
                      <a href="<?php echo base_url().'Aset'?>" class="small-box-footer">
                      Ke Halaman Perbaikan Aset <i class="fas fa-arrow-circle-right"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
          </div>
            <!-- /.card -->
        </div>
      </div>
      <?php  
      }
      ?>
      <?php 
      }
      ?>
      <!-- modal -->
      <div class="modal fade" id="modal-single">
            <div class="modal-dialog">
            <div class="modal-content">
              <form role="form" action="<?php echo base_url().'Reimbursement/Password'?>" method="POST" enctype="multipart/form-data">
                  <div class="modal-header text-center">
                  <h4 class="modal-title text-center">Pembuatan Password Baru</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="text" name="newPass" class="form-control">
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-warning">Ganti Password</button>
                  </div>
              </form>    
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->