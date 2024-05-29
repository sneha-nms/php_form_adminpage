




<nav class="bg-black py-4 text-white" id="nav">
    <div class="container mx-auto flex items-center justify-around">
        <div class="flex items-center">
            <a href="#" class="text-xl font-semibold ">Hownward University</a>
        </div>
        <div  id="btnn"class="w-20 p-2 rounded-md text-center border border-solid border-black">
            <?php if (isset($_SESSION['email']) ||isset($_SESSION['admin'])) : ?>
                <button  class="hover:text-white focus:outline-none text-center">
                    <a href="./controller/logout.php">Logout</a>
                </button>


            <?php else : ?>
                <button  id="btnn"class="hover:text-white focus:outline-none text-center">
                    <a href="/login.php">Login</a>
                </button>
            <?php endif; ?>

        </div>
</nav>