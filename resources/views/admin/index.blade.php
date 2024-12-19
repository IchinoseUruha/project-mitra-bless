@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <!-- Statistics Cards Section -->
        <div class="tf-section-2 mb-30">
            <div class="flex gap20 flex-wrap-mobile">
                <!-- Left Column -->
                <div class="w-half">
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Total Orders</div>
                                    <h4>{{ $totalOrders }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-dollar-sign"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Total Amount</div>
                                    <h4>Rp {{ number_format($totalAmount, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Pending Orders</div>
                                    <h4>{{ $pendingOrders }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="wg-chart-default">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-dollar-sign"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Pending Orders Amount</div>
                                    <h4>Rp {{ number_format($pendingAmount, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="w-half">
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Delivered Orders</div>
                                    <h4>{{ $deliveredOrders }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-dollar-sign"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Delivered Orders Amount</div>
                                    <h4>Rp {{ number_format($deliveredAmount, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Canceled Orders</div>
                                    <h4>{{ $cancelledOrders }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="wg-chart-default">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-dollar-sign"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Canceled Orders Amount</div>
                                    <h4>Rp {{ number_format($cancelledAmount, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

            <!-- Earnings Revenue Chart Section -->
            <div class="wg-box">
                <div class="flex items-center justify-between">
                    <h5>Earnings revenue</h5>
                </div>
                <div class="flex flex-wrap gap40">
                    <div>
                        <div class="mb-2">
                            <div class="block-legend">
                                <div class="dot t1"></div>
                                <div class="text-tiny">Revenue</div>
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                            <h4>Rp {{ number_format($deliveredAmount, 2) }}</h4>
                            <div class="box-icon-trending {{ $percentageChange >= 0 ? 'up' : 'down' }}">
                                <i class="icon-trending-{{ $percentageChange >= 0 ? 'up' : 'down' }}"></i>
                                <div class="body-title number">{{ number_format(abs($percentageChange), 2) }}%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="line-chart-8" style="min-height: 365px;"></div>
            </div>
        </div>

        <!-- Recent Orders Table Section -->
        <div class="tf-section mb-30">
            <div class="wg-box">
                <div class="flex items-center justify-between">
                    <h5>Recent orders</h5>
                    <div class="dropdown default">
                        <a class="btn btn-secondary dropdown-toggle" href="{{ route('admin.pemesanan') }}">
                            <span class="view-all">View all</span>
                        </a>
                    </div>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 200px" class="text-center">OrderNo</th>
                                    <th class="text-center">Name</th>
                                    {{-- <th class="text-center">Phone</th> --}}
                                    <th class="text-center">Subtotal</th>
                                    {{-- <th class="text-center">Tax</th> --}}
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Order Date</th>
                                    <th class="text-center">Total Items</th>
                                    <th class="text-center">Delivered On</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td class="text-center">{{ $order['order_number'] }}</td>
                                    <td class="text-center">{{ $order['name'] }}</td>
                                    {{-- <td class="text-center">{{ $order['phone'] }}</td> --}}
                                    <td class="text-center">Rp. {{ number_format($order['subtotal'], 2) }}</td>
                                    {{-- <td class="text-center">Rp {{ number_format($order['tax'], 2) }}</td> --}}
                                    <td class="text-center">Rp {{ number_format($order['total'], 2) }}</td>
                                    <td class="text-center">{{ $order['status'] }}</td>
                                    <td class="text-center">{{ $order['order_date']->format('Y-m-d H:i:s') }}</td>
                                    <td class="text-center">{{ $order['total_items'] }}</td>
                                    <td class="text-center">{{ $order['delivered_on'] ? $order['delivered_on']->format('Y-m-d H:i:s') : '' }}</td>
                                    {{-- <td class="text-center">
                                        <a href="#">
                                            <div class="list-icon-function view-icon">
                                                <div class="item eye">
                                                    <i class="icon-eye"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/apexcharts/apexcharts.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const monthlyData = @json($monthlyEarnings);
    
    var options = {
        series: [{
            name: 'Total',
            data: [...Object.values(monthlyData.total || {})],
        }, {
            name: 'Pending',
            data: [...Object.values(monthlyData.pending || {})],
        }, {
            name: 'Delivered',
            data: [...Object.values(monthlyData.delivered || {})],
        }, {
            name: 'Canceled',
            data: [...Object.values(monthlyData.canceled || {})],
        }],
        chart: {
            type: 'bar',
            height: 325,
            toolbar: {
                show: false,
            },
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '10px',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            show: true,
            position: 'top',
            horizontalAlign: 'left'
        },
        colors: ['#2377FC', '#FFA500', '#078407', '#FF0000'],
        stroke: {
            show: false,
        },
        xaxis: {
            labels: {
                style: {
                    colors: '#212529',
                },
            },
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        },
        yaxis: {
            show: true,
            labels: {
                formatter: function(value) {
                    return 'Rp ' + value.toLocaleString();
                }
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return "Rp " + val.toLocaleString()
                }
            }
        }
    };

    const chart = new ApexCharts(document.querySelector("#line-chart-8"), options);
    chart.render();
});
</script>
@endpush

@endsection