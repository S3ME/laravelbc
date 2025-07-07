<x-app-layout>
    <x-slot name="title">
        {{ $title ?? 'Dashboard' }}
    </x-slot>

    @push('styles')
        <style>
            .card-soft-blue {
                background-color: #e0f0fa;
                border: 1px solid #a3d0eb;
                color: #004a6f;
            }

            .card-soft-green {
                background-color: #dbf4db;
                border: 1px solid #a3d8a3;
                color: #2d6a2d;
            }

            .card-soft-yellow {
                background-color: #fdf1d6;
                border: 1px solid #f0dca3;
                color: #8a6d1f;
            }
            
            .card-soft {
                border-radius: 0.5rem;
                padding: 1.25rem;
                box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.05);
            }

            .quick-action a {
                text-decoration: none;
            }

            #stockPieChart {
                width: 100% !important;
                height: auto !important;
                max-height: 500px;
            }

            .card {
                height: 100%;
            }
        </style>
    @endpush

    <div>
        <h1 class="mb-4">Dashboard</h1>

        <!-- Statistics -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card-soft card-soft-blue">
                    <h6>Total Products</h6>
                    <h3>{{ $totalProducts }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-soft card-soft-green text-success">
                    <h6>Total Product Views</h6>
                    <h3>{{ $totalClicks }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-soft card-soft-yellow text-warning">
                    <h6>Total Categories</h6>
                    <h3>{{ $totalCategories }}</h3>
                </div>
            </div>
        </div>

        <!-- Stock Pie Chart -->
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card p-3">
                        <h5 class="mb-3 text-center">Remaining Stock by Category</h5>
                        <canvas id="stockPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Low Stock Alert -->
        @if(count($lowStockProducts) > 0)
        <div class="alert alert-warning">
            <strong>Warning!</strong> Some products are running low on stock:
            <ul class="mb-0">
                @foreach($lowStockProducts as $product)
                    <li>{{ $product->name }} (Stock: {{ $product->stock }})</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="row g-3 quick-action">
            <div class="col">
                <a href="{{ route('products.create') }}" class="btn btn-outline-primary w-100">+ Add Product</a>
            </div>
            <div class="col">
                <a href="{{ route('categories.create') }}" class="btn btn-outline-secondary w-100">+ Add Category</a>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('stockPieChart').getContext('2d');

            const stockLabels = @json($categoryLabels);
            const stockData = @json($categoryStockCounts);

            // Generate random color otomatis
            const generateColors = (count) => {
                const colors = [];
                for (let i = 0; i < count; i++) {
                    const r = Math.floor(Math.random() * 255);
                    const g = Math.floor(Math.random() * 255);
                    const b = Math.floor(Math.random() * 255);
                    colors.push(`rgba(${r}, ${g}, ${b}, 0.7)`);
                }
                return colors;
            }

            const bgColors = generateColors(stockLabels.length);

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: stockLabels,
                    datasets: [{
                        label: 'Remaining Stock',
                        data: stockData,
                        backgroundColor: bgColors,
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
