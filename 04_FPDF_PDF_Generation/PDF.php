<?php
ob_start();

if (isset($_POST['export_pdf'])) {
    require('PDF.php');

    $host = '127.0.0.1';
    $user = 'root';
    $pass = '';
    $db   = 'fpdf';

    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Database Connection Failed: " . $conn->connect_error);
    }

    class PDF extends FPDF {
        public $widths = [];
        public $aligns = [];
        public $titlePrinted = false;

        function Header() {
            if ($this->titlePrinted) {
                return;
            }

            $this->SetFont('Arial', 'B', 14);
            $this->SetTextColor(44, 62, 80);
            $this->Cell(0, 6, 'Student Fee Receipt Report', 0, 1, 'C');

            $this->SetFont('Arial', '', 8);
            $this->SetTextColor(127, 140, 141);
            $this->Cell(0, 4, 'Generated on: ' . date('d-M-Y') . ' | Sorted by: Highest Amount Paid (Descending)', 0, 1, 'C');
            $this->Ln(3);

            $this->SetFillColor(236, 240, 241);
            $this->SetTextColor(44, 62, 80);
            $this->SetFont('Arial', 'B', 7);
            $this->SetDrawColor(120, 120, 120);

            $headers = ['R. No.', 'Date', 'Student ID', 'Student Name', 'Code', 'Course Name', 'Amt (Rs)', 'Pay Method'];
            foreach ($headers as $i => $h) {
                $this->Cell($this->widths[$i], 6, $h, 1, 0, 'C', true);
            }
            $this->Ln();
            $this->titlePrinted = true;
        }

        function Footer() {
            $this->SetY(-10);
            $this->SetFont('Arial', 'I', 7);
            $this->SetTextColor(127, 140, 141);
            $this->Cell(0, 5, 'Page ' . $this->PageNo(), 0, 0, 'C');
        }

        function SetWidths($w) {
            $this->widths = $w;
        }

        function SetAligns($a) {
            $this->aligns = $a;
        }

        function ellipsize($text, $maxChars) {
            $text = trim((string)$text);
            if (strlen($text) <= $maxChars) return $text;
            return substr($text, 0, max(0, $maxChars - 3)) . '...';
        }

        function Row($data) {
            $h = 5;
            $x = $this->GetX();
            $y = $this->GetY();

            for ($i = 0; $i < count($data); $i++) {
                $this->Rect($x, $y, $this->widths[$i], $h);
                $this->SetXY($x, $y + 0.8);
                $this->SetFont('Arial', '', 7);
                $this->Cell($this->widths[$i], 3.5, $data[$i], 0, 0, $this->aligns[$i] ?? 'L');
                $x += $this->widths[$i];
                $this->SetXY($x, $y);
            }
            $this->Ln($h);
        }
    }

    $countRes = $conn->query("SELECT COUNT(*) AS total FROM receipt");
    $totalRows = 0;
    if ($countRes) {
        $totalRows = (int)$countRes->fetch_assoc()['total'];
    }

    $rowHeight = 5;
    $headerBlock = 20;
    $tableHeader = 6;
    $footerSpace = 15;
    $pageHeight = $headerBlock + $tableHeader + ($totalRows * $rowHeight) + $footerSpace;

    if ($pageHeight < 120) {
        $pageHeight = 120;
    }

    $pdf = new PDF('L', 'mm', [297, $pageHeight]);
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetAutoPageBreak(false);
    $pdf->AliasNbPages();

    $pdf->SetWidths([15, 22, 25, 48, 10, 62, 20, 35]);
    $pdf->SetAligns(['C', 'C', 'C', 'L', 'C', 'L', 'R', 'C']);

    $pdf->AddPage();
    $pdf->SetDrawColor(120, 120, 120);

    $sql = "SELECT rno, rdate, stud_id, stud_nm, ccode, cname, amt, pay_method
            FROM receipt
            ORDER BY amt DESC, rno DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pdf->Row([
                $pdf->ellipsize($row['rno'], 12),
                $pdf->ellipsize($row['rdate'], 12),
                $pdf->ellipsize($row['stud_id'], 18),
                $pdf->ellipsize($row['stud_nm'], 30),
                $pdf->ellipsize(strtoupper($row['ccode']), 8),
                $pdf->ellipsize($row['cname'], 40),
                number_format((int)$row['amt']),
                $pdf->ellipsize($row['pay_method'], 20)
            ]);
        }
    } else {
        $pdf->Cell(0, 10, 'No records found.', 1, 1, 'C');
    }

    $conn->close();
    ob_end_clean();
    $pdf->Output('receipt_report.pdf', 'I');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Database Records</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #f4f6f9;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h2 {
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 10px;
        }
        p {
            color: #7f8c8d;
            margin-bottom: 30px;
            font-size: 14px;
            line-height: 1.5;
        }
        .btn {
            background-color: #ffffff;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn:hover {
            background-color: #c0392b;
        }
        .btn svg {
            margin-right: 8px;
            fill: currentColor;
            width: 18px;
            height: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Student Fee Records</h2>
        <p>The system will compile all historical payment records and generate a single custom-height PDF sheet.</p>

        <form method="POST" action="">
            <button type="submit" name="export_pdf" class="btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM112 256H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>
                Export to PDF
            </button>
        </form>
    </div>
</body>
</html>
use fpdf;

CREATE TABLE receipt (
  rno varchar(8) NOT NULL,
  rdate varchar(10) NOT NULL,
  stud_id varchar(15) NOT NULL,
  stud_nm varchar(50) NOT NULL,
  ccode varchar(3) NOT NULL,
  cname varchar(50) NOT NULL,
  amt int(5) NOT NULL,
  pay_method varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO receipt (rno, rdate, stud_id, stud_nm, ccode, cname, amt, pay_method) VALUES
('2020041', '24/10/2020', '2K19DCE013', 'Krupal Gajendra Vyas', 'd3s', 'Diploma Computer Engg Sem 3', 2000, 'By Cash'),
('2020042', '03/11/2020', '2K20DCE025', 'Ashish Dilipbhai Thanki', 'd1s', 'Diploma Computer Engg Sem 1', 2000, 'By Cash'),
('2020043', '10/11/2020', '2K19DCE008', 'Ronit Kamleshbhai Motivaras', 'd3s', 'Diploma Computer Engg Sem 3', 2500, 'By Cash'),
('2020044', '11/11/2020', '2K20DCE023', 'Sumit  Amar', 'd1s', 'Diploma Computer Engg Sem 1', 1500, 'NEFT Transfer'),
('2020045', '12/11/2020', '2K20DCE019', 'Riya Jitesh Desai', 'd1s', 'Diploma Computer Engg Sem 1', 2000, 'NEFT Transfer'),
('2020046', '02/10/2020', '2K20DCE019', 'Riya Jitesh Desai', 'd1s', 'Diploma Computer Engg Sem 1', 2000, 'NEFT Transfer'),
('2020047', '22/11/2020', '2K19DCE001', 'Devam Jagdishbhai Joshi', 'd3s', 'Diploma Computer Engg Sem 3', 4000, 'PhonePe'),
('2020048', '21/11/2020', '2K19BCA002', 'Parth Nileshbhai Lalcheta', 'b3s', 'Bachelor of Computer App Sem 3', 2800, 'Google Pay'),
('2020049', '14/09/2020', '2K20DCE018', 'Tanvi Alkeshbhai Bhadiyadra', 'd1s', 'Diploma Computer Engg Sem 1', 2000, 'By Cash'),
('2020050', '05/12/2020', '2K20BCA005', 'Yash Subhashbhai Kotia', 'b1s', 'Bachelor of Computer App Sem 1', 3000, 'By Cash'),
('2020051', '05/12/2020', '2K19DCE003', 'Ashish Jitendrabhai Vaja', 'd3s', 'Diploma Computer Engg Sem 3', 1200, 'By Cash'),
('2020052', '08/12/2020', '2K19DCE006', 'Vruti Vijaybhai Sukhadiya', 'd3s', 'Diploma Computer Engg Sem 3', 2200, 'Google Pay'),
('2020053', '18/12/2020', '2K20BCA004', 'Falguni Pravinbhai Gadher', 'b1s', 'Bachelor of Computer App Sem 1', 1500, 'By Cash'),
('2020054', '25/12/2020', '2K19DCE011', 'Nidhi Gopalbhai Makwana', 'd3s', 'Diploma Computer Engg Sem 3', 4000, 'By Cash'),
('2020055', '26/12/2020', '2K20DCE025', 'Ashish Dilipbhai Thanki', 'd1s', 'Diploma Computer Engg Sem 1', 2000, 'By Cash'),
('2020056', '08/01/2021', '2K20DCE018', 'Tanvi Alkeshbhai Bhadiyadra', 'd1s', 'Diploma Computer Engg Sem 1', 2000, 'By Cash'),
('2020057', '08/01/2021', '2K20DCE020', 'Darshit Satishbhai Vara', 'd1s', 'Diploma Computer Engg Sem 1', 2000, 'By Cash'),
('2020058', '22/11/2021', '2K20BCA006', 'Shyam Ajaybhai Parekh', 'b1s', 'Bachelor of Computer App Sem 1', 1000, 'By Cash'),
('2020059', '20/12/2020', '2K19DCE010', 'Het Rajeshbhai Tank', 'd3s', 'Diploma Computer Engg Sem 3', 3200, 'NEFT Transfer'),
('2020187', '23/07/2023', '2K23DCE095', 'Mihir Girishbhai Fataniya', 'd2s', 'Diploma Computer Engg Sem 2', 5000, 'By Cash'),
('2021060', '23/01/2021', '2K19DCE015', 'Umang  Nandha', 'd3s', 'Diploma Computer Engg Sem 3', 2600, 'By Cash'),
('2021061', '16/02/2021', '2K20DCE021', 'Vivek Umeshbhai Vara', 'd1s', 'Diploma Computer Engg Sem 1', 1000, 'By Cash'),
('2021062', '01/03/2021', '2K20BCA007', 'Kalp Jayesh bhai  Parekh', 'b1s', 'Bachelor of Computer App Sem 1', 3000, 'By Cash'),
('2021063', '01/03/2021', '2K20DCE022', 'Ronak Rajeshbhai Bokhiriya', 'd1s', 'Diploma Computer Engg Sem 1', 1500, 'By Cash'),
('2021064', '01/03/2021', '2K20DCE028', 'Geeta  Odedara', 'd1s', 'Diploma Computer Engg Sem 1', 1800, 'By Cash'),
('2021065', '23/03/2021', '2K19DCE002', 'Jharana Vinod Savjani', 'd4s', 'Diploma Computer Engg Sem 4', 5000, 'By Cash'),
('2021066', '31/03/2021', '2K19DCE001', 'Devam Jagdishbhai Joshi', 'd4s', 'Diploma Computer Engg Sem 4', 2500, 'PhonePe'),
('2021067', '31/03/2021', '2K19DCE006', 'Vruti Vijaybhai Sukhadiya', 'd4s', 'Diploma Computer Engg Sem 4', 2500, 'Google Pay'),
('2021068', '13/04/2021', '2K19DCE008', 'Ronit Kamleshbhai Motivaras', 'd4s', 'Diploma Computer Engg Sem 4', 2500, 'PayTM'),
('2021069', '07/04/2021', '2K19DCE006', 'Vruti Vijaybhai Sukhadiya', 'd4s', 'Diploma Computer Engg Sem 4', 2500, 'Google Pay'),
('2021070', '06/05/2021', '2K20DCE018', 'Tanvi Alkeshbhai Bhadiyadra', 'd2s', 'Diploma Computer Engg Sem 2', 2000, 'Google Pay');