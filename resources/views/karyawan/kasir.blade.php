<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        .kasir-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
    <div class="container kasir-container">
        <div class="header-title">Halaman Kasir Offline</div>
        <form>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="pelanggan" class="form-label">Pelanggan</label>
                    <input type="text" class="form-control" id="pelanggan" placeholder="Masukkan Nama Pelanggan">
                </div>
                <div class="col-md-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal">
                </div>
                <div class="col-md-3">
                    <label for="payment_method" class="form-label">Metode Pembayaran</label>
                    <input type="text" class="form-control" id="payment_method" placeholder="Masukkan Tipe Pembayaran">
                </div>
                <div class="col-md-2">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text" class="form-control" id="lokasi" placeholder="Masukkan Lokasi">
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
            <div class="text-end mt-3">
                <button type="button" class="btn btn-success" id="add-row">Cari Produk</button>
            </div>
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

    <!-- Modal Pencarian Produk -->
    <div class="modal fade" id="searchProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cari Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Brand</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->brand->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" 
                                                onclick="pilihProduk('{{ $product->id }}', '{{ $product->name }}', 
                                                         '{{ $product->brand->name }}', {{ $product->price }}, {{ $product->quantity }})">
                                            Pilih
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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

        // Event listener untuk tombol Cari Produk
        document.getElementById('add-row').addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('searchProductModal'));
            modal.show();
        });

        // Fungsi untuk memilih produk
        function pilihProduk(id, nama, brand, harga, stok) {
            const tableBody = document.getElementById('table-body');

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" class="form-control" name="namaBarang[]" value="${nama}" readonly></td>
                <td><input type="text" class="form-control" name="kodeBarang[]" value="${id}" readonly></td>
                <td><input type="text" class="form-control" name="brand[]" value="${brand}" readonly></td>
                <td><input type="number" class="form-control" name="jumlahBarang[]" value="1" max="${stok}"></td>
                <td><input type="text" class="form-control" name="hargaSatuan[]" value="${formatRupiah(harga)}" readonly></td>
                <td><input type="text" class="form-control" name="discountPercent[]" value="0.00" readonly></td>
                <td><input type="text" class="form-control" name="hargaTotal[]" value="${formatRupiah(harga)}" readonly></td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
                </td>
            `;

            tableBody.appendChild(newRow);

            // Tutup modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('searchProductModal'));
            modal.hide();

            // Setup event listener untuk tombol hapus
            newRow.querySelector('.remove-row').addEventListener('click', function() {
                this.closest('tr').remove();
                updateGrandTotal();
            });

            // Event listener untuk jumlah barang
            const qtyInput = newRow.querySelector('[name="jumlahBarang[]"]');
            qtyInput.addEventListener('input', function() {
                const qty = parseInt(this.value) || 0;
                if (qty > stok) {
                    this.value = stok;
                    alert('Jumlah melebihi stok tersedia!');
                }
                const total = this.value * harga;
                newRow.querySelector('[name="hargaTotal[]"]').value = formatRupiah(total);
                updateGrandTotal();
            });

            updateGrandTotal();
        }

        // Fungsi update total keseluruhan
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

            const checkoutBtn = document.querySelector('[data-bs-target="#checkoutModal"]');
            if (grandTotal > 0) {
                checkoutBtn.removeAttribute('disabled');
            } else {
                checkoutBtn.setAttribute('disabled', 'disabled');
            }
        }
    </script>
</body>
</html>