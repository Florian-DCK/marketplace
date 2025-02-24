<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Connexion</title>
</head>
<body>
    <div class="flex justify-center items-center h-screen w-screen">
        <div class="w-full flex">
            <?php include_once 'login.php'; ?>
            <div name="switch-to-signup" class="w-1/2 flex flex-col items-center my-auto font-semibold tracking-tight text-3xl text-[#FFD1A9]">
                <p class="mb-5">Welcome !</p>
                <p class="mb-5">Pour créer votre compte,</p>
                <p class="mb-5">c'est par ici !</p>
                <button type="submit" class="cursor-pointer flex justify-center font-semibold text-xl text-white bg-[#FFD1A9] border rounded-full w-60 py-3 hover:bg-white hover:text-[#FFD1A9] duration-500 ease-in-out hover:scale-115">Sign in</button> 
            </div>
        </div>
        <div class="w-full hidden">
            <div name="switch-to-login" class="w-1/2 flex flex-col items-center font-semibold tracking-tight text-3xl bg-[#FFD1A9] text-white">
                <p class="mb-5 mt-auto">Welcome back !</p>
                <p class="mb-5">Pour continuer,</p>
                <p class="mb-5">veuillez vous connecter !</p>
                <button type="submit" class="mb-auto cursor-pointer flex justify-center font-semibold text-xl bg-white text-[#FFD1A9] rounded-full w-60 py-3 hover:bg-[#FFD1A9] hover:text-white duration-500 ease-in-out hover:scale-115 border">Log in</button>
            </div>
            <?php include_once 'signup.php'; ?>
        </div>
    </div>
</body>
</html>