<script src="https://unpkg.com/@tailwindcss/browser@4"></script>

<form action="" method="" class="h-screen flex flex-col justify-center items-center bg-[#FFD1A9]">
    <div class="mb-8">
        <p class="font-semibold tracking-tight text-5xl text-white">Sign in to your account</p>
    </div>
    <div class="flex mb-8 p-2 rounded-sm bg-[#EAEBED] w-md">
        <span class="flex items-center pl-2"><img src="../../public/svg/email.svg" alt="email_logo" class="w-5 h-5"></span>
        <input type="text" name="email" class="p-1 text-[#9F9F9F]" placeholder="Email">
    </div>
    <div class="flex mb-8 p-2 rounded-sm bg-[#EAEBED] w-md">
        <span class="flex items-center pl-2"><img src="../../public/svg/closed-lock-password.svg" alt="password_logo" class="w-5 h-5"></span>
        <input type="text" name="password" class="p-1 text-[#9F9F9F]" placeholder="Password">
    </div>
    <button type="submit" class="cursor-pointer flex justify-center font-semibold text-xl text-white border rounded-full w-60 py-3 hover:bg-white hover:text-[#FFD1A9] duration-500 ease-in-out hover:scale-115">Log in</button>   
</form>
