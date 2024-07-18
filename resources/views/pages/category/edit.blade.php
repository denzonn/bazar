@extends('layouts.app')

@section('title')
    Edit Category
@endsection

@section('content')
    <div class="mb-4">
        <div class="flex flex-row gap-4 text-[#707EAE]">
            <a href="/admin/dashboard">Page</a>
            <div>/</div>
            <a href="/admin/category">Category</a>
            <div>/</div>
            <div>Edit Category</div>
        </div>
        <div class=" font-semibold text-primary text-4xl mt-2">Edit Category</div>
    </div>
    <div class="bg-white p-8 rounded-md text-gray-500">
        <form action="{{ route('category.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-6">
                <div class="flex flex-col gap-2">
                    <label for="">Nama Category</label>
                    <input type="text" placeholder="Masukkan Nama Category" name="name"
                        class="w-full border px-4 py-2 rounded-md bg-transparent" value="{{ $data->name }}" required />
                </div>
                <button type="submit" class="w-full rounded-md bg-primary mt-8 text-white py-2 text-lg">Update
                    Category</button>
            </div>
        </form>
    </div>
@endsection

@push('addon-script')
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
