<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Kasir</title>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Root variables for consistent theming */
    :root {
    /* Color palette */
    --primary-color: #F062A8;
    --primary-hover: #F062A8;
    --text-primary: #111827;
    --text-secondary: #4b5563;
    --bg-gray: #f3f4f6;
    
    /* Layout dimensions */
    --sidebar-width: 280px;
    --cart-width: 320px;
    }

/* Base styles for overall document */
body {
    background-color: var(--bg-gray);
    color: var(--text-primary);
    min-height: 100vh;
}

/* Layout Components */
/* Left sidebar containing profile and navigation */
.sidebar-left {
    width: var(--sidebar-width);
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    background: white;
    border-right: 1px solid #e5e7eb;
    box-shadow: 2px 0 8px rgba(0,0,0,0.05);
    z-index: 1000;
    overflow-y: auto;
}

/* Right sidebar containing cart */
.sidebar-right {
    width: var(--cart-width);
    height: 100vh;
    position: fixed;
    right: 0;
    top: 0;
    background: white;
    border-left: 1px solid #e5e7eb;
    box-shadow: -2px 0 8px rgba(0,0,0,0.05);
    z-index: 1000;
}

/* Main content area */
.main-content {
    max-width: 650px; /* Tetapkan lebar maksimum konten */
    margin-left: 256px; /* Default margin saat sidebar terlihat */
    padding: 20px;
    transition: margin-left 0.3s ease-in-out, max-width 0.3s ease-in-out;
}


/* Profile Section Styling */
.avatar {
    background-color: var(--primary-color) !important;
    width: 48px !important;
    height: 48px !important;
}

/* Navigation Menu Styling */
.nav-link {
    color: var(--text-secondary);
    padding: 0.8rem 1rem;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.nav-link:hover {
    background-color: #f3f4f6;
    color: var(--primary-color);
}

.nav-link.active {
    background-color: var(--primary-color);
    color: white;
}

/* Icon styling */
.bi {
    font-size: 1.25rem;
}

/* Search Bar Component */
.search-container {
    position: relative;
    margin-bottom: 1.5rem;
    margin-left: 2rem
}

.search-container .bi-search {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
}

#searchProduct {
    width: calc(100% - 2rem); /* Mengambil lebar penuh minus padding kiri dan kanan */
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

#searchProduct:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(124, 58, 237, 0.1);
    outline: none;
}

/* Product Display Grid */
.product-grid {
    display: grid;
    /* Change the grid template to define fixed columns with a minimum width */
    grid-template-columns: repeat(4, 1fr); /* This forces 4 columns */
    gap: 1.5rem;
    padding: 1rem 0;
}

/* Product Card Styling */
.product-card {
    background: white;
    border-radius: 0.75rem;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    /* Add minimum width to ensure cards don't get too small */
    min-width: 200px;
    height: 100%;
}

.product-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.product-image {
    height: 200px;
    background: #f8f9fa;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-info {
    padding: 1.25rem;
}

.product-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.product-category {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 1rem;
}

.product-price {
    font-weight: 600;
    color: var(--primary-color);
    font-size: 0.9rem;
}

