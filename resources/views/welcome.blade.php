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
                @if (session('danger'))
                            <p style="color: red;">{{ session('danger') }}</p>
                        @endif
                <div class="card-body" id="pending">
                    @foreach ($pendings as $pending)
                    

                        <div class="task-item" draggable="true" ondragstart="drag(event)" id="task-{{ $pending->id }}">
                            <div class="d-flex justify-content-between align-items-center py-1 px-2 border rounded bg-light mb-2" style="font-size: 0.9rem;">
                        <p class="mb-0">{{ $pending->title }}</p>
                        <form class="d-inline" method="POST" action="{{ route('destroy', $pending->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger py-0 px-2">Delete</button>
                        </form>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
    
            <!-- Started -->
            <div class="card flex-shrink-0" style="width: 300px;" ondrop="drop(event, 'started')" ondragover="allowDrop(event)">
                <div class="card-header bg-primary text-white text-center">
                    <strong>Started</strong>
                </div>
                <div class="card-body" id="started">
                    <div class="card-column">
                @foreach ($started as $start )
                <div class="d-flex justify-content-between align-items-center py-1 px-2 border rounded bg-light mb-2" style="font-size: 0.9rem;">
                    <p class="mb-0">{{ $start->title }}</p>
                    <form class="d-inline" method="POST" >
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger py-0 px-2">Delete</button>
                    </form>
                </div>
                @endforeach
                    </div>
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
    <script>
        function allowDrop(event) {
            event.preventDefault();
        }
        function drag(event){
            event.dataTransfer.setData("text", event.target.id);
        }

        function drop(event, newStatus){
            event.preventDefault();
            const taskId = event.dataTransfer.getData("text").split('-')[1];
           
            const task = document.getElementById(`task-${taskId}`);
            event.target.appendChild(task);
            console.log(taskId);
            fetch('/tasks/'+taskId+'/update-status', { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: newStatus })
                }).then(response=>{
                    if(!response.ok){
                        alert("Failed to update!");
                    }
                });
        }
    </script>
</body>
</html>