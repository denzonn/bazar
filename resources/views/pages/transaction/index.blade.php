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
        <div class="mb-4 flex flex-row gap-4">
            <button class="bg-white w-40 h-10 rounded-xl filter-button border border-primary text-gray-500"
                data-status="">All</button>
            <button class="bg-white w-40 h-10 rounded-xl filter-button text-gray-500" data-status="Proses">Proses</button>
            <button class="bg-white w-40 h-10 rounded-xl filter-button text-gray-500" data-status="Paid">Paid</button>
            <button class="bg-white w-40 h-10 rounded-xl filter-button text-gray-500" data-status="Cancel">Cancel</button>
            <button class="bg-white w-40 h-10 rounded-xl filter-button text-gray-500"
                data-status="Complete">Complete</button>
        </div>
        <div class="bg-white p-8 rounded-md text-gray-500">
            <table id="transactionTable" class="w-full">
                <thead class="text-left">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                            No</th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">
                            Transaction Code</th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">
                            Ordered Name</th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">
                            Not Yet Delivered</th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">
                            Status</th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        $(document).ready(function() {
            let table = $('#transactionTable').DataTable({
                processing: true,
                ajax: "{{ route('transactionData') }}",
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'transaction_not_yet_deliver',
                        name: 'transaction_not_yet_deliver',
                        render: function(data) {
                            return data > 0 ? data : "";
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            switch (data) {
                                case 'Proses':
                                    return '<span class="bg-yellow-500 text-white px-3 py-1 rounded-md">' +
                                        data + '</span>';
                                case 'Paid':
                                    return '<span class="bg-green-500 text-white px-3 py-1 rounded-md">' +
                                        data + '</span>';
                                case 'Cancel':
                                    return '<span class="bg-red-500 text-white px-3 py-1 rounded-md">' +
                                        data + '</span>';
                                case 'Complete':
                                    return '<span class="bg-blue-500 text-white px-3 py-1 rounded-md text-lowercase">' +
                                        data + '</span>';
                                default:
                                    return data;
                            }
                        }
                    },
                    {
                        data: 'id',
                        render: function(data) {
                            let editUrl = '{{ route('detailTransaction', ':id') }}';
                            editUrl = editUrl.replace(':id', data);
                            return '<div class="flex">' +
                                '<a href="' + editUrl +
                                '" class="bg-yellow-500 px-3 text-sm py-1 rounded-md text-white mr-2" data-id="' +
                                data + '"><i class="fa-solid fa-eye"></i></a>' +
                                '</div>';
                        }
                    }
                ]
            });

            // Filter button click event
            $(document).on('click', '.filter-button', function() {
                let status = $(this).data('status');
                $('.filter-button').removeClass('border border-primary');
                $(this).addClass('border border-primary');
                table.column(4).search(status).draw();
            });

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

            setInterval(function() {
                table.ajax.reload(null, false);
            }, 120000);
        });
    </script>
@endpush
