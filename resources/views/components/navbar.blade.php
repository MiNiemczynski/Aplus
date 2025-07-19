<nav class="navbar aplus-bg-dark-blue text-white sticky-top">
    <div class="container-fluid">
        <span class="fs-4 fw-bold mx-3">Welcome, {{ $user->Name }}</span>
        <div class="d-flex ms-auto me-3 gap-4">
            <form class="" role="search">
                <div class="d-flex">
                    <input class="form-control me-2" type="search" name="search" value="{{ $search ?? "" }}" placeholder="Search" />
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </div>
            </form>
            <a class="nav-link" title="Log out" href="/logout"><i class="bi bi-box-arrow-left fs-3 text-white"></i></a>
            <a class="nav-link" title="Acount" href=""><i class="bi bi-person-circle fs-3 text-white"></i></a>
            <a class="nav-link" title="Settings" href=""><i class="bi bi-gear fs-3 text-white"></i></a>
        </div>
    </div>
</nav>