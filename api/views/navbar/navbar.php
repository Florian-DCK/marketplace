
<script src="https://unpkg.com/@tailwindcss/browser@4"></script>

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
					<a href="">
						<svg fill="none" class="size-6 cursor-pointer hover:bg-gray-300 rounded-md stroke-black" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 9h10M7 13h10m4 7-3.324-1.662a4.161 4.161 0 0 0-.51-.234 2.007 2.007 0 0 0-.36-.085c-.139-.019-.28-.019-.561-.019H6.2c-1.12 0-1.68 0-2.108-.218a2 2 0 0 1-.874-.874C3 16.48 3 15.92 3 14.8V7.2c0-1.12 0-1.68.218-2.108a2 2 0 0 1 .874-.874C4.52 4 5.08 4 6.2 4h11.6c1.12 0 1.68 0 2.108.218a2 2 0 0 1 .874.874C21 5.52 21 6.08 21 7.2V20Z"/></svg>
					</a>
					<?php include 'dropdown.php'; ?>
				</div>
			</div>
            <?php include 'categoryNavbar.php'; ?>
		</div>
