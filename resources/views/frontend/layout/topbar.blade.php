<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Small Shop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
            </li>
            
            @guest
            <li class="nav-item">
                <a class="nav-link" href="/login">Login / Register</a>
            </li>
            @endguest            
            
            @if (Auth::check())
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ Auth::user()->name }} <!-- Display the user's name -->
                </a>
                <ul class="dropdown-menu">
                    
                    <li><a class="dropdown-item" href="#">Cart</a></li>
                    <li><a class="dropdown-item" href="#">Order</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Logout</a></li>

                    
                </ul>
            </li>
            @endif
           

        </ul>
    </div>
</nav>