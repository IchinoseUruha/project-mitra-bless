<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Kasir')</title>

    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .sidebar-left {
            width: 256px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: white;
            border-right: 1px solid #e5e7eb;
        }

        .avatar {
            width: 48px;
            height: 48px;
            background-color: rgb(124 58 237);   /* Violet-600 */
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
        }

        .nav-link.active {
            background-color: rgb(124 58 237);
            color: white;
            border-radius: 0.5rem;
        }

        .kasir-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: rgb(124 58 237);
            color: white;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            transition: background-color 0.2s;
        }

        .kasir-button:hover {
            background-color: rgb(109 40 217);
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #4b5563;
            border-radius: 0.5rem;
            transition: background-color 0.2s;
        }

        .menu-link:hover {
            background-color: #f3f4f6;
        }

        .menu-link i {
            margin-right: 0.5rem;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Left Sidebar -->
    <div class="sidebar-left">
        <!-- Profile Section -->
        <div class="p-4 border-b">
            <div class="flex items-center gap-3">
                <div class="avatar">
                    <span class="text-white text-xl font-semibold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </span>
                </div>
                <div>
                    <div class="font-medium">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-gray-500">Kasir</div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="p-4">
            <!-- Kasir Button -->
            <a href="{{ route('kasir.index') }}" 
               class="kasir-button {{ Request::is('kasir') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart mr-2"></i>
                <span>Kasir</span>
            </a>

            <!-- Daftar Pemesanan -->
            <a href="{{ route('kasir.pemesanan') }}" 
               class="menu-link {{ Request::is('kasir/daftar-pemesanan') ? 'active' : '' }}">
                <i class="fas fa-list"></i>
                <span>Daftar Pemesanan</span>
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="ml-64 p-6">
        @yield('content')
    </div>

</body>
</html>