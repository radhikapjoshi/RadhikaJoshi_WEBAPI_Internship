<html>
 
<body>
    <?php
    /* XML string */
    $myXMLData =
    "<?xml version='1.0' encoding='UTF-8'?>
    <note>
        <to>principal@drvrgit.com</to>
        <from>brjoshi@gmail.com</from>
        <heading>Vacation Leave</heading>
 
        <body>
            Please allow leave to me for 30 days.
        </body>
    </note>";
 
    /* The function reads xml data from the passed string */
    $xml = simplexml_load_string($myXMLData)
    or die("Error: Cannot create xml data object");
     
    print_r($xml);
	echo "<br>To : " . $xml->to . "<br>";
    echo "From : " . $xml->from . "<br>";
    echo "Subject : " . $xml->heading . "<br>";
    echo "Body : " . $xml->body;
    ?>
</body>
 
</html>