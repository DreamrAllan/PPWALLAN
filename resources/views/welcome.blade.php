<div class="mt-16">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @elseif ($message = Session::get('error'))
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @endif
</div>

<style>
    .alert {
        padding: 20px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .alert-danger {
        background-color: #f8d7da; /* Lighter red */
        border-color: #f5c6cb; /* Slightly darker border */
        color: #721c24; /* Darker text */
    }
    .alert-success {
        background-color: #d4edda; /* Lighter green */
        border-color: #c3e6cb; /* Slightly darker border */
        color: #155724; /* Darker text */
    }

    .alert:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
</style>
