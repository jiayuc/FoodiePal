<?php
$json_file = file_get_contents('miniB.json');
// convert the string to a json object
$jfo = json_decode($json_file);
$business_id = $jfo->business_id;
echo $jfo->full_address ;
// copy the array to a php var
$tags = $jfo->categories;
// iterate through
foreach ($tags as $tag) {
    echo $tag;
}
?>
