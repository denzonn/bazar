@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="mb-4">
        <div class="flex flex-row gap-4 text-[#707EAE]">
            <div>Page</div>
            <div>/</div>
            <div>Dashboard</div>
        </div>
        <div class="font-semibold text-primary text-4xl">Dashboard</div>
    </div>
    <div class="grid md:grid-cols-4 gap-6 items-center">
        <div class="bg-white p-8 rounded-lg text-gray-500">
            <div class="text-2xl font-semibold">Penjualan</div>
            <div class="text-3xl font-semibold">Rp. {{ number_format($totalPaidTransactions, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white p-8 rounded-lg text-gray-500">
            <div class="text-2xl font-semibold">Transaksi Belum Dibayar</div>
            <div class="text-3xl font-semibold">Rp. {{ number_format($totalUnPaidTransactions, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="bg-white p-8 rounded-lg mt-6">
        <div class="text-2xl font-semibold mb-4">Total Quantity per Product</div>
        <table class="w-full text-left">
            <thead>
                <tr>
                    <th class="px-4 py-2">Product Name</th>
                    <th class="px-4 py-2">Total Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productQuantities as $productQuantity)
                    <tr>
                        <td class="border px-4 py-2">{{ $productQuantity->product->name }}</td>
                        <td class="border px-4 py-2">{{ $productQuantity->total_quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
