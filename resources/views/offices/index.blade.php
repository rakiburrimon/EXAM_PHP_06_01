<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Office Colleague List</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <div class="row">
        <div class="col">
            <button id="add-office-btn" class="btn btn-primary">Add Office</button>
        </div>
    </div>
</div>

<div class="container mt-4">
    <table id="offices-table" class="table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Office Name</th>
                <th>Address</th>
                <th>No. of Colleague</th>
                <th>OPT</th>
            </tr>
        </thead>
        <tbody>
            <!-- Table body content will be dynamically generated -->
            @foreach($offices as $office)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $office->name }}</td>
                    <td>{{ $office->address }}</td>
                    <td>{{ $office->colleagues_count }}</td>
                    <td>
                        <a href="{{ route('offices.view', $office->id) }}" class="btn btn-sm btn-primary">View</a>
                        <a href="{{ route('offices.edit', $office->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <button class="delete btn btn-sm btn-danger" data-id="{{ $office->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#offices-table').DataTable();

        // Handle click event on delete button
        $('.delete').click(function() {
            var officeId = $(this).data('id');
            if (confirm("Are you sure you want to delete this office?")) {
                $.ajax({
                    url: '/offices/delete/' + officeId, // Change the URL as per your route
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
        });
    });
</script>

</body>
</html>
