<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "intern";

// Database Connection
$conn = mysqli_connect($host,$user,$password,$dbname);

if (!$conn)
{
    die("Connection Failed : " . mysqli_connect_error());
}

$sql = "SELECT * FROM product";

$result = mysqli_query($conn,$sql);

// Create XML Document
$xml = new DOMDocument("1.0","UTF-8");

$xml->formatOutput = true;

// Root Element
$products = $xml->createElement("products");
$xml->appendChild($products);

// Add Product Records
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $product = $xml->createElement("product");

        $product->appendChild(
            $xml->createElement("pid", $row["pid"])
        );

        $product->appendChild(
            $xml->createElement("pname", $row["pname"])
        );

        $product->appendChild(
            $xml->createElement("price", $row["price"])
        );

        $product->appendChild(
            $xml->createElement("qty", $row["qty"])
        );

        $products->appendChild($product);
    }
}

$xmlFile = "products.xml";

$xml->save($xmlFile);

echo "XML File Created Successfully";

mysqli_close($conn);

?>