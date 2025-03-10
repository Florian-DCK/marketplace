<?php 
	$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
?>

<body>
    <div class=" w-full max-w-1/5">
        <ul class="h-full w-full flex flex-col space-y-4 text-right px-5 pt-5">
            <?php if(!str_contains($url, "admin")){?>
                <li><a href="">Mon profil</a></li>
                <li><a href="">Se déconnecter</a></li>

            <?php } elseif (str_contains($url, "admin")){ ?>
                <li><a href="">Ajouter Utiilisateur</a></li>
                <li><a href="">Afficher les infos d'un user</a></li>
                <li><a href="">Modifier Utilisateur</a></li>
                <li><a href="">Supprimer Utilisateur</a></li>
            <?php }  ?>
        </ul>
    </div>
</body>