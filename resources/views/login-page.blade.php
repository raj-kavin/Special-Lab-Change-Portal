<!doctype html>
<html lang="en">
   <head>
      <title>Login Page</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=Iceland" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=Monospace" rel="stylesheet">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <link rel="stylesheet" href="{{asset('login-template')}}/css/style.css">
      <link rel="stylesheet" href="{{asset('login-template')}}/css/bootstrap.min.css">
   </head>
   <body style = "background-image: url({{asset('login-template/images/admin-1.jpg')}});">

   <div class="container-fluid ">

        <div class="container ">

            <div class="row ">
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
                <div class=" login-box" style="display:flex;align-items:center;justify-content:center;" >


                    <div class="row">
                        <div class="col-lg-20 col-md-90 log-det" style="padding:30px 100px 50px 100px">
                            <div class="d-flex align-items-center justify-content-center">
                                <img src="{{asset('login-template')}}/images/logo.png">
                            </div>
                            <h2 class="mb-3" style="font-family:Iceland;font-weight:900;color:#080808">Special Lab Portal</h2>
                            <div class="text-box-cont mt-9">
                            <form action="handle-login" method="POST" class="login-form">
                              {{ csrf_field() }}
                                <div class="input-group mb-3" style="margin-top:10px">
                                    <i class="fas fa-user" style="padding-top:15px;padding-right:5px;border-bottom:solid rgb(129, 124, 124)"></i>
                                    <input type="text" name="username" class="form-control" placeholder="Email" style="border-top-style:hidden;border-right-style:hidden;border-left-style:hidden;border-bottom:groove;border-bottom:solid black;"required autocomplete="off">

                                </div>
                                <div class="input-group mb-3" style="margin-top:20px">
                                    <i class="fas fa-lock" style="padding-top:15px;padding-right:5px;border-bottom:solid rgb(129, 124, 124)"></i>
                                    <input type="password" name="password" style="border-top-style:hidden;border-right-style:hidden;border-left-style:hidden;border-bottom:groove;border-bottom:solid black" class="form-control" placeholder="Password" id="password" required autocomplete="off">

                                </div>
                                <div class="form-check form-check-inline mb-9" style="margin-top:20px;color:black;font-weight:bolder;">
                                    <input class="form-check-input" type="checkbox" name="showpassword" onclick="showPassword()">
                                    <label class="form-check-label" for="password" >Show Password</label>
                                </div>

                            </div>




                                <div class="input-group center mb-20" style="margin-top:20px">
                                    <button type="submit" value="Login" class="btn btn-login btn-round" style="background-color:blue">LOG IN</button>
                                </div>
                            </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
      <script src="https://apis.google.com/js/platform.js" async defer></script>
      <script src="{{asset('login-template')}}/js/jquery.min.js"></script>
      <script src="{{asset('login-template')}}/js/popper.js"></script>
      <script src="{{asset('login-template')}}/js/bootstrap.min.js"></script>
      <script src="{{asset('login-template')}}/js/main.js"></script>
      <script>
        function showPassword(){
            var x = document.getElementById('password');
            if (x.type==="password"){
                x.type='text';
            }else{
                x.type='password'
            }
        }
      </script>
   </body>
</html>