/* Shopping Cart Styling */
.cart-item {
    background: #f8f9fa;
    border-radius: 0.5rem;
    padding: 1rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.cart-item:hover {
    background: #f3f4f6;
}

/* Button Styles */
.btn-primary {
    background-color: #F062A8;
    border-color: white;
    padding: 0.20rem 0.5rem;  /* Mengurangi padding */
    border-radius: 0.5rem;
    font-size: 0.800rem; /* Mengurangi ukuran font */
    transition: all 0.3s ease;
    margin-left: 0.2rem;
    color: #f3f4f6;
}

.btn-primary:hover {
    background-color: rgb(156, 54, 92);
    border-color: var(--primary-hover);
}

.btn-outline-primary {
    color: var(--primary-color);
    border-color: var(--primary-color);
    background-color: transparent;
    padding: 0.20rem 0.5rem;  /* Mengurangi padding */
    font-size: 0.800rem; /* Mengurangi ukuran font */
}

.btn-outline-primary:hover {
    background-color: var(--primary-color);
    color: white;
}

.text-pink{
    color: #F062A8
}

.judul{
    margin-left: 60px; 
}

/* Responsive Design Breakpoints */
@media (max-width: 1400px) {
    .product-grid {
        grid-template-columns: repeat(3, 1fr); /* 3 columns on smaller screens */
    }
}

@media (max-width: 1200px) {
    .product-grid {
        grid-template-columns: repeat(2, 1fr); /* 2 columns on even smaller screens */
    }
}

@media (max-width: 768px) {
    .product-grid {
        grid-template-columns: repeat(1, 1fr); /* 1 column on mobile */
    }
}

@media (max-width: 992px) {
    :root {
        --sidebar-width: 250px;
        --cart-width: 280px;
    }
}

@media (max-width: 768px) {
    .sidebar-left, .sidebar-right {
        width: 100%;
        height: auto;
        position: relative;
    }

    .main-content {
        margin-left: 0;
        margin-right: 0;
    }

    .product-grid {
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    }
}
    </style>
</head>
<body>
    <div class="d-flex min-vh-100">
       
        @extends('layouts.sidebarKasir')


        <!-- Main Content Area -->
        <div class="main-content">
            <h4 class="judul mb-4">Produk Kosmetik</h4>
            
            <!-- Search Bar -->
            <div class="search-container d-flex align-items-center">
                <i class="bi bi-search"></i>
                <input type="text" id="searchProduct" placeholder="Cari produk...">
            </div>

            <!-- Product Grid -->
            <div class="product-grid">
                @foreach ($products as $product)
                <div class="product-card">
                    <div class="product-image" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
                        <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <p class="product-category">{{ $product->category->name ?? 'No Category' }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="product-price mb-0">Rp {{ number_format($product->price) }}</p>
                            <div class="d-flex gap-2">
                                <button class="btn-primary" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
                                    <i class="bi bi-eye"></i> Detail
                                </button>
                                <button class="btn btn-primary btn-sm add-to-cart" 
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        data-price="{{ $product->price }}">
                                    <i class="bi bi-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Detail Modal -->
                <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Produk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center mb-3">
                                    <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" 
                                         style="max-height: 200px; object-fit: cover;">
                                </div>
                                <h5 class="mb-2">{{ $product->name }}</h5>
                                <p class="text-muted mb-2">{{ $product->category->name ?? 'No Category' }}</p>
                                <p class="fw-bold text-primary mb-3">Rp {{ number_format($product->price) }}</p>
                                <p class="mb-3">{{ $product->description }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Stok: {{ $product->quantity }}</span>
                                    <button class="btn btn-primary add-to-cart" 
                                            data-id="{{ $product->id }}"
                                            data-name="{{ $product->name }}"
                                            data-price="{{ $product->price }}"
                                            data-bs-dismiss="modal">
                                        <i class="bi bi-plus"></i> Tambah ke Pesanan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Right Sidebar - Cart -->
        <div class="sidebar-right">
            <div class="p-4">
                <h5 class="mb-4">Pesanan</h5>
                <div id="cartItems" class="mb-4" style="height: calc(100vh - 250px); overflow-y: auto;">
                    <!-- Cart items will be populated by JavaScript -->
                </div>
                <div class="border-top pt-3">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Subtotal</span>
                        <span id="subtotal" class="fw-bold text-pink">Rp 0</span>
                    </div>
                    <a href="{{route('kasir.order')}}">
                        <button id="btnCheckout" class="btn-primary w-100" disabled>
                            Lanjutkan Pemesanan
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    // Script untuk kasir.blade.php
    <script>
        // Cart Management
        let cart = [];
    
        // Add to Cart functionality
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.id;
                const productName = this.dataset.name;
                const productPrice = parseFloat(this.dataset.price);
    
                addToCart(productId, productName, productPrice);
                updateCartDisplay();
                
                // Close modal if product was added from modal
                const modal = bootstrap.Modal.getInstance(this.closest('.modal'));
                if (modal) {
                    modal.hide();
                }
            });
        });
    
        function addToCart(id, name, price) {
            // Check if item already exists in cart
            const existingItem = cart.find(item => item.id === id);
            
            if (existingItem) {
                // If item exists, increment quantity
                existingItem.quantity += 1;
            } else {
                // If item is new, add to cart with quantity 1
                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    quantity: 1
                });
            }
    
            // Show a brief notification
            showNotification(`${name} ditambahkan ke pesanan`);
        }
    
        function updateCartDisplay() {
            const cartContainer = document.getElementById('cartItems');
            const subtotalElement = document.getElementById('subtotal');
            const checkoutButton = document.getElementById('btnCheckout');
            
            // Clear current cart display
            cartContainer.innerHTML = '';
            
            // Calculate subtotal and generate cart items HTML
            let subtotal = 0;
    
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
    
                cartContainer.innerHTML += `
                    <div class="cart-item mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-0">${item.name}</h6>
                                <small class="text-muted">Rp ${item.price.toLocaleString()} x ${item.quantity}</small>
                            </div>
                            <div class="d-flex flex-column align-items-end">
                                <span class="text-primary fw-bold">Rp ${itemTotal.toLocaleString()}</span>
                                <div class="btn-group btn-group-sm mt-2">
                                    <button class="btn btn-outline-secondary" 
                                            onclick="updateQuantity('${item.id}', ${item.quantity - 1})">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <span class="btn btn-outline-secondary disabled">
                                        ${item.quantity}
                                    </span>
                                    <button class="btn btn-outline-secondary" 
                                            onclick="updateQuantity('${item.id}', ${item.quantity + 1})">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                    <button class="btn btn-outline-danger" 
                                            onclick="removeItem('${item.id}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
    
            // Update subtotal display
            subtotalElement.textContent = `Rp ${subtotal.toLocaleString()}`;
            
            // Enable/disable checkout button based on cart contents
            checkoutButton.disabled = cart.length === 0;
    
            // Update cart badge if exists
            const cartBadge = document.getElementById('cartBadge');
            if (cartBadge) {
                cartBadge.textContent = cart.length;
                cartBadge.style.display = cart.length ? 'block' : 'none';
            }
        }
    
        function updateQuantity(id, newQuantity) {
            // Remove item if quantity is 0 or less
            if (newQuantity < 1) {
                removeItem(id);
                return;
            }
            
            // Update quantity for specific item
            const item = cart.find(item => item.id === id);
            if (item) {
                item.quantity = newQuantity;
                updateCartDisplay();
            }
        }
    
        function removeItem(id) {
            // Find item before removing for notification
            const item = cart.find(item => item.id === id);
            
            // Remove item from cart array
            cart = cart.filter(i => i.id !== id);
            updateCartDisplay();
            
            // Show removal notification if item was found
            if (item) {
                showNotification(`${item.name} dihapus dari pesanan`);
            }
        }
    
        function showNotification(message) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = 'toast-notification';
            notification.innerHTML = `
                <div class="toast align-items-center text-white bg-primary border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;
            
            // Add notification styles if not already present
            if (!document.getElementById('notificationStyles')) {
                const styles = document.createElement('style');
                styles.id = 'notificationStyles';
                styles.innerHTML = `
                    .toast-notification {
                        position: fixed;
                        bottom: 20px;
                        right: 20px;
                        z-index: 1050;
                    }
                `;
                document.head.appendChild(styles);
            }
    
            // Add to document and show
            document.body.appendChild(notification);
            const toast = new bootstrap.Toast(notification.querySelector('.toast'));
            toast.show();
    
            // Remove after hiding
            notification.addEventListener('hidden.bs.toast', function() {
                notification.remove();
            });
        }
    
        // Search functionality
        document.getElementById('searchProduct').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.product-card').forEach(card => {
                const productName = card.querySelector('.product-name').textContent.toLowerCase();
                const productCategory = card.querySelector('.product-category').textContent.toLowerCase();
                
                // Show/hide based on name or category match
                const matches = productName.includes(searchTerm) || productCategory.includes(searchTerm);
                card.style.display = matches ? '' : 'none';
            });
        });
    
        // Checkout process
        document.getElementById('btnCheckout').addEventListener('click', function() {
            if (cart.length > 0) {
                // Simpan cart ke localStorage sebelum pindah halaman
                localStorage.setItem('cartItems', JSON.stringify(cart));
            }
        });
    
        // Initialize tooltips and popovers if using Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
    
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            popoverTriggerList.map(function(popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });
        });
    </script>
    
    {{-- //Script untuk order_offline.blade.php --}}
    <script>
        // Fungsi format Rupiah
        function formatRupiah(angka) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
        }
    
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil data cart dari localStorage
            const cartItems = JSON.parse(localStorage.getItem('cartItems') || '[]');
            
            // Isi tabel dengan data cart
            const tableBody = document.getElementById('table-body');
            cartItems.forEach(item => {
                addItemToTable(item);
            });
    
            // Update total pesanan
            updateGrandTotal();
    
            // Event listener untuk tombol Cari Produk
            document.getElementById('add-row').addEventListener('click', function() {
                const modal = new bootstrap.Modal(document.getElementById('searchProductModal'));
                modal.show();
            });
        });
    
        // Fungsi untuk menambahkan item ke tabel
        function addItemToTable(item) {
            const tableBody = document.getElementById('table-body');
            const row = document.createElement('tr');
            const product = window.products.find(p => p.id === item.id) || {};
            
            row.innerHTML = `
                <td><input type="text" class="form-control" name="namaBarang[]" value="${item.name}" readonly></td>
                <td><input type="text" class="form-control" name="kodeBarang[]" value="${item.id}" readonly></td>
                <td><input type="text" class="form-control" name="brand[]" value="${product.brand?.name || '-'}" readonly></td>
                <td><input type="number" class="form-control" name="jumlahBarang[]" value="${item.quantity}" min="1" max="${product.quantity || 999}"></td>
                <td><input type="text" class="form-control" name="hargaSatuan[]" value="${formatRupiah(item.price)}" readonly></td>
                <td><input type="text" class="form-control" name="discountPercent[]" value="0.00" readonly></td>
                <td><input type="text" class="form-control" name="hargaTotal[]" value="${formatRupiah(item.price * item.quantity)}" readonly></td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
                </td>
            `;
            tableBody.appendChild(row);
    
            // Setup event listeners untuk row baru
            setupRowEventListeners(row, item.price, product.quantity || 999);
        }
    
        // Setup event listeners untuk baris tabel
        function setupRowEventListeners(row, price, maxStock) {
            // Event listener untuk tombol hapus
            row.querySelector('.remove-row').addEventListener('click', function() {
                row.remove();
                updateGrandTotal();
            });
    
            // Event listener untuk input jumlah
            const qtyInput = row.querySelector('[name="jumlahBarang[]"]');
            qtyInput.addEventListener('input', function() {
                let qty = parseInt(this.value) || 0;
                
                // Validasi stok
                if (qty > maxStock) {
                    qty = maxStock;
                    this.value = maxStock;
                    showAlert('Jumlah melebihi stok tersedia!');
                } else if (qty < 1) {
                    qty = 1;
                    this.value = 1;
                }
    
                const total = qty * price;
                row.querySelector('[name="hargaTotal[]"]').value = formatRupiah(total);
                updateGrandTotal();
            });
        }
    
        // Update grand total
        function updateGrandTotal() {
            const totalInputs = document.getElementsByName('hargaTotal[]');
            let grandTotal = 0;
    
            totalInputs.forEach(input => {
                const value = input.value.replace(/[^0-9]/g, '');
                grandTotal += parseInt(value) || 0;
            });
    
            document.querySelector('.summary .col-md-6').innerHTML = `
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ringkasan Pesanan</h5>
                        <div class="d-flex justify-content-between">
                            <span>Total:</span>
                            <strong>${formatRupiah(grandTotal)}</strong>
                        </div>
                    </div>
                </div>
            `;
    
            // Update status tombol checkout
            const checkoutBtn = document.querySelector('[data-bs-target="#checkoutModal"]');
            checkoutBtn.disabled = grandTotal === 0;
        }
    
        // Fungsi untuk menampilkan alert
        function showAlert(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-warning alert-dismissible fade show position-fixed top-0 end-0 m-3';
            alertDiv.setAttribute('role', 'alert');
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            document.body.appendChild(alertDiv);
            
            // Hapus alert setelah 3 detik
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }
    
        // Event listener untuk modal checkout
        document.querySelector('#checkoutModal .btn-primary').addEventListener('click', function() {
            // Kumpulkan data pesanan
            const orderData = {
                customer: document.getElementById('pelanggan').value,
                date: document.getElementById('tanggal').value,
                payment_method: document.getElementById('payment_method').value,
                location: document.getElementById('lokasi').value,
                items: Array.from(document.getElementsByTagName('tr')).slice(1).map(row => ({
                    product_id: row.querySelector('[name="kodeBarang[]"]').value,
                    quantity: parseInt(row.querySelector('[name="jumlahBarang[]"]').value),
                    price: parseInt(row.querySelector('[name="hargaSatuan[]"]').value.replace(/[^0-9]/g, '')),
                    discount: parseFloat(row.querySelector('[name="discountPercent[]"]').value)
                }))
            };
    
            // Di sini Anda bisa menambahkan kode untuk mengirim data ke server
            console.log('Order Data:', orderData);
    
            // Clear localStorage setelah checkout berhasil
            localStorage.removeItem('cartItems');
    
            // Redirect atau refresh halaman sesuai kebutuhan
            // window.location.href = '/success-page';
        });
    </script>
    </body>
</html>