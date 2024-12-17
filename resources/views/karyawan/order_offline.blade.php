<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Kasir</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
   <style>
       body {
           font-family: 'Inter', sans-serif;
           margin: 0;
           background-color: #f8f9fa;
           min-height: 100vh;
           display: flex;
       }

       .main-content {
           flex: 1;
           margin-left: 250px;
           padding: 20px;
       }

       .kasir-container {
           background: #fff;
           padding: 2rem;
           border-radius: 12px;
           box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
       }

       .header-title {
           font-size: 1.5rem;
           font-weight: 600;
           color: #2c3e50;
           text-align: center;
           margin-bottom: 1.5rem;
           padding-bottom: 1rem;
           border-bottom: 2px solid #eee;
       }

       .table {
           margin-top: 1.5rem;
       }

       .table th {
           background-color: #f8f9fa;
           font-weight: 600;
           color: #2c3e50;
       }

       .table td, .table th {
           vertical-align: middle;
           padding: 1rem;
       }

       .form-control, .form-select {
           padding: 0.5rem 0.75rem;
           border: 1px solid #dee2e6;
           border-radius: 6px;
       }

       .summary {
           margin-top: 2rem;
           padding-top: 1.5rem;
           border-top: 2px solid #eee;
       }

       .btn-action {
           padding: 0.75rem 2rem;
           font-weight: 500;
           border-radius: 6px;
       }
       .ui-autocomplete {
    max-height: 200px;
    overflow-y: auto;
    overflow-x: hidden;
    z-index: 9999;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.ui-menu-item {
    padding: 8px 12px;
    cursor: pointer;
}

.ui-menu-item:hover {
    background: #f8f9fa;
}

.ui-helper-hidden-accessible {
    display: none;
}
   </style>
</head>
<body>
   @extends('layouts.sidebarKasir')
   
   <div class="main-content">
       <div class="container kasir-container">
           <div class="header-title">Kasir Offline</div>
           <form id="offlineOrderForm">
               @csrf
               <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Email Customer (Opsional)</label>
                        <input type="email" class="form-control" id="customer_email_input" name="customer_email" placeholder="Masukkan email customer jika ada">
                        <input type="hidden" id="customer_id" name="customer_id">
                        <small class="text-muted">Isi jika customer memiliki akun</small>
                    </div>
                   <div class="col-md-6">
                       <label class="form-label">Metode Pembayaran</label>
                       <select class="form-select" name="payment_method" required>
                           <option value="cash">Cash</option>
                           <option value="bank_transfer">Transfer Bank</option>
                           <option value="e_wallet">E-Wallet</option>
                       </select>
                   </div>
                   <div class="col-md-12 payment-details mt-3" style="display:none;">
                       <label class="form-label">Detail Pembayaran</label>
                       <select class="form-select" name="payment_details">
                           <optgroup label="Bank Transfer">
                               <option value="BCA 0123456789">BCA - 0123456789</option>
                               <option value="BNI 0987654321">BNI - 0987654321</option>
                               <option value="Mandiri 1234567890">Mandiri - 1234567890</option>
                           </optgroup>
                           <optgroup label="E-Wallet">
                               <option value="GoPay 081234567890">GoPay - 081234567890</option>
                               <option value="DANA 081234567890">DANA - 081234567890</option>
                               <option value="OVO 081234567890">OVO - 081234567890</option>
                           </optgroup>
                       </select>
                   </div>
               </div>

               <table class="table table-bordered">
                   <thead>
                       <tr>
                           <th>Kode Produk</th>
                           <th>Jumlah</th>
                           <th>Harga Satuan</th>
                           <th>Total</th>
                           <th>Aksi</th>
                       </tr>
                   </thead>
                   <tbody id="cartItems">
                   </tbody>
               </table>

               <div class="summary">
                   <div class="row">
                       <div class="col-md-6 ms-auto">
                           <div class="card">
                               <div class="card-body">
                                   <h5 class="card-title">Ringkasan Pesanan</h5>
                                   <div id="orderSummary"></div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>

               <div class="text-end mt-4">
                   <button type="button" class="btn btn-primary btn-action" id="checkoutButton">
                       Proses Pembayaran
                   </button>
               </div>
           </form>
       </div>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <script>
       function formatRupiah(angka) {
           return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
       }

       function updateRowTotal(row) {
           const quantity = parseInt(row.querySelector('[name="quantity[]"]').value) || 0;
           const price = parseInt(row.querySelector('[name="price[]"]').value) || 0;
           const total = quantity * price;
           
           row.querySelector('[name="total[]"]').value = total;
           updateOrderSummary();
       }

       function updateOrderSummary() {
           let grandTotal = 0;
           document.querySelectorAll('#cartItems tr').forEach(row => {
               grandTotal += parseInt(row.querySelector('[name="total[]"]').value) || 0;
           });

           document.getElementById('orderSummary').innerHTML = `
               <div class="d-flex justify-content-between mb-3">
                   <span>Total:</span>
                   <strong>${formatRupiah(grandTotal)}</strong>
               </div>
           `;

           document.getElementById('checkoutButton').disabled = grandTotal === 0;
       }

       function showAlert(message, type = 'warning') {
           const alertDiv = document.createElement('div');
           alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
           alertDiv.setAttribute('role', 'alert');
           alertDiv.style.zIndex = '9999';
           alertDiv.innerHTML = `
               ${message}
               <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
           `;
           document.body.appendChild(alertDiv);
           setTimeout(() => alertDiv.remove(), 3000);
       }

       document.addEventListener('DOMContentLoaded', function() {
           const form = document.getElementById('offlineOrderForm');
           const paymentMethod = form.querySelector('[name="payment_method"]');
           const paymentDetails = document.querySelector('.payment-details');
           const paymentDetailsSelect = document.querySelector('[name="payment_details"]');

           paymentMethod.addEventListener('change', function() {
               if (this.value === 'cash') {
                   paymentDetails.style.display = 'none';
                   paymentDetailsSelect.removeAttribute('required');
               } else {
                   paymentDetails.style.display = 'block';
                   paymentDetailsSelect.setAttribute('required', 'required');
                   
                   const optgroups = paymentDetailsSelect.getElementsByTagName('optgroup');
                   for (let optgroup of optgroups) {
                       if (this.value === 'bank_transfer' && optgroup.label === 'Bank Transfer' ||
                           this.value === 'e_wallet' && optgroup.label === 'E-Wallet') {
                           optgroup.style.display = '';
                           if (optgroup.getElementsByTagName('option')[0]) {
                               optgroup.getElementsByTagName('option')[0].selected = true;
                           }
                       } else {
                           optgroup.style.display = 'none';
                           for (let option of optgroup.getElementsByTagName('option')) {
                               option.selected = false;
                           }
                       }
                   }
               }
           });

           // Load cart items
           const cartItems = JSON.parse(localStorage.getItem('cartItems') || '[]');
           const cartItemsContainer = document.getElementById('cartItems');
           
           cartItems.forEach(item => {
               const row = document.createElement('tr');
               row.innerHTML = `
                   <td>
                       <input type="hidden" name="produk_id[]" value="${item.id}">
                       ${item.id}
                   </td>
                   <td>
                       <input type="number" class="form-control" name="quantity[]" 
                              value="${item.quantity}" min="1">
                   </td>
                   <td>
                       <input type="hidden" name="price[]" value="${item.price}">
                       ${formatRupiah(item.price)}
                   </td>
                   <td>
                       <input type="hidden" name="total[]" value="${item.price * item.quantity}">
                       ${formatRupiah(item.price * item.quantity)}
                   </td>
                   <td>
                       <button type="button" class="btn btn-danger btn-sm remove-item">Hapus</button>
                   </td>
               `;

               cartItemsContainer.appendChild(row);

               // Add event listeners
               row.querySelector('[name="quantity[]"]').addEventListener('change', () => updateRowTotal(row));
               row.querySelector('.remove-item').addEventListener('click', () => {
                   row.remove();
                   updateOrderSummary();
               });
           });

           updateOrderSummary();

           document.getElementById('checkoutButton').addEventListener('click', async function() {
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    try {
        const formData = {
            customer_email: form.querySelector('[name="customer_email"]').value,
            payment_method: form.querySelector('[name="payment_method"]').value,
            payment_details: form.querySelector('[name="payment_details"]').value || null,
            items: Array.from(document.querySelectorAll('#cartItems tr')).map(row => ({
                produk_id: row.querySelector('[name="produk_id[]"]').value,
                quantity: row.querySelector('[name="quantity[]"]').value,
                price: row.querySelector('[name="price[]"]').value,
                total: row.querySelector('[name="total[]"]').value
            }))
        };

        const response = await fetch('/kasir/process-offline-order', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(formData)
        });

        // Tambahkan pengecekan response
        if (!response.ok) {
            const errorText = await response.text();
            console.error('Response Error:', errorText);
            throw new Error('Terjadi kesalahan pada server');
        }

        const data = await response.json();

        if (data.success) {
            localStorage.removeItem('cartItems');
            showAlert('Transaksi berhasil!', 'success');
            setTimeout(() => window.location.reload(), 1500);
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert(error.message);
    }
});
$(document).ready(function() {
    $("#customer_email_input").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "/kasir/search-customer-emails", // URL yang sudah disesuaikan
                dataType: "json",
                data: {
                    query: request.term
                },
                success: function(data) {
                    response(data.map(function(item) {
                        return {
                            label: item.email,
                            value: item.email,
                            id: item.id
                        };
                    }));
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            $("#customer_id").val(ui.item.id);
        }
    });
});
       });
   </script>
</body>
</html>