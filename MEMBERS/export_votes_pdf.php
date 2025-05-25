<?php
session_start();

// Start output buffering to prevent early output before PDF generation
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

// Database connection
$conn = new mysqli("localhost", "u495515480_root", "Voting$123", "u495515480_voting_db");
//$conn = new mysqli("localhost", "root", "", "voting_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Include TCPDF library
require_once('tcpdf_min/tcpdf.php');

// SQL query with custom position ordering using FIELD()
$sql = "
    SELECT position, name, votes 
    FROM candidates 
    ORDER BY FIELD(position,
        'President', 'Vice-President', 'External', 'Internal', 'Secretary',
        'Assistant Secretary', 'Treasurer', 'Assistant Treasurer', 'Auditor',
        'Business Manager', 'P. R. O', 'Property Custodian', 'Quizzer Head',
        'Sports Head', 'Multimedia Head'), votes DESC, name ASC
";

$result = $conn->query($sql);
if (!$result) {
    die("Error fetching votes: " . $conn->error);
}

// Build HTML content for the PDF
$html = '<h1 style="text-align:center;">ICpEP.SE BulSU Main Campus 2025-2026</h1>
<h2 style="text-align:center;">Voting Results</h2>
<br><br>';

$currentPosition = '';
while ($row = $result->fetch_assoc()) {
    if ($row['position'] !== $currentPosition) {
        if ($currentPosition !== '') {
            $html .= '</ul>'; // Close previous position list
        }
        $currentPosition = $row['position'];
        $html .= '<h2 style="color:#004080;">' . htmlspecialchars($currentPosition) . '</h2><ul>';
    }
    $html .= '<li style="font-size:14px;">' . htmlspecialchars($row['name']) . ': <strong>' . intval($row['votes']) . '</strong> votes</li>';
}
$html .= '</ul>'; // Close the last position list

$conn->close();

// Create new TCPDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document metadata
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Organization');
$pdf->SetTitle('Voting Results');
$pdf->SetSubject('Voting Results Report');
$pdf->SetKeywords('Voting, Results, PDF');

// Disable default header and footer for clean output
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Set margins and page breaks
$pdf->SetMargins(15, 20, 15);
$pdf->SetAutoPageBreak(TRUE, 20);

// Add a page and write HTML content
$pdf->AddPage();
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF inline to browser
$pdf->Output('voting_results.pdf', 'I');

ob_end_flush();
