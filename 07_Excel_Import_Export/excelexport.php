<?php

$data = [
    ['College Name', 'Location', 'Established', 'Type'],
    ['Harvard University', 'Cambridge, MA', '1636', 'Private'],
    ['Stanford University', 'Stanford, CA', '1885', 'Private'],
    ['MIT', 'Cambridge, MA', '1661', 'Private'],
    ['University of Oxford', 'Oxford, UK', '1096', 'Public'],
    ['University of Tokyo', 'Tokyo, Japan', '1877', 'Public']
];


$filename = "college_list_" . date('Y-m-d') . ".xlsx";


header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");


echo "<?xml version=\"1.0\"?>\n";
echo "<?mso-application progid=\"Excel.Sheet\"?>\n";
echo "<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"\n";
echo " xmlns:o=\"urn:schemas-microsoft-com:office:office\"\n";
echo " xmlns:x=\"urn:schemas-microsoft-com:office:excel\"\n";
echo " xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"\n";
echo " xmlns:html=\"http://www.w3.org/TR/REC-html40\">\n";
echo " <Worksheet ss:Name=\"Colleges\">\n";
echo "  <Table>\n";


foreach ($data as $row) {
    echo "   <Row>\n";
    foreach ($row as $cell) {
        
        $cellValue = htmlspecialchars($cell ?? '');
        
     
        $type = is_numeric($cell) ? 'Number' : 'String';
        
        echo "    <Cell><Data ss:Type=\"$type\">$cellValue</Data></Cell>\n";
    }
    echo "   </Row>\n";
}

echo "  </Table>\n";
echo " </Worksheet>\n";
echo "</Workbook>\n";
exit;
?>