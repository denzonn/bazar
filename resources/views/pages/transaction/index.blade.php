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
        <div class="bg-white p-8 rounded-md text-gray-500">
            <table id="transactionTable" class="w-full">
                <thead class="text-left">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                            No</th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-6/12">
                            Nama Pemesan</th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-6/12">
                            Status</th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        $(document).ready(function() {
            $('#transactionTable').DataTable({
                processing: true,
                ajax: "{{ route('transactionData') }}",
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            if (data === 'PROSES') {
                                return '<span class="bg-red-500 text-white px-3 py-1 rounded-md">' + data + '</span>';
                            } else if (data === 'PAID') {
                                return '<span class="bg-green-500 text-white px-3 py-1 rounded-md">' + data + '</span>';
                            } else if (data === 'CANCEL') {
                                return '<span class="bg-gray-500 text-white px-3 py-1 rounded-md">' + data + '</span>';
                            } else if (data === 'SUDAH LENGKAP') {
                                return '<span class="bg-yellow-500 text-white px-3 py-1 rounded-md">' + data + '</span>';
                            } else {
                                return data; // Default, jika status tidak dikenali
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
                                data + '">Detail</a>'
                                '</div>';
                        }
                    },
                ]
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
        });
    </script>
@endpush
