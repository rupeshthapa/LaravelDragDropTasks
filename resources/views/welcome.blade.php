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




<div class="d-flex gap-5">
   <div class="card p-4 shadow-sm w-25" ondrop="drop(event, 'pending')" ondragover="allowDrop(event)">
        <div class="card-body">
            <h5 class="card-title text-center">Pending</h5>
            <ol>
            @foreach ($pendings as $pending)
            <li id="task-{{ $pending->id }}"
                draggable="true"
                ondragstart="drag(event)">
                <div class="d-flex justify-content-between align-items-center py-1 px-2 border rounded bg-light mb-2" style="font-size: 0.9rem;">
                    <p class="mb-0">{{ $pending->title }}</p>
                    <form class="d-inline" method="POST" action="{{ route('destroy', $pending->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger py-0 px-2">Delete</button>
                    </form>
                </div>
                    </li>
                @endforeach
            </ol>
        </div>
   </div>

   <div class="card p-4 shadow-sm w-25" ondrop="drop(event, 'started')" ondragover="allowDrop(event)">
        <div class="card-body">
            <h5 class="card-title text-center">Started</h5>
            <ol>
           @foreach ($started as $start)
               <li id="task-{{ $start->id }}"
                draggable="true"
                ondragstart="drag(event)">
                <div class="d-flex justify-content-between align-items-center py-1 px-2 border rounded bg-light mb-2" style="font-size: 0.9rem;">
                    <p class="mb-0">{{ $start->title }}</p>
                    <form class="d-inline" method="POST" action="{{ route('destroy', $start->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger py-0 px-2">Delete</button>
                    </form>
                </div>
                    </li>
                @endforeach
            </ol>
        </div>
   </div>
   
   <div class="card p-4 shadow-sm w-25" ondrop="drop(event, 'testing')" ondragover="allowDrop(event)">
        <div class="card-body">
            <h5 class="card-title text-center">Testing</h5>
            <ol>
            @foreach ($testing as $test)
                <li id="task-{{ $test->id }}"
                    draggable="true"
                    ondragstart="drag(event)">
                    
                    <div class="d-flex justify-content-between align-items-center py-1 px-2 border rounded bg-light mb-2" style="font-size: 0.9rem;">
                        <p class="mb-0">{{ $test->title }}</p>
                        <form class="d-inline" method="POST" action="{{ route('destroy', $test->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger py-0 px-2">Delete</button>
                        </form>
                    </div>
                       
                    @endforeach
                </ol>
        </div>
   </div>


   <div class="card p-4 shadow-sm w-25" ondrop="drop(event, 'completed')" ondragover="allowDrop(event)">
        <div class="card-body">
            <h5 class="card-title text-center">Completed</h5>
            <ol>
            @foreach ($completed as $complete)
                <li id="task-{{ $complete->id }}"
                    draggable="true"
                    ondragstart="drag(event)">
                    
                    <div class="d-flex justify-content-between align-items-center py-1 px-2 border rounded bg-light mb-2" style="font-size: 0.9rem;">
                        <p class="mb-0">{{ $complete->title }}</p>
                        <form class="d-inline" method="POST" action="{{ route('destroy', $complete->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger py-0 px-2">Delete</button>
                        </form>
                    </div>
                        </li>
                    
                        @endforeach
        </ol>
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

        function drop(event, newStatus) {
    event.preventDefault();

    // Get the task ID from the dataTransfer object
    const taskId = event.dataTransfer.getData("text").split('-')[1];  // Assuming task ID is set as "task-123"
    const task = document.getElementById(`task-${taskId}`);  // Get the task element by its ID
    
    // Find the target list to append the task (the <ol> inside the target container)
    const targetList = event.target.querySelector('ol');
    
    if (targetList) {
        // Append the task to the target list
        targetList.appendChild(task);
    } else {
        // If no <ol> is found in the target, just append the task to the event target
        event.target.appendChild(task);
    }
    
    console.log(`Task ID: ${taskId}, New Status: ${newStatus}`);
    
    // Send the updated status to the server via a POST request
    fetch(`/tasks/${taskId}/update-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status: newStatus })
    }).then(response => {
        if (!response.ok) {
            alert("Failed to update!");
        }
    });
}


        
    </script>
</body>
</html>