<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Connexion</title>
    <link rel="stylesheet" href="global.css">
</head>

<?php 
    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
?>

<body>
    <div class="flex justify-center items-center h-screen w-screen static">
        <div class="absolute top-0 left-0">
            <a href="/">
                <span class="flex items-center">
                    <div class="h-12 w-12 bg-[#5242AE] rounded-full m-3"
                        id="avatar">
                    </div>
                    <h1 class="hidden font-bold sm:flex sm:text-3xl lg:text-5xl text-white">Hello World !</h1>
                </span>
            </a>
        </div>
        <div id="login-section" class="w-screen h-screen flex flex-col lg:flex-row"> <!-- Log in dominant -->
            <?php include_once __DIR__ . '/signIn.php'; ?>
            <div 
                name="switch-to-signup" 
                class="w-1/2 p-5 flex flex-col lg:text-xl xl:text-2xl mx-auto items-center my-auto whitespace-nowrap font-semibold tracking-tight text-3xl text-[#5242AE]">
                <p class="mb-5 hidden lg:flex">Welcome !</p>
                <p class="mb-5 hidden lg:flex">To create your account,</p>
                <p class="mb-5 hidden lg:flex">Click below !</p>
                <button 
                    id="show-signup" 
                    type="button" 
                    class="cursor-pointer flex my-5 justify-center font-semibold text-xl text-white bg-[#5242AE] border rounded-full w-60 lg:w-40 py-3 hover:bg-white hover:text-[#5242AE] hover:duration-500 ease-in-out hover:scale-115">Create
                </button> 
            </div>
        </div>
        <div id="signup-section" class="w-full h-screen hidden flex-col lg:flex-row"> <!-- Sign up dominant -->
            <div name="switch-to-login" class="lg:w-1/2 pt-20 lg:h-full flex flex-col text-center items-center justify-center px-5 font-semibold tracking-tight text-3xl bg-gradient-to-br from-[#5242AE] to-[#8d54b1] text-white">
                <p class="mb-5 hidden lg:flex">Welcome back !</p>
                <p class="mb-5 hidden lg:flex">To proceed,</p>
                <p class="mb-5 hidden lg:flex">Please log in !</p>
                <button 
                    id="show-login" 
                    type="button" 
                    class="mb-5 cursor-pointer flex justify-center font-semibold text-xl bg-white text-[#5242AE] rounded-full w-60 lg:w-40 py-3 hover:bg-[#5242AE] hover:text-white hover:duration-500 ease-in-out hover:scale-115 border">Log in
                </button>
            </div>
            <?php include_once __DIR__ . '/signUp.php'; ?>
        </div>
    </div>

    

    <script>

        // Afficher le nom du fichier selectionné
        let file = document.getElementById('fileInput');
                let message = document.getElementById('avatarPlaceholder');

                file.addEventListener("input", () => {
                //si on selectionne une image
                    if (file.files.length) {
                        let fileName = file.files[0].name;
                        message.innerHTML = `${fileName}`;
                    }
                //si on annule la selection
                    else {
                        message.innerHTML = "Click to upload avatar";
                    }
                });

        document.addEventListener('DOMContentLoaded', function() {
            const loginSection = document.getElementById('login-section');
            const signupSection = document.getElementById('signup-section');
            const showSignupBtn = document.getElementById('show-signup');
            const showLoginBtn = document.getElementById('show-login');
            const avatarBtn = document.getElementById('fileInput');
            const avatarPlaceholder = document.getElementById('avatarPlaceholder');

            //Masquer le text Click to upload avatar et remplacer par le fichier up
            //avatarBtn.addEventListener('click', function() {
                //avatarPlaceholder.classList.add('hidden');
                //document.getElementById('avatarPlaceholder').innerText = '';});

            // Afficher le formulaire d'inscription et masquer le formulaire de connexion
            showSignupBtn.addEventListener('click', function() {
                loginSection.classList.add('hidden');
                signupSection.classList.remove('hidden');
                signupSection.classList.add('flex');
            });

            // Afficher le formulaire de connexion et masquer le formulaire d'inscription
            showLoginBtn.addEventListener('click', function() {
                signupSection.classList.add('hidden');
                loginSection.classList.remove('hidden');
            });

            
        });
    </script>
</body>
</html>