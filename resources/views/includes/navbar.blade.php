<style>
  :root {
    --primary-color: #ff385c;
    --primary-dark: #e31c5f;
    --text-dark: #222222;
    --text-light: #717171;
    --border-color: #dddddd;
    --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.08);
    --shadow-md: 0 2px 8px rgba(0, 0, 0, 0.12);
  }
  
  .navbar {
    min-height: 80px;
    padding: 0 40px;
    background-color: #ffffff;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 9999;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    width: 100%;
  }
  
  .navbar-brand {
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
  }
  
  .navbar-brand i {
    color: var(--primary-color);
    font-size: 2rem;
  }
  
  .navbar-brand-text {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-color);
    letter-spacing: -0.5px;
  }
  
  .navbar-center {
    flex: 1;
    display: flex;
    justify-content: center;
    max-width: 500px;
    margin: 0 auto;
  }
  
  .search-container {
    width: 100%;
    max-width: 350px;
  }
  
  .search-bar {
    display: flex;
    align-items: center;
    background: #ffffff;
    border: 1px solid var(--border-color);
    border-radius: 40px;
    padding: 4px;
    box-shadow: var(--shadow-sm);
    transition: all 0.2s ease;
    gap: 8px;
  }
  
  .search-bar:hover {
    box-shadow: var(--shadow-md);
  }
  
  .search-bar:focus-within {
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
  }
  
  .search-input {
    flex: 1;
    border: none;
    outline: none;
    padding: 8px 12px;
    font-size: 0.9rem;
    color: var(--text-dark);
    background: transparent;
    min-width: 0;
    pointer-events: auto;
    border-radius: 0;
    box-shadow: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
  }
  
  .search-input::placeholder {
    color: var(--text-light);
    background: transparent;
  }
  
  .search-button {
    background: white;
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
    border-radius: 50%;
    width: 36px;
    height: 36px;
    min-width: 36px;
    min-height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    cursor: pointer;
    transition: all 0.2s ease;
    pointer-events: auto;
  }
  
  .search-button:hover {
    background: var(--primary-color);
    color: white;
  }
  
  .search-button i {
    font-size: 0.85rem;
    pointer-events: none;
  }
  
  .navbar-actions {
    display: flex;
    align-items: center;
    gap: 16px;
  }
  
  .nav-link-item {
    text-decoration: none;
    color: var(--text-dark);
    font-size: 1.05rem;
    font-weight: 500;
    padding: 8px 16px;
    border-radius: 24px;
    transition: all 0.2s ease;
    white-space: nowrap;
  }
  
  .nav-link-item:hover {
    background-color: rgba(255, 56, 92, 0.1);
    color: var(--primary-color);
  }
  
  .menu-icon {
    display: none;
    cursor: pointer;
    padding: 8px;
    border-radius: 8px;
    transition: all 0.2s ease;
  }
  
  .menu-icon:hover {
    background-color: #f7f7f7;
  }
  
  .menu-icon i {
    color: var(--text-dark);
    font-size: 1.5rem;
  }
  
  .mobile-menu {
    display: none;
  }

  .mobile-search {
    display: none;
  }


  /* Desktop: Show desktop search, hide mobile search */
  @media (min-width: 1101px) {
    .mobile-search {
      display: none !important;
    }
  }
  
  @media (max-width: 1100px) {
    .navbar {
      padding: 0 24px;
    }
    
    .navbar-center {
      display: none;
    }
    
    .navbar-actions {
      display: none;
    }
    
    .menu-icon {
      display: block;
    }

    .mobile-search {
      display: flex;
      align-items: center;
      justify-content: center;
      flex: 1;
      margin: 0 auto;
      max-width: 400px;
    }

    .mobile-search-bar {
      display: flex;
      align-items: center;
      background: white;
      border: 1px solid var(--border-color);
      border-radius: 24px;
      padding: 4px;
      width: 100%;
      transition: all 0.2s ease;
      gap: 6px;
      box-shadow: var(--shadow-sm);
    }

    .mobile-search-bar:hover {
      box-shadow: var(--shadow-md);
    }

    .mobile-search-bar:focus-within {
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
    }

    .mobile-search-input {
      flex: 1;
      border: none;
      outline: none;
      padding: 6px 12px;
      font-size: 0.85rem;
      color: var(--text-dark);
      background: transparent;
      min-width: 0;
      border-radius: 0;
      box-shadow: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
    }

    .mobile-search-input::placeholder {
      color: var(--text-light);
      background: transparent;
    }

    .mobile-search-button {
      background: white;
      color: var(--primary-color);
      border: 2px solid var(--primary-color);
      border-radius: 50%;
      width: 32px;
      height: 32px;
      min-width: 32px;
      min-height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .mobile-search-button:hover {
      background: var(--primary-color);
      color: white;
    }

    .mobile-search-button i {
      font-size: 0.75rem;
      pointer-events: none;
    }
    
    .mobile-menu {
      display: flex;
      position: absolute;
      top: 100%;
      right: 24px;
      width: 280px;
      background: white;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
      padding: 16px 0;
      margin-top: 8px;
      flex-direction: column;
      z-index: 1000;
      /* Smooth slide-down and fade animation */
      transform: translateX(20px);
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }
    
    .mobile-menu.active {
      transform: translateX(0);
      opacity: 1;
      visibility: visible;
    }
    
    .mobile-menu-item {
      padding: 16px 24px;
      text-decoration: none;
      color: var(--text-dark);
      font-weight: 500;
      transition: all 0.2s ease;
      display: block;
    }
    
    .mobile-menu-item:hover {
      background-color: #f7f7f7;
      color: var(--text-dark);
    }
    
    .mobile-menu-divider {
      height: 1px;
      background-color: var(--border-color);
      margin: 8px 0;
    }
  }

  @media (max-width: 768px) {
    .navbar {
      min-height: 64px;
      padding: 0 16px;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 9999;
    }
    
    body {
      padding-top: 64px;
    }
    
    .navbar-brand-text {
      font-size: 1.25rem;
    }
    
    .navbar-brand i {
      font-size: 1.5rem;
    }

    .mobile-search {
      margin: 0 auto;
    }

    .mobile-search-bar {
      padding: 3px;
    }

    .mobile-search-input {
      padding: 5px 10px;
      font-size: 0.8rem;
    }

    .mobile-search-button {
      width: 30px;
      height: 30px;
      min-width: 30px;
      min-height: 30px;
    }

    .mobile-search-button i {
      font-size: 0.7rem;
    }

    .mobile-menu {
      right: 16px;
      width: 260px;
    }
  }

  @media (max-width: 576px) {
    .navbar {
      min-height: 56px;
      padding: 0 12px;
    }

    .navbar-brand-text {
      display: none;
    }

    .navbar-brand i {
      font-size: 1.5rem;
    }

    .navbar-brand {
      gap: 0;
      padding: 0;
      margin: 0;
    }

    .mobile-search {
      margin: 0 auto;
      max-width: 300px;
    }

    .mobile-search-bar {
      padding: 2px;
    }

    .mobile-search-input {
      padding: 4px 8px;
      font-size: 0.75rem;
    }

    .mobile-search-button {
      width: 28px;
      height: 28px;
      min-width: 28px;
      min-height: 28px;
    }

    .mobile-search-button i {
      font-size: 0.65rem;
    }

    .menu-icon {
      padding: 6px;
    }

    .menu-icon i {
      font-size: 1.25rem;
    }

    .mobile-menu {
      right: 12px;
      width: calc(100vw - 24px);
      max-width: 320px;
    }

    .mobile-menu-item {
      padding: 14px 20px;
      font-size: 0.95rem;
    }
  }

  @media (max-width: 400px) {
    .navbar {
      padding: 0 8px;
    }

    .navbar-brand i {
      font-size: 1.25rem;
    }

    .mobile-search {
      margin: 0 auto;
    }

    .mobile-search-bar {
      padding: 2px;
    }

    .mobile-search-input {
      padding: 4px 6px;
      font-size: 0.7rem;
    }

    .mobile-search-button {
      width: 26px;
      height: 26px;
      min-width: 26px;
      min-height: 26px;
      border-width: 1.5px;
    }

    .mobile-search-button i {
      font-size: 0.6rem;
    }

    .mobile-menu {
      right: 8px;
      width: calc(100vw - 16px);
    }
  }

</style>

<nav class="navbar">
  <!-- Brand Logo -->
  <a class="navbar-brand" href="{{ route('listings.index') }}">
    <i class="fa-solid fa-house-flag"></i>
    <span class="navbar-brand-text">airnbn</span>
  </a>

  <!-- Mobile Search (Tablets and below) -->
  <div class="mobile-search">
    <form class="mobile-search-bar" action="{{ route('listings.index') }}" method="GET">
      <input 
        class="mobile-search-input" 
        type="search" 
        name="search"
        placeholder="Search destinations" 
        aria-label="Search"
        value="{{ request('search') }}"
      />
      <button class="mobile-search-button" type="submit">
        <i class="fa-solid fa-magnifying-glass"></i>
      </button>
    </form>
  </div>

  <!-- Center Search Bar (Desktop) -->
  <div class="navbar-center">
    <div class="search-container">
      <form class="search-bar" action="{{ route('listings.index') }}" method="GET">
        <input 
          class="search-input" 
          type="search" 
          name="search"
          placeholder="Search destinations" 
          aria-label="Search"
          value="{{ request('search') }}"
        />
        <button class="search-button" type="submit">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      </form>
    </div>
  </div>

  <!-- Right Actions (Desktop) -->
  <div class="navbar-actions">

    
    @auth
      @if(auth()->user()->isHost())
        <a href="{{ route('listings.create') }}" class="nav-link-item">
          Create Listing
        </a>
        <a href="{{ route('bookings.host-dashboard') }}" class="nav-link-item">
          Host Dashboard
        </a>
      @elseif(auth()->user()->isGuest())
        <a href="{{ route('bookings.my-bookings') }}" class="nav-link-item">
          My Bookings
        </a>
      @endif
    @endauth
    
    @guest
    <a href="{{ route('signup') }}" class="nav-link-item">Sign up</a>
    <a href="{{ route('login') }}" class="nav-link-item">Log in</a>
    @else
    <a href="{{ route('logout') }}" class="nav-link-item">Logout</a>
    @endguest
  </div>

  <!-- Mobile Menu Icon -->
  <div class="menu-icon" id="mobile-menu-toggle">
    <i class="fa-solid fa-bars"></i>
  </div>

  <!-- Mobile Menu Dropdown -->
  <div class="mobile-menu" id="mobile-menu">
    <a href="{{ route('listings.index') }}" class="mobile-menu-item">Explore</a>
    @auth
      @if(auth()->user()->isHost())
        <a href="{{ route('listings.create') }}" class="mobile-menu-item">Create Listing</a>
        <a href="{{ route('bookings.host-dashboard') }}" class="mobile-menu-item">Host Dashboard</a>
      @elseif(auth()->user()->isGuest())
        <a href="{{ route('bookings.my-bookings') }}" class="mobile-menu-item">My Bookings</a>
      @endif
    @endauth

    @guest
    <a href="{{ route('signup') }}" class="mobile-menu-item">Sign up</a>
    <a href="{{ route('login') }}" class="mobile-menu-item">Log in</a>
    @else
    <a href="{{ route('logout') }}" class="mobile-menu-item">Log out</a>
    @endguest
  </div>
</nav>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Mobile menu toggle
    const mobileToggle = document.getElementById("mobile-menu-toggle");
    const mobileMenu = document.getElementById("mobile-menu");

    if (mobileToggle) {
      mobileToggle.addEventListener("click", function (e) {
        e.stopPropagation();
        mobileMenu.classList.toggle("active");
      });
    }

    // Close mobile menu when clicking outside
    document.addEventListener("click", function (e) {
      if (mobileMenu && !mobileMenu.contains(e.target) && !mobileToggle.contains(e.target)) {
        mobileMenu.classList.remove("active");
      }
    });


  });
</script>
