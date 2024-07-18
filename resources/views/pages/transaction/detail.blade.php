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
                    <div>Transaction</div>
                </div>
                <div class=" font-semibold text-primary text-4xl">Transaction</div>
            </div>
        </div>
        <div class="bg-white p-8 rounded-md text-gray-500 relative">
            @if ($transaction->status === 'PROSES')
                <div class="absolute top-5 right-5">
                    <form action="{{ route('paidTransaction', $transaction->id) }}">
                        <button class="text-white bg-primary px-8 py-2 rounded-md text-xl">Bayar</button>
                    </form>
                </div>
            @endif
            <div class="leading-10">
                <div class="text-xl">Nama Pemesan : {{ $transaction->name }}</div>
                <div class="text-xl">Total Pesanan : Rp. {{ $transaction->total }}</div>
            </div>
            <div class="text-lg">Meja : {{ $transaction->table }}</div>

            <div class="text-xl mt-3">Detail Pesanan :</div>
            @foreach ($transaction->transactionDetails as $item)
                <div class="bg-white py-4 rounded-xl flex flex-row gap-2 items-center justify-between px-2 mb-2 w-6/12">
                    <div class="w-2/12">
                        <img src="{{ Storage::url($item->product->photo) }}" alt=""
                            class="w-full h-32 object-cover scale-x-110">
                    </div>
                    <div class="w-8/12">
                        <div class="font-semibold text-xl mt-2">
                            {{ $item->product->name }}
                        </div>
                        <div>{{ 'Rp ' . number_format($item->product->price, 0, ',', '.') }}</div>
                    </div>
                    <div class="w-2/12 flex items-center justify-center">
                        Quantity : {{ $item->quantity }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.delete-button', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Apakah kamu ingin menghapus Transaction?",
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
        });
    </script>
@endpush
