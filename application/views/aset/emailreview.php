<script src="https://kit.fontawesome.com/dbbccc7cdc.js" crossorigin="anonymous"></script>
<div style="width: 600px; padding: 30px; background-color: #F3F4F5; margin: auto;">
    <h1><br />Review Perbaikan Aset</h1>
    <div style="background-color: white; padding: 30px; margin-top: 30px;">
        <h2 style="text-transform: uppercase;">Repair ID : <?= $rowRP['RP_ID'];?></h2>
        <hr>
        <table style="border-spacing:5px">
            <tr>
                <td>Yang Mengajukan</td>
                <td>:</td>
                <td><?= $nama; ?></td>
                <td>Review</td>
                <td>:</td>
                <td><?= $bintang; ?> dari 5 Bintang</td>
            </tr>
            <tr>
                <td>Tanggal Pengajuan</td>
                <td>:</td>
                <td><?= $rowRP['RP_SUB_DATE'];?></td>
                <td>Tanggal Approval</td>
                <td>:</td>
                <td><?= $rowRP['RP_APP_DATE'];?></td>
            </tr>
            <tr>
                <td>Jadwal Mulai Visit</td>
                <td>:</td>
                <td><?= $rowRP['RP_STR_DATE'];?></td>
                <td>Jadwal Selesai Visit</td>
                <td>:</td>
                <td><?= $rowRP['RP_END_DATE'];?></td>
            </tr>
            <tr>
                <td>Jadwal Datang Teknisi</td>
                <td>:</td>
                <td><?= $rowRP['RP_ARRIVAL'];?></td>
                <td>Jadwal Selesai Teknisi</td>
                <td>:</td>
                <td><?= $rowRP['RP_FINISH'];?></td>
            </tr>
            <tr>
                <td colspan="6">Teknisi Yang Visit :</td>
            </tr>
                <?php
                $arrteknisi = array(
                    'RP_ID' => $rowRP['RP_ID'],
                );
                $teknisi = $this->Model_online->findAllDataWhere($arrteknisi, 'tr_repair_sch');
                foreach($teknisi as $teknisi):
                    $arr_emp=array(
                        'EMP_ID' => $teknisi['EMP_ID'],
                    );
                    $kary = $this->Model_online->findSingleDataWhere($arr_emp,'m_employee');
                ?>
            <tr>
                <td colspan="6"><?= $kary['EMP_FULL_NAME']?></td>
            </tr>
                <?php    
                endforeach;
                ?>
        </table>
        <hr>
        <h2 style="word-wrap:break-word;">Komentar</h2>
        <p><?= $komentar;?></p>
        <hr>
        <table>
            <tr>
                <td>
                    <table style="border-top: 2px solid #000000; border-bottom: 2px solid #989EA3; width: 540px" cellpadding=24 cellspacing="0">
                        <tr bgcolor="#ffffff">
                            <th align="left" style="border-bottom: 1px solid #E1E3E4;">#</th>
                            <th align="left" style="border-bottom: 1px solid #E1E3E4;">Nama Aset</th>
                            <th align="left" style="border-bottom: 1px solid #E1E3E4;">Keterangan</th>
                            <th align="left" style="border-bottom: 1px solid #E1E3E4;">Foto Awal</th>
                            <th align="left" style="border-bottom: 1px solid #E1E3E4;">Foto Akhir</th>
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
                                <p>&#9776;</p>
                                </a>
                            </td>
                            <td align="left" style="border-top: 1px solid #E1E3E4;">
                                <a style="text-decoration: none;color:inherit;" href="<?php echo base_url()?>assets/doc-repair/<?= $rowDet['DET_RP_REV_PHOTO'];?>" target="_blank" rel="noopener noreferrer">
                                <p>&#9776;</p>
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
</div>