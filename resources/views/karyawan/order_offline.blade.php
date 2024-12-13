<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0; /* Ubah margin jadi 0 */
            background-color: #f9f9f9;
            min-height: 100vh;
            display: flex; /* Tambahkan display flex */
        }
         /* Container utama */
        .main-content {
            flex: 1;
            margin-left: 250px; /* Sesuaikan dengan lebar sidebar */
            padding: 20px;
        }

        .kasir-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
        }

        .table td, .table th {
            vertical-align: middle;
        }
        .btn-action {
            width: 100%;
            margin-top: 10px;
        }
        .form-control {
            height: calc(2.25rem + 10px);
        }
        .header-title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .summary {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #ddd;
        }
    </style>
</head>
<body>
    @extends('layouts.sidebarKasir')
    
   <div class="main-content">
    <div class="container kasir-container">
        <div class="header-title">Halaman Kasir Offline</div>
        <form>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal">
                </div>
                <div class="col-md-3">
                    <label for="payment_method" class="form-label">Metode Pembayaran</label>
                    <input type="text" class="form-control" id="payment_method" placeholder="Masukkan Tipe Pembayaran">
                </div>
                <div class="col-md-2">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" placeholder="Masukkan Address">
                </div>
            </div>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Kode Barang</th>
                        <th>Brand</th>
                        <th>Jumlah Barang</th>
                        <th>Harga Satuan</th>
                        <th>Diskon</th>
                        <th>Harga Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                </tbody>
            </table>
            <div class="row summary">
                <div class="col-md-6">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <button type="button" class="btn btn-success btn-action" data-bs-toggle="modal" data-bs-target="#checkoutModal">Checkout</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Checkout -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">Konfirmasi Checkout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah semua data sudah benar dan siap untuk checkout?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>
   </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fungsi format Rupiah
        function formatRupiah(angka) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
        }
    
        // Setup event listeners untuk baris tabel
        function setupRowEventListeners(row, harga) {
            // Event listener untuk tombol hapus
            row.querySelector('.remove-row').addEventListener('click', function() {
                row.remove();
                updateGrandTotal();
            });
    
            // Event listener untuk input jumlah
            const qtyInput = row.querySelector('[name="jumlahBarang[]"]');
            qtyInput.addEventListener('input', function() {
                let qty = parseInt(this.value) || 0;
                
                // Validasi jumlah minimum
                if (qty < 1) {
                    qty = 1;
                    this.value = 1;
                }
    
                updateRowTotal(row, qty, harga);
            });
    
            // Event listener untuk input diskon
            const discountInput = row.querySelector('[name="discountPercent[]"]');
            discountInput.addEventListener('input', function() {
                let discount = parseFloat(this.value) || 0;
                
                // Validasi diskon (0-100%)
                if (discount < 0) {
                    discount = 0;
                    this.value = '0.00';
                } else if (discount > 100) {
                    discount = 100;
                    this.value = '100.00';
                }
    
                const qty = parseInt(qtyInput.value) || 1;
                updateRowTotal(row, qty, harga, discount);
            });
        }
    
        // Update total untuk satu baris
        function updateRowTotal(row, quantity, price, discount = 0) {
            const subtotal = quantity * price;
            const discountAmount = subtotal * (discount / 100);
            const total = subtotal - discountAmount;
            
            row.querySelector('[name="hargaTotal[]"]').value = formatRupiah(total);
            updateGrandTotal();
        }
    
        // Update grand total
        function updateGrandTotal() {
            const totalInputs = document.getElementsByName('hargaTotal[]');
            let subtotal = 0;
            let totalDiscount = 0;
            let grandTotal = 0;
    
            totalInputs.forEach((input, index) => {
                const value = parseInt(input.value.replace(/[^0-9]/g, '')) || 0;
                const qtyInput = document.getElementsByName('jumlahBarang[]')[index];
                const priceInput = document.getElementsByName('hargaSatuan[]')[index];
                const discountInput = document.getElementsByName('discountPercent[]')[index];
                
                const qty = parseInt(qtyInput.value) || 0;
                const price = parseInt(priceInput.value.replace(/[^0-9]/g, '')) || 0;
                const discount = parseFloat(discountInput.value) || 0;
                
                const rowSubtotal = qty * price;
                const rowDiscount = rowSubtotal * (discount / 100);
                
                subtotal += rowSubtotal;
                totalDiscount += rowDiscount;
                grandTotal += value;
            });
    
            // Update ringkasan pesanan
            document.querySelector('.summary .col-md-6').innerHTML = `
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ringkasan Pesanan</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>${formatRupiah(subtotal)}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Diskon:</span>
                            <span>-${formatRupiah(totalDiscount)}</span>
                        </div>
                        <div class="d-flex justify-content-between border-top pt-2">
                            <span class="fw-bold">Total:</span>
                            <strong>${formatRupiah(grandTotal)}</strong>
                        </div>
                    </div>
                </div>
            `;
    
            // Update status tombol checkout
            const checkoutBtn = document.querySelector('[data-bs-target="#checkoutModal"]');
            checkoutBtn.disabled = grandTotal === 0;
    
            return {
                subtotal,
                totalDiscount,
                grandTotal
            };
        }
    
        // Fungsi untuk menampilkan alert
        function showAlert(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-warning alert-dismissible fade show position-fixed top-0 end-0 m-3';
            alertDiv.setAttribute('role', 'alert');
            alertDiv.style.zIndex = '9999';
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
    
        // Event listener saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Set tanggal hari ini sebagai default
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tanggal').value = today;
    
            // Ambil data cart dari localStorage
            const cartItems = JSON.parse(localStorage.getItem('cartItems') || '[]');
            
            // Tambahkan item dari cart ke tabel
            cartItems.forEach(item => {
                // Buat row baru
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td><input type="text" class="form-control" name="namaBarang[]" value="${item.name}" readonly></td>
                    <td><input type="text" class="form-control" name="kodeBarang[]" value="${item.id}" readonly></td>
                    <td><input type="text" class="form-control" name="brand[]" value="${item.brand || '-'}" readonly></td>
                    <td><input type="number" class="form-control" name="jumlahBarang[]" value="${item.quantity}" min="1"></td>
                    <td><input type="text" class="form-control" name="hargaSatuan[]" value="${formatRupiah(item.price)}" readonly></td>
                    <td><input type="text" class="form-control" name="discountPercent[]" value="0.00"></td>
                    <td><input type="text" class="form-control" name="hargaTotal[]" value="${formatRupiah(item.price * item.quantity)}" readonly></td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
                    </td>
                `;
                
                document.getElementById('table-body').appendChild(newRow);
                
                // Setup event listeners untuk baris baru
                setupRowEventListeners(newRow, item.price);
            });
    
            // Update total awal
            updateGrandTotal();
        });
    
        // Event listener untuk modal checkout
        document.querySelector('#checkoutModal .btn-primary').addEventListener('click', function() {
            // Validasi form
            const customer = document.getElementById('pelanggan').value;
            const location = document.getElementById('address').value;
            const paymentMethod = document.getElementById('payment_method').value;
    
            if (!customer || !address || !paymentMethod) {
                showAlert('Mohon lengkapi semua data pesanan!');
                return;
            }
    
            // Kumpulkan data pesanan
            const items = Array.from(document.getElementById('table-body').getElementsByTagName('tr'))
                .map(row => ({
                    product_id: row.querySelector('[name="kodeBarang[]"]').value,
                    quantity: parseInt(row.querySelector('[name="jumlahBarang[]"]').value),
                    price: parseInt(row.querySelector('[name="hargaSatuan[]"]').value.replace(/[^0-9]/g, '')),
                    total: parseInt(row.querySelector('[name="hargaTotal[]"]').value.replace(/[^0-9]/g, ''))
                }));
    
            const { subtotal, totalDiscount, grandTotal } = updateGrandTotal();
    
            const orderData = {
                customer,
                address,
                payment_method: paymentMethod,
                items,
                summary: {
                    subtotal,
                    total_discount: totalDiscount,
                    grand_total: grandTotal
                }
            };
    
            // Kirim data ke server
            fetch('/kasir/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(orderData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Clear localStorage
                    localStorage.removeItem('cartItems');
                    
                    // Tampilkan notifikasi sukses
                    showAlert('Pesanan berhasil dibuat!');
                    
                    // Redirect ke halaman kasir setelah 2 detik
                    setTimeout(() => {
                        window.location.href = '/kasir';
                    }, 2000);
                } else {
                    showAlert('Terjadi kesalahan: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Terjadi kesalahan saat memproses pesanan');
            });
        });
    </script>
</body>
</html>