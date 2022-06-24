<?php 
    if (!defined('BASEPATH')) exit('No direct script access allowed');
    require(APPPATH .'third_party/fpdf181/fpdf.php');
    class PDFOUTLET extends FPDF{

        function __construct($orientation='P', $unit='mm', $size='legal')
        {
            parent::__construct($orientation,$unit,$size);
        }

        function Header(){
            global $branchId;
            global $branchCode;
            global $branchName;
            global $leaderName;
            global $allTotal;
            global $allPaidTotal;

            // Logo
            $this->Image('logo.jpg',10,5,30);
            // Arial bold 15
            $this->SetFont('Helvetica','B',30);
            $this->SetFillColor(230,230,0);
            // Move to the right
            $this->Cell(60,10,'',0,0,'C');
            // Title
            $this->Cell(93,10,'MAPAN GROUP',0,0,'L');
            $this->Cell(23,10,'',0,0,'R');
            $this->Cell(20,10,'FA',1,1,'C');
            // Line break
            $this->Ln(4);
            // Bagian Judul
            $this->SetFont('Arial','B',14);
            $this->Cell(10,1,'',0,1);
            $this->Cell(20,10,'Outlet','TB',0,'L');
            $this->Cell(5,10,':','TB',0,'C');
            $this->Cell(100,10,$branchName,'TB',0,'L');
            $this->Cell(40,10,'Kode Outlet','LTB',0,'C');
            $this->Cell(5,10,':','TB',0,'C');
            $this->Cell(25,10,$branchCode,'TB',1,'C');
            $this->Cell(10,2,'',0,1);
            
            $this->SetFont('Arial','B',10);
            $this->Cell(35,5,'Nama Leader',0,0,'L');
            $this->Cell(5,5,':',0,0,'L');
            // $name = explode(" ", $branchName);
            // $len_name = count($name);
            // if($len_name>=3){
            //     $impName = implode(' ',array($name[0],$name[1],$name[2]));
            // }elseif($len_name<3){
            //     $impName = implode(' ',array($name[0],$name[1]));
            // }elseif($len_name<2){
            //     $impName = implode(' ',array($name[0]));
            // }
            //$impName = implode(' ',array($name[0],$name[1],$name[2]));
            $this->Cell(72,5,$leaderName,0,0,'L');

            //Bagian Total Reimburse 
            $this->SetFont('Arial','',10);
            $this->Cell(35,5,'Jenis Laporan',0,0,'L');
            $this->Cell(5,5,':',0,0,'L');
            $this->Cell(45,5,'Proyek Aktif',0,1,'L');
            
            //Bagian Pengaju 
            $this->SetFont('Arial','',10);
            $this->Cell(35,5,'Total Pengajuan',0,0,'L');
            $this->Cell(5,5,':',0,0,'L');
            $this->Cell(72,5,'Rp. '.number_format($allTotal),0,0,'L');

            //Bagian Total Reimburse 
            $this->Cell(35,5,'Total Pembayaran',0,0,'L');
            $this->Cell(5,5,':',0,0,'L');
            $this->Cell(45,5,'Rp. '.number_format($allPaidTotal),0,1,'L');
            

            // Memberikan space kebawah agar tidak terlalu rapat
            
            $this->Cell(10,2,'',0,1);
            $this->SetFont('Arial','B',10);
            $this->Cell(6,6,'#',1,0,'C');
            $this->Cell(60,6,'Pengajuan Proyek',1,0,'L');
            $this->Cell(35,6,'Total Pengajuan',1,0,'R');
            $this->Cell(58,6,'Pengeluaran',1,0,'L');
            $this->Cell(35,6,'Total Pengeluaran',1,1,'R');
            $this->Cell(6,6,'#',1,0,'C');
            $this->Cell(60,6,'Detail Proyek',1,0,'L');
            $this->Cell(35,6,'Nominal',1,0,'R');
            $this->Cell(48,6,'Detail Pengeluaran',1,0,'L');
            $this->Cell(10,6,'Foto',1,0,'L');
            $this->Cell(35,6,'Nominal',1,1,'R');
            
        }


        function SetWidths($w)
        {
            //Set the array of column widths
            $this->widths=$w;
        }

        function SetAligns($a)
        {
            //Set the array of column alignments
            $this->aligns=$a;
        }

        function Row($data)
        {
            //Calculate the height of the row
            $nb=0;
            for($i=0;$i<count($data);$i++)
                $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
            $h=5*$nb;
            //Issue a page break first if needed
            $this->CheckPageBreak($h);
            //Draw the cells of the row
            for($i=0;$i<count($data);$i++)
            {
                $w=$this->widths[$i];
                $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                //Save the current position
                $x=$this->GetX();
                $y=$this->GetY();
                //Draw the border
                $this->Rect($x,$y,$w,$h);
                //Print the text
                $this->MultiCell($w,5,$data[$i],0,$a);
                //Put the position to the right of the cell
                $this->SetXY($x+$w,$y);
            }
            //Go to the next line
            $this->Ln($h);
        }

        function CheckPageBreak($h)
        {
            //If the height h would cause an overflow, add a new page immediately
            if($this->GetY()+$h>$this->PageBreakTrigger)
                $this->AddPage($this->CurOrientation);
        }

        function NbLines($w,$txt)
        {
            //Computes the number of lines a MultiCell of width w will take
            $cw=&$this->CurrentFont['cw'];
            if($w==0)
                $w=$this->w-$this->rMargin-$this->x;
            $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
            $s=str_replace("\r",'',$txt);
            $nb=strlen($s);
            if($nb>0 and $s[$nb-1]=="\n")
                $nb--;
            $sep=-1;
            $i=0;
            $j=0;
            $l=0;
            $nl=1;
            while($i<$nb)
            {
                $c=$s[$i];
                if($c=="\n")
                {
                    $i++;
                    $sep=-1;
                    $j=$i;
                    $l=0;
                    $nl++;
                    continue;
                }
                if($c==' ')
                    $sep=$i;
                $l+=$cw[$c];
                if($l>$wmax)
                {
                    if($sep==-1)
                    {
                        if($i==$j)
                            $i++;
                    }
                    else
                        $i=$sep+1;
                    $sep=-1;
                    $j=$i;
                    $l=0;
                    $nl++;
                }
                else
                    $i++;
            }
            return $nl;
        }

        function vcell($c_width, $c_height, $x_axis, $text, $border, $align)
        {
            $panjangMin = (int) 10;
            $panjangCol = $c_width / $panjangMin;
            $len = strlen($text); // check the length of the cell and splits the text into 7 character each and saves in a array 
            $lengthToSplit = 7*$panjangCol; // Default strLn is 6
            if ($len > $lengthToSplit) {
                $w_text = str_split($text, $lengthToSplit);
                foreach ($w_text as $key => $value) {
                    $this->SetX($x_axis);
                    $this->Cell($c_width, $c_height, $value, $border, 1, '');
                }
            } else {
                $this->SetX($x_axis);
                $this->Cell($c_width, $c_height, $text, $border, 0, $align, 0);
            }
        }

        function Footer()
        {
            global $datapindah;
            global $datapindah2;            
            // Go to 1.5 cm from bottom
            $this->SetY(-30);
            // Select Arial italic 8
            //$this->SetFont('Arial','I',8);
            $this->SetFont('Arial','B',10);
            // Print centered page number
            // if($this->isFinished){
            //     //$this->Cell(70,5, "Signature:_______________________________", 1, 1,'R');
            //     $i = count($datapindah);
            //     $o = 0;
            //     foreach($datapindah as $data){
            //         $a=0;
            //         $counttgl=strlen($data['TR_KB_APP_DATE']);
            //         $this->Cell($counttgl+20,6,'Approved',0,$a,'C');
            //         $this->Cell(5,5,'',0,$a);
            //     }
            //     $this->Cell(190,5,'',0,1);
            //     $this->SetFont('Arial','',10);
            //     foreach ($datapindah as $datapindah){
            //         $o++;
            //         $a=0;
            //         $counttgl=strlen($datapindah['TR_KB_APP_DATE']);
            //         if($o==$i){
            //             $a=1;
            //         }
            //         $this->Cell($counttgl+20,5,date('l, d-m-Y',strtotime($datapindah['TR_KB_APP_DATE'])),0,$a,'C');
            //         $this->Cell(5,5,'',0,$a);
            //     }
            //     $this->SetFont('Arial','',10);
            //     foreach ($datapindah2 as $datapindah2){
            //         $o++;
            //         $a=0;
            //         $counttgl2=strlen($datapindah['TR_KB_APP_DATE']);
            //         if($o==$i){
            //             $a=1;
            //         }
            //         $this->Cell($counttgl2+20,6,substr($datapindah2['EMP_FULL_NAME'],0,20),'B',$a,'C');
            //         $this->Cell(5,6,'',0,$a,'C');
            //     }
            // }
        }    
    }   

?>