<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;


class PageController extends Controller
{
  public function ViewLoginPageController(){

      return view("login-page");

  }

  public function ViewHomePageController(){

       $session_type = Session::get('Session_Type');
       $session_value = Session::get('Session_Value');

       if($session_type == "Admin"){

         $pending_data = DB::select("SELECT leave_data.*, staff_data.firstname, staff_data.lastname FROM leave_data, staff_data WHERE staff_data.staff_id = leave_data.staff_id AND leave_data.approval_status = '[PENDING]' ORDER BY leave_data.staff_id ASC"); // SQL-CODE

         return view("admin-dashboard-content/home-page")->with("pending_data", $pending_data);

       }else if($session_type == "lab_head"){

        $pending_data = DB::select("SELECT leave_data.*, staff_data.firstname, staff_data.lastname FROM leave_data, staff_data WHERE staff_data.staff_id = leave_data.staff_id AND leave_data.approval_status = '[LAB_INCHARGE APPROVED]' ORDER BY leave_data.staff_id ASC");

        return view("lab-head-dashboard-content/home-page")->with("pending_data", $pending_data);

       }else{

         return Redirect::to("/");

       }
    }

    public function ViewHistoryPageController(){

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if($session_type == "lab_head"){

            
            $leave_data = DB::table('leave_data')->get();
            return view("lab-head-dashboard-content/history-page")->with('leave_data', $leave_data);


        }else{

          return Redirect::to("/");

        }

      }





  public function ViewStaffManagementIndexController(){

       $session_type = Session::get('Session_Type');
       $session_value = Session::get('Session_Value');

       if($session_type == "Admin"){

         $staff_data = DB::table('staff_data')->get(); // Get staff data.
         return view("admin-dashboard-content/staff-management-page-1-index")->with('staff_data', $staff_data); //Send staff data with it.

       }else{

         return Redirect::to("/");

       }

  }

  public function ViewStaffManagementEditController($auto_id){

       $session_type = Session::get('Session_Type');
       $session_value = Session::get('Session_Value');

       if($session_type == "Admin"){

         $staff_data = DB::table('staff_data')->where("auto_id", $auto_id)->get(); // Get staff data.
         return view("admin-dashboard-content/staff-management-page-2-edit")->with('staff_data', $staff_data); //Send staff data with it.

       }else{

         return Redirect::to("/");

       }

  }

  public function ViewSettingsPageContoller(){

       $session_type = Session::get('Session_Type');
       $session_value = Session::get('Session_Value');

       if($session_type == "Admin"){

         $admin_data = DB::table('user_account')->where("account_type", "admin")->get(); // Get staff data.
         return view("admin-dashboard-content/settings-page-1-index")->with('admin_data', $admin_data); //Send staff data with it.

       }else{

         return Redirect::to("/");

       }

  }



  public function ViewUserAccountsIndexContoller(){

       $session_type = Session::get('Session_Type');
       $session_value = Session::get('Session_Value');

       if($session_type == "Admin"){

         $staff_data = DB::select("SELECT * FROM staff_data WHERE staff_data.staff_id NOT IN (SELECT user_account.staff_id FROM user_account)"); // SQL-CODE
         $staff_user_data = DB::table('user_account')->where("account_type", "staff")->get(); // Get staff data.

         return view("admin-dashboard-content/user-accounts-page-1-index")->with(['staff_user_data' => $staff_user_data, "staff_data" => $staff_data]); //Send staff data with it.

       }else{

         return Redirect::to("/");

       }

  }

  public function ViewEditUserAccount($auto_id){

    $session_type = Session::get('Session_Type');
    $session_value = Session::get('Session_Value');

    if($session_type == "Admin"){

      $user_data = DB::table('user_account')->where(["auto_id" => $auto_id])->get();
      return view("admin-dashboard-content/user-accounts-page-2-edit")->with(['user_data' => $user_data]); //Send staff data with it.



    }else{

      return Redirect::to("/");

    }

  }

