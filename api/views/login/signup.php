<script src="https://unpkg.com/@tailwindcss/browser@4"></script>

<form action="" method="" class="h-screen flex flex-col justify-center items-center w-full">
    <div class="mb-8">
        <p class="font-semibold tracking-tight text-6xl text-[#FFD1A9]">Create your account</p>
    </div>
    <div class="flex relative mb-8">
        <input type="text" 
                name="first_name"
                placeholder="Prénom" 
                required
                class="peer p-2 ps-10 rounded-sm bg-[#EAEBED] w-md border border-transparent text-[#9F9F9F] w-full focus:outline-none invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 invalid:[&:not(:placeholder-shown):not(:focus)]:text-red-500">
                    <svg fill="none" stroke="#9F9F9F" stroke-linecap="square" aria-labelledby="userIconTitle" viewBox="0 0 24 24"
                    class="w-8 h-8 flex text-red-500 items-center absolute top-1/2  transform -translate-y-1/2 m-0 pl-2  peer-[&:not(:placeholder-shown):not(:focus):invalid]:[&_*]:fill-red-500">
                    <path stroke-linecap="round" d="M5.5 19.5c2.333-1 3.833-1.833 4.5-2.5 1-1-2-1-2-6 0-3.333 1.333-5 4-5s4 1.667 4 5c0 5-3 5-2 6 .667.667 2.167 1.5 4.5 2.5"/><circle cx="12" cy="12" r="10"/>
                    </svg>
    </div>
    <div class="flex relative mb-8">
        <input type="text" 
                name="last_name"
                placeholder="Nom" 
                required
                class="peer p-2 ps-10 rounded-sm bg-[#EAEBED] w-md border border-transparent text-[#9F9F9F] w-full focus:outline-none invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 invalid:[&:not(:placeholder-shown):not(:focus)]:text-red-500">
                    <svg fill="none" stroke="#9F9F9F" stroke-linecap="square" aria-labelledby="userIconTitle" viewBox="0 0 24 24"
                    class="w-8 h-8 flex text-red-500 items-center absolute top-1/2  transform -translate-y-1/2 m-0 pl-2  peer-[&:not(:placeholder-shown):not(:focus):invalid]:[&_*]:fill-red-500">
                    <path stroke-linecap="round" d="M5.5 19.5c2.333-1 3.833-1.833 4.5-2.5 1-1-2-1-2-6 0-3.333 1.333-5 4-5s4 1.667 4 5c0 5-3 5-2 6 .667.667 2.167 1.5 4.5 2.5"/><circle cx="12" cy="12" r="10"/>
                    </svg>
    </div>
    <div class="flex relative mb-8">
        <input type="email" 
                name="email"
                placeholder="Email" 
                required
                class="peer p-2 ps-10 rounded-sm bg-[#EAEBED] w-md border border-transparent text-[#9F9F9F] w-full focus:outline-none invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 invalid:[&:not(:placeholder-shown):not(:focus)]:text-red-500">
            <svg width="800" height="800" fill="#9F9F9F" viewBox="0 0 40 40" 
                class="w-8 h-8 flex text-red-500 items-center absolute top-1/2  transform -translate-y-1/2 m-0 pl-2  peer-[&:not(:placeholder-shown):not(:focus):invalid]:[&_*]:fill-red-500">
                <path d="M34.285 10H5.714a.714.714 0 0 0-.714.714v18.571c0 .395.32.715.714.715h28.571c.396 0 .715-.32.715-.715V10.714a.713.713 0 0 0-.715-.714zM6.429 12.269l8.818 7.068-8.818 8.124V12.269zM20 21.318l-12.335-9.89h24.671L20 21.318zm-3.626-1.077 3.178 2.548.004.002.021.017c.013.009.025.019.038.026l.024.015a.463.463 0 0 0 .043.024c.007.002.013.006.019.01a.91.91 0 0 0 .07.027c.021.006.044.014.066.017.006.002.011.004.017.004a.363.363 0 0 0 .056.009c.005.002.012.002.017.002a.437.437 0 0 0 .143 0c.005 0 .011 0 .016-.002a.34.34 0 0 0 .074-.013c.022-.003.044-.011.066-.017.001-.002.002-.002.003-.002l.067-.025c.007-.004.013-.008.019-.01l.045-.024c.008-.005.016-.009.023-.015l.037-.026a.128.128 0 0 0 .022-.017l.004-.002 3.178-2.548 9.043 8.33H7.332l9.042-8.33zm8.38-.904 8.817-7.068v15.175l-8.817-8.107z"/>
            </svg>
    </div>
    <div class="flex relative mb-8">
        <input type="password" 
                name="password"  
                placeholder="Password" 
                required
                class="peer p-2 ps-10 rounded-sm bg-[#EAEBED] w-md border border-transparent text-[#9F9F9F] w-full focus:outline-none invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 invalid:[&:not(:placeholder-shown):not(:focus)]:text-red-500">
            <svg  width="800" height="800" fill="#9F9F9F" viewBox="0 0 128 128"
                class="w-8 h-8 flex text-red-500 items-center absolute top-1/2  transform -translate-y-1/2 m-0 pl-2  peer-[&:not(:placeholder-shown):not(:focus):invalid]:[&_*]:fill-red-500">
                <path d="M64 1C47.5 1 34 14.5 34 31v26H15v70h99V57H94V31C94 14.5 80.5 1 64 1zM42 31c0-12.1 9.9-22 22-22s22 9.9 22 22v26H42V31zm64 34v54H23V65h83z"/><path d="M60 81h8v22h-8z"/>
            </svg>
    </div>
    <div class="flex relative mb-8">
        <input type="password" 
                name="confirm_password"  
                placeholder="Confirm password" 
                required
                class="peer p-2 ps-10 rounded-sm bg-[#EAEBED] w-md border border-transparent text-[#9F9F9F] w-full focus:outline-none invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 invalid:[&:not(:placeholder-shown):not(:focus)]:text-red-500">
            <svg width="800" height="800" fill="#9F9F9F" viewBox="0 0 72 72"
                class="w-8 h-8 flex text-red-500 items-center absolute top-1/2  transform -translate-y-1/2 m-0 pl-2  peer-[&:not(:placeholder-shown):not(:focus):invalid]:[&_*]:fill-red-500">
                <path d="M24.014 70.462a9.718 9.718 0 0 1-6.917-2.859L2.175 53.877C.267 51.971-.751 49.513-.751 46.898s1.018-5.072 2.866-6.92a9.723 9.723 0 0 1 6.921-2.866c2.591 0 5.029 1 6.872 2.818l8.102 7.109L55.861 4.618c.057-.075.119-.146.186-.213 1.849-1.85 4.307-2.867 6.921-2.867s5.072 1.018 6.921 2.867c3.784 3.784 3.815 9.923.093 13.747L31.697 67.416a2.242 2.242 0 0 1-.165.188c-1.914 1.912-4.498 2.926-7.214 2.854-.102.002-.202.004-.304.004zM9.037 41.112a5.753 5.753 0 0 0-4.093 1.695C3.851 43.9 3.25 45.353 3.25 46.898s.602 3 1.694 4.093l14.922 13.726c1.148 1.146 2.6 1.914 4.148 1.914l.227.164h.151l.221-.164c1.51 0 2.929-.654 4.008-1.69l38.275-49.294c.051-.065.105-.148.165-.207 2.256-2.258 2.256-5.939 0-8.195a5.754 5.754 0 0 0-4.093-1.701 5.743 5.743 0 0 0-3.999 1.602L25.914 51.169a2 2 0 0 1-2.919.301l-9.771-8.573a1.967 1.967 0 0 1-.095-.089 5.746 5.746 0 0 0-4.092-1.696z"/></svg>
    </div>
    <button type="submit" class="cursor-pointer flex justify-center font-semibold text-xl text-white bg-[#FFD1A9] border rounded-full w-60 py-3 hover:bg-white hover:text-[#FFD1A9] duration-500 ease-in-out hover:scale-115">Sign in</button>   
</form>
