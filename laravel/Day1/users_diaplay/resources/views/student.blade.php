<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                @if($error)
                    <!-- Error Alert -->
                    <div class="alert alert-danger shadow-sm" role="alert">
                        <h4 class="alert-heading">Error!</h4>
                        <p class="mb-0">{{ $error }}</p>
                    </div>
                    <a href="/students" class="btn btn-secondary">Back to All Students</a>
                @else
                    <!-- Student Table -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Student Details</h4>
                            <a href="/students" class="btn btn-light btn-sm">Back to All Students</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Field</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $student['id'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ ucfirst($student['name']) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $student['email'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

</body>
</html>