<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Office Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>

<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h2>Office Details</h2>
            <hr>
            <div class="card">
                <div class="card-header">
                    Office Information
                </div>
                <div class="card-body">
                    <h5 class="card-title">Office Name: <span id="office-name">{{ $office->name }}</span></h5>
                    <p class="card-text">Address: <span id="office-address">{{ $office->address }}</span></p>
                    <p class="card-text">Number of Colleagues: <span id="colleagues-count">{{ $office->colleagues_count }}</span></p>
                    @if(!empty($office->appointment_letter))
                        <a href="{{ route('download-files') }}" class="btn btn-primary">Download Files</a>
                    @else
                        <p>No files available for download.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h2>Colleagues</h2>
            <hr>
            <table id="colleagues-table" class="table">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Table body content will be dynamically generated -->
                </tbody>
            </table>
            <br>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // Get office ID from the span element
        var officeId = {{ $office->id }};

        // Fetch colleagues data for the specific office
        $.ajax({
            url: '/offices/' + officeId + '/colleagues',
            method: 'GET',
            success: function(data) {
                // Populate the colleagues table with data
                var tableBody = $('#colleagues-table tbody');
                tableBody.empty();
                $.each(data, function(index, colleague) {
                    var row = '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + colleague.name + '</td>' +
                        '<td>' + colleague.phone + '</td>' +
                        '<td>' + colleague.address + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                });

                // Initialize DataTable
                $('#colleagues-table').DataTable();
            }
        });
    });
</script>

</body>
</html>
