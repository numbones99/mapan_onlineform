<html>
    <head>
    </head>
<body>
<?php $ymd = date('Y-m-d'); ?>
<div style="width: 600px; padding: 30px; background-color: #F3F4F5; margin: auto;">
    <h1><br />Jadwal Perbaikan Aset - <?= $ymd;?> </h1>
    <div style="background-color: white; padding: 30px; margin-top: 30px;">
        <h2 style="text-transform: uppercase;">Nama Teknisi : <?= $emp['EMP_FULL_NAME'];?></h2>
        <table style="padding-top: 1rem;">
            <tr>
                <td>
                    <table style="border-top: 2px solid #000000; border-bottom: 2px solid #989EA3; width: 540px" cellpadding=24 cellspacing="0">
                        <tr bgcolor="#ffffff">
                            <th align="left" style="border-bottom: 1px solid #E1E3E4;">#</th>
                            <th colspan="2" align="left" style="border-bottom: 1px solid #E1E3E4;">Pengaju</th>
                            <th align="left" style="border-bottom: 1px solid #E1E3E4;">Branch</th>
                            <th align="left" style="border-bottom: 1px solid #E1E3E4;">Jadwal</th>
                        </tr>    
                        <?php
                        $i=1;
                        foreach($jadwal as $jadwal){
                        ?>
                        <tr bgcolor="#ffffff">
                            <td style="border-top: 1px solid #E1E3E4;"><?= $i++;?></td>
                            <td colspan="2" align="left" style="border-top: 1px solid #E1E3E4;"><?= $jadwal['EMP_FULL_NAME']?></td>
                            <td align="left" style="border-top: 1px solid #E1E3E4;"><?= $jadwal['BRANCH_NAME']?></td>
                            <td align="left" style="border-top: 1px solid #E1E3E4;">
                                <?= $jadwal['RP_STR_DATE']?>
                            </td>
                        </tr>
                        <?php 
                        $arr_det = array(
                                'RP_ID' => $jadwal['RP_ID'],
                        );
                        $datadet = $this->Model_online->findAllDataWhere($arr_det, 'tr_detail_repair'); 
                        foreach($datadet as $datadet) : 
                        $whereAset = array(
                            'ASSET_CODE' => $datadet['ASSET_CODE'],
                        );
                        $aset = $this->Model_online->findSingleDataWhere($whereAset, 'm_asset');
                        ?>
                        <tr bgcolor="#ffffff">
                            <td style="border-top: 1px solid #E1E3E4;"><p>&#8627;</p></td>
                            <td colspan="2" align="left" style="border-top: 1px solid #E1E3E4;"><?= $aset['ASSET_CODE'].' - '.$aset['ASSET_NAME']?></td>
                            <td align="left" style="border-top: 1px solid #E1E3E4;"><?= $datadet['DET_RP_REASON']?></td>
                            <td align="left" style="border-top: 1px solid #E1E3E4;">
                                <a style="text-decoration: none;color:inherit;" href="<?php echo base_url()?>assets/doc-repair/<?= $datadet['DET_RP_PHOTO'];?>" target="_blank" rel="noopener noreferrer">
                                    <p>&#9776;</p>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach;?> 
                        <?php
                        }
                        ?>                 
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>