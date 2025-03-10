<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Connexion</title>
</head>
<body>
    <div class="flex justify-center items-center h-screen w-screen">
        <div class="w-screen h-screen flex flex-col lg:flex-row hidden"> <!-- Log in dominant -->
            <?php include_once 'login.php'; ?>
            <div name="switch-to-signup" class="w-1/2 p-5 flex flex-col lg:text-xl xl:text-2xl mx-auto items-center my-auto whitespace-nowrap font-semibold tracking-tight text-3xl text-[#FFD1A9]">
                <p class="mb-5 hidden lg:flex">Welcome !</p>
                <p class="mb-5 hidden lg:flex">Pour créer votre compte,</p>
                <p class="mb-5 hidden lg:flex">c'est par ici !</p>
                <button type="submit" class="cursor-pointer flex my-5 justify-center font-semibold text-xl text-white bg-[#FFD1A9] border rounded-full w-60 lg:w-50 py-3 hover:bg-white hover:text-[#FFD1A9] hover:duration-500 ease-in-out hover:scale-115">Create account</button> 
            </div>
        </div>
        <div class="w-full h-screen flex flex-col lg:flex-row"> <!-- Sign up dominant --> <!-- pt-70 à check -->
            <div name="switch-to-login" class="pt-5 lg:h-full flex flex-col text-center items-center justify-center px-5 font-semibold tracking-tight text-3xl bg-[#FFD1A9] text-white">
                <p class="mb-5 hidden lg:flex">Welcome back !</p>
                <p class="mb-5 hidden lg:flex">Pour continuer,</p>
                <p class="mb-5 hidden lg:flex">veuillez vous connecter !</p>
                <button type="submit" class="mb-5 cursor-pointer flex justify-center font-semibold text-xl bg-white text-[#FFD1A9] rounded-full w-60 py-3 hover:bg-[#FFD1A9] hover:text-white hover:duration-500 ease-in-out hover:scale-115 border">Log in</button>
            </div>
            <?php include_once 'signup.php'; ?>
        </div>
    </div>
</body>
</html>