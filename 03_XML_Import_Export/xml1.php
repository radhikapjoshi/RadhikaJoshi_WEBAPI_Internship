<?php
$xml = simplexml_load_file('xml1.xml');
$books = $xml->book;
foreach ($books as $book) {
    $id = $book->id;
    $title = $book->name;
    $price = $book->price;
    echo "<br>The title of the book $id is $title and it costs $price.";
}

?>
