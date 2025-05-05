<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Drag and Drop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card p-4 shadow-sm">
                    <div class="card-body">
                        <h1 class="card-title text-center">Pending</h1>
                        @if (session('success'))
                            <p style="color: green;">{{ session('success') }}</p>
                        @endif
                        <form method="POST" action="{{ route('store') }}">
                            @csrf
                            <label for="form-label">Task</label>
                            <input type="text" class="form-control" name="title">
                            @error('title')
                                <p style="color: red;">{{ $message }}</p>
                            @enderror
                            <div class="d-flex justify-content-center my-3">
                                <button type="submit" class="btn btn-primary w-75">ADD</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-5">
        <div class="d-flex justify-content-center gap-4 px-3" style="min-height: 400px;">
            <!-- Pending -->
            <div class="card flex-shrink-0" style="width: 300px;">
                <div class="card-header bg-warning text-white text-center">
                    <strong>Pending</strong>
                </div>
                <div class="card-body" id="pending">
                    @foreach ($pendings as $pending)
                        <p>{{ $pending->title }}</p>
                    @endforeach
                </div>
            </div>
    
            <!-- Started -->
            <div class="card flex-shrink-0" style="width: 300px;">
                <div class="card-header bg-primary text-white text-center">
                    <strong>Started</strong>
                </div>
                <div class="card-body" id="started">
                    <!-- Tasks go here -->
                </div>
            </div>
    
            <!-- Testing -->
            <div class="card flex-shrink-0" style="width: 300px;">
                <div class="card-header bg-info text-white text-center">
                    <strong>Testing</strong>
                </div>
                <div class="card-body" id="testing">
                    <!-- Tasks go here -->
                </div>
            </div>
    
            <!-- Completed -->
            <div class="card flex-shrink-0" style="width: 300px;">
                <div class="card-header bg-success text-white text-center">
                    <strong>Completed</strong>
                </div>
                <div class="card-body" id="completed">
                    <!-- Tasks go here -->
                </div>
            </div>
        </div>
    </div>
    











    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>