<?php
require "RSSParser.php";

$file = "rss.xml";
$fp = fopen($file, "r") or die("$file not found");
while (!feof ($fp)) {
    $buffer .= fgets($fp, 4096);
}
fclose ($fp);

$rss = new RSSParser();
$rss->parse($buffer);
echo "<pre>";
//print_r($rss->getStructure());
//print_r($rss->getChannel());
//print_r($rss->getItems());
//print_r($rss->getTextinputs());
echo "</pre>";



$activeTagValue	= 1;

switch ($activeTagValue) {
    case 0:
        echo "i equals 0";
       // break;
    case 1:
        echo "i equals 1";
       // break;
    case 2:
        echo "i equals 2";
        break;

     default : 
		echo "i equals etc";
}

?>