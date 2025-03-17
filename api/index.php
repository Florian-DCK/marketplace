<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace</title>
    <link rel="stylesheet" href="/global.css">
</head>
<body class="bg-[#EAEBED] flex flex-col">
    <?php 
    //session_start();
    include __DIR__ . '/views/navbar.php'; 

    $mustache = new Mustache_Engine([
	'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/templates'),
	'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/templates/partials')
    ]);

    $data = [
        'products' => [
            [
                'name' => 'Polo Ralph Laurent',
                'image' => 'https://dtcralphlauren.scene7.com/is/image/PoloGSI/s7-1352639_lifestyle?$rl_4x5_pdp$',
                'price' => 25.99,
                'sales' => true,
                'useOriginal' => true
            ],
            [
                'name' => 'Bob le Bricoleur',
                'image' => 'https://media.senscritique.com/media/000006502525/0/bob_le_bricoleur.jpg',
                'price' => 10.99,
                'new' => true,
                'useBlueNuitCorail' => true
            ],
            [
                'name' => 'Sneakers Nike Air Max',
                'image' => 'https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco/fcd47476-18fc-488c-8a84-d583a59de563/AIR+MAX+DN+QS.png',
                'price' => 129.99,
                'trending' => true,
                'useIndigoAmbre' => true
            ],
            [
                'name' => 'Smartphone Galaxy S23',
                'image' => 'https://citygsm.be/wp-content/uploads/2023/02/Samsung-Galaxy-s23-Lavender-pdf.jpg',
                'price' => 899.99,
                'fast' => true,
                'antoine' => true
            ]
        ]
    ];
    ?>
    <div class="flex space-x-5 mx-24 my-4">
        <?php
        echo $mustache->render('card', $data);
        ?>
    </div>  
</body>
</html>

<?php
unset($mustache);
unset($data);