<link rel="stylesheet" href="/global.css">
<main class="h-screen w-screen flex flex-col">
    <?php include __DIR__ . '/../navbar/navbar.php'; ?>
    <div class="bg-[#EAEBED] h-full flex flex-1">
    <?php  
        include __DIR__ . '/../dashboard/sidebar.php';
        if(str_contains($url, 'addUser')) {
            include __DIR__ . '/userAdd.php';
        } elseif(str_contains($url, 'dashboard/admin/users')){
            include __DIR__ .'/userList.php';
        }
    ?>
    </div>
    
</main>
