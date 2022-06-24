<form role="form" action="<?php echo base_url().'EmailApp/mainApp'?>" method="POST" target="_blank">
<div style="width: 600px; padding: 30px; background-color: #F3F4F5; margin: auto;">
    <h1><br />Pengajuan Approval Reimbursement</h1>
    <div style="background-color: white; padding: 30px; margin-top: 30px;">
        <h2 style="text-transform: uppercase;">Reimburse ID : <?= $idreim;?></h2>
        <p>Tanggal Pengajuan : <?= $tglPengajuan;?></p>
        <p>Yang Mengajukan : <?=$nama;?></p>
        <p>Total : <?= 'Rp. '.number_format($total);?></p>

<table>
	<tr>
		<td>
			<table style="border-top: 2px solid #000000; border-bottom: 2px solid #989EA3; width: 540px" cellpadding=24 cellspacing="0">
				<tr bgcolor="#ffffff">
					<th align="left" style="border-bottom: 1px solid #E1E3E4;">#</th>
                    <th align="left" style="border-bottom: 1px solid #E1E3E4;">Keterangan</th>
                    <th align="left" style="border-bottom: 1px solid #E1E3E4;">Nominal</th>
                    <th align="left" style="border-bottom: 1px solid #E1E3E4;">File Foto Nota</th>
				</tr>
				
                <?php
                $i=1;
                $whereData = array(
                    'RB_ID' => $idreim,
                );
                $rowReim = $this->Model_online->findAllDataWhere($whereData,'tr_detail_reimburse');
                foreach($rowReim as $rowReim){
                ?>
                <tr bgcolor="#ffffff">
					<td style="border-top: 1px solid #E1E3E4;"><?= $i++;?></td>
                    <td align="left" style="border-top: 1px solid #E1E3E4;"><?= $rowReim['DET_RB_ITEM'];?></td>
                    <td align="left" style="border-top: 1px solid #E1E3E4;"><?= number_format($rowReim['DET_RB_VALUE']);?></td>
                    <td align="left" style="border-top: 1px solid #E1E3E4;"><a style="text-decoration: none;color:inherit;" href="<?php echo base_url()?>assets/dokumen/<?= $rowReim['DET_RB_PHOTO']; ?>" target="_blank" rel="noopener noreferrer"><?= $rowReim['DET_RB_PHOTO'];?></a></td>
                </tr> 
                <?php
                }
                ?>
				 
            </table>
		</td>
	</tr>
</table>
</div>

    <input type="hidden" name="empID" value="<?=$idEmp;?>">
    <input type="hidden" name="reimID" value="<?=$idreim;?>">
    <?php
    //mengecek apakah user yang login memiliki atasan ?
    $whereLeader = array(
        'EMP_ID_MEMBER' => $idEmp,
    );
    $cekAdaLeader = $this->Model_online->countRowWhere('tr_supervision',$whereLeader);
    $whereFA = array(
        'EMP_ID' => $idEmp,
        'DEPART_ID' => 'DP/003',
    );
    $cekDiaFA = $this->Model_online->countRowWhere('m_employee',$whereFA);
    $ENidreim = base64_encode(str_replace('/','',$idreim));
    $ENidEmp = base64_encode(str_replace('/','',$idEmp));
    $ENmember = base64_encode('EMP003009');
    $ENLeader = base64_encode('Leader');
    $ENFA = base64_encode('FA');
    $ENReject = base64_encode('Reject');
    $ENFinal = base64_encode('Final');
    //mengecek apakah leadernya memiliki status 5
    $whereCek = array(
        'ts.EMP_ID_MEMBER' => $idEmp,
        'me.LEAD_STATUS' => '5',
    );
    $direksi = $this->Model_online->direksi($whereCek);
    $whereparam = array(
    'ID_PARAM' => 'PR/0001', 
    ); 
    $param = $this->Model_online->findSingleDataWhere($whereparam, 'm_param');
    if($total<=$param['VALUE_PARAM'] && $direksi>0){
    ?>
        <!-- pakai form action inline -->
        <a href="<?php echo base_url().'EmailApp/mainApp?member='.$ENmember.'&value='.$ENFA.'&reimID='.$ENidreim.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        <div style="background-color:#f0ad4e; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        Final Approval & Pengajuan FA
        </div>
        </a>
        <!-- pakai form action inline -->
        <a href="<?php echo base_url().'EmailApp/mainApp?value='.$ENReject.'&reimID='.$ENidreim.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        <div style="background-color: #dc3545; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        Reject
        </div>
        </a>
    <?php
    }else{
    if($cekAdaLeader>0 && $cekDiaFA<=0){ //ybs punya leader dan ybs orang FA
    ?>
        <a href="<?php echo base_url().'EmailApp/mainApp?value='.$ENLeader.'&reimID='.$ENidreim.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        <div style="background-color: #28a745; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        <!-- <input type="submit" name="action" value="Leader Approval" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
       
        </input> -->
        Leader Approval
        </div>
        </a>
        <a href="<?php echo base_url().'EmailApp/mainApp?value='.$ENReject.'&reimID='.$ENidreim.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        <div style="background-color: #dc3545; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        <!-- <input type="submit" name="action" value="Reject" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        </input> -->
        Reject
        </div>
        </a>
    <?php
    }elseif($cekAdaLeader>0 && $cekDiaFA>0){ // ybs punya leader dan ybs orang FA
    ?>
        <!-- pakai form action utama -->
        <a href="<?php echo base_url().'EmailApp/mainApp?value='.$ENLeader.'&reimID='.$ENidreim.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        <div style="background-color: #28a745; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        <!-- <input type="submit" name="action" value="Leader Approval" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
       
        </input> -->
        Leader Approval
        </div>
        </a>
        <!-- pakai form action inline -->
        <!-- <a href="<?php echo base_url().'EmailApp/mainApp?value='.$ENFinal.'&reimID='.$ENidreim.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        <div style="background-color:#5bc0de; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        Final Approval
        </div>
        </a> -->
        <!-- pakai form action inline -->
        <a href="<?php echo base_url().'EmailApp/mainApp?value='.$ENReject.'&reimID='.$ENidreim.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        <div style="background-color: #dc3545; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        <!-- <input type="submit" name="action" value="Reject" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        </input> -->
        Reject
        </div>
        </a>
    <?php 
    }elseif($cekAdaLeader<=0 && $cekDiaFA>0){ // kondisi ketika ybs tidak punya leader(topsendiri) dan ybs orang FA
    ?>
        <!-- pakai form action inline -->
        <a href="<?php echo base_url().'EmailApp/mainApp?value='.$ENFinal.'&reimID='.$ENidreim.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        <div style="background-color:#5bc0de; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        <!-- <input type="submit" name="action" value="Final Approval" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;"> 
        </input> -->
        Release Pengajuan
        </div>
        </a>
        <!-- pakai form action inline -->
        <a href="<?php echo base_url().'EmailApp/mainApp?value='.$ENReject.'&reimID='.$ENidreim.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
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
        <a href="<?php echo base_url().'EmailApp/mainApp?member='.$ENmember.'&value='.$ENFA.'&reimID='.$ENidreim.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        <div style="background-color:#f0ad4e; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        Final Approval & Pengajuan FA
        </div>
        </a>
        <!-- pakai form action inline -->
        <a href="<?php echo base_url().'EmailApp/mainApp?value='.$ENReject.'&reimID='.$ENidreim.'&empID='.$ENidEmp?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
        <div style="background-color: #dc3545; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        Reject
        </div>
        </a>
    <?php    
    }
}
    ?>

</div>
</form>