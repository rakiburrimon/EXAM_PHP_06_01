<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Office</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h2>Edit Office</h2>
            <hr>
            <!-- Office Form -->
            <form id="officeForm" action="{{ route('offices.update', $office->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-md-12">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">Office Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $office->name }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $office->address }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="phone">Office Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $office->phone }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="file">Appointment Letter</label>
                            <input type="file" class="form-control" id="appointment_letter" name="appointment_letter">
                            @if (!empty($office->appointment_letter))
                                <p class="mt-2">Current File: {{ $office->appointment_letter }}</p>
                            @else
                                <p class="mt-2">No file uploaded</p>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <!-- Colleague Form -->
            <form id="colleagueForm" action="{{ route('colleagues.update', $office->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" id="addColleague" class="btn btn-primary">+ Add Colleague</button>
                    </div>
                </div>
                <br>
                <input type="hidden" name="office_id" value="{{ $office->id }}">
                <div id="colleagueBlocks">
                    @foreach ($colleagues as $colleague)
                    <div class="colleague-block">
                        <input type="hidden" name="colleague_id[]" value="{{ $colleague->id }}">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="button" class="btn btn-sm btn-danger removeColleague">Remove colleague</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">Colleague Name</label>
                                <input type="text" class="form-control" name="colleague_name[]" value="{{ $colleague->name }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone">Colleague Phone</label>
                                <input type="text" class="form-control" name="colleague_phone[]" value="{{ $colleague->phone }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="address">Colleague Address</label>
                                <input type="text" class="form-control" name="colleague_address[]" value="{{ $colleague->address }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="file">Photo</label>
                                <input type="file" class="form-control" name="colleague_photo[]">
                                @if (!empty($colleague->photo))
                                    <p class="mt-2">Current File: {{ $colleague->photo }}</p>
                                @else
                                    <p class="mt-2">No file uploaded</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript to handle form submission via AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to handle form submission
        function submitForm(form) {
            var url = form.attr('action'); // Get the form action URL
            var method = form.attr('method'); // Get the form method

            // Serialize form data
            var formData = new FormData(form[0]);

            // Send AJAX request
            $.ajax({
                url: url,
                method: method,
                data: formData,
                processData: false, // Prevent jQuery from automatically processing the data
                contentType: false, // Prevent jQuery from automatically setting the Content-Type header
                success: function(response) {
                    // Handle success response
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error(xhr.responseText);
                }
            });
        }

        // Add Colleague Button Click Event
        $('#addColleague').click(function() {
            var colleagueBlock = '<div class="colleague-block">' +
                                    '<div class="row">' +
                                        '<div class="col-md-12 text-right">' +
                                            '<button type="button" class="btn btn-sm btn-danger removeColleague">Remove colleague</button>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="row">' +
                                        '<div class="form-group col-md-6">' +
                                            '<label for="name">Colleague Name</label>' +
                                            '<input type="text" class="form-control" name="colleague_name[]">' +
                                        '</div>' +
                                        '<div class="form-group col-md-6">' +
                                            '<label for="phone">Colleague Phone</label>' +
                                            '<input type="text" class="form-control" name="colleague_phone[]">' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="row">' +
                                        '<div class="form-group col-md-6">' +
                                            '<label for="address">Colleague Address</label>' +
                                            '<input type="text" class="form-control" name="colleague_address[]">' +
                                        '</div>' +
                                        '<div class="form-group col-md-6">' +
                                            '<label for="file">Photo</label>' +
                                            '<input type="file" class="form-control" name="colleague_photo[]">' +
                                        '</div>' +
                                    '</div>' +
                                '</div>';

            $('#colleagueBlocks').prepend(colleagueBlock);
        });

        // Remove Colleague Button Click Event
        $(document).on('click', '.removeColleague', function() {
            var form1 = $('#officeForm');
            var form2 = $('#colleagueForm');

            // Remove colleague block
            $(this).closest('.colleague-block').remove();

            // Submit both forms after removing colleague
            submitForm(form1);
            submitForm(form2);
        });

        // Function to handle form submission
        function submitForm(form) {
            var url = form.attr('action'); // Get the form action URL
            var method = form.attr('method'); // Get the form method

            // Serialize form data
            var formData = new FormData(form[0]);

            // Send AJAX request
            $.ajax({
                url: '{{ route("offices.delete", ["id" => ""]) }}/' + officeId,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Reload the page after successful deletion
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(error);
                }
            });
        }

        // Listen for changes in form fields and automatically submit the form
        $('#officeForm, #colleagueForm').on('input change', function() {
            submitForm($(this));
        });
    });
</script>

</body>
</html>
