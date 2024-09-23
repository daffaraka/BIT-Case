<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">

                <x-nav-link :active="request()->routeIs('home')" href="/home">Home</x-nav-link>
                <x-nav-link :active="request()->routeIs('kontak')" href="/kontak">Kontak</x-nav-link>
                <x-nav-link :active="request()->routeIs('about')" href="/about">about</x-nav-link>



            </ul>
        </div>
    </div>
</nav>
