<?php

class PDFPAGE extends FPDF{

    function __construct() {

        //$this->load->library('someclass');

        parent::__construct();	

        include APPPATH . 'third_party/fpdf181/fpdf.php';

        //include_once APPPATH . 'third_party/fpdf181/fpdf.php';

    }



    function Header()

    {

        // Select Arial bold 15

        $this->SetFont('Arial','B',15);

        // Move to the right

        $this->Cell(80);

        // Framed title

        $this->Cell(30,10,'Title',1,0,'C');

        // Line break

        $this->Ln(20);

    }

}

?>