  public function ViewLeaveHistoryController(){

    $session_type = Session::get('Session_Type');

    if($session_type == "Admin"){

      $staff_basic_data = DB::table('staff_data')->select("staff_id","firstname", "lastname")->get();

      $leave_data = DB::table('leave_data')->where(["approval_status" => "[ACCEPTED]"])->orWhere("approval_status", "[DECLINED]")->orderBy('Name', 'DESC')->get();

      return view("admin-dashboard-content/leave-management-page-1-index")->with(["staff_basic_data"=>$staff_basic_data,"leave_data" => $leave_data, "filter_options" => ["staff_id" => "Select a staff","date_of_request" => "All", "year" => "All", "month" => "All", "status" => "All"]]); //Send staff data with it.

    }else{

      return Redirect::to("/");

    }

  }

  public function FilterSearchLeaveHistoryController(Request $request){
   // echo "hello";
    $session_type = Session::get('Session_Type');

    if($session_type == "Admin"){

      $session_value = Session::get('Session_Value');

      $staff_basic_data = DB::table('staff_data')->select("firstname", "lastname")->where(["staff_id" => $session_value])->get();
      $SqlCode = "";


      $staff_id      =  $request->staff_id;
      $Curr_lab      =  $request->Curr_lab;
      $year          =  $request->year;
      $month         =  $request->month;
      $status        =  $request->status;


      if($Curr_lab == "All" && $year == "All" && $month == "All" && $status == "All" && $staff_id != ""){

        $SqlCode = "SELECT * FROM leave_data WHERE (approval_status  = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id' ORDER BY 'DESC'";

    //   }else if($Curr_lab != "All" && $year == "All" && $month == "All" && $status == "All" && $staff_id != ""){

    //     $SqlCode = "SELECT * FROM leave_data WHERE Curr_lab = '$Curr_lab' AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id' ORDER BY 'DESC'";

    //   }else if($Curr_lab == "All" && $year != "All" && $month == "All" && $status == "All" && $staff_id != ""){

    //     $SqlCode = "SELECT * FROM leave_data WHERE (date_of_request LIKE '{$year}______%') AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id' ORDER BY 'DESC'";

    //   }else if($Curr_lab == "All" && $year != "All" && $month != "All" && $status == "All" && $staff_id != ""){

    //     $SqlCode = "SELECT * FROM leave_data WHERE (date_of_request LIKE '%{$year}_{$month}___%') AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id' ORDER BY 'DESC'";

    //   }else if($Curr_lab == "All" && $year == "All" && $month == "All" && $status != "All" && $staff_id != ""){

    //     $SqlCode = "SELECT * FROM leave_data WHERE approval_status = '$status' AND staff_id = '$staff_id' ORDER BY 'DESC'";

    //   }else if($Curr_lab != "All" && $year != "All" && $month == "All" && $status == "All" && $staff_id != ""){

    //     $SqlCode = "SELECT * FROM leave_data WHERE (date_of_request LIKE '%{$year}______%' AND Curr_lab = '$Curr_lab') AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id' ORDER BY 'DESC'";

    //   }else if($Curr_lab != "All" && $year != "All" && $month != "All" && $status == "All"  && $staff_id != ""){

    //     $SqlCode = "SELECT * FROM leave_data WHERE (date_of_request LIKE '%{$year}_{$month}___%' AND Curr_lab = '$Curr_lab') AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id'  ORDER BY 'DESC'";

    //   }else if($Curr_lab != "All" && $year != "All" && $month != "All" && $status != "All" && $staff_id != ""){

    //     $SqlCode = "SELECT * FROM leave_data WHERE (date_of_request LIKE '%{$year}_{$month}___%' AND Curr_lab = '$Curr_lab' AND approval_status = '$status') AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id' ORDER BY 'DESC'";

    //   }else if($Curr_lab != "All" && $year != "All" && $month == "All" && $status != "All" && $staff_id != ""){

    //     $SqlCode = "SELECT * FROM leave_data WHERE (date_of_request LIKE '%{$year}______%)' AND Curr_lab = '$Curr_lab' AND approval_status = '$status' AND staff_id = '$staff_id' ORDER BY 'DESC'";

    //   }else if($Curr_lab == "All" && $year != "All" && $month == "All" && $status != "All" && $staff_id != ""){

    //     $SqlCode = "SELECT * FROM leave_data WHERE (date_of_request LIKE '%{$year}______%') AND approval_status = '$status' AND staff_id = '$staff_id' ORDER BY 'DESC'";

    //   }else if($Curr_lab == "All" && $year != "All" && $month != "All" && $status != "All" && $staff_id != ""){
    //     $SqlCode = "SELECT * FROM leave_data WHERE date_of_request LIKE '%{$year}_{$month}___%' AND approval_status = '$status' AND staff_id = '$staff_id' ORDER BY 'DESC'";

    //   }else{

    //     return redirect()->back()->withErrors("<strong>Wrong filter.</strong>");

    //   }



      $leave_data = DB::select($SqlCode); // SQL-CODE


      $staff_basic_data = DB::table('staff_data')->select("staff_id","firstname", "lastname")->get();

      return view("admin-dashboard-content/leave-management-page-1-index")->with(["staff_basic_data" =>$staff_basic_data,"leave_data" => $leave_data, "filter_options" => ["staff_id" => "$staff_id", "Curr_lab" => "$Curr_lab", "year" => "$year", "month" => "$month", "status" => "$status"]]); //Send staff data with it.


    }else{

      return Redirect::to("/");
    }

  }}





