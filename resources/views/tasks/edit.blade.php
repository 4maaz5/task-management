@extends('layout.app')
@section('main')
    <!-- Content Start -->
    <div class="container mt-5">
        <div class="row justify-content-center">

            <div class="col-md-6">


                    <h1 class="mb-5 text-center">Edit Task</h1>
                    <!-- Form Start -->
                    <form action="" method="post" id="EditTaskForm" name="EditTaskForm">

                        <div class=" mt-5">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $edit->title }}" >
                                <p></p>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ $edit->description }}</textarea>
                                <p></p>
                            </div>
                            <div class="mb-3">
                                <label for="priority">Priority</label>
                                <select name="priority" id="priority" class="form-control">
                                    <option value="">--Select--</option>
                                    <option value="1" {{ ($edit->priority==1)?'selected':'' }}>Pending</option>
                                    <option value="2" {{ ($edit->priority==2)?'selected':'' }}>Completed</option>

                                </select>
                            </div>


                        <div class="mb-3 mt-2">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" value="{{ $edit->due_date }}">
                            <p></p>
                        </div>
                            <button id="submitButton" type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>


                <!-- Form End -->
            </div>
        </div>
    </div>
    @endsection
@section('customJs')
<script type="text/javaScript">

$('#EditTaskForm').submit(function(event) {
    event.preventDefault();
    var element = $(this);
    $("#submitButton").prop('disabled', true);

    // Get CSRF token value
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '{{ route('update.task',$edit->id) }}',
        type: 'put',
        data: {
            // Include CSRF token in the data
            _token: csrfToken,
            title: $('#title').val(), // Get the value of title input
            description: $('#description').val(),
            priority: $('#priority').val(), // Get the value of description textarea
            due_date: $('#due_date').val() // Get the value of description textarea
        },
        dataType: 'json',

        success: function(response) {
            $("#submitButton").prop('disabled', false);

            if (response["status"] === true) {
                window.location.href = "{{ route('tasks') }}";
            } else {
                var errors = response['errors'];

                if (errors['title']) {
                    $('#title').addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                        .html(errors['title']);
                } else {
                    $('#title').removeClass('is-invalid').siblings('p').removeClass(
                        'invalid-feedback').html("");
                }
                if (errors['description']) {
                    $('#description').addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                        .html(errors['description']);
                } else {
                    $('#description').removeClass('is-invalid').siblings('p').removeClass(
                        'invalid-feedback').html("");
                }
            }
        }
    });
});


       </script>
@endsection
