@extends('layouts.app')

@section('title')
    Category
@endsection

@section('content')
    <div class="flex flex-col gap-4">
        <div class="flex flex-row justify-between items-center">
            <div>
                <div class="flex flex-row gap-4 text-[#707EAE]">
                    <div>Page</div>
                    <div>/</div>
                    <div>Category</div>
                </div>
                <div class=" font-semibold text-primary text-4xl">Category</div>
            </div>
            <div class="w-full flex justify-end">
                <a href="{{ route('category.create') }}" class="px-6 py-2 bg-primary rounded-md text-white justify-end">
                    Tambah Category
                </a>
            </div>
        </div>
        <div class="bg-white p-8 rounded-md text-gray-500">
            <table id="categoryTable" class="w-full">
                <thead class="text-left">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                            No</th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-6/12">
                            Nama Category</th>
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
            $('#categoryTable').DataTable({
                processing: true,
                ajax: "{{ route('categoryData') }}",
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
                        data: 'id',
                        render: function(data) {
                            let editUrl = '{{ route('category.edit', ':id') }}';
                            let deleteUrl = '{{ route('category.destroy', ':id') }}';
                            editUrl = editUrl.replace(':id', data);
                            deleteUrl = deleteUrl.replace(':id', data);
                            return '<div class="flex">' +
                                '<a href="' + editUrl +
                                '" class="bg-yellow-500 px-3 text-sm py-1 rounded-md text-white mr-2" data-id="' +
                                data + '">Edit</a>' +
                                '<form action="' + deleteUrl +
                                '" method="POST" class="d-inline delete-form">' +
                                '@csrf' +
                                '@method('DELETE')' +
                                '<button class="bg-red-500 text-white px-3 text-sm py-1 rounded-md delete-button" type="button">Delete</button>' +
                                '</form>' +
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
                    text: "Apakah kamu ingin menghapus Category?",
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
