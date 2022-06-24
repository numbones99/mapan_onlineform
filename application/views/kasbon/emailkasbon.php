<form role="form" action="<?php echo base_url().'EmailAppKB/mainApp'?>" method="POST" target="_blank">
<div style="width: 600px; padding: 30px; background-color: #F3F4F5; margin: auto;">
    <h1><br />Pengajuan Approval Kasbon</h1>
    <div style="background-color: white; padding: 30px; margin-top: 30px;">
        <h2 style="text-transform: uppercase;">Kasbon ID : <?= $rowKB['KB_ID'];?></h2>
        <hr>
        <p>Tanggal Pengajuan : <?= $rowKB['KB_SUBMIT_DATE'];?></p>
        <p>Yang Mengajukan : <?= $nama; ?></p>
        <p>Total Pengajuan : <?= 'Rp. '.number_format($rowKB['KB_TOTAL_AWAL']);?></p>
        <table>
            <tr>
                <td>
                    <table style="border-top: 2px solid #000000; border-bottom: 2px solid #989EA3; width: 540px" cellpadding=24 cellspacing="0">
                        <tr bgcolor="#ffffff">
                            <th align="left" style="border-bottom: 1px solid #E1E3E4;">#</th>
                            <th align="left" style="border-bottom: 1px solid #E1E3E4;">Keterangan</th>
                            <th align="left" style="border-bottom: 1px solid #E1E3E4;">Nominal</th>
                        </tr>
                        
                        <?php
                        $i=1;
                        foreach($rowDet as $rowDet){
                        ?>
                        <tr bgcolor="#ffffff">
                            <td style="border-top: 1px solid #E1E3E4;"><?= $i++;?></td>
                            <td align="left" style="border-top: 1px solid #E1E3E4;"><?= $rowDet['DET_KB_ITEM'];?></td>
                            <td align="left" style="border-top: 1px solid #E1E3E4;"><?= number_format($rowDet['DET_KB_VALUE']);?></td>
                        </tr> 
                        <?php
                        }
                        ?>                 
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <!-- untuk approval tergantung siapa yang dituju -->

    <input type="hidden" name="empID" value="<?= $leader['EMP_ID']; ?>">
    <input type="hidden" name="kasbonID" value="<?= $rowKB['KB_ID'];?>">
    <?php
    //mengecek apakah user yang login memiliki atasan ?
    $whereLeader = array(
        'EMP_ID_MEMBER' => $leader['EMP_ID'],
    );
    $cekAdaLeader = $this->Model_online->countRowWhere('tr_supervision',$whereLeader);
    $whereFA = array(
        'EMP_ID' => $leader['EMP_ID'],
        'DEPART_ID' => 'DP/003',
    );
    $cekDiaFA = $this->Model_online->countRowWhere('m_employee',$whereFA);

    $ENidkasbon = base64_encode(str_replace('/','',$rowKB['KB_ID']));
    $ENidEmp = base64_encode(str_replace('/','',$leader['EMP_ID']));
    $ENmember = base64_encode('EMP003009');
    $ENLeader = base64_encode('Leader');
    $ENFA = base64_encode('FA');
    $ENReject = base64_encode('Reject');
    $ENFinal = base64_encode('Final');
    //mengecek apakah leadernya memiliki status 5
    $whereCek = array(
        'ts.EMP_ID_MEMBER' => $leader['EMP_ID'],
        'me.LEAD_STATUS' => '5',
    );
    $direksi = $this->Model_online->direksi($whereCek);
    $whereparam = array(
    'ID_PARAM' => 'PR/0002', 
    ); 
    $param = $this->Model_online->findSingleDataWhere($whereparam, 'm_param');
    if($rowKB['KB_TOTAL_AWAL']<=$param['VALUE_PARAM'] && $direksi>0){
    ?>
        
        <!-- pakai form action inline -->
        <a href="<?php echo base_url().'EmailAppKB/mainApp?member='.$ENmember.'&value='.$ENFA.'&kasbonID='.$ENidkasbon.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        <div style="background-color:#f0ad4e; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        Final Approval & Pengajuan FA
        </div>
        </a>
        <!-- pakai form action inline -->
        <a href="<?php echo base_url().'EmailAppKB/mainApp?value='.$ENReject.'&kasbonID='.$ENidkasbon.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        <div style="background-color: #dc3545; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        Reject
        </div>
        </a>
    <?php
    }else{
    if($cekAdaLeader>0 && $cekDiaFA<=0){ //ybs punya leader
    ?>
        <a href="<?php echo base_url().'EmailAppKB/mainApp?value='.$ENLeader.'&kasbonID='.$ENidkasbon.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        <div style="background-color: #28a745; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        Leader Approval
        </div>
        </a>
        <a href="<?php echo base_url().'EmailAppKB/mainApp?value='.$ENReject.'&kasbonID='.$ENidkasbon.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        <div style="background-color: #dc3545; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        Reject
        </div>
        </a>
    <?php 
    }elseif($cekAdaLeader>0 && $cekDiaFA>0){
    ?>
        <a href="<?php echo base_url().'EmailAppKB/mainApp?value='.$ENLeader.'&kasbonID='.$ENidkasbon.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        <div style="background-color: #28a745; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        Leader Approval
        </div>
        </a>
        <a href="<?php echo base_url().'EmailAppKB/mainApp?value='.$ENReject.'&kasbonID='.$ENidkasbon.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        <div style="background-color: #dc3545; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        Reject
        </div>
        </a>
    <?php
    }elseif($cekAdaLeader<=0 && $cekDiaFA>0){ // kondisi ketika ybs tidak punya leader(topsendiri) dan ybs orang FA
    ?>
        <!-- pakai form action inline -->
        <a href="<?php echo base_url().'EmailAppKB/mainApp?value='.$ENFinal.'&kasbonID='.$ENidkasbon.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        <div style="background-color:#5bc0de; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        <!-- <input type="submit" name="action" value="Final Approval" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;"> 
        </input> -->
        Release Pengajuan
        </div>
        </a>
        <!-- pakai form action inline -->
        <a href="<?php echo base_url().'EmailAppKB/mainApp?value='.$ENReject.'&kasbonID='.$ENidkasbon.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        <div style="background-color: #dc3545; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        <!-- <input type="submit" name="action" value="Reject" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        </input> -->
        Cancel Pengajuan
        </div>
        </a>
    <?php    
    }elseif($cekAdaLeader<=0 && $cekDiaFA<=0){ // kondisi ketika ybs tidak punya leader dan dia BUKAN orang FA
    ?>
        <!-- pakai form action inline -->
        <a href="<?php echo base_url().'EmailAppKB/mainApp?member='.$ENmember.'&value='.$ENFA.'&kasbonID='.$ENidkasbon.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        <div style="background-color:#f0ad4e; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        Final Approval & Pengajuan FA
        </div>
        </a>
        <!-- pakai form action inline -->
        <a href="<?php echo base_url().'EmailAppKB/mainApp?value='.$ENReject.'&kasbonID='.$ENidkasbon.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        <div style="background-color: #dc3545; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        Reject
        </div>
        </a>
    <?php    
    }
    }
    ?>
    <!-- end approval -->
</div>
</form>