<link rel="stylesheet" href="/php-Workspace/DuAn_WebMonAn_Nhom6/assets/css/header.css">
<header class="header">
    <div class="header-content">
        <a href="#home" class="logo" onclick="scrollToTop(event)">Đặt đồ ăn Online</a>
        <!-- Menu Toggle Button -->
        <div class="menu-container">
            <button class="menu-toggle">
                <i class="fa-solid fa-bars"></i>
            </button>
            <!-- Dropdown menu -->
            <nav class="nav" id="nav">
                <a href="#home" class="nav-link" onclick="scrollToTop(event)">
                    <i class="fa-solid fa-house"></i>
                    Trang chủ
                </a>
                <a href="#menu" class="nav-link cart" onclick="scrollToMenu()">
                    <i class="fa-solid fa-cart-shopping"></i>
                    Giỏ hàng
                </a>
                <a href="#footer" class="nav-link" onclick="scrollToFinal()">
                    <i class="fa-solid fa-info-circle"></i>
                    Thông tin
                </a>
                <a href="/login" class="nav-link">
                    <i class="fa-solid fa-sign-in-alt"></i>
                    Đăng Nhập
                </a>
                <a href="/admin" class="nav-link">
                    <i class="fa-solid fa-user-shield"></i>
                    Admin đăng nhập
                </a>
            </nav>
        </div>
    </div>
</header>
