    
<div>
    <img id="menu-button" src="/api/public/svgs/hamburger.svg" alt="Menu" class="size-6 cursor-pointer hover:bg-gray-300 rounded-md">
    <div id="menu-dropdown" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 ring-1 shadow-lg ring-black/5 focus:outline-hidden hidden transform opacity-0 scale-95 transition-all duration-100 ease-in-out" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
        <!-- Active: "bg-gray-100 outline-hidden", Not Active: "" -->
        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>
        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
    </div>
</div>

<script>
    const menuButton = document.getElementById('menu-button');
    const menuDropdown = document.getElementById('menu-dropdown');
    let isOpen = false;

    function toggleMenu() {
        isOpen = !isOpen;
        menuButton.setAttribute('aria-expanded', isOpen);
        
        if (isOpen) {
            menuDropdown.classList.remove('hidden');
            setTimeout(() => {
                menuDropdown.classList.remove('opacity-0', 'scale-95');
                menuDropdown.classList.add('opacity-100', 'scale-100');
            }, 10);
        } else {
            menuDropdown.classList.remove('opacity-100', 'scale-100');
            menuDropdown.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                menuDropdown.classList.add('hidden');
            }, 100);
        }
    }

    menuButton.addEventListener('click', toggleMenu);

    document.addEventListener('click', function(event) {
        if (!menuButton.contains(event.target) && !menuDropdown.contains(event.target) && isOpen) {
            toggleMenu();
        }
    });
    
</script>
