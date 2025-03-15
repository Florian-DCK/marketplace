
<div class="relative">
    <div class="flex items-center space-x-3 cursor-pointer" id="profile-trigger">
        <p class="select-none" id="user-menu-button-text">John Doe</p>
        <button type="button" class="relative flex rounded-full bg-gray-800 text-sm focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden cursor-pointer" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
            <span class="absolute -inset-1.5"></span>
            <span class="sr-only">Open user menu</span>
            <img class="size-10 rounded-full transit" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
        </button>
    </div>
    <div id="user-menu-dropdown" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 ring-1 shadow-lg ring-black/5 focus:outline-hidden hidden transform opacity-0 scale-95 transition-all duration-100 ease-in-out" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
        <!-- Active: "bg-gray-100 outline-hidden", Not Active: "" -->
        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>
        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.getElementById('user-menu-button');
    const menuButtonText = document.getElementById('user-menu-button-text');
    const profileTrigger = document.getElementById('profile-trigger');
    const menuDropdown = document.getElementById('user-menu-dropdown');
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

    // Ajouter l'événement de clic sur toute la zone du profil
    profileTrigger.addEventListener('click', toggleMenu);

    // Fermer le menu si on clique en dehors
    document.addEventListener('click', function(event) {
        if (!profileTrigger.contains(event.target) && !menuDropdown.contains(event.target) && isOpen) {
            toggleMenu();
        }
    });

    // Gérer la fermeture avec la touche Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && isOpen) {
            toggleMenu();
        }
    });
});
</script>