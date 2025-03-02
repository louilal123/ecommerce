<?php

use Livewire\Volt\Component;
use App\Models\Product;

new class extends Component {
    public $productId, $name, $price, $stock;
    public $products;

    public function mount()
    {
        // Fetch all products when the component is initialized
        $this->products = Product::all();
    }

    public function save()
    {
        // Validate input
        $this->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        // Save or update the product
        Product::updateOrCreate(['id' => $this->productId], [
            'name' => $this->name,
            'price' => $this->price,
            'stock' => $this->stock,
        ]);

        // Reset form fields and refresh the product list
        $this->reset();
        $this->products = Product::all();
    }

    public function edit($id)
    {
        // Load the product data into the form for editing
        $product = Product::findOrFail($id);
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->stock = $product->stock;
    }

    public function delete($id)
    {
        // Delete the product
        Product::findOrFail($id)->delete();

        // Refresh the product list
        $this->products = Product::all();
    }
};
?>

<div class="p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-xl font-bold mb-4">Product Management</h1>

    {{-- Add / Edit Form --}}
    <form wire:submit.prevent="save" class="mb-4">
        <input type="hidden" wire:model="productId">

        <div class="mb-2">
            <label class="block text-sm font-medium">Name:</label>
            <input type="text" wire:model="name" class="w-full border p-2 rounded">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-2">
            <label class="block text-sm font-medium">Price:</label>
            <input type="number" wire:model="price" step="0.01" class="w-full border p-2 rounded">
            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-2">
            <label class="block text-sm font-medium">Stock:</label>
            <input type="number" wire:model="stock" class="w-full border p-2 rounded">
            @error('stock') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
            @if($productId) Update Product @else Add Product @endif
        </button>
    </form>

    {{-- Product List --}}
    <table class="w-full border">
        <thead>
            <tr>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Price</th>
                <th class="border px-4 py-2">Stock</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td class="border px-4 py-2">{{ $product->name }}</td>
                    <td class="border px-4 py-2">${{ $product->price }}</td>
                    <td class="border px-4 py-2">{{ $product->stock }}</td>
                    <td class="border px-4 py-2">
                        <button wire:click="edit({{ $product->id }})" class="bg-yellow-500 text-white px-2 py-1">Edit</button>
                        <button wire:click="delete({{ $product->id }})" class="bg-red-500 text-white px-2 py-1">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>