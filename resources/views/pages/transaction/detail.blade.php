@extends('layouts.app')

@section('title')
    Transaction
@endsection

@section('content')
    <div class="flex flex-col gap-4">
        <div class="flex flex-row justify-between items-center">
            <div>
                <div class="flex flex-row gap-4 text-[#707EAE]">
                    <div>Page</div>
                    <div>/</div>
                    <a href="/admin/transaction">Transaction</a>
                    <div>/</div>
                    <div>Detail Transaction</div>
                </div>
                <div class="font-semibold text-primary text-4xl">Transaction</div>
            </div>
        </div>
        <div class="bg-white p-8 rounded-md text-gray-500 relative">
            <div>User Detail</div>
            <div class="leading-7 mt-2">
                <div class="flex flex-row gap-4">
                    <div class="w-2/12">
                        Orderer&#8217;s Name
                    </div>
                    <div class="w-10/12">: {{ $transaction->name }}</div>
                </div>
                <div class="flex flex-row gap-4">
                    <div class="w-2/12">
                        Table
                    </div>
                    <div class="w-10/12">: {{ $transaction->table }}</div>
                </div>
                <div class="flex flex-row gap-4">
                    <div class="w-2/12">
                        Total Amount
                    </div>
                    <div class="w-10/12">: Rp. {{ number_format($transaction->total, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="mt-6">Order Detail</div>
            <div class="flex flex-row gap-4 border-b mt-4">
                <div class="w-3/12">Item Name</div>
                <div class="w-1/12">Qty</div>
                <div class="w-2/12">Price</div>
                <div class="w-2/12">Amount</div>
                <div class="w-1/12 text-center">
                    Delivered
                </div>
            </div>
            @if ($transaction->allDelivered === false)
                <form action="{{ route('transaction.arrive') }}" method="POST">
                    @csrf
                    <div class="leading-8 mt-2">
                        @foreach ($transaction->transactionDetails as $item)
                            <div class="flex flex-row gap-4">
                                <div class="w-3/12">{{ $item->product->name }}</div>
                                <div class="w-1/12">{{ $item->quantity }}</div>
                                <div class="w-2/12">Rp. {{ number_format($item->product->price, 0, ',', '.') }}</div>
                                <div class="w-2/12">Rp.
                                    {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</div>
                                <div class="flex items-center justify-center w-1/12">
                                    <input type="checkbox" name="delivered_items[]"
                                        class="w-5 h-5 border rounded-full checked:bg-primary" value="{{ $item->id }}"
                                        {{ $item->arrive ? 'checked disabled' : '' }}>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex flex-row gap-4">
                        <div class="w-3/12"></div>
                        <div class="w-1/12"></div>
                        <div class="w-2/12"></div>
                        <div class="w-2/12">
                        </div>
                        <div class="w-2/12 text-center">
                            <button type="submit" class="mt-4 px-4 py-2 bg-primary text-white rounded-md">Mark as
                                Delivered</button>
                        </div>
                    </div>
                </form>
                @if ($transaction->status === 'Proses' && $transaction->anyDelivered === false)
                    <form action="{{ route('transaction.cancel', $transaction->id) }}" method="POST">
                        @csrf
                        <div class="flex flex-row gap-4 mt-4">
                            <div class="w-3/12"></div>
                            <div class="w-1/12"></div>
                            <div class="w-2/12"></div>
                            <div class="w-2/12">
                            </div>
                            <div class="w-2/12 text-center">
                                <button type="submit" class="px-4 py-2 bg-red-400 text-white rounded-md cancel-button">Cancel the
                                    Order</button>
                            </div>
                        </div>
                    </form>
                @endif
            @else
                <div class="leading-8 mt-2">
                    @foreach ($transaction->transactionDetails as $item)
                        <div class="flex flex-row gap-4">
                            <div class="w-3/12">{{ $item->product->name }}</div>
                            <div class="w-1/12">{{ $item->quantity }}</div>
                            <div class="w-2/12">Rp. {{ number_format($item->product->price, 0, ',', '.') }}</div>
                            <div class="w-2/12">Rp.
                                {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</div>
                            <div class="flex items-center justify-center w-1/12">
                                <input type="checkbox" class="w-5 h-5 border rounded-full checked:bg-primary"
                                    value="{{ $item->id }}" checked disabled>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($transaction->status === 'Paid')
                @else
                    <form action="{{ route('paidTransaction', $transaction->id) }}" method="POST">
                        @csrf
                        <div class="mt-6">
                            <div class="flex flex-row gap-4 py-2 bg-secondary items-center rounded-full text-third">
                                <div class="w-3/12"></div>
                                <div class="w-1/12"></div>
                                <div class="w-2/12"></div>
                                <div class="w-2/12">
                                    <div class="">Method Payment</div>
                                    <div class="flex flex-row gap-2">
                                        <div class="flex items-center gap-2">
                                            <input type="radio" value="Cash" name="payment_method" class="border"
                                                checked> Cash
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <input type="radio" value="Transfer" name="payment_method" class="border">
                                            Transfer
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-full">Paid the
                                        Transaction</button>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
            @endif
        </div>
    </div>
@endsection


@push('addon-script')
    <script>
        $(document).on('click', '.cancel-button', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure you want to cancel the order?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endpush
