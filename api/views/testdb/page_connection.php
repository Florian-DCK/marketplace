<script src="https://unpkg.com/@tailwindcss/browser@4"></script>

<form action="../../../api/models/connection_et_inscription/connection.php" method="POST" class="h-screen flex flex-col justify-center items-center bg-[#FFD1A9]">
    <div class="mb-8">
        <p class="font-semibold tracking-tight text-5xl text-white">Sign in to your account</p>
    </div>
    <div class="flex relative mb-8">
        <input type="email" 
        name="email"
        placeholder="Email" 
        required
        class="peer p-2 ps-10 rounded-sm bg-[#EAEBED] w-md border border-transparent text-[#9F9F9F] w-full focus:outline-none invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 invalid:[&:not(:placeholder-shown):not(:focus)]:text-red-500">
        <svg width="800" height="800" viewBox="0 0 40 40" 
        class="w-8 h-8 flex text-red-500 items-center absolute top-1/2  transform -translate-y-1/2 m-0 pl-2  peer-[&:not(:placeholder-shown):not(:focus):invalid]:[&_*]:fill-red-500">
            <path d="M34.285 10H5.714a.714.714 0 0 0-.714.714v18.571c0 .395.32.715.714.715h28.571c.396 0 .715-.32.715-.715V10.714a.713.713 0 0 0-.715-.714zM6.429 12.269l8.818 7.068-8.818 8.124V12.269zM20 21.318l-12.335-9.89h24.671L20 21.318zm-3.626-1.077 3.178 2.548.004.002.021.017c.013.009.025.019.038.026l.024.015a.463.463 0 0 0 .043.024c.007.002.013.006.019.01a.91.91 0 0 0 .07.027c.021.006.044.014.066.017.006.002.011.004.017.004a.363.363 0 0 0 .056.009c.005.002.012.002.017.002a.437.437 0 0 0 .143 0c.005 0 .011 0 .016-.002a.34.34 0 0 0 .074-.013c.022-.003.044-.011.066-.017.001-.002.002-.002.003-.002l.067-.025c.007-.004.013-.008.019-.01l.045-.024c.008-.005.016-.009.023-.015l.037-.026a.128.128 0 0 0 .022-.017l.004-.002 3.178-2.548 9.043 8.33H7.332l9.042-8.33zm8.38-.904 8.817-7.068v15.175l-8.817-8.107z"/></svg>
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