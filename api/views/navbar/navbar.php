
<script src="https://unpkg.com/@tailwindcss/browser@4"></script>
<?php 
	$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
?>
		<div class="relative h-max w-screen bg-[#EAEBED]">
			<div class="flex items-center justify-between">
				<span class="flex items-center">
					<div
						class=" h-12 w-12 bg-[#5242AE] rounded-full m-3"
						id="avatar"></div>
					<h1 class=" text-5xl">Marketplace</h1>
				</span>
                <?php include 'searchBar.php'; ?>
				<div class="flex items-center mr-2 space-x-3">
					<?php include 'profiles.php'; ?>
					<?php include 'dropdown.php'; ?>
				</div>
			</div>
            <?php
				if(!str_contains($url, 'dashboard')){
					include 'categoryNavbar.php';
				}
			?>
		</div>
