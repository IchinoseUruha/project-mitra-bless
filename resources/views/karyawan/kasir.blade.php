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
        <div class="header-title">Halaman Kasir</div>
        <form>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="pelanggan" class="form-label">Pelanggan</label>
                    <input type="text" class="form-control" id="pelanggan" placeholder="Masukkan Nama Pelanggan">
                </div>
                <div class="col-md-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal">
                </div>
                <div class="col-md-3">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text" class="form-control" id="lokasi" placeholder="Masukkan Lokasi">
                </div>
            </div>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Produk</th>
                        <th>Satuan</th>
                        <th>Qty</th>
                        <th>Harga Satuan</th>
                        <th>Harga Total</th>
                        <th>Disc %</th>
                        <th>Disc</th>
                        <th>Net Total</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <tr>
                        <td><input type="text" class="form-control" name="kodeBarang[]" placeholder="Masukkan kode barang"></td>
                        <td><input type="text" class="form-control" name="namaProduk[]" placeholder="Masukkan nama produk"></td>
                        <td><input type="text" class="form-control" name="satuan[]" placeholder="Masukkan satuan"></td>
                        <td><input type="number" class="form-control" name="qty[]" placeholder="0"></td>
                        <td><input type="text" class="form-control" name="hargaSatuan[]" placeholder="0.00"></td>
                        <td><input type="text" class="form-control" name="hargaTotal[]" placeholder="0.00" readonly></td>
                        <td><input type="text" class="form-control" name="discountPercent[]" placeholder="0"></td>
                        <td><input type="text" class="form-control" name="discount[]" placeholder="0.00" readonly></td>
                        <td><input type="text" class="form-control" name="netTotal[]" placeholder="0.00" readonly></td>
                    </tr>
                </tbody>
            </table>
            <div class="text-end mt-3">
                <button type="button" class="btn btn-success" id="add-row">Tambah Barang</button>
            </div>
            <div class="row summary">
                <div class="col-md-6">
                    <div class="row mb-2">
                        <div class="col-6">Sub Total</div>
                        <div class="col-6 text-end"><input type="text" class="form-control" placeholder="0.00"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">Diskon</div>
                        <div class="col-6 text-end"><input type="text" class="form-control" placeholder="0%"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">Pembulatan</div>
                        <div class="col-6 text-end"><input type="text" class="form-control" placeholder="0.00"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">Total</div>
                        <div class="col-6 text-end"><input type="text" class="form-control" placeholder="0.00"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">Total + Ongkir</div>
                        <div class="col-6 text-end"><input type="text" class="form-control" placeholder="0.00"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-2">
                        <div class="col-6">Total Tagihan</div>
                        <div class="col-6 text-end"><input type="text" class="form-control" placeholder="0.00"></div>                    
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">Cara Bayar</div>
                        <div class="col-6 text-end">
                            <select class="form-select">
                                <option value="tunai">Uang</option>
                                <option value="kredit">Kredit</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">Bayar Uang</div>
                        <div class="col-6 text-end"><input type="text" class="form-control" placeholder="0.00"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">Total Tunai</div>
                        <div class="col-6 text-end"><input type="text" class="form-control" placeholder="0.00"></div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary btn-action">Simpan</button>
                </div>
                <div class="col-md-6">
                    <button type="reset" class="btn btn-secondary btn-action">Batal</button>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <button type="button" class="btn btn-success btn-action" data-bs-toggle="modal" data-bs-target="#checkoutModal">Checkout</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('add-row').addEventListener('click', function() {
            const tableBody = document.getElementById('table-body');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" class="form-control" name="kodeBarang[]" placeholder="Masukkan kode barang"></td>
                <td><input type="text" class="form-control" name="namaProduk[]" placeholder="Masukkan nama produk"></td>
                <td><input type="text" class="form-control" name="satuan[]" placeholder="Masukkan satuan"></td>
                <td><input type="number" class="form-control" name="qty[]" placeholder="0"></td>
                <td><input type="text" class="form-control" name="hargaSatuan[]" placeholder="0.00"></td>
                <td><input type="text" class="form-control" name="hargaTotal[]" placeholder="0.00" readonly></td>
                <td><input type="text" class="form-control" name="discountPercent[]" placeholder="0"></td>
                <td><input type="text" class="form-control" name="discount[]" placeholder="0.00" readonly></td>
                <td><input type="text" class="form-control" name="netTotal[]" placeholder="0.00" readonly></td>
            `;
            tableBody.appendChild(newRow);
        });
    </script>
</body>
</html>
