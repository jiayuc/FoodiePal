<?php
// copy file content into a string var
$json_file = file_get_contents('miniB.json');
// $json_file = '{"business_id": "rncjoVoEFUJGCUoC1JgnUA", "full_address": "8466 W Peoria Ave\nSte 6\nPeoria, AZ 85345", "open": true}';
// convert the string to a json object
$jfo = json_decode($json_file);
// read the title value
$business_id = $jfo->business_id;
echo $jfo->full_address ;
// copy the posts array to a php var
$tags = $jfo->categories;
// listing posts
foreach ($tags as $tag) {
    echo $tag;
}
?>