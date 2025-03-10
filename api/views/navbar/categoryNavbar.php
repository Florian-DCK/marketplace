<script src="https://unpkg.com/@tailwindcss/browser@4"></script>

<?php

$categories = [
    "Food",
    "Tech",
    "Furnitures",
    "Books",
    "Sports",
    "Crafts",
    "Pets",
    "Human slavery",
    "Cars",
    "Clothes",
    "Beauty, healthcare and wellness",
    "Kitchen and houses",
]



?>

<div class="bg-[#EAEBED] w-full flex justify-center">
    <ul class="flex space-x-2 items-center w-[90%] justify-center shadow-[0_10px_10px_-10px_rgba(0,0,0,0.1)]">
        <?php
            foreach ($categories as $category) {
                echo "<a href='"."/search?category=".$category."'><li class='p-2 hover:bg-gray-200 cursor-pointer'>". $category ."</li> </a>";
            }
        ?>
    </ul>
</div>