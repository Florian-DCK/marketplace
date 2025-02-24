<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Connexion</title>
</head>
<body>
    <div class="flex justify-center items-center h-screen w-screen">
        <div class="w-full flex hidden">
            <?php include_once 'login.php'; ?>
            <div name="switch-to-signup" class="w-1/2">
                <p>Vous n'avez pas de compte ?</p>
            </div>
        </div>
        <div class="w-full flex ">
            <div name="switch-to-login" class="bg-[#FFD1A9] w-1/2">
                <p>Vous avez déjà un compte ?</p>
            </div>
            <?php include_once 'signup.php'; ?>
        </div>
    </div>
</body>
</html>