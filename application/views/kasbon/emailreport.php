<form role="form" action="<?php echo base_url().'EmailAppKB/mainApp'?>" method="POST" target="_blank">
<div style="width: 600px; padding: 30px; background-color: #F3F4F5; margin: auto;">
    <h1><br />Report Kelengkapan Kasbon</h1>
    <div style="background-color: white; padding: 30px; margin-top: 30px;">
        <h2 style="text-transform: uppercase;">Kasbon ID : <?= $rowKB['KB_ID'];?></h2>
        <hr>
        <table style="border-spacing:5px">
            <tr>
                <td>Tanggal Pengajuan</td>
                <td>:</td>
                <td><?= $rowKB['KB_SUBMIT_DATE'];?></td>
                <td>Tanggal Approval</td>
                <td>:</td>
                <td><?= $rowKB['KB_APP_DATE'];?></td>
            </tr>
                <td>Yang Mengajukan</td>
                <td>:</td>
                <td><?= $nama; ?></td>
                <td>Tanggal Report</td>
                <td>:</td>
                <td><?= $rowKB['KB_REPORT_DATE'];?></td>
            <tr>
            </tr>
            <tr>
                <td>Total Pengajuan</td>
                <td>:</td>
                <td>Rp. <?= number_format($rowKB['KB_TOTAL_AWAL']);?></td>
                <td>Total Laporan</td>
                <td>:</td>
                <td>Rp. <?= number_format($rowKB['KB_TOTAL_AKHIR']);?></td>
            </tr>
            <tr>
            <td>Selisih</td>
            <td>:</td>
            <td>Rp. <?= $rowKB['KB_DIFF'];?></td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <table style="border-top: 2px solid #000000; border-bottom: 2px solid #989EA3; width: 540px" cellpadding=24 cellspacing="0">
                        <tr bgcolor="#ffffff">
                            <th align="left" style="border-bottom: 1px solid #E1E3E4;">#</th>
                            <th align="left" style="border-bottom: 1px solid #E1E3E4;">Keterangan</th>
                            <th align="left" style="border-bottom: 1px solid #E1E3E4;">Nominal Awal</th>
                            <th align="left" style="border-bottom: 1px solid #E1E3E4;">Nominal Lapor</th>
                            <th align="left" style="border-bottom: 1px solid #E1E3E4;">Selisih</th>
                        </tr>
                        
                        <?php
                        $i=1;
                        foreach($rowDet as $rowDet){
                        ?>
                        <tr bgcolor="#ffffff">
                            <td style="border-top: 1px solid #E1E3E4;"><?= $i++;?></td>
                            <td align="left" style="border-top: 1px solid #E1E3E4;"><?= $rowDet['DET_KB_ITEM'];?></td>
                            <td align="left" style="border-top: 1px solid #E1E3E4;"><?= number_format($rowDet['DET_KB_VALUE']);?></td>
                            <td align="left" style="border-top: 1px solid #E1E3E4;"><?= number_format($rowDet['DET_KB_END_VALUE']);?></td>
                            <td align="left" style="border-top: 1px solid #E1E3E4;"><?= number_format($rowDet['DET_KB_DIFF']);?></td>
                        </tr>
                        <?php
                        $where = array(
                            'DET_KB_ID' => $rowDet['DET_KB_ID'],
                            );
                        $real = $this->Model_online->findAllDataWhere($where,'tr_detail_real');
                        foreach($real as $real) :
                        ?>
                        <tr bgcolor="#ffffff">
                            <td style="border-top: 1px solid #E1E3E4;">>></td>
                            <td colspan="2" align="left" style="border-top: 1px solid #E1E3E4;"><?= $real['REAL_NAME'];?></td>
                            <td align="left" style="border-top: 1px solid #E1E3E4;"><?= number_format($real['REAL_VALUE']);?></td>
                            <td align="left" style="border-top: 1px solid #E1E3E4;">
                            <a style="text-decoration: none;color:inherit;" href="<?php echo base_url()?>assets/doc-kasbon/<?= $real['REAL_PHOTO'];?>" target="_blank" rel="noopener noreferrer">
                            <?= $real['REAL_PHOTO'];?>
                            </a>
                            </td>
                        </tr>
                         
                        <?php
                        endforeach;
                        }
                        ?>                 
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <a href="<?php echo base_url().'Kasbon/Approval'?>" style="text-decoration: none;border: none;padding: 0;background: none;color: white; font-size: 18px;">
    <div style="background-color: #28a745; padding: 18px 80px; margin: 40px auto; text-align: center; width: 400px; cursor: pointer;">
        Cek Via Aplikasi
    </div>
    </a>
    
</div>
</form>