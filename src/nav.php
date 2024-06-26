<nav class="sticky top-0 flex items-center justify-between flex-wrap bg-primary-color p-6">
    <div class="flex items-center flex-shrink-0 text-white mr-6">
        <svg class="fill-none stroke-current h-8 w-8 mr-2" width="54" height="54" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M20 7L9.00004 18L3.99994 13" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <a href="/auth" class="font-semibold text-xl tracking-tight">Auth</a>
    </div>
    <div id="menu" class="block lg:hidden">
        <button
            class="flex items-center px-3 py-2 border rounded text-secondary-color border-primary-color hover:text-white hover:border-white">
            <svg class="fill-white h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <title>Menu</title>
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
            </svg>
        </button>
    </div>
    <div id="nav-link" class="h-0 lg:h-auto overflow-hidden w-full block flex-grow lg:flex lg:items-center lg:w-auto">
        <div class="text-sm lg:flex-grow">
            <a href="#responsive-header"
                class="block mt-4 lg:inline-block lg:mt-0 text-tertiary-color hover:text-white mr-4">
                Docs
            </a>
            <a href="draggables.php"
                class="block mt-4 lg:inline-block lg:mt-0 text-tertiary-color hover:text-white mr-4">
                Examples
            </a>
            <a href="clamp.php"
                class="block mt-4 lg:inline-block lg:mt-0 text-tertiary-color hover:text-white">
                Blog
            </a>
        </div>
        <div>
            <a href="login.php"
                class="inline-block text-sm px-4 py-2 leading-none bg-secondary-color lg:bg-transparent border lg:border-0 rounded hover:border-white text-white hover:text-primary-color hover:bg-white mt-4 lg:mt-0">Login</a>
            <a href="register.php"
                class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-primary-color hover:bg-white mt-4 lg:mt-0">Register</a>
        </div>
    </div>
</nav>