@extends('layout.app')
@section('main')
    <!-- Content Start -->
    <div class="container mt-5">
        <div class="row justify-content-center">

            <div class="col-md-6">


                    <h1 class="mb-5 text-center">Add Task</h1>
                    <!-- Form Start -->
                    <form action="" method="post" id="TaskForm" name="TaskForm">

                        <div class=" mt-5">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" >
                                <p></p>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                <p></p>
                            </div>
                            <div class="mb-3">
                                <label for="priority">Priority</label>
                                <select name="priority" id="priority" class="form-control">
                                    <option value="">--Select--</option>
                                    <option value="1">Pending</option>
                                    <option value="2">Completed</option>

                                </select>
                            </div>


                        <div class="mb-3 mt-2">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" >
                            <p></p>
                        </div>
                        <button id="submitButton" type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    </form>


                <!-- Form End -->
            </div>
        </div>
    </div>
    @endsection
@section('customJs')
<script type="text/javaScript">

$('#TaskForm').submit(function(event) {
    event.preventDefault();
    var element = $(this);
    $("#submitButton").prop('disabled', true);

    // Get CSRF token value
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '{{ route('store.task') }}',
        type: 'post',
        data: {
            // Include CSRF token in the data
            _token: csrfToken,
            title: $('#title').val(), // Get the value of title input
            description: $('#description').val() ,// Get the value of description textarea
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
                if (errors['priority']) {
                    $('#priority').addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                        .html(errors['priority']);
                } else {
                    $('#priority').removeClass('is-invalid').siblings('p').removeClass(
                        'invalid-feedback').html("");
                }
                if (errors['due_date']) {
                    $('#due_date').addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                        .html(errors['due_date']);
                } else {
                    $('#due_date').removeClass('is-invalid').siblings('p').removeClass(
                        'invalid-feedback').html("");
                }
            }
        }
    });
});


       </script>
@endsection
