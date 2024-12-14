<!DOCTYPE html>
<html>
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Daftar Pemesanan</title>
    <style>
        .pagination {
            display: flex;
            gap: 1px;
        }
        /* ... style pagination lainnya ... */

        /* Style untuk modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body class="bg-gray-50">
    @extends('layouts.sidebarKasir')
    <div class="min-h-screen p-6">
        <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-sm">
            <!-- Header -->
            <div class="border-b border-gray-200 px-8 py-6">
                <h1 class="text-2xl font-semibold text-gray-800">
                    <i class="fas fa-shopping-cart text-pink-500 mr-2"></i>
                    Daftar Pemesanan
                </h1>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table-auto min-w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-pink-500 to-pink-600 text-white">
                            <th class="px-6 py-4 text-left font-semibold">Nomor Pesanan</th>
                            <th class="px-6 py-4 text-left font-semibold">Status</th>
                            <th class="px-6 py-4 text-left font-semibold">Alamat</th>
                            <th class="px-6 py-4 text-left font-semibold">Jumlah Barang</th>
                            <th class="px-6 py-4 text-left font-semibold">Total</th>
                            <th class="px-6 py-4 text-left font-semibold">Bukti Pembayaran</th>
                            <th class="px-6 py-4 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order_items as $order)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-6 py-4 font-mono text-sm">{{ $order->order_number }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-sm 
                                    @if($order->status == 'menunggu_pembayaran') bg-yellow-100 text-yellow-800 
                                    @elseif($order->status == 'diproses') bg-blue-100 text-blue-800 
                                    @elseif($order->status == 'dikirim') bg-green-100 text-green-800 
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $order->address }}</td>
                            <td class="px-6 py-4">{{ $order->quantity }}</td>
                            <td class="px-6 py-4 font-semibold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($order->bukti_pembayaran)
                                    <img src="{{ asset('uploads/bukti_pembayaran/'.$order->bukti_pembayaran) }}" 
                                         alt="Bukti Pembayaran" 
                                         class="h-16 w-16 object-cover rounded">
                                @else
                                    <span class="text-gray-500">Tidak ada bukti</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-2">
                                    <button onclick="showDetail('{{ $order->id }}')"
                                            class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition-colors">
                                        <i class="fas fa-eye mr-2"></i>
                                        Detail
                                    </button>

                                    @if($order->status != 'dibatalkan')
                                        @if($order->status != 'selesai' && $order->status != 'dikirim')
                                            <button class="inline-flex items-center justify-center px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded-md transition-colors">
                                                <i class="fas fa-check mr-2"></i>
                                                <a href="{{ route('kasir.orderitem.updateStatus', $order->id) }}" 
                                                   class="confirm-btn text-white">Konfirmasi</a>
                                            </button>
                                        @endif

                                        @if($order->status == 'dikirim')
                                            <button class="inline-flex items-center justify-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md transition-colors">
                                                <i class="fas fa-flag-checkered mr-2"></i>
                                                <a href="{{ route('kasir.orderitem.updateStatus', $order->id) }}" 
                                                   class="finish-btn text-white">Selesai</a>
                                            </button>
                                        @endif

                                        @if($order->status == 'menunggu_pembayaran')
                                            <button class="inline-flex items-center justify-center px-4 py-2 border border-pink-500 text-pink-500 hover:bg-pink-50 rounded-md transition-colors">
                                                <i class="fas fa-times-circle mr-2"></i>
                                                <a href="{{ route('kasir.orderitem.cancel', $order->id) }}" 
                                                   class="cancel-btn text-pink-500">Batalkan</a>
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <div class="px-8 py-6 bg-gray-50 rounded-b-lg border-t border-gray-200">
                <div class="flex justify-end">
                    <div class="pagination">
                        {{ $order_items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div id="detailModal" class="modal">
        <div class="bg-white rounded-lg max-w-2xl w-full mx-4">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Detail Pemesanan</h2>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="modalContent" class="space-y-4">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function untuk menampilkan modal
        function showDetail(orderId) {
            fetch(`/kasir/order/${orderId}/detail`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modalContent').innerHTML = `
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Nomor Pesanan</p>
                                <p class="font-mono">${data.order_number}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tanggal</p>
                                <p>${new Date(data.created_at).toLocaleDateString()}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Metode Pengiriman</p>
                                <p>${data.delivery_method}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Metode Pembayaran</p>
                                <p>${data.payment_method}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Detail Pembayaran</p>
                                <p>${data.payment_details}</p>
                            </div>
                        </div>
                    `;
                    document.getElementById('detailModal').classList.add('active');
                });
        }

        // Function untuk menutup modal
        function closeModal() {
            document.getElementById('detailModal').classList.remove('active');
        }

        // Close modal when clicking outside
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Existing confirm button event listeners
        document.querySelectorAll('.confirm-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                if(confirm('Apakah Anda yakin ingin mengkonfirmasi pesanan ini?')) {
                    window.location.href = this.getAttribute('href');
                }
            });
        });
    </script>
</body>
</html>