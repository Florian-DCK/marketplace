<script src="https://unpkg.com/@tailwindcss/browser@4"></script>

<main class="h-screen w-screen flex flex-col">
    <?php include __DIR__ . '/../navbar/navbar.php'; ?>
    <div class="bg-[#EAEBED] h-full flex flex-1">
    <?php   include __DIR__ . '/../dashboard/sidebar.php';
            include __DIR__ . '/../dashboard/userInfos.php';
    ?>
    </div>
    
</main>

