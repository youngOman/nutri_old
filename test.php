<?php
header("Content-Type:text/html; charset=big5");
$xml=simplexml_load_file("https://opendata.cwb.gov.tw/fileapi/v1/opendataapi/F-C0032-031?Authorization=rdec-key-123-45678-011121314&format=XML");
// echo "<pre>";
// print_r($xml);
// echo "</pre>";
$postdata=file_get_contents($xml->dataset->resource->uri,'r');
echo "<pre>";
echo $postdata;
echo "</pre>";
?>