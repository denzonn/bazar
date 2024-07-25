@extends('layouts.app')

@section('title')
    Edit Product
@endsection

@section('content')
    <div class="mb-4">
        <div class="flex flex-row gap-4 text-[#707EAE]">
            <a href="/admin/dashboard">Page</a>
            <div>/</div>
            <a href="/admin/product">Product</a>
            <div>/</div>
            <div>Edit Product</div>
        </div>
        <div class="font-semibold text-primary text-4xl mt-2">Edit Product</div>
    </div>
    <div class="bg-white p-8 rounded-md text-gray-500">
        <form action="{{ route('product.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-6">
                <div class="flex flex-col gap-2">
                    <label for="">Product Name</label>
                    <input type="text" placeholder="Masukkan Nama Product" name="name"
                        class="w-full border px-4 py-2 rounded-md bg-transparent" value="{{ $data->name }}" required />
                </div>
                <div class="flex flex-col gap-2">
                    <label for="">Product Category</label>
                    <select name="category_id" id="" class="bg-transparent border px-4 py-[10px] rounded-md">
                        @foreach ($category as $item)
                            <option value="{{ $item->id }}" {{ $data->category_id === $item->id ? 'selected' : '' }}>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-6 grid grid-cols-2 gap-6">
                <div class="flex flex-col gap-2">
                    <label for="">Product Price</label>
                    <input type="number" placeholder="Masukkan Harga Product" name="price"
                        class="w-full border px-4 py-2 rounded-md bg-transparent" value="{{ $data->price }}" required />
                </div>
                <div class="flex flex-col gap-2">
                    <label for="">Product Status</label>
                    <select name="status" id="" class="bg-transparent border px-4 py-[10px] rounded-md">
                            <option value="Ready" {{ $data->status === 'Ready' ? 'selected' : '' }}>Ready</option>
                            <option value="Sold" {{ $data->status === 'Sold' ? 'selected' : '' }}>Sold</option>
                    </select>
                </div>
            </div>
            <div class="mt-6 grid grid-cols-2 gap-6">
                <div class="flex flex-col gap-2">
                    <label for="">Product Photo</label>
                    <input type="file" placeholder="Masukkan Foto Product" name="photo"
                        class="w-full border px-4 py-2 rounded-md bg-transparent" onchange="previewImage(event)"
                        accept=".jpg, .jpeg, .png" />
                </div>
                <div class="mt-6 flex flex-col gap-2">
                    <label>Photo Preview</label>
                    @if ($data->photo)
                        <img id="photo-preview" class="w-1/3 border-none" src="{{ url('storage/' . $data->photo) }}" alt="Product Image">
                        <span id="no-photo-text" class="text-red-500 hidden">No Photos Yet</span>
                    @else
                        <img id="photo-preview" class="w-1/3 border-none" src="" alt="Product Image">
                        <span id="no-photo-text" class="text-red-500">No Photos Yet</span>
                    @endif
                </div>
            </div>
            <button type="submit" class="w-full rounded-md bg-primary mt-8 text-white py-2 text-lg">Update Product</button>
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

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('photo-preview');
                output.src = reader.result;
                document.getElementById('no-photo-text').style.display = 'none';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endpush
