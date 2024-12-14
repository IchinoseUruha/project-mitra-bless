@extends('layouts.admin')
@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<style>
.pagination {
    display: flex;
    gap: 1px;
}

.pagination > div {
    display: flex;
    gap: 1px;
}

.pagination span, 
.pagination a {
    padding: 0.5rem 1rem;
    border: 1px solid #e5e7eb;
    color: #374151;
    background: white;
    cursor: pointer;
    transition: all 0.2s;
}

.pagination span.current-page {
    background: #ec4899;
    color: white;
    border-color: #ec4899;
}

.pagination a:hover {
    background: #f3f4f6;
}

.pagination span.dots {
    cursor: default;
}
</style>

<body class="bg-gray-50">
  <div class="min-h-screen p-4 md:p-6">
    <!-- Mengurangi padding pada mobile untuk maximize space -->

    <div class="w-full mx-auto bg-white rounded-lg shadow-sm">
      <!-- Mengubah max-w-7xl menjadi w-full untuk full width -->
      
      <!-- Header -->
      <div class="border-b border-gray-200 px-4 md:px-8 py-6">
        <h1 class="text-2xl font-semibold text-gray-800">
          <i class="fas fa-shopping-cart text-pink-500 mr-2"></i>
          Daftar Pemesanan
        </h1>
      </div>

      <!-- Table Container dengan custom padding -->
      <div class="w-full overflow-x-auto px-2 md:px-4">
        <table class="w-full table-auto">
          <thead>
            <tr class="bg-gradient-to-r from-pink-500 to-pink-600 text-white">
              <th class="px-4 md:px-6 py-4 text-left font-semibold whitespace-nowrap">Nomor Pesanan</th>
              <th class="px-4 md:px-6 py-4 text-left font-semibold whitespace-nowrap">Tanggal</th>
              <th class="px-4 md:px-6 py-4 text-left font-semibold whitespace-nowrap">Status</th>
              <th class="px-4 md:px-6 py-4 text-left font-semibold whitespace-nowrap">Metode Pengiriman</th>
              <th class="px-4 md:px-6 py-4 text-left font-semibold whitespace-nowrap">Alamat</th>
              <th class="px-4 md:px-6 py-4 text-left font-semibold whitespace-nowrap">Metode Pembayaran</th>
              <th class="px-4 md:px-6 py-4 text-left font-semibold whitespace-nowrap">Detail Pembayaran</th>
              <th class="px-4 md:px-6 py-4 text-left font-semibold whitespace-nowrap">Total</th>
              {{-- <th class="px-4 md:px-6 py-4 text-left font-semibold whitespace-nowrap">Aksi</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
              <td class="px-4 md:px-6 py-4">
                <span class="font-mono text-sm">{{ $order->order_number }}</span>
              </td>
              <td class="px-4 md:px-6 py-4 text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
              <td class="px-4 md:px-6 py-4">
                <span class="px-3 py-1 rounded-full text-sm
                  @if($order->status == 'menunggu_pembayaran') bg-yellow-100 text-yellow-800
                  @elseif($order->status == 'diproses') bg-blue-100 text-blue-800
                  @elseif($order->status == 'dikirim') bg-green-100 text-green-800
                  @else bg-red-100 text-red-800 @endif">
                  {{ ucwords(str_replace('_', ' ', $order->status)) }}
                </span>
              </td>
              <td class="px-4 md:px-6 py-4">
                <span class="inline-flex items-center">
                  <i class="fas fa-truck text-gray-400 mr-2"></i>
                  {{ ucwords($order->delivery_method) }}
                </span>
              </td>
              <td class="px-4 md:px-6 py-4">
                <span class="inline-flex items-center">
                  <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                  {{ $order->address }}
                </span>
              </td>
              <td class="px-4 md:px-6 py-4">
                <span class="inline-flex items-center">
                  <i class="fas fa-credit-card text-gray-400 mr-2"></i>
                  {{ ucwords(str_replace('_', ' ', $order->payment_method)) }}
                </span>
              </td>
              <td class="px-4 md:px-6 py-4">{{ $order->payment_details }}</td>
              <td class="px-4 md:px-6 py-4 font-semibold">
                Rp {{ number_format($order->total, 0, ',', '.') }}
              </td>
              {{-- <td class="px-4 md:px-6 py-4">
                <div class="flex flex-col gap-2">
                  <button class="inline-flex items-center justify-center px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded-md transition-colors text-sm">
                    <i class="fas fa-check mr-2"></i> Konfirmasi    
                  </button>
                  @if($order->status == 'menunggu_pembayaran')
                  <button class="inline-flex items-center justify-center px-4 py-2 border border-pink-500 text-pink-500 hover:bg-pink-50 rounded-md transition-colors text-sm">
                    <i class="fas fa-times-circle mr-2"></i> Batalkan
                  </button>
                  @endif
                </div>
              </td> --}}
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Footer -->
      <div class="px-4 md:px-8 py-6 bg-gray-50 rounded-b-lg border-t border-gray-200">
        <div class="flex justify-end items-center">
          <div class="pagination">
            {{ $orders->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
@endsection