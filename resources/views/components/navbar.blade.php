<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Dunamic CRUD</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item {{ request()->routeIs('read') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('read') }}">Dynamic crud</a>
            </li>
            <li class="nav-item {{ request()->routeIs('ajax.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('ajax.index') }}">Using With Ajax</a>
            </li>
            <li class="nav-item {{ request()->routeIs('ajax.modal') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('ajax.modal') }}">Modal With Ajax</a>
            </li>
        </ul>
    </div>
</nav>