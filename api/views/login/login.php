<script src="https://unpkg.com/@tailwindcss/browser@4"></script>

<form action="" method="" class="h-screen flex flex-col justify-center items-center bg-[#FFD1A9]">
    <div class="mb-8">
        <p class="font-semibold tracking-tight text-5xl text-white">Sign in to your account</p>
    </div>
    <div class="flex relative mb-8">
        <input type="email" 
        name="email"
        placeholder="Email" 
        required
        class="peer p-2 ps-10 rounded-sm bg-[#EAEBED] w-md border border-transparent text-[#9F9F9F] w-full focus:outline-none invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 invalid:[&:not(:placeholder-shown):not(:focus)]:text-red-500">
        <img src="../../public/svg/email.svg" alt="password_logo" class="w-8 h-8 flex items-center absolute top-1/2  transform -translate-y-1/2 m-0 pl-2  peer-[&:not(:placeholder-shown):not(:focus):invalid]:fill-red-500">
    </div>
    <div class="flex relative mb-8">
        <span class="flex items-center absolute top-1/2  transform -translate-y-1/2 m-0 pl-2"><img src="../../public/svg/closed-lock-password.svg" alt="password_logo" class="w-5 h-5"></span>
        <input type="password" 
                name="password"
                placeholder="Email" 
                required
                class="p-2 ps-10 rounded-sm bg-[#EAEBED] w-md border border-transparent text-[#9F9F9F] w-full focus:outline-none invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 invalid:[&:not(:placeholder-shown):not(:focus)]:text-red-500">
    </div>
    <button type="submit" class="cursor-pointer flex justify-center font-semibold text-xl bg-white text-[#FFD1A9] rounded-full w-60 py-3 hover:bg-[#FFD1A9] hover:text-white duration-500 ease-in-out hover:scale-115 border">Log in</button>   
</form>
