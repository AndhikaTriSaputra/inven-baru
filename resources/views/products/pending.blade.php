@extends('layouts.app')

@section('title', 'Pending Products Approval')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clock"></i> Pending Products Approval
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-arrow-left"></i> Back to Products
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Unit</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        @php
                                            $product = is_object($product) ? (array)$product : $product;
                                        @endphp
                                        <tr>
                                            <td>{{ $product['temp_id'] ?? $product['id'] ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge badge-info">{{ $product['code'] ?? 'N/A' }}</span>
                                            </td>
                                            <td>{{ $product['name'] ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge badge-secondary">{{ ucfirst($product['type'] ?? 'N/A') }}</span>
                                            </td>
                                            <td>{{ $product['brand'] ?? 'N/A' }}</td>
                                            <td>{{ $product['category'] ?? 'N/A' }}</td>
                                            <td>{{ $product['unit'] ?? 'N/A' }}</td>
                                            <td>
                                                @if($product['image'] ?? false)
                                                    @php
                                                        $images = explode(',', $product['image']);
                                                        $firstImage = trim($images[0]);
                                                    @endphp
                                                    <img src="{{ asset('images/products/' . $firstImage) }}" 
                                                         alt="{{ $product['name'] ?? 'Product' }}" 
                                                         class="img-thumbnail" 
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-clock"></i> Pending
                                                </span>
                                            </td>
                                            <td>{{ isset($product['created_at']) ? \Carbon\Carbon::parse($product['created_at'])->format('d/m/Y H:i') : 'N/A' }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('products.show', $product['temp_id'] ?? $product['id'] ?? '') }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    
                                                    <form action="{{ route('products.approve', $product['temp_id'] ?? $product['id'] ?? '') }}" 
                                                          method="POST" 
                                                          style="display: inline-block;"
                                                          onsubmit="return confirm('Are you sure you want to approve this product?')">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-success" 
                                                                title="Approve Product">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    
                                                    <form action="{{ route('products.reject', $product['temp_id'] ?? $product['id'] ?? '') }}" 
                                                          method="POST" 
                                                          style="display: inline-block;"
                                                          onsubmit="return confirm('Are you sure you want to reject this product?')">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-danger" 
                                                                title="Reject Product">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h4>No Pending Products</h4>
                            <p class="text-muted">All products have been processed.</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left"></i> Back to Products
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto refresh every 30 seconds to check for new pending products
    setInterval(function() {
        // You can add AJAX call here to refresh the page or update the count
    }, 30000);
</script>
@endpush