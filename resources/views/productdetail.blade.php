<x-guest-layout>
    @push('styles')
        <style>
            .zoom-wrapper {
                position: relative;
                overflow: hidden;
                width: 100%;
                max-height: 400px;
                border: 1px solid #ddd;
            }

            .zoom-img {
                width: 100%;
                height: auto;
                transition: transform 0.1s ease;
                transform-origin: center center;
            }
        </style>
    @endpush

    <x-slot name="title">{{ $product->name }}</x-slot>

    <div class="container py-4">
        <div class="row g-4 d-flex align-items-center">
            <!-- Image Grid -->
            <div class="col-md-4 col-12">
                <div class="zoom-wrapper">
                    <img src="{{ $product->image }}" class="zoom-img" id="zoomImage" alt="{{ $product->name }}">
                </div>
            </div>

            {{-- Detail Grid --}}
            <div class="col-md-5 col-12">
                <h4 class="fw-bold">{{ $product->name }}</h4>
                <div class="mb-3">
                    <h3 class="text-success fw-bold mt-2">Rp{{ number_format($product->price, 0, ',', '.') }}</h3>
                </div>
                <p class="text-muted">Kategori: {{ $product->category->name }}</p>
                <div class="bg-light p-2 rounded">
                    <h5 class="fw-bold mb-3">Product Details</h5>
                    <p><strong>Condition:</strong> New</p>
                    <p><strong>Min. Order:</strong> 1 Pcs</p>
                    <p><strong>Specifications:</strong></p>
                    <p>{{ $product->description ?? 'Tidak ada detail spesifikasi.' }}</p>
                </div>
            </div>

            <!-- Checkout Grid -->
            <div class="col-md-3 col-12">
                <div class="bg-white border rounded p-4 h-100 d-flex flex-column">
                    <h5 class="fw-bold">Set quantity and notes</h5>
                    <div class="mb-3">
                        <h3 class="text-success fw-bold mt-2">Rp{{ number_format($product->price, 0, ',', '.') }}</h3>
                    </div>
                    <div class="d-grid gap-2 mt-auto">
                        <button class="btn btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                                <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z"/>
                                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                            </svg>
                            Add to Cart
                        </button>
                        <button class="btn btn-outline-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                            </svg>
                            Save to Wishlist
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Product --}}
        <div class="mt-5">
            <h4 class="mb-4">Related Products</h4>
            <div class="row g-4">
                @forelse ($relatedProducts as $related)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <a href="{{ route('detail', $related->id) }}" class="card h-100 text-decoration-none">
                            <img src="{{ $related->image }}" class="card-img-top" style="height: 160px; object-fit: cover;" alt="{{ $related->name }}">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">{{ $related->name }}</h6>
                                <p class="text-success fw-semibold">Rp{{ number_format($related->price, 0, ',', '.') }}</p>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-muted">Tidak ada produk terkait.</p>
                @endforelse
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const zoomWrapper = document.querySelector('.zoom-wrapper');
                const zoomImg = document.getElementById('zoomImage');

                zoomWrapper.addEventListener('mousemove', function (e) {
                    const bounds = zoomWrapper.getBoundingClientRect();
                    const x = (e.clientX - bounds.left) / bounds.width * 100;
                    const y = (e.clientY - bounds.top) / bounds.height * 100;

                    zoomImg.style.transformOrigin = `${x}% ${y}%`;
                    zoomImg.style.transform = 'scale(2)';
                });

                zoomWrapper.addEventListener('mouseleave', function () {
                    zoomImg.style.transform = 'scale(1)';
                    zoomImg.style.transformOrigin = 'center center';
                });
            });
        </script>
    @endpush
</x-guest-layout>
