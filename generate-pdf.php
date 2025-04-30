<?php
require_once __DIR__ . '/vendor/autoload.php';

header("Access-Control-Allow-Origin: https://info-1111-self-learning-advanced-ncg3bdfdv.vercel.app");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = isset($_POST['amount']) ? filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : '';
    $dueDate = isset($_POST['dueDate']) ? htmlspecialchars($_POST['dueDate']) : '';
    $reason = isset($_POST['reason']) ? htmlspecialchars($_POST['reason']) : '';

    if (empty($amount) || empty($dueDate) || empty($reason)) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields.']);
        exit;
    }

    $pdf = new TCPDF();
    $pdf->SetTitle('Levy Notice');
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, 'Levy Notice', 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->Cell(0, 10, "Amount: $" . $amount, 0, 1);
    $pdf->Cell(0, 10, "Due Date: " . $dueDate, 0, 1);
    $pdf->Cell(0, 10, "Reason: " . $reason, 0, 1);
    $pdf->Output('levy_notice.pdf', 'D');
}