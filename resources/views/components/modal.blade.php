@props([
    'name',
    'show' => false,
    'maxWidth' => 'lg' // Bootstrap only supports sm, lg, xl (not 2xl)
])

@php
$maxWidthClass = match($maxWidth) {
    'sm' => 'modal-sm',
    'lg' => 'modal-lg',
    'xl' => 'modal-xl',
    default => '',
};
@endphp

<!-- Modal Trigger (example) -->
{{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $name }}">
    Launch Modal
</button> --}}

<!-- Modal -->
<div
    class="modal fade"
    id="{{ $name }}"
    tabindex="-1"
    aria-labelledby="{{ $name }}Label"
    aria-hidden="true"
    data-bs-backdrop="static"
>
    <div class="modal-dialog {{ $maxWidthClass }} modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            {{ $slot }}
        </div>
    </div>
</div>
