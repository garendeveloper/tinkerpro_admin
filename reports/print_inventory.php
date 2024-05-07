<?php
require_once('vendor/autoload.php');

// Extend TCPDF to create custom header and footer
class MYPDF extends TCPDF {
    // Page header
    public function Header() {
        // Set header font
        $this->SetFont('helvetica', 'B', 12);
        
        // Title
        $this->Cell(0, 10, 'My Thermal Receipt', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        
        // Set footer font
        $this->SetFont('helvetica', 'I', 8);
        
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Create a new PDF document
$pdf = new MYPDF('P', 'mm', array(50, 80), true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Thermal Receipt');
$pdf->SetSubject('Thermal Receipt Example');
$pdf->SetKeywords('Thermal, Receipt, TCPDF');

// Set margins (assuming no margins)
$pdf->SetMargins(0, 0, 0);

// Remove default footer
$pdf->setPrintFooter(false);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 10);

// Add your content here
$content = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas nec justo vel massa scelerisque eleifend. Nulla facilisi. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede.";
$pdf->MultiCell(0, 10, $content, 0, 'L');

// Get PDF content as string
$pdfContent = $pdf->Output('thermal_receipt.pdf', 'S');

// Output PDF content
header('Content-Type: application/pdf');
echo $pdfContent;
?>
