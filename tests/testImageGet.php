<?php
require_once '../api/models/images.php';
// array(3) { ["id"]=> string(7) "HNPqjbW" ["deletehash"]=> string(15) "jhPuxUanqhxFx88" ["link"]=> string(32) "https://i.imgur.com/HNPqjbW.jpeg" } 

$imageId = "HNPqjbW";
$result = get($imageId);

// echo "";
// echo $result;
echo "";
echo "id demandée :" . $imageId;
echo "id retrouvée :" . $result['id'] ;
echo "link retrouvée :" . $result['link'];
echo "delete hash retrouvé :" . $result['deletehash'];