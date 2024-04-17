@extends('layout.app')
@section('main')

    <div class="mt-5">
        <div class="row">

            <div class="col-1"></div>
            <div class="col-md-10">
                      <!-- Display success or error messages -->
                      @if (session('success'))
                      <div class="alert alert-success">{{ session('success') }}</div>
                  @endif
                  @if (session('delete'))
                      <div class="alert alert-danger">{{ session('delete') }}</div>
                  @endif
                <h2>Task List <span class="float-end" style="font-size: 25px;"><a href="{{ route('tasks.create') }}"><button class="btn btn-primary">Add Task</button></a></span></h2>
                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col" class="col-2">Title</th>
                            <th scope="col" class="col-5">Description</th>

                            <th scope="">Priority

                            </th>
                            <th scope="col" class="col-1">Due date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $key)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $key->title }}</td>
                                <td>{{ $key->description }}</td>

                                @if($key->priority==1)
                                <td class="text-danger">Pending</td>
                            @else
                            <td class="text-success">Completed</td>

                                @endif
                                <td>{{ $key->due_date }}</td>
                                <td>
@if($key->priority==1)
<a href="{{ route('tasks.complete',$key->id) }}" class="btn btn-success complete-task" data-task-id="{{ $key->id }}">Complete</a>


@endif
                                        <a href="#" class="btn btn-secondry" data-toggle="modal"
                                            data-target="#exampleModal_{{ $key->id }}">View</a>
                                        <a href="{{ route('tasks.edit',$key->id) }}" class="btn btn-secondry" >Edit</a>
                                        <a href="{{ route('tasks.delete', $key->id) }}" class="btn btn-secondry"
                                            id="myButton"
                                            onclick="return confirm('Are you sure you want to delete!');">Delete</a>

                                </td>
                            </tr>



                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal_{{ $key->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Task Details</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h2>ID: <span style="margin-left: 50px;">{{ $key->id }}</span></h2>
                                            <h2>Title: </h2><p>{{ $key->title }}</p>
                                            <h2>Description: </h2><p>{{ $key->description }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="alert alert-primary">Data Not found</div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
                {{ $data->links() }}
            </div>
        </div>
    </div>



@endsection

@section('customJS')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">





 function deleteCategory(id){
        var url='{{ route("tasks.delete","ID") }}';
        var newUrl=url.replace("ID",id);
        if (confirm("Are You sure you want to delete?")) {
            $.ajax({
                url: newUrl,
                type: 'delete',
                data: {},
                dataType: 'json',
                headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
                success: function(response) {

                    if (response["status"]) {
                        window.location.href = "{{ route('tasks') }}";
                    }else{

                    }
                }
                });
        }

    }
    </script>
@endsection
