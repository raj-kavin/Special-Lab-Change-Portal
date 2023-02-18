<?php

namespace App\Http\Controllers;

use Exception;

use App\Mail\MailNotify;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class DatabaseController extends Controller
{
    public function InsertStaffData(Request $request)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "staff") {

            $validatedata = $request->validate([
                'staff_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'date_of_birth' => 'required',
                'email' => 'required',
                'phone_number' => 'required|min:10|max:10',
                //   'position' => 'required',
            ]);

            $staff_id       = $request->staff_id;
            $first_name     = $request->first_name;
            $last_name      = $request->last_name;
            $date_of_birth  = $request->date_of_birth;
            $email          = $request->email;
            $phone_number   = $request->phone_number;
            // $position       = $request->position;


            if (DB::table('staff_data')->where('staff_id', $staff_id)->doesntExist()) {

                if (DB::insert('INSERT INTO staff_data (staff_id, firstname, lastname, dob, email, phone_number) values (?, ?, ?, ?, ?, ?)', [$staff_id, $first_name, $last_name, $date_of_birth, $email, $phone_number])) {

                    return redirect()->back()->with('message', 'Registeration is Successful.');
                }
            } else {
                return redirect()->back()->withErrors("<strong>Unable to register:</strong> The given staff ID already exists in the database");
            }
        }
    }

    public function DeleteStaffData($auto_id)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "Admin") {

            if (DB::table('staff_data')->where('auto_id', '=', $auto_id)->delete()) {

                return redirect()->back()->with('message', 'Deletion is Successful.');
            }
        } else {

            return Redirect::to("/");
        }
    }

    public function UpdateStaffData(Request $request)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "Admin") {

            $validatedata = $request->validate([
                'auto_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'date_of_birth' => 'required',
                'email' => 'required',
                'phone_number' => 'required|min:10|max:10',
                //   'position' => 'required',
            ]);

            $auto_id        = $request->auto_id;
            $first_name     = $request->first_name;
            $last_name      = $request->last_name;
            $date_of_birth  = $request->date_of_birth;
            $email          = $request->email;
            $phone_number   = $request->phone_number;
            // $position       = $request->position;


            if (DB::table('staff_data')->where('auto_id', $auto_id)->update(['firstname' => $first_name, 'lastname' => $last_name, 'dob' => $date_of_birth, 'email' => $email, 'phone_number' => $phone_number])) {

                return Redirect::to("/view-staff-management-index")->with('message', 'Updation is Successful.');
            } else {

                return Redirect::to("/view-staff-management-index")->with('message', 'No changes made.');
            }
        } else {

            return Redirect::to("/");
        }
    }


    public function ChangeUsername(Request $request)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "Admin") {

            $admin_data = DB::table('user_account')->where("account_type", "admin")->get(); // Get staff data.

            if ($request->password == $admin_data[0]->password) {

                if (DB::table('user_account')->where('account_type', 'admin')->update(['username' => $request->username])) {

                    return redirect()->back()->with('message', 'Username has been updated successfully.');
                } else {

                    return redirect()->back()->with('message', 'No changes made.');
                }
            } else {

                return redirect()->back()->withErrors('The password is wrong.');
            }
        } else {

            return Redirect::to("/");
        }
    }

    public function ChangePassword(Request $request)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "Admin") {

            $admin_data = DB::table('user_account')->where("account_type", "admin")->get(); // Get staff data.

            if ($request->current_password == $admin_data[0]->password) {

                if ($request->new_password == $request->confirm_password) {

                    if (DB::table('user_account')->where('account_type', 'admin')->update(['password' => $request->new_password])) {

                        return redirect()->back()->with('message', 'Password has been updated successfully.');
                    } else {

                        return redirect()->back()->with('message', 'No changes made.');
                    }
                } else {

                    return redirect()->back()->withErrors('The confirm password does not match');
                }
            } else {

                return redirect()->back()->withErrors('The current password is wrong.');
            }
        } else {

            return Redirect::to("/");
        }
    }

    public function EditUserAccount(Request $request)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "Admin") {

            $this->validate($request, [
                'username' => 'required',
                'password' => 'required',
            ]);


            $username  =  $request->username;
            $password  =  $request->password;
            $auto_id   =  $request->auto_id;

            if (DB::table('user_account')->where('auto_id', $auto_id)->update(['username' => $username, 'password' => $password])) {

                return Redirect::to("/view-user-accounts-index")->with('message', 'Updation is Successful.');
            } else {

                return Redirect::to("/view-user-accounts-index")->with('message', 'No changes made.');
            }
        } else {

            return Redirect::to("/");
        }
    }

    public function DeleteUserAccount($auto_id)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "Admin") {

            if (DB::table('user_account')->where('auto_id', '=', $auto_id)->delete()) {

                return redirect()->back()->with('message', 'Deletion is Successful.');
            }
        } else {

            return Redirect::to("/");
        }
    }

    public function InsertUserAccount(Request $request)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "Admin") {

            $validatedata = $request->validate([
                'staff_id' => 'required',
                'username' => 'required',
                'password' => 'required',
            ]);

            $staff_id  =  $request->staff_id;
            $username  =  $request->username;
            $password  =  $request->password;


            if (DB::table('user_account')->where('staff_id', $staff_id)->doesntExist()) {

                if (DB::table('user_account')->where('username', $username)->doesntExist()) {

                    if (DB::insert('INSERT INTO user_account (staff_id, username, password, account_type) values (?, ?, ?, ?)', [$staff_id, $username, $password, "staff"])) {

                        return redirect()->back()->with('message', 'Account creation is Successful.');
                    }
                } else {

                    return redirect()->back()->withErrors("<strong>Unable to create:</strong> The given username already exists in the database.");
                }
            } else {

                return redirect()->back()->withErrors("<strong>Unable to create:</strong> The staff already has an account");
            }
        }
    }

    public function AcceptRequest($auto_id)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "Admin") {

            if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[LAB_INCHARGE APPROVED]"])) {
                return redirect()->back()->with('message', 'Accepted');
            } else {

                return redirect()->back()->with('message', 'No changes made.');
            }
        } else if ($session_type == "lab_head") {

            if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[LAB_HEAD APPROVED]"])) {

                $leavedata = DB::table('leave_data')->where(['auto_id' => $auto_id])->get();
                $staffid = $leavedata[0]->staff_id;
                $staffdata = DB::table('staff_data')->where(['staff_id' => $staffid])->get();
                $mailid = $staffdata[0]->email;
                //echo $mailid;
                $data = [

                    "recipient" => $mailid,
                    "fromemail" => "srisathyasai24680@gmail.com",
                    "fromname" => "Camps Site",
                    "subject" => 'Reg: Special Lab',
                    "body" => 'Your Special Lab Change Has Been Approved

                                For more special lab details, refer our wiki page:
                                https://wiki.bitsathy.ac.in/wiki/SLABS:Special_labs'

                ];
                try {
                    Mail::to($mailid)->send(new MailNotify($data));
                } catch (Exception $th) {
                    return $th;
                }
                if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[ACCEPTED]"])) {
                    return redirect()->back()->with('message', 'Accepted');


                } else {

                    return redirect()->back()->with('message', 'No changes made.');
                }
            } else {
                return "No internet connection";
            }
        } else {

            return Redirect::to("/");
        }
    }
    //  public function sendEmail(){

    //     if($this->isOnline()){

    //         $leavedata = DB::table('leave_data')->where(['auto_id'=> $auto_id])->get();
    //         $staffid = $leavedata[0]->staff_id;
    //         $staffdata=DB::table('staff_data')->where(['staff_id'=> $staffid])->get();
    //         $mailid= $staffdata[0]->email;
    //         //return $mailid;
    //          $data1=[

    //              "recipient"=> "kavinraj.cs21@bitsathy.ac.in",
    //              "fromemail"=>"srisathyasai24680@gmail.com",
    //              "fromname"=> "Camps Site",
    //              "subject" => 'Reg: Leave request',
    //              "body"=> 'Your leave request as been accepted'

    //          ];
    //          try {
    //              Mail::to("srisathyasai24680@gmail.com")->send(new MailNotify($data1));
    //          } catch (Exception $th) {
    //              return 'mail not sent';
    //          }

    //      }else{
    //          return "No internet connection";
    //      }

    //  }


    public function isOnline($site = "https://youtube.com/")
    {
        if (@fopen($site, "r")) {
            return true;
        } else {
            return false;
        }
    }

    public function DeclineRequest($auto_id)
    {

         $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "Admin") {

            if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[LAB_INCHARGE DECLINED]"])) {
                return redirect()->back()->with('message', 'Declined');
            } else {

                return redirect()->back()->with('message', 'No changes made.');
            }
        } else if ($session_type == "lab_head") {

            if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[LAB_HEAD DECLINED]"])) {

                $leavedata = DB::table('leave_data')->where(['auto_id' => $auto_id])->get();
                $staffid = $leavedata[0]->staff_id;
                $staffdata = DB::table('staff_data')->where(['staff_id' => $staffid])->get();
                $mailid = $staffdata[0]->email;
                //echo $mailid;
                $data = [

                    "recipient" => $mailid,
                    "fromemail" => "srisathyasai24680@gmail.com",
                    "fromname" => "Camps Site",
                    "subject" => 'Reg: Special Lab',
                    "body" => 'Your Special Lab Change Request Has Been Declined

                                For more special lab details, refer our wiki page:
                                https://wiki.bitsathy.ac.in/wiki/SLABS:Special_labs'

                ];
                try {
                    Mail::to($mailid)->send(new MailNotify($data));
                } catch (Exception $th) {
                    return $th;
                }
                if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[DECLINED]"])) {
                    return redirect()->back()->with('message', 'Declined');

                } else {

                    return redirect()->back()->with('message', 'No changes made.');
                }
            } else {
                return "No internet connection";
            }
        } else {

            return Redirect::to("/");
        }
    }

    public function ChangeUsernameOfStaffAccount(Request $request)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "staff") {

            $staff_data = DB::table('user_account')->where(["account_type" => "staff", "staff_id" => $session_value])->get(); // Get staff data.

            if ($request->password == $staff_data[0]->password) {

                if (DB::table('user_account')->where(["account_type" => "staff", "staff_id" => $session_value])->update(['username' => $request->username])) {

                    return redirect()->back()->with('message', 'Username has been updated successfully.');
                } else {

                    return redirect()->back()->with('message', 'No changes made.');
                }
            } else {

                return redirect()->back()->withErrors('The password is wrong.');
            }
        } else {

            return Redirect::to("/");
        }
    }

    public function ChangePasswordOfStaffAccount(Request $request)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "staff") {

            $staff_data = DB::table('user_account')->where(["account_type" => "staff", "staff_id" => $session_value])->get(); // Get staff data.

            if ($request->current_password == $staff_data[0]->password) {

                if ($request->new_password == $request->confirm_password) {

                    if (DB::table('user_account')->where(["account_type" => "staff", "staff_id" => $session_value])->update(['password' => $request->new_password])) {

                        return redirect()->back()->with('message', 'Password has been updated successfully.');
                    } else {

                        return redirect()->back()->with('message', 'No changes made.');
                    }
                } else {

                    return redirect()->back()->withErrors('The confirm password does not match');
                }
            } else {

                return redirect()->back()->withErrors('The current password is wrong.');
            }
        } else {

            return Redirect::to("/");
        }
    }


    public function InsertLeaveDataOfStaffAccount(Request $request)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "staff") {

            $validatedata = $request->validate([

                'Name' => 'required',
                'Department' => 'required',
                'Curr_lab' => 'required',
                'To_lab' => 'required',
                'date_of_request' => 'required',
                'Reason_For_Change' => 'required|max:200',
            ]);


            $Name              =  $request->Name;
            $staff_id          =  $session_value;
            $Department        =  $request->Department;
            $Curr_lab          =  $request->Curr_lab;
            $To_lab            =  $request->To_lab;
            $Reason_For_Change =  $request->Reason_For_Change;
            $date_of_request   =  $request->date_of_request;
            $approval_status      =  "[PENDING]";


            if (DB::insert('INSERT INTO leave_data ("staff_id", "Name", "Department", "Curr_lab", "To_lab", "Reason_For_Change", "date_of_request", "approval_status" ) values (?, ?, ?, ?, ?, ?,?,?)', [$staff_id, $Name, $Department, $Curr_lab, $To_lab, $Reason_For_Change, $date_of_request, $approval_status])) {

                return redirect()->back()->with('message', 'Special Lab change form submitted Successfully ');
            }
        }
    }

    public function DeleteLeavePendingRequestInStaffAccount($auto_id)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "staff") {

            if (DB::table('leave_data')->where('auto_id', '=', $auto_id)->delete()) {

                return redirect()->back()->with('message', 'Deletion is Successful.');
            }
        } else {

            return Redirect::to("/");
        }
    }
}