  public function ViewHomePageOfStaffAccountController(){

    $session_type = Session::get('Session_Type');


    if($session_type == "staff"){

      $session_value = Session::get('Session_Value');

      $staff_basic_data = DB::table('staff_data')->select("firstname", "lastname")->where(["staff_id" => $session_value])->get();
      $leave_pending_data = DB::table('leave_data')->where(["staff_id" => $session_value, "approval_status" => "[PENDING]"])->orderBy('Name', 'ASC')->get();
      $username = DB::table('user_account')->select("username")->where(["staff_id" => $session_value])->get();

      return view("staff-dashboard-content/home-page-index")->with(['staff_basic_data' => $staff_basic_data, "username" => $username, "leave_pending_data" => $leave_pending_data]);
    }else{

      return Redirect::to("/");

    }

  }
  public function ViewLabHeadManagementController(){

    $session_type = Session::get('Session_Type');
    $session_value = Session::get('Session_Value');

    if($session_type == "lab_head"){

      $pending_data = DB::select("SELECT leave_data.*, staff_data.firstname, staff_data.lastname FROM leave_data, staff_data WHERE staff_data.staff_id = leave_data.staff_id AND leave_data.approval_status = '[LAB_INCHARGE APPROVED]' ORDER BY leave_data.staff_id ASC"); // SQL-CODE

      return view("lab-head-dashboard-content/home-page")->with("pending_data", $pending_data);

    }else{

      return Redirect::to("/");

    }
}

  public function ViewSettingsPageOfStaffAccountContoller(){

     $session_type = Session::get('Session_Type');
     if($session_type == "staff"){

       $session_value = Session::get('Session_Value');
       $staff_basic_data = DB::table('staff_data')->select("firstname", "lastname")->where(["staff_id" => $session_value])->get();
       $staff_data = DB::table('user_account')->where(["account_type" => "staff", "staff_id" => $session_value])->get(); // Get staff data.

       return view("staff-dashboard-content/settings-page-1-index")->with(['staff_data' => $staff_data, 'staff_basic_data' => $staff_basic_data]); //Send staff data with it.

     }else{

       return Redirect::to("/");

     }

  }

//   public function ViewMyLeaveHistoryPageOfStaffAccountController(){


//      $session_type = Session::get('Session_Type');

//      if($session_type == "staff"){

//        $session_value = Session::get('Session_Value');

//        $staff_basic_data = DB::table('staff_data')->select("firstname", "lastname")->where(["staff_id" => $session_value])->get();
//        $leave_data = DB::table('leave_data')->where(["approval_status" => "[ACCEPTED]"])->orWhere("approval_status", "[DECLINED]")->orderBy('Name', 'DESC')->get();

//        return view("staff-dashboard-content/my-leave-history")->with(["staff_basic_data" =>$staff_basic_data,"leave_data" => $leave_data,"filter_options" => ["Curr_lab" => "All", "year" => "All", "month" => "All", "status" => "All"]]); //Send staff data with it.

//      }else{

//        return Redirect::to("/");

//      }
//   }

//   public function FilterSearchLeaveHistoryPageOfStaffAccountController(Request $request){
//     echo "hello";

//     $session_type = Session::get('Session_Type');

//     if($session_type == "Staff"){

//       $session_value = Session::get('Session_Value');

//       $staff_basic_data = DB::table('staff_data')->select("firstname", "lastname")->where(["staff_id" => $session_value])->get();
//       $SqlCode = "";

//       $Curr_lab = $request->Curr_lab;
//       $year          =  $request->year;
//       $month         =  $request->month;
//       $status        =  $request->status;

//       if($Curr_lab == "All" && $year == "All" && $month == "All" && $status == "All"){

//         $SqlCode = "SELECT * FROM leave_data WHERE approval_status  = '[ACCEPTED]' OR approval_status = '[DECLINED]' ORDER BY 'DESC'";

