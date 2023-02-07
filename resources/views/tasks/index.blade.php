<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <body>
        <div class="container">
           <div class="card-box card  mt-4 p-3">
            <table class="table" style="">
                <thead>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3">
                            <input type="checkbox" class="show" name="show" id="show"> Show all text
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                                <table>
                                    <tr>
                                        <td><input class="form-control" placeholder="Enter task name" type="text" name="name" id="name" required></td>
                                        <td><button class="btn btn-success add-button">Add</button></td>
                                    </tr>
                                </table>
                        </td>
                    </tr>


                    <tr>
                        <td colspan="3">
                            <div class="list-task">
                            <table>
                                @foreach($task as $data)
                                @php
                                    $endTime = \Carbon\Carbon::parse($data->created_at);
                                    $timeleft = $endTime->diffForHumans();
                                @endphp
                                <tr>
                                    <td class="status-checkbox"><input type="checkbox" name="status" id="status" data-id="{{$data->id}}"  data-value="{{$data->status}}"  @if($data->status == '1') checked @endif></td>
                                    <td style="padding-left: 10px;"> {{$data->name ?? ''}}</td>
                                    <td style="padding-left: 100px;">{{$timeleft}}</td>
                                    <td style="padding-left: 200%;" class="icon-dlt"><i class="material-icons" data-id="{{ $data->id }}">delete</i></td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </td>
                    </tr>
            </table>
           </div>
        </div>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script>
            $(document).ready(function() {
                $(document).on('click', '.add-button', function() {
                    var name = document.getElementById("name").value;
                    if (name == "") {
                        swal("Please Enter name First!");
                        return false;
                    }else{
                        $.ajax({
                            url: "{{ route('tasks.create') }}",
                            cache: false,
                            type: 'GET',
                            data: {
                                name: name
                            },
                            success: function(data) {
                                if(data.status == '400'){
                                    swal("Task name has already Exist!");
                                }else{
                                    $(".list-task").empty();
                                    $(".list-task").html(data);
                                    $("#name").val('');
                                    swal("Task has been added successfully !");
                                }
                            },
                        })
                    }
                })

                // Deleted task js
                $(document).on('click', '.icon-dlt', function() {
                    swal({
                    title: "Are you sure to delete this Task?",
                    text: "Once deleted, you will not be able to see in this Task List!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        var id = $(this).find('i').attr('data-id');
                        $.ajax({
                            url: "{{ route('tasks.delete') }}",
                            cache: false,
                            type: 'GET',
                            data: {
                                id: id
                            },
                            success: function(data) {
                                $("#name").val('');
                                $(".list-task").empty();
                                $(".list-task").html(data);
                            },
                        })
                        swal("Your task has been Deleted Successfully!", {
                        icon: "success",
                        });
                    } else {
                        swal("Your Task is Safe!");
                    }
                    });
                })

                // task status chnages js
                $(document).on('click', '.status-checkbox', function() {
                    var status =  $(this).find('input').attr('data-value');
                    var id     =  $(this).find('input').attr('data-id');
                    $.ajax({
                            url: "{{ route('tasks.status') }}",
                            cache: false,
                            type: 'GET',
                            data: {
                                id: id,
                                status : status
                            },
                            success: function(data) {
                                // console.log(data);
                                $("#name").val('');
                                $(".list-task").empty();
                                $(".list-task").html(data);
                                swal("Task's Status Changed successfully !");
                            },
                        })
                    });

                     // task status chnages js
                $(document).on('click', '.show', function() {
                    $.ajax({
                            url: "{{ route('tasks.show') }}",
                            cache: false,
                            type: 'GET',
                            success: function(data) {
                                // console.log(data);
                                $("#name").val('');
                                $(".list-task").empty();
                                $(".list-task").html(data);
                                swal("All the task show!");
                            },
                        })
                    });
                })

        </script>
        </body>
</html>
