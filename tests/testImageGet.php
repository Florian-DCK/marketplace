<?php
require_once '../api/models/images.php';
$imageId = "HNPqjbW";
$result = image_get($imageId);

// echo "";
// echo $result;
echo "";
echo "id demandée :" . $imageId;
echo "id retrouvée :" . $result['id'] ;
echo "link retrouvée :" . $result['link'];
echo "delete hash retrouvé :" . $result['deletehash'];