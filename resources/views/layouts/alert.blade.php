@if ($message = Session::get('success'))
    {{-- <div class="alert alert-success alert-dismissable show fade" id="successMessage">
        <div class="alert-body">
            <button class="close" data-dismiss='alert'>
            </button>
            <p>{{ $message }}</p>
        </div>
    </div>

    <script>
        // Hide the success message after 5 seconds
        setTimeout(function() {
            $('#successMessage').hide();
        }, 3000);
    </script> --}}
@endif
