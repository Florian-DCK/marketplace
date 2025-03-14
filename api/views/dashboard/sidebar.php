<?php 
	$url = $_SERVER['REQUEST_URI'];
?>

<body>
    <div class=" w-full max-w-1/5">
        <ul class="h-full w-full flex flex-col space-y-4 text-right px-5 pt-5">
            <?php if(!str_contains($url, "admin")){?>
                <li><a href="">Mon profil</a></li>
                <li><a href="">Mes produits</a></li>
                <li><a href="">Se déconnecter</a></li>

            <?php } elseif (str_contains($url, "admin")){ ?>
                <li><a href="/dashboard/admin/addUser">Ajouter Utilisateur</a></li>
                <li><a href="/dashboard/admin/users">Afficher les utilisateurs</a></li>
                <li><a href="">Afficher les infos d'un user</a></li>
                <li><a href="">Modifier Utilisateur</a></li>
                <li><a href="">Supprimer Utilisateur</a></li>
            <?php }  ?>
        </ul>
    </div>
</body>