@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissable show fade" id="successMessage">
        <div class="alert-body">
            <button class="close" data-dismiss='alert'>
                {{-- <span>x</span> --}}
            </button>
            <p>{{ $message }}</p>
        </div>

    </div>

    <script>
        // $(document).ready(function () {
        //     // Attach a click event handler to the close button
        //     $('.close').on('click', function () {
        //         // Hide the parent div with the id "successMessage"
        //         $('#successMessage').hide();
        //     });
        // });

        // Hide the success message after 5 seconds
        setTimeout(function() {
                $('#successMessage').hide();
            }, 3000);
    </script>

    {{-- <script>
         setTimeout(function() {
         $('#successMessage').remove();
        }, 5000);
    </script>

    <script>
        $(document).ready(function () {
        // Attach a click event handler to the close button
        $('.close').on('click', function () {
            // Hide the parent div with the id "successMessage"
            $('#successMessage').remove();
        });
    });
    </script> --}}
@endif



