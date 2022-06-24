<form role="form" action="<?php echo base_url().'EmailAppKB/mainApp'?>" method="POST" target="_blank">
<div style="width: 600px; padding: 30px; background-color: #F3F4F5; margin: auto;">
    <h1><br />Pengajuan Approval Perbaikan Aset</h1>
    <div style="background-color: white; padding: 30px; margin-top: 30px;">
        <h2 style="text-transform: uppercase;">Repair ID : <?= $rowRP['RP_ID'];?></h2>
        <hr>
        <p>Tanggal Pengajuan : <?= $rowRP['RP_SUB_DATE'];?></p>
        <p>Yang Mengajukan : <?= $nama; ?></p>
        <table>
            <tr>
                <td>
                    <table style="border-top: 2px solid #000000; border-bottom: 2px solid #989EA3; width: 540px" cellpadding=24 cellspacing="0">
                        <tr bgcolor="#ffffff">
                            <th align="left" style="border-bottom: 1px solid #E1E3E4;">#</th>
                            <th align="left" style="border-bottom: 1px solid #E1E3E4;">Nama Aset</th>
                            <th align="left" style="border-bottom: 1px solid #E1E3E4;">Keterangan</th>
                            <th align="left" style="border-bottom: 1px solid #E1E3E4;">Foto Awal</th>
                        </tr>
                        
                        <?php
                        $i=1;
                        foreach($rowDet as $rowDet){
                        $whereAset = array(
                            'ASSET_CODE' => $rowDet['ASSET_CODE'],
                        );
                        $aset = $this->Model_online->findSingleDataWhere($whereAset, 'm_asset');
                        ?>
                        <tr bgcolor="#ffffff">
                            <td style="border-top: 1px solid #E1E3E4;"><?= $i++;?></td>
                            <td align="left" style="border-top: 1px solid #E1E3E4;"><?= $rowDet['ASSET_CODE'].' - '.$aset['ASSET_NAME'];?></td>
                            <td align="left" style="border-top: 1px solid #E1E3E4;"><?= $rowDet['DET_RP_REASON'];?></td>
                            <td align="left" style="border-top: 1px solid #E1E3E4;">
                                <a style="text-decoration: none;color:inherit;" href="<?php echo base_url()?>assets/doc-repair/<?= $rowDet['DET_RP_PHOTO'];?>" target="_blank" rel="noopener noreferrer">
                                <?= $rowDet['DET_RP_PHOTO'];?>
                                </a>
                            </td>
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
    <input type="hidden" name="repairID" value="<?= $rowRP['RP_ID'];?>">
    <?php
    $ENid = base64_encode(str_replace('/','',$rowRP['RP_ID']));
    $ENReject = base64_encode('Reject');
    $ENFinal = base64_encode('Final');
    ?>
        <a href="<?php echo base_url().'EmailAppRP/mainApp?value='.$ENFinal.'&repairID='.$ENid?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
            <div style="background-color: #28a745; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
                Ke Halaman Approval
            </div>
        </a>
        <a href="<?php echo base_url().'EmailAppRP/mainApp?value='.$ENReject.'&repairID='.$ENid?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
            <div style="background-color: #dc3545; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
            Reject
            </div>
        </a>
    
    <!-- end approval -->
</div>
</form>