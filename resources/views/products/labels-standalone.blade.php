<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Labels</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Print Labels</h2>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Labels</h3>
            
            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($products as $product)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center">
                                <input type="checkbox" class="product-checkbox mr-3" value="{{ $product->id }}" data-product='{{ json_encode($product) }}'>
                                <div>
                                    <h4 class="font-semibold text-gray-800 text-sm">{{ $product->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $product->category_name ?? 'No Category' }}</p>
                                </div>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600">
                                {{ $product->stock ?? 0 }} {{ $product->unit_name ?? 'pcs' }}
                            </span>
                        </div>

                        <div class="space-y-2">
                            <div class="text-xs">
                                <span class="text-gray-500">SKU:</span>
                                <span class="font-mono">{{ $product->code }}</span>
                            </div>
                            <div class="text-xs">
                                <span class="text-gray-500">Price:</span>
                                <span class="font-semibold">Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}</span>
                            </div>
                            @if($product->brand_name)
                            <div class="text-xs">
                                <span class="text-gray-500">Brand:</span>
                                <span>{{ $product->brand_name }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <p>No products found.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
    function selectAll() {
        document.querySelectorAll('.product-checkbox').forEach(checkbox => {
            checkbox.checked = true;
        });
    }

    function clearSelection() {
        document.querySelectorAll('.product-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });
    }

    function printLabels() {
        const selectedProducts = [];
        document.querySelectorAll('.product-checkbox:checked').forEach(checkbox => {
            try {
                const productData = JSON.parse(checkbox.dataset.product);
                selectedProducts.push(productData);
            } catch (e) {
                console.error('Error parsing product data:', e);
            }
        });

        if (selectedProducts.length === 0) {
            alert('Please select at least one product to print labels.');
            return;
        }

        alert('Print functionality will be implemented. Selected: ' + selectedProducts.length + ' products');
    }
    </script>
</body>
</html>




























