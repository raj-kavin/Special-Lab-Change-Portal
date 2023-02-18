@extends('admin-dashboard-layout.dashboard-template')

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
    <div class="card-body">
      <h3 class="panel-title" style="text-align:center;color:#020202;font-weight:900">Create User Accounts</h3>
      <br>

      <form action="/insert-user-accounts" method="POST">

        {{ csrf_field() }}

        <div class="form-group row">
          <label for="username" class="col-sm-2 col-form-label" style="color:#0c0c0c;font-weight:900">Roll No.</label>
          <div class="col-sm-8">
            <select class="form-control" name = "staff_id" id="staff_id" aria-label="Default select example">

              <option selected disabled>Select a roll no.</option>
              @foreach ($staff_data as $key => $data)
                <option value="{{$data->staff_id}}">{{$data->staff_id}} ({{$data->firstname}} {{$data->lastname}})</option>
              @endforeach

            </select>
          </div>
        </div>

        <div class="form-group row">
          <label for="username" class="col-sm-2 col-form-label" style="color:#0b0b0b;font-weight:900">Username</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" autocomplete="off" required>
          </div>
        </div>

        <div class="form-group row">
          <label for="password" class="col-sm-2 col-form-label" style="color:#070707;font-weight:900">Password</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="password" name="password" placeholder="Enter password" autocomplete="off" required>
          </div>
        </div>

        <div class="form-group row">
          <label style="visibility:hidden;" for="button" class="col-sm-2 col-form-label">button</label>
          <div class="col-sm-8">
            <input class="btn btn-primary col-md-2 col-sm-12" value="Create" id="button" type="submit">
          </div>
        </div>

      </form>

    </div>
</div>

<br>

<div class="card" style="background-color:rgb(187,187,233);border-radius: 30px;">
      <div class="card-body" style="overflow: scroll">

          <table class="table table-bordered table-hover table-dark">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Roll No.</th>
                  <th scope="col">Username</th>
                  <th scope="col">Password</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($staff_user_data as $key => $data)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{$data->staff_id}}</td>
                        <td>{{$data->username}}</td>
                        <td>{{$data->password}}</td>
                        <td><a class="btn btn-primary" href="/view-edit-user-account/{{$data->auto_id}}">Edit</a> <a class="btn btn-danger confirmation" href="/delete-user-account/{{$data->auto_id}}">Delete</a></td>
                    </tr>

                @endforeach

              </tbody>
          </table>

      </div>
</div>



@endsection

<script>

    window.onload=function(){
      $(".nav-item:eq(3)").addClass("active");

      $('.confirmation').on('click', function () {
          return confirm('Are you sure to delete?');
      });

    }

</script>
