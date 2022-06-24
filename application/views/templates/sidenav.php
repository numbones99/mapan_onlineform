<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- TOP Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
            class="fas fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    
    <a href="#" class="brand-link">
    <img src="<?php echo base_url()?>assets/dist/img/M.png" alt="Mapan Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Online Form</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url()?>assets/dist/img/user1.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?php echo base_url().'Dashboard'?>" class="d-block"><?php echo $this->session->userdata('EMP_FULL_NAME')?></a>
        </div>
      </div>
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        
        <div class="info">
          <a href="<?php echo base_url().'Login/logout'?>" class="d-block">Logout</a>
        </div>
      </div>
      <?php
      //cek pass dengan session id login jika 11111 maka muncul
      $idEmp = $this->session->userdata('EMP_ID');
      $whereEmp = array(
        'EMP_ID' => $idEmp,
      );
      $dataEmp = $this->Model_online->findSingleDataWhere($whereEmp,'m_employee');
      $passLama = $dataEmp['EMP_PASS'];
      $statReset = $dataEmp['EMP_STATUS'];
      if($passLama == '11111' || $statReset == '99'){
      ?>
      
      <?php }else{
        
      ?>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <!-- FA Menu -->
        <?php 
        if(($this->session->userdata('BRANCH_ID')=='BR/0009' || $this->session->userdata('BRANCH_ID')=='BR/0022') && $this->session->userdata('EMP_ID')!='EMP/006/006'){
        ?>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header">Menu Finance & Accounting</li>
          <li class="nav-item has-treeview <?php echo ($this->uri->segment(1) == 'Reimbursement')? ' menu-open':''; ?>">
            <a href="" class="nav-link <?php echo ($this->uri->segment(1) == 'Reimbursement')?' active':''; ?>">
              <i class="nav-icon fas fa-file-signature" aria-hidden="true"></i>
              <p>Reimbusement</p>
              <i class="right fas fa-angle-left"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url().'Reimbursement'?>" class="nav-link <?php echo ($this->uri->segment(1) == 'Reimbursement' && $this->uri->segment(2) != 'Approval' && $this->uri->segment(2) != 'DetailApproval') ?' active' :''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <?php
              //mengecek apakah user yang login memiliki member ?
              $empID = $this->session->userdata('EMP_ID');
              $whereMember = array(
                'EMP_ID_LEADER' => $empID,
              );
              $cekAdaMember = $this->Model_online->countRowWhere('tr_supervision',$whereMember);
              //mengecek apakah user yang login bagian dari FA ?
              $whereFA = array(
                'DEPART_ID' => 'DP/003',
                'EMP_ID' => $empID,
              );
              $cekFA = $this->Model_online->countRowWhere('m_employee',$whereFA);
              //mengecek apakah user yang login bagian dari Direksi ?
              $whereDir = array(
                'DEPART_ID' => 'DP/009',
                'EMP_ID' => $empID,
              );
              $cekDir = $this->Model_online->countRowWhere('m_employee',$whereDir);
              if($cekAdaMember>0 || $cekFA>0 || $cekDir>0){
              ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'Reimbursement/Approval'?>" class="nav-link <?php echo ($this->uri->segment(1) == 'Reimbursement' && $this->uri->segment(2) == 'Approval' || $this->uri->segment(2) == 'DetailApproval' )?' active':''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Approval</p>
                </a>
              </li>
              <?php
              }
              ?>
            </ul>
          </li>
          <li class="nav-item has-treeview <?php echo ($this->uri->segment(1) == 'Kasbon')? ' menu-open':''; ?>">
            <a href="" class="nav-link <?php echo ($this->uri->segment(1) == 'Kasbon')?' active':''; ?>">
              <i class="nav-icon fas fa-file-signature" aria-hidden="true"></i>
              <p>Kasbon</p>
              <i class="right fas fa-angle-left"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url().'Kasbon'?>" class="nav-link <?php echo (($this->uri->segment(1) == 'Kasbon' &&  $this->uri->segment(2) == '') || ($this->uri->segment(1) == 'Kasbon' &&  $this->uri->segment(2) == 'detail') || ($this->uri->segment(1) == 'Kasbon' &&  $this->uri->segment(2) == 'report') || ($this->uri->segment(1) == 'Kasbon' &&  $this->uri->segment(2) == 'dtreport') || ($this->uri->segment(1) == 'Kasbon' &&  $this->uri->segment(2) == 'report')) ?' active' :''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <?php
              if($cekAdaMember>0 || $cekFA>0 || $cekDir>0){
              ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'Kasbon/Approval'?>" class="nav-link <?php echo (($this->uri->segment(1) == 'Kasbon' &&  $this->uri->segment(2) == 'Approval') || ($this->uri->segment(1) == 'Kasbon' &&  $this->uri->segment(2) == 'detailapproval'))?' active':''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Approval Kasbon</p>
                </a>
              </li>
              <?php 
              }
              ?>
              
            </ul>
          </li>
          <li class="nav-item has-treeview <?php echo ($this->uri->segment(1) == 'Project')? ' menu-open':''; ?>">
            <a href="" class="nav-link <?php echo ($this->uri->segment(1) == 'Project')?' active':''; ?>">
              <i class="nav-icon fas fa-file-signature" aria-hidden="true"></i>
              <p>Proyek</p>
              <i class="right fas fa-angle-left"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url("Project")?>" class="nav-link <?php echo ($this->uri->segment(1) == 'Project')?' active':''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
        <!-- /End FA Menu -->
        <?php 
        }
        // pengecualian sementara untuk malang
        if((($this->session->userdata('LEAD_STATUS')=='3' && $this->session->userdata('BRANCH_ID')=='BR/0025') || $this->session->userdata('LEAD_STATUS')=='4' || $this->session->userdata('LEAD_STATUS')=='5' || $this->session->userdata('DEPART_ID')=='DP/006' || $this->session->userdata('EMP_ID') == 'EMP/007/002') && $this->session->userdata('EMP_ID')!='EMP/003/009' ){
        ?>
        <!-- GA Menu -->
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header">Menu Building & Maintenance</li>
          <li class="nav-item has-treeview <?php echo ($this->uri->segment(1) == 'Aset')? ' menu-open':''; ?>">
            <a href="" class="nav-link <?php echo ($this->uri->segment(1) == 'Aset')?' active':''; ?>">
              <i class="nav-icon fas fa-file-signature" aria-hidden="true"></i>
              <p>Perbaikan Aset</p>
              <i class="right fas fa-angle-left"></i>
            </a>
            <ul class="nav nav-treeview">
              <?php
                if($this->session->userdata('LEAD_STATUS')!='2'){
              ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'Aset'?>" class="nav-link <?php echo ($this->uri->segment(1) == 'Aset' && $this->uri->segment(2) != 'approval' && $this->uri->segment(2) != 'DetailApproval' && $this->uri->segment(2) != 'jadwal') ?' active' :''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <?php
                }
              if($this->session->userdata('DEPART_ID')=='DP/006' || $this->session->userdata('BRANCH_ID')=='BR/0022'){
                if($this->session->userdata('LEAD_STATUS')!='2'){
              ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'Aset/approval'?>" class="nav-link <?php echo ($this->uri->segment(1) == 'Aset' && $this->uri->segment(2) == 'approval') ?' active' :''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Approval</p>
                </a>
              </li>
              <?php 
              }
              ?>
              <li class="nav-item">
                <a href="<?php echo base_url().'Aset/jadwal'?>" class="nav-link <?php echo ($this->uri->segment(1) == 'Aset' && $this->uri->segment(2) == 'jadwal') ?' active' :''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jadwal</p>
                </a>
              </li>
              <?php
              }

              ?>
            </ul>
          </li>
          <li class="nav-header">Menu Information & Technology</li>
          <li class="nav-item has-treeview <?php echo ($this->uri->segment(1) == 'Aset')? ' menu-open':''; ?>">
            <a href="" class="nav-link <?php echo ($this->uri->segment(1) == 'Aset')?' active':''; ?>">
              <i class="nav-icon fas fa-file-signature" aria-hidden="true"></i>
              <p>Permintaan / Perbaikan</p>
              <i class="right fas fa-angle-left"></i>
            </a>
            <ul class="nav nav-treeview">
              <?php
                if($this->session->userdata('LEAD_STATUS')!='2'){
                  ?>
                  <li class="nav-item">
                    <a href="<?php echo base_url().'Aset_it'?>" class="nav-link <?php echo ($this->uri->segment(1) == 'Aset' && $this->uri->segment(2) != 'approval' && $this->uri->segment(2) != 'DetailApproval' && $this->uri->segment(2) != 'jadwal') ?' active' :''; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Dashboard</p>
                    </a>
                  </li>
                  <?php
                }
                if($this->session->userdata('DEPART_ID')=='DP/006' || $this->session->userdata('BRANCH_ID')=='BR/0022'){
                  if($this->session->userdata('LEAD_STATUS')!='2'){
                    ?>
                    <li class="nav-item">
                      <a href="<?php echo base_url().'Aset/approval'?>" class="nav-link <?php echo ($this->uri->segment(1) == 'Aset' && $this->uri->segment(2) == 'approval') ?' active' :''; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Approval</p>
                      </a>
                    </li>
                    <?php 
                  }
                  ?>
                  <li class="nav-item">
                    <a href="<?php echo base_url().'Aset/jadwal'?>" class="nav-link <?php echo ($this->uri->segment(1) == 'Aset' && $this->uri->segment(2) == 'jadwal') ?' active' :''; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Jadwal</p>
                    </a>
                  </li>
                <?php
                }

              ?>
            </ul>
          </li>
        </ul>
        <?php 
        }
        ?>
        <!-- /End GA Menu -->
      </nav>
      <?php
      }
      ?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
