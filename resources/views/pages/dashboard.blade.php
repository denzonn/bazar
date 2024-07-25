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
    <div class="flex flex-row gap-4">
        <div class="w-[40%]">
            <div class="text-xl mb-4 text-gray-500">Total Sales</div>
            <div class="flex flex-row justify-center items-center gap-14 w-full bg-white rounded-xl shadow-sm">
                <div class="py-8 text-gray-500">
                    <div class="text-lg">Total Profit</div>
                    <div class="text-2xl font-semibold">Rp. {{ number_format($totalPaidTransactions, 0, ',', '.') }}</div>
                </div>
                <div class="bg-gray-200 h-16 w-[2px]"></div>
                <div class="py-8 text-gray-500">
                    <div class="text-lg">Unpaid</div>
                    <div class="text-2xl font-semibold">Rp. {{ number_format($totalUnPaidTransactions, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="mt-8">
                <div class="flex flex-row items-center justify-between">
                    <div class="text-xl text-gray-500">Latest Transactions</div>
                    <div>
                        <a href="/transaction" class="text-gray-400 border px-4 py-1 rounded-md text-sm">Show All</a>
                    </div>
                </div>
                <div class="mt-4 space-y-4">
                    @foreach ($latestTransactions as $transaction)
                        @php
                            $icon = '';
                            $statusText = '';
                            $bgColor = 'bg-white';
                            $textColor = 'text-gray-600';
                            $bgIcon = 'bg-secondary';

                            if ($transaction->status == 'Paid') {
                                $icon = 'fa-solid fa-cash-register text-primary';
                                $statusText = 'Order #'.$transaction->code.' has been paid';
                            } elseif ($transaction->status == 'Cancel') {
                                $icon = 'fa-solid fa-xmark text-red-500';
                                $statusText = 'Order #'.$transaction->code.' cancelled';
                                $textColor = 'text-red-500';
                                $bgIcon = 'bg-red-200';
                            } elseif ($transaction->isComplete()) {
                                $icon = 'fa-regular fa-hourglass-half text-primary';
                                $statusText = 'Order #'.$transaction->code.' - All orders have been delivered, waiting for payment';
                            } elseif ($transaction->transactionDetails()->where('arrive', true)->exists()) {
                                $icon = 'fa-solid fa-bell-concierge text-primarytext-primary';
                                $statusText = 'Orders from #'.$transaction->code.' transactions are delivered';
                            } else {
                                $icon = 'fa-solid fa-plus text-primary';
                                $statusText = 'Order #'.$transaction->code.' has been placed';
                            }
                        @endphp
                        <div class="flex flex-row items-center gap-4 {{ $bgColor }} shadow-sm px-4 py-2 rounded-xl">
                            <div class="w-[10%]">
                                <div class="{{ $bgIcon }} rounded-full w-9 h-9 flex justify-center items-center">
                                    <i class="{{ $icon }} "></i>
                                </div>
                            </div>
                            <div class="w-[90%] flex flex-col">
                                <div class="text-base tracking-normal {{ $textColor }}">{{ $statusText }}</div>
                                <div class="text-sm text-gray-400 tracking-wider font-thin">{{ $transaction->updated_at->format('d M Y \a\t H:i') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="w-[60%] pl-6">
            @if ($productQuantities->isEmpty() !== true)
                <div class="text-gray-500">
                    <div class="bg-white shadow-sm rounded-xl p-2">
                        <div class="text-xl mb-4 mt-2 ml-4">Total Quantity per Product</div>
                        <table class="min-w-full">
                            <thead class="bg-[#fdfdfd] text-gray-400">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider rounded-tl-lg">
                                        Product Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                        Price
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider rounded-tr-lg">
                                        Total Quantity Sold
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y">
                                @foreach ($productQuantities as $productQuantity)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                            {{ $productQuantity->product->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                            Rp. {{ number_format($productQuantity->product->price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $productQuantity->total_quantity }} sold
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
