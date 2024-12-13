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
    --primary-color: #7c3aed;
    --primary-hover: #6d28d9;
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
    margin-left: var(--sidebar-width);
    margin-right: var(--cart-width);
    padding: 2rem;
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
}

.search-container .bi-search {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
}

#searchProduct {
    width: 100%;
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
    font-size: 1.1rem;
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
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: var(--primary-hover);
    border-color: var(--primary-hover);
}

.btn-outline-primary {
    color: var(--primary-color);
    border-color: var(--primary-color);
    background-color: transparent;
}

.btn-outline-primary:hover {
    background-color: var(--primary-color);
    color: white;
}

/* Modal Component Styling */
.modal-content {
    border-radius: 0.75rem;
    border: none;
    box-shadow: 0 10px 15px rgba(0,0,0,0.1);
}

.modal-header {
    border-bottom: 1px solid #e5e7eb;
    padding: 1.25rem;
}

.modal-body {
    padding: 1.5rem;
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
        <!-- Left Sidebar - Profile & Navigation -->
        <div class="sidebar-left">
            <!-- Profile Section -->
            <div class="p-4 border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar rounded-circle d-flex align-items-center justify-content-center">
                        <span class="text-white fw-bold fs-5">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                        <small class="text-muted">Kasir</small>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="p-4">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('kasir.index') }}" class="nav-link {{ Request::is('kasir') ? 'active' : '' }}">
                            <i class="bi bi-cart"></i>
                            <span>Kasir</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bi bi-list-check"></i>
                            <span>Daftar Pemesanan</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content Area -->
        <div class="main-content">
            <h4 class="mb-4">Produk Kosmetik</h4>
            
            <!-- Search Bar -->
            <div class="search-container">
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
                        <p class="product-category">{{ $product->kategori->name ?? 'No Category' }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="product-price mb-0">Rp {{ number_format($product->price) }}</p>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
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
                                <p class="text-muted mb-2">{{ $product->kategori->name ?? 'No Category' }}</p>
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
                        <span id="subtotal" class="fw-bold text-primary">Rp 0</span>
                    </div>
                    <button id="btnCheckout" class="btn btn-primary w-100" disabled>
                        Lanjutkan Pemesanan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
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
                // Remove item from cart array
                cart = cart.filter(item => item.id !== id);
                updateCartDisplay();
                
                // Show removal notification
                const item = cart.find(item => item.id === id);
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
                    // Prepare cart data for submission
                    const cartData = {
                        items: cart.map(item => ({
                            id: item.id,
                            quantity: item.quantity,
                            price: item.price
                        })),
                        subtotal: cart.reduce((sum, item) => sum + (item.price * item.quantity), 0)
                    };

                    // Send to server
                    fetch('/kasir/checkout', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(cartData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Redirect to success page or show confirmation
                            window.location.href = data.redirect;
                        } else {
                            // Show error message
                            showNotification('Terjadi kesalahan saat checkout. Silakan coba lagi.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Terjadi kesalahan saat checkout. Silakan coba lagi.');
                    });
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
    </body>
</html>