    //   }else if($Curr_lab != "All" && $year == "All" && $month == "All" && $status == "All"){

    //     $SqlCode = "SELECT * FROM leave_data WHERE Curr_lab = '$Curr_lab' AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') ORDER BY 'DESC'";

    //   }else if($Curr_lab == "All" && $year != "All" && $month == "All" && $status == "All"){

    //     $SqlCode = "SELECT * FROM leave_data WHERE date_of_request LIKE '{$year}______%' AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') ORDER BY 'DESC'";

    //   }else if($Curr_lab == "All" && $year != "All" && $month != "All" && $status == "All"){

    //     $SqlCode = "SELECT * FROM leave_data WHERE date_of_request LIKE '%{$year}_{$month}___%' AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') ORDER BY 'DESC'";
    //   }else if($Curr_lab == "All" && $year == "All" && $month == "All" && $status != "All"){

    //     $SqlCode = "SELECT * FROM leave_data WHERE approval_status = '$status' ORDER BY 'DESC'";

    //   }else if($Curr_lab != "All" && $year != "All" && $month == "All" && $status == "All"){

    //     $SqlCode = "SELECT * FROM leave_data WHERE (date_of_request LIKE '%{$year}______%' AND Curr_lab = '$Curr_lab') AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') ORDER BY 'DESC'";

    //   }else if($Curr_lab != "All" && $year != "All" && $month != "All" && $status == "All"){

    //     $SqlCode = "SELECT * FROM leave_data WHERE (date_of_request LIKE '%{$year}_{$month}___%' AND Curr_lab = '$Curr_lab') AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') ORDER BY 'DESC'";

    //   }else if($Curr_lab != "All" && $year != "All" && $month != "All" && $status != "All"){

    //     $SqlCode = "SELECT * FROM leave_data WHERE (date_of_request LIKE '%{$year}_{$month}___%' AND Curr_lab = '$Curr_lab' AND approval_status = '$status') AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') ORDER BY 'DESC'";

    //   }else if($Curr_lab != "All" && $year != "All" && $month == "All" && $status != "All"){

    //     $SqlCode = "SELECT * FROM leave_data WHERE date_of_request LIKE '%{$year}______%' AND Curr_lab = '$Curr_lab' AND approval_status = '$status' ORDER BY 'DESC'";

    //   }else if($Curr_lab == "All" && $year != "All" && $month == "All" && $status != "All"){

    //     $SqlCode = "SELECT * FROM leave_data WHERE date_of_request LIKE '%{$year}______%' AND approval_status = '$status' ORDER BY 'DESC'";

    //   }else if($Curr_lab == "All" && $year != "All" && $month != "All" && $status != "All"){

    //     $SqlCode = "SELECT * FROM leave_data WHERE date_of_request LIKE '%{$year}_{$month}___%' AND approval_status = '$status' ORDER BY 'DESC'";

    //   }else{

    //     return redirect()->back()->withErrors("<strong>Wrong filter.</strong>");

    //   }

        // echo $SqlCode;

    //   $leave_data = DB::select($SqlCode); // SQL-CODE


    //   return view("staff-dashboard-content/my-leave-history")->with(["staff_basic_data" =>$staff_basic_data,"leave_data" => $leave_data, "filter_options" => ["Curr_lab" => "$Curr_lab", "year" => "$year", "month" => "$month", "status" => "$status"]]); //Send staff data with it.data_of_request
//     }else{

//       return Redirect::to("/");
//     }

//   }

// }

 }
