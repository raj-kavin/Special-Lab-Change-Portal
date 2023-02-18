@extends('staff-dashboard-layout.dashboard-template')

@section('dashboard-staff-content')


    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div id="errorBox" style="text-align:center;margin-top:20px;"
                class="alert alert-danger col-md-12 alert-dismissible fade show" role="alert">
                <strong style="color:white;">{!! $error !!}</strong>
                <button type="button" style="color:white;" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="color:white;">&times;</span>
                </button>
            </div>

            <script>
                window.onload = function() {

                    $("#errorBox").delay(3000).fadeOut("slow");

                }
            </script>
        @endforeach
    @endif


    @if (session()->has('message'))
        <div id="successBox" style="text-align:center;margin-top:20px;"
            class="alert alert-success col-md-12 alert-dismissible fade show" role="alert">
            <strong> {{ session()->get('message') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <script>
            setTimeout(
                function() {
                    $("#successBox").delay(3000).fadeOut("slow");

                }, 1000);
        </script>
    @endif


    <div class="card" style="background-color:rgb(187,187,233);border-radius: 30px;">
        <div class="card-body">
            <h3 class="panel-title" style="text-align:center;color:black;font-weight:900">Special lab Changing Form</h3>
            <br>

            <form action="/insert-leave-data-of-staff-account" method="POST">
                {{ csrf_field() }}

                <div class="form-group row" style="gap:30px;">
                    <label for="Name" class="col-sm-2 col-form-label" style="color:black;font-weight:900">Name</label>
                    <div class="col-sm-8">

                        <input class="form-control" name="Name" id="Name"
                            aria-label="Default select example" required placeholder="Enter Name" autocomplete="off">
                    </div>



                    <label for="Department" class="col-sm-2 col-form-label" style="color:black;font-weight:900">Department</label>
                    <div class="col-sm-8">

                        <input class="form-control" name="Department" id="Department" aria-label="Default select example" required placeholder="Enter Department Name" autocomplete="off">
                    </div>




                    <label for="Curr_lab" class="col-sm-2 col-form-label" style="color:black;font-weight:900">Curr* Special Lab Name</label>
                    <div class="col-sm-8">

                        <select class="form-control" name="Curr_lab" id="Curr_lab"
                        aria-label="Default select example" required>

                        <option value="All" selected>All</option>
                        <option value="Cloud Computing">Cloud Computing</option>
                        <option value="Artificial Intelligence">Artificial Intelligence</option>
                        <option value="Data Science">Data Science</option>
                        <option value="Blockchain">Blockchain</option>
                        <option value="Cyber Security">Cyber Security</option>


                    </select>
                    </div>


                    <label for="To_lab" class="col-sm-2 col-form-label" style="color:black;font-weight:900">To* Special Lab Name</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="To_lab" id="To_lab"
                        aria-label="Default select example" required>

                        <option value="All" selected>All</option>
                        <option value="Cloud Computing">Cloud Computing</option>
                        <option value="Artificial Intelligence">Artificial Intelligence</option>
                        <option value="Data Science">Data Science</option>
                        <option value="Blockchain">Blockchain</option>
                        <option value="Cyber Security">Cyber Security</option>


                    </select>
                    </div>

                    <label for="date_of_request" class="col-sm-2 col-form-label" style="color:black;font-weight:900">date_of_request</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="date_of_request" id="date_of_request"
                            aria-label="Default select example" required type="Date" placeholder="Date" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row" style="padding-top:20px">
                    <label for="Reason_For_Change" class="col-sm-2 col-form-label" style="color:black;font-weight:900">Reason For Change</label>
                    <div class="col-sm-8" style="padding-left:40px" >
                        <textarea class="form-control" name="Reason_For_Change" id="Reason_For_Change" placeholder="Reason For Change"  required></textarea>
                    </div>
                </div>



                {{-- <div class="form-group row">
                    <label for="from_date" class="col-sm-2 col-form-label">From Date</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="from_date" name="from_date" required>
                    </div>
                    <label for="to_date" class="col-sm-2 col-form-label">To Date</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="to_date" name="to_date" required>
                    </div>
                </div>


                <div class="row">
                    <div class="col-3">
                        Session
                    </div>
                    <div class="form-check col-2">
                        <input class="form-check-input" type="radio" name="session" id="session" value="FN">
                        <label class="form-check-label" for="session" >
                            FN
                        </label>
                    </div>

                    <div class="form-check col-2">
                        <input class="form-check-input" type="radio" name="session" id="session" value="AN">
                        <label class="form-check-label" for="session" >
                            AN
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="session" id="session" value="Full Day">
                        <label class="form-check-label" for="session">
                            Full Day
                        </label>
                    </div>
                </div> --}}
                <br><br>
                <div class="form-group row">
                    <label style="visibility:hidden;" for="button" class="col-sm-2 col-form-label">button</label>
                    <div class="col-sm-8">
                        <input class="btn btn-primary col-md-2 col-sm-12" value="Submit" id="button" type="submit">
                    </div>
                </div>

            </form>

        </div>
    </div>

    <br>

    <div class="card">
        <div class="card-body">
            <h3 class="panel-title" style="text-align:center;color:black;font-weight:900">My Pending Requests</h3>
            <br>

             @foreach ($leave_pending_data as $key => $data)
                <div class="card text-white" style="background-color:rgb(187,187,233);border-radius: 30px;border:black solid">
                    <div class="card-header bg-white" style="color:black;border-radius:30px" >
                        Name: <strong>{{ $data->Name }}</strong><br>
                        Roll_Number: <strong>{{ $data->staff_id}}</strong><br>
                        Department: <strong>{{ $data->Department }}</strong><br>
                        Curr_lab: <strong>{{ $data->Curr_lab }}</strong><br>
                        To_lab: <strong>{{ $data->To_lab }}</strong><br>
                        Reason_For_Change:<strong>{{ $data->Reason_For_Change}}</strong>
                        <i class="float-right" style="font-size:85%;">Request sent on :- {{ $data->date_of_request }}</i>
                    </div>
                    <div class="card-body">

                        <a class="btn btn-danger float-right confirmation"
                            href="/delete-leave-pending-request-in-staff-account/{{ $data->auto_id }}">Delete Request</a>
                    </div>
                </div>
            @endforeach



        </div>
    </div>



@endsection

<script>
    window.onload = function() {

        $(".nav-item:eq(0)").addClass("active");

        $('.confirmation').on('click', function() {
            return confirm('Are you sure to delete?');
        });

    }
</script>
