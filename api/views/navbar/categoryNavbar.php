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
    <ul class="flex space-x-2 items-center w-5/6 justify-center">
        <?php
            foreach ($categories as $category) {
                echo "<li class='p-2 hover:bg-gray-200 cursor-pointer'>". $category ."</li>";
            }
        ?>
    </ul>
</div>