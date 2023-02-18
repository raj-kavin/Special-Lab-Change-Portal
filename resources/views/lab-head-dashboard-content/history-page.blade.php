@extends('lab-head-dashboard-layout.dashboard-template')

@section('dashboard-admin-content')


@if($errors->any())
  @foreach ($errors->all() as $error)
      <div id="errorBox" style="text-align:center;margin-top:20px;" class="alert alert-danger col-md-12 alert-dismissible fade show" role="alert">
          <strong style="color:white;">{!!$error!!}</strong>
          <button type="button" style="color:white;" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true" style="color:white;" >&times;</span>
          </button>
      </div>

      <script>

        window.onload=function(){

          $("#errorBox").delay(3000).fadeOut("slow");

        }

      </script>

  @endforeach
@endif


@if(session()->has('message'))

    <div id="successBox" style="text-align:center;margin-top:20px;" class="alert alert-success col-md-12 alert-dismissible fade show" role="alert">
        <strong> {{ session()->get('message') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <script>

        setTimeout(
        function()
        {
            $("#successBox").delay(3000).fadeOut("slow");

        }, 1000);

    </script>

@endif


<div class="card" style="background-color:rgb(187,187,233);border-radius: 30px;">
    <div class="card-body" style="overflow: scroll">
    <table class="table  table-hover table-dark">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Staff ID</th>
                <th scope="col">Name</th>
                <th scope="col">Department</th>
                <th scope="col">Curr_lab</th>
                <th scope="col">To_lab</th>
                <th scope="col">Reason_For_Change</th>
                <th scope="col">date_of_request</th>
                <th scope="col">approval_status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($leave_data as $key => $data)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $data->staff_id }}</td>
                    <td>{{ $data->Name }}</td>
                    <td>{{ $data->Department }}</td>
                    <td>{{ $data->Curr_lab }}</td>
                    <td>{{ $data->To_lab }}</td>
                    <td>{{ $data->Reason_For_Change }}</td>
                    <td>{{ $data->date_of_request }}</td>
                    <td>{{ $data->approval_status }}</td>


                </tr>
            @endforeach
            </table>
    </div>

    </div>





@endsection

