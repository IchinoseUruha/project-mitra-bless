@extends('layouts.admin')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@section('content')
<style>
    .customer-container {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        padding: 30px;
        margin: 20px 0;
    }

    .page-title {
        color: #333;
        font-size: 32px;  /* Increased */
        font-weight: 600;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .page-title i {
        color: #4f46e5;
        font-size: 28px;  /* Added for icon */
    }

    .table-container {
        background: white;
        border-radius: 8px;
        overflow: hidden;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: linear-gradient(to right, #4f46e5, #6366f1);
        color: white;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 16px;  /* Increased */
        padding: 20px;    /* Increased */
        border: none;
    }

    .table tbody tr:hover {
        background-color: #f8fafc;
    }

    .table td {
        padding: 20px;    /* Increased */
        vertical-align: middle;
        border-color: #f1f5f9;
        font-size: 16px;  /* Added */
    }

    .customer-name {
        color: #4f46e5;
        font-weight: 500;
        font-size: 16px;  /* Added */
        text-decoration: none;
        transition: color 0.2s;
    }

    .customer-name:hover {
        color: #4338ca;
    }

    .customer-type {
        padding: 8px 16px;  /* Increased */
        border-radius: 20px;
        font-size: 14px;    /* Increased */
        font-weight: 500;
        display: inline-block;
    }

    .customer-type.regular {
        background-color: #dbeafe;
        color: #1e40af;
    }

    .customer-type.business {
        background-color: #fae8ff;
        color: #86198f;
    }

    .table td.phone-number {
        font-family: 'Courier New', monospace;
        font-size: 16px;  /* Added */
    }

    .alert {
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 16px;  /* Added */
        padding: 15px 20px;
    }

    .alert-success {
        background-color: #dcfce7;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .pagination {
        margin: 25px 0 0 0;
        gap: 8px;
    }

    .page-link {
        border-radius: 6px;
        padding: 12px 20px;  /* Increased */
        color: #4f46e5;
        border: 1px solid #e2e8f0;
        font-size: 16px;     /* Added */
    }

    .page-link:hover {
        background-color: #4f46e5;
        color: white;
        border-color: #4f46e5;
    }

    .page-item.active .page-link {
        background-color: #4f46e5;
        border-color: #4f46e5;
    }

    .email-cell {
        color: #64748b;
        font-size: 16px;  /* Added */
    }
</style>

<div class="customer-container">
    @if(Session::has('status'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            {{ Session::get('status') }}
        </div>
    @endif

    <h3 class="page-title">
        <i class="fas fa-users"></i>
        Daftar Customer
    </h3>

    <div class="table-responsive table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Nomor Telepon</th>
                    <th>Tipe Customer</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>
                        <a href="#" class="customer-name">{{ $user->name }}</a>
                    </td>
                    <td class="email-cell">{{ $user->email }}</td>
                    <td class="phone-number">{{ $user->mobile }}</td>
                    <td>
                        <span class="customer-type">
                            {{ $user->utype }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection