
<script src="https://unpkg.com/@tailwindcss/browser@4"></script>

		<div class="relative h-max w-screen bg-[#EAEBED]">
			<div class="flex items-center justify-between">
				<span class="flex items-center">
					<div
						class=" h-12 w-12 bg-[#5242AE] rounded-full m-3"
						id="avatar"></div>
					<h1 class=" text-5xl">Marketplace</h1>
				</span>
				<!-- <SearchBar /> -->
                <?php include 'searchBar.php'; ?>
				<div>
					<?php include 'profiles.php'; ?>
				</div>
			</div>
			<!-- <CategoryNavbar /> -->
            <?php include 'categoryNavbar.php'; ?>
		</div>
