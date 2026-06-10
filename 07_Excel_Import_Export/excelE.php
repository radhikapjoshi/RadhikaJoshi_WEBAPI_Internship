<?php
$data = [
    ['College Name', 'Location', 'Established'],
    ['Harvard University', 'Cambridge, MA', '1636'],
    ['Stanford University', 'Stanford, CA', '1885']
];

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=colleges.csv');


$output = fopen('php://output', 'w');


foreach ($data as $row) {
    fputcsv($output, $row);
}
fclose($output);
exit;
?>