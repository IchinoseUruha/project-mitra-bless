<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Kasir')</title>

    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        /* Sidebar styles */
        .sidebar-left {
            width: 256px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: white;
            border-right: 1px solid #e5e7eb;
            box-shadow: 2px 0 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar-left.hidden {
            transform: translateX(-100%);
        }

        /* Avatar styles */
        .avatar {
            width: 48px;
            height: 48px;
            background-color: #F062A8; /* Pink */
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px; /* Circle */
            color: white;
            font-weight: bold;
            font-size: 1.25rem;
        }

        /* Navigation links */
        .nav-link, .menu-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1rem;
            color: #4B5563; /* Gray-700 */
            border-radius: 0.5rem;
            text-decoration: none;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .menu-link:hover {
            background-color: #F062A8; /* Hover: Pink */
            color: white;
        }

        .nav-link.active, .menu-link.active {
            background-color: #F062A8; /* Active: Pink */
            color: white;
        }

        /* Logout button */
        button {
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #e3342f; /* Hover: Red */
            color: white;
        }

        /* Main Content */
        .main-content {
            margin-left: 256px; /* Default margin saat sidebar terlihat */
            transition: margin-left 0.3s ease-in-out;
        }

        /* Toggle button styles */
        #sidebarToggle {
            position: fixed; /* Tombol tetap terlihat saat sidebar disembunyikan */
            top: 20px;
            left: 276px; /* Posisi tombol di sebelah kanan sidebar */
            z-index: 1000;
            background-color: #F062A8;
            padding: 10px;
            border-radius: 50%;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: left 0.3s ease-in-out;
        }

        #sidebarToggle:hover {
            background-color: rgb(156, 54, 92);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Button to toggle sidebar -->
    <button id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar-left">
        <!-- Profile Section -->
        <div class="p-4 border-b flex items-center gap-3">
            <div class="avatar">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div>
                <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                <p class="text-sm text-gray-500">Kasir</p>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="p-4 space-y-4">
            <a href="{{ route('kasir.index') }}" class="nav-link {{ Request::is('kasir') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Kasir</span>
            </a>
            <a href="{{ route('kasir.pemesanan') }}" class="nav-link {{ Request::is('kasir/daftar-pemesanan') ? 'active' : '' }}">
                <i class="fas fa-list"></i>
                <span>Daftar Pemesanan</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="menu-link text-red-600 hover:bg-red-500 hover:text-white">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <!-- JavaScript -->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            const sidebar = document.querySelector('.sidebar-left');
            const mainContent = document.querySelector('.main-content');
            const toggleButton = document.getElementById('sidebarToggle');

            // Toggle sidebar visibility
            sidebar.classList.toggle('hidden');

            // Adjust main content margin and toggle button position
            if (sidebar.classList.contains('hidden')) {
                mainContent.style.marginLeft = '0'; // Geser konten ke kiri
                toggleButton.style.left = '20px'; // Pindahkan tombol ke tepi layar
            } else {
                mainContent.style.marginLeft = '256px'; // Kembali ke posisi normal
                toggleButton.style.left = '276px'; // Kembali ke posisi di sebelah sidebar
            }
        });
    </script>
</body>
</html>
