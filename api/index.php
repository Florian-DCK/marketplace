<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace</title>
    <link rel="stylesheet" href="/global.css">
</head>
<body class="bg-[#EAEBED] flex flex-col">
    <?php include __DIR__ . '/views/navbar.php'; 

    $mustache = new Mustache_Engine([
	'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/templates'),
	'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/templates/partials')
    ]);

    $data = [
        'products' => [
            'name' => 'Polo Ralph Laurent',
            'image' => 'https://dtcralphlauren.scene7.com/is/image/PoloGSI/s7-1352639_lifestyle?$rl_4x5_pdp$',
            'price' => 25.99,
            'isTrending' => false,
            'isNew' => false,
            'isFast' => false,
            'isCheap' => false
        ]
        ];
    ?>
    <div class="flex space-x-5 mx-24 my-4">
        <?php
        echo $mustache->render('card', $data);
        echo $mustache->render('card', $data);
        ?>
    </div>  
</body>
</html>

<?php
unset($mustache);
unset($data);