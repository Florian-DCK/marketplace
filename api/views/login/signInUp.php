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
            <span class="flex items-center">
                <div class="h-12 w-12 bg-[#5242AE] rounded-full m-3"
                    id="avatar">
                </div>
                <h1 class="hidden sm:flex sm:text-3xl lg:text-5xl">Marketplace</h1>
            </span>
        </div>
        <div id="login-section" class="w-screen h-screen flex flex-col lg:flex-row"> <!-- Log in dominant -->
            <?php include_once __DIR__ . '/signIn.php'; ?>
            <div name="switch-to-signup" class="w-1/2 p-5 flex flex-col lg:text-xl xl:text-2xl mx-auto items-center my-auto whitespace-nowrap font-semibold tracking-tight text-3xl text-[#FFD1A9]">
                <p class="mb-5 hidden lg:flex">Welcome !</p>
                <p class="mb-5 hidden lg:flex">Pour créer votre compte,</p>
                <p class="mb-5 hidden lg:flex">c'est par ici !</p>
                <button id="show-signup" type="button" class="cursor-pointer flex my-5 justify-center font-semibold text-xl text-white bg-[#FFD1A9] border rounded-full w-60 lg:w-50 py-3 hover:bg-white hover:text-[#FFD1A9] hover:duration-500 ease-in-out hover:scale-115">Create account</button> 
            </div>
        </div>
        <div id="signup-section" class="w-full h-screen flex flex-col lg:flex-row hidden transition-all"> <!-- Sign up dominant -->
            <div name="switch-to-login" class="pt-20 lg:h-full flex flex-col text-center items-center justify-center px-5 font-semibold tracking-tight text-3xl bg-[#FFD1A9] text-white">
                <p class="mb-5 hidden lg:flex">Welcome back !</p>
                <p class="mb-5 hidden lg:flex">Pour continuer,</p>
                <p class="mb-5 hidden lg:flex">veuillez vous connecter !</p>
                <button id="show-login" type="button" class="mb-5 cursor-pointer flex justify-center font-semibold text-xl bg-white text-[#FFD1A9] rounded-full w-60 py-3 hover:bg-[#FFD1A9] hover:text-white hover:duration-500 ease-in-out hover:scale-115 border">Log in</button>
            </div>
            <?php include_once __DIR__ . '/signUp.php'; ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginSection = document.getElementById('login-section');
            const signupSection = document.getElementById('signup-section');
            const showSignupBtn = document.getElementById('show-signup');
            const showLoginBtn = document.getElementById('show-login');

            // Afficher le formulaire d'inscription et masquer le formulaire de connexion
            showSignupBtn.addEventListener('click', function() {
                loginSection.classList.add('hidden');
                signupSection.classList.remove('hidden');
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