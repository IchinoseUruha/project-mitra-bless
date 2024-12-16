@extends('layouts.sidebarKasir')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 50;
    }
    
    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .pagination {
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
        margin-top: 1rem;
    }
    .pagination > * {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        color: #374151;
        background-color: white;
        border: 1px solid #D1D5DB;
        border-radius: 0.375rem;
    }
    .pagination > *:hover {
        background-color: #F3F4F6;
    }
    .pagination .active {
        background-color: #3B82F6;
        color: white;
        border-color: #3B82F6;
    }
    .pagination .disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>

<div class="p-6 mx-auto max-w-7xl">
    <div class="flex items-center mb-6 relative">
        <button id="innerSidebarToggle" class="mr-4 text-gray-500 hover:text-pink-500 lg:hidden">
            <i class="fas fa-bars text-xl"></i>
        </button>
        <h1 class="text-2xl font-semibold text-gray-800">Daftar Pesanan Offline</h1>
    </div>
    <div class="bg-white rounded-lg shadow-sm mx-auto">
        <div class="border-b border-gray-200 p-4">
            <div class="flex items-center">
                <i class="fas fa-shopping-cart text-gray-500 mr-2"></i>
                <span class="font-semibold text-gray-700">Data Pesanan Offline</span>
            </div>
        </div>
        <div class="p-4">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Order</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk ID</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Metode Pembayaran</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($offlineOrders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->order_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->produk_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @switch($order->payment_method)
                                        @case('cash')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Cash
                                            </span>
                                            @break
                                        @case('bank_transfer')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Transfer Bank
                                            </span>
                                            @break
                                        @case('e_wallet')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                E-Wallet
                                            </span>
                                            @break
                                        @default
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $order->payment_method }}
                                            </span>
                                    @endswitch
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @switch($order->status)
                                        @case('selesai')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Selesai
                                            </span>
                                            @break
                                        @case('dibatalkan')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Dibatalkan
                                            </span>
                                            @break
                                        @default
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $order->status }}
                                            </span>
                                    @endswitch
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex gap-2 justify-center">
                                        <button type="button"
                                                data-order-id="{{ $order->id }}"
                                                data-order="{{ json_encode($order) }}"
                                                onclick="showDetail({{ json_encode($order) }})"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                            <i class="fas fa-eye mr-1.5"></i> Detail
                                        </button>
                                
                                        {{-- @if($order->status != 'dibatalkan' && $order->status != 'selesai')
                                            <form action="{{ route('kasir.pemesanan.cancel', $order->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-1.5 border border-pink-500 text-xs font-medium rounded-md text-pink-500 hover:bg-pink-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors duration-200">
                                                    <i class="fas fa-times-circle mr-1.5"></i> Batalkan
                                                </button>
                                            </form>
                                        @endif --}}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    Tidak ada data pesanan offline
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="px-6 py-4">
                    {{ $offlineOrders->links() }}
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function showDetail(order) {
    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('id-ID', { 
            style: 'currency', 
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(amount);
    };

    const date = new Date(order.created_at).toLocaleString('id-ID', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
    
    document.getElementById('modalContent').innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
            <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-sm font-medium text-gray-500">Nomor Pesanan</p>
                <p class="mt-1 font-mono text-gray-900">${order.order_number}</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-sm font-medium text-gray-500">Tanggal Pesanan</p>
                <p class="mt-1 text-gray-900">${date}</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-sm font-medium text-gray-500">Jumlah</p>
                <p class="mt-1 text-gray-900">${order.quantity} unit</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-sm font-medium text-gray-500">Harga Satuan</p>
                <p class="mt-1 text-gray-900">${formatCurrency(order.price)}</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-sm font-medium text-gray-500">Total Harga</p>
                <p class="mt-1 text-gray-900">${formatCurrency(order.total)}</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-sm font-medium text-gray-500">Harga Setelah Diskon</p>
                <p class="mt-1 text-gray-900">${formatCurrency(order.harga_diskon || order.total)}</p>
            </div>
        </div>
    `;
    
    document.getElementById('detailModal').classList.add('active');
}

function closeModal() {
    document.getElementById('detailModal').classList.remove('active');
}

// Close modal when clicking outside
document.getElementById('detailModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endsection