<x-guest-layout>
    <div class="container mt-5 mb-5">
        <h2 class="mb-4">Shopping Cart</h2>
        @if (count($cartItems) > 0)
            <div class="row g-3">
                @foreach($cartItems as $item)
                    <div class="col-12">
                        <div class="card p-3 d-flex flex-row align-items-center">
                            <img src="{{ $item['product']->image ?? 'https://via.placeholder.com/200' }}"
                                 class="me-3 rounded"
                                 alt="Product Image"
                                 style="height: 200px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <div class="fw-bold">{{ $item['product']->name }}</div>
                                <div class="text-muted small">
                                    Rp{{ number_format($item['product']->price, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="me-3">
                                <form action="{{ route('cart.update', $item['product']->id) }}" method="POST">
                                    @csrf
                                    <input
                                        type="number"
                                        name="qty"
                                        class="form-control qty-input"
                                        value="{{ $item['qty'] }}"
                                        min="1"
                                        style="width: 80px;"
                                        data-price="{{ $item['product']->price }}"
                                        data-id="{{ $item['product']->id }}"
                                        onchange="this.form.submit()"
                                    >
                                </form>
                            </div>
                            <div class="me-3 fw-bold item-total" id="item-total-{{ $item['product']->id }}">
                                Rp{{ number_format($item['product']->price * $item['qty'], 0, ',', '.') }}
                            </div>
                            <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            @php
                $subtotal = collect($cartItems)->sum(function($item) {
                    return $item['product']->price * $item['qty'];
                });
                $tax = $subtotal * 0.08;
                $total = $subtotal + $tax;
            @endphp

            <div class="d-flex justify-content-end mt-4">
                <div id="cart-summary" class="card p-3" style="min-width: 300px;">
                    <h5>Cart Total</h5>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span id="subtotal">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Tax</span>
                        <span id="tax">Rp{{ number_format($tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span id="total">Rp{{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <button type="button" class="btn btn-primary mt-3 w-100" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                        Proceed to Checkout
                    </button>

                    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('cart.checkout') }}" method="POST" class="modal-content">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="checkoutModalLabel">Customer Info</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="customerName" class="form-label">Your Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="customerName" name="name" value="{{ old('name') }}" required maxlength="50" placeholder="Enter your name">
                                        @error('name')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="customerPhone" class="form-label">Your Phone <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">+62</span>
                                            <input type="tel" class="form-control" id="customerPhone" name="phone" value="{{ old('phone') }}" pattern="[0-9]{9,13}" maxlength="13" minlength="9" placeholder="81234567890" required>
                                        </div>
                                        <div class="form-text">Enter your phone number without the leading zero.</div>
                                        @error('phone')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success w-100">Order</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info">
                Your cart is empty.
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        function formatRupiah(number) {
            return 'Rp' + number.toLocaleString('id-ID');
        }
    </script>
    @endpush
</x-guest-layout>