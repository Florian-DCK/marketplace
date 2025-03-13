
<script src="https://unpkg.com/@tailwindcss/browser@4"></script>
<?php 
	$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
?>
		<div class="relative h-max w-screen bg-[#EAEBED]">
			<div class="flex items-center justify-between">
				<a href="/">
				<span class="flex items-center">

					<div
						class=" h-12 w-12 bg-[#5242AE] rounded-full m-3"
						id="avatar"></div>
					<h1 class=" text-5xl">Marketplace</h1>
				</span>
			</a>
                <?php include 'searchBar.php'; ?>
				<div class="flex items-center mr-2 space-x-3">
					<a href="/login"><button class=" bg-[#5242AE] text-white px-2 py-1 rounded-lg cursor-pointer">Connexion</button></a>

					<a href="/dashboard"><button class=" bg-[#5242AE] text-white px-2 py-1 rounded-lg cursor-pointer">Dashboard</button></a>
					
					<a href="/dashboard/admin"><button class=" bg-[#5242AE] text-white px-2 py-1 rounded-lg cursor-pointer">Admin</button></a>
				</div>
			</div>
            <?php
				if(!str_contains($url, 'dashboard')){
					include 'categoryNavbar.php';
				}
			?>
		</div>
