<?php

namespace App\Http\Controllers;

use App\Models\SocialHour;
use App\Models\User;
use App\Models\Users;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function submit() {
        return view('submit', ['error'=> ""]);
    }

    public function submitProcess(Request $rd) {

        $hours = $rd->all()['hours'];
        $description = $rd->all()['description'];
        $date = $rd->all()['date'];
        $user = $rd->all()['user'];

        $SocialHours = new SocialHour;
        $SocialHours->user = $user;
        $SocialHours->hours = $hours;
        $SocialHours->description = $description;
        $SocialHours->date = $date;
        $SocialHours->save();

        $Users = Users::query()->where('username', "=", $user)->get();
        $totalHours = $Users[0]["total_hours"];
        $time = 0;
        $time = $time + intval(substr($totalHours,0,2)) * 60;
        $time = $time + intval(substr($totalHours,3,2));

        $time = $time + intval(substr($hours,0,2)) * 60;
        $time = $time + intval(substr($hours,3,2));

        $minutes = fmod($time,60);
        $hours = intdiv($time, 60);
        // get the correct formatting of 00:00 and save it the variable $totalTime
        $minutesstr = "";
        $hoursstr ="";
        $totalTime="";
        if ($hours > 0){
            if ($minutes < 10 ){
                $minutesstr = "0".strval($minutes);
            }
            else {
                $minutesstr = strval($minutes);
            }

            if ($hours < 10 ){
                $hoursstr = "0".strval($hours);
            }
            else{
                $hoursstr = $hours;
            }
            $totalTime = $hoursstr . ":" . $minutesstr;
        }
        if ($hours < 0 ){
            if ($minutes != 0){
                $minutes = 60 - $minutes;
                $hours = $hours +1;
            }
            if ($minutes < 10 ){
                $minutesstr = "0".strval($minutes);
            }
            else {
                $minutesstr = strval($minutes);
            }

            if ($hours < 10 ){
                $hoursstr = "0".strval(-$hours);
            }
            else{
                $hoursstr = -$hours;
            }
            $totalTime = "-". $hoursstr . ":" . $minutesstr;
        }

        echo ($totalTime);

        User::where('username', $user)->update(array('total_hours'=> $totalTime));


        return redirect('/overview?user='.$user);
    }

    public function overview(Request $rd){
        $user = $rd->all()['user'];
        $SocialHours =  SocialHour::query()->where('user',"=",$user)->get();
        $Users = Users::query()->where('username', "=", $user)->get();
        $whg = $Users[0]["name"];
        $semester = $Users[0]["semester"];

        //Calculate the total of hours done
        $time = 0;
        foreach ($SocialHours as $value){
            $time = $time + intval(substr($value["hours"],0,2)) * 60;
            $time = $time + intval(substr($value["hours"],3,2));
        }
        $minutes = fmod($time,60);
        $hours = intdiv($time, 60);
        $hours = $hours - $semester *6;
        // get the correct formatting of 00:00 and save it the variable $totalTime
        $minutesstr = "";
        $hoursstr ="";
        $totalTime="";
        if ($hours > 0){
            if ($minutes < 10 ){
                $minutesstr = "0".strval($minutes);
            }
            else {
                $minutesstr = strval($minutes);
            }

            if ($hours < 10 ){
                $hoursstr = "0".strval($hours);
            }
            else{
                $hoursstr = $hours;
            }
            $totalTime = $hoursstr . ":" . $minutesstr;
        }
        if ($hours < 0 ){
            if ($minutes != 0){
                $minutes = 60 - $minutes;
                $hours = $hours +1;
            }
            if ($minutes < 10 ){
                $minutesstr = "0".strval($minutes);
            }
            else {
                $minutesstr = strval($minutes);
            }

            if ($hours < 10 ){
                $hoursstr = "0".strval(-$hours);
            }
            else{
                $hoursstr = -$hours;
            }
            $totalTime = "-". $hoursstr . ":" . $minutesstr;
        }

        return view ('overview',['totalTime' => $totalTime, 'user' => $user, 'array' => $SocialHours, 'whg' => $whg]);
    }
    public function Leaderboard(){
        $SocialHours =  SocialHour::query()->orderBy('user')->get();
        $user = $SocialHours[0]["user"];
        $time = 0;
        $array = array();
        foreach ($SocialHours as $value){
            if ($value["user"] == $user){
                $time = $time + intval(substr($value["hours"],0,2)) * 60;
                $time = $time + intval(substr($value["hours"],3,2));
            }
            else {
                $minutes = fmod($time,60);
                $hours = intdiv($time, 60);
                // get the correct formatting of 00:00 and save it the variable $totalTime
                $minutesstr = "";
                $hoursstr ="";
                $totalTime="";
                if ($hours > 0){
                    if ($minutes < 10 ){
                        $minutesstr = "0".strval($minutes);
                    }
                    else {
                        $minutesstr = strval($minutes);
                    }

                    if ($hours < 10 ){
                        $hoursstr = "0".strval($hours);
                    }
                    else{
                        $hoursstr = $hours;
                    }
                    $totalTime = $hoursstr . ":" . $minutesstr;
                }
                if ($hours < 0 ){
                    if ($minutes != 0){
                        $minutes = 60 - $minutes;
                        $hours = $hours +1;
                    }
                    if ($minutes < 10 ){
                        $minutesstr = "0".strval($minutes);
                    }
                    else {
                        $minutesstr = strval($minutes);
                    }

                    if ($hours < 10 ){
                        $hoursstr = "0".strval(-$hours);
                    }
                    else{
                        $hoursstr = -$hours;
                    }
                    $totalTime = "-". $hoursstr . ":" . $minutesstr;
                }
                $arr_tmp = array ($user => array($totalTime, $time));
                $array = $array + $arr_tmp;
                $user = $value["user"];
                $time = 0;
                $time = $time + intval(substr($value["hours"],0,2)) * 60;
                $time = $time + intval(substr($value["hours"],3,2));
            }
        }

        // to insert the last element / user to the array
        $minutes = fmod($time,60);
        $hours = intdiv($time, 60);
        // get the correct formatting of 00:00 and save it the variable $totalTime
        $minutesstr = "";
        $hoursstr ="";
        $totalTime="";
        if ($hours > 0){
            if ($minutes < 10 ){
                $minutesstr = "0".strval($minutes);
            }
            else {
                $minutesstr = strval($minutes);
            }

            if ($hours < 10 ){
                $hoursstr = "0".strval($hours);
            }
            else{
                $hoursstr = $hours;
            }
            $totalTime = $hoursstr . ":" . $minutesstr;
        }
        if ($hours < 0 ){
            if ($minutes != 0){
                $minutes = 60 - $minutes;
                $hours = $hours +1;
            }
            if ($minutes < 10 ){
                $minutesstr = "0".strval($minutes);
            }
            else {
                $minutesstr = strval($minutes);
            }

            if ($hours < 10 ){
                $hoursstr = "0".strval(-$hours);
            }
            else{
                $hoursstr = -$hours;
            }
            $totalTime = "-". $hoursstr . ":" . $minutesstr;
        }
        $arr_tmp = array ($user => array($totalTime, $time));
        $array = $array + $arr_tmp;

        //sort the array according to the time "[1]" ( "user" => array ( [0] => time_str, [1] => time_in_minutes_int ) )
        $keys = array_column($array, 1);
        array_multisort($keys, SORT_DESC, $array);

        return view ('leaderboard',['array'=>$array]);
    }

    public function LeaderboardActive(){

        $Users = Users::query()->where('active', "=", 1)->get();

        $array = array();
        foreach ($Users as $value){
            $time = 0;
            $time = $time + intval(substr($value["total_hours"],0,2)) * 60;
            $time = $time + intval(substr($value["total_hours"],3,2));
            $time = $time - $value['semester'] * 60 * 6;

            $minutes = fmod($time,60);
            $hours = intdiv($time, 60);

            // get the correct formatting of 00:00 and save it the variable $totalTime
            $minutesstr = "";
            $hoursstr ="";
            $totalTime="";
            if ($hours >= 0){
                if ($minutes < 10 ){
                    $minutesstr = "0".strval($minutes);
                }
                else {
                    $minutesstr = strval($minutes);
                }

                if ($hours < 10 ){
                    $hoursstr = "0".strval($hours);
                }
                else{
                    $hoursstr = $hours;
                }
                $totalTime = $hoursstr . ":" . $minutesstr;
            }
            if ($hours < 0 ){
                if ($minutes > -10 ){
                    $minutesstr = "0".strval(-$minutes);
                }
                else {
                    $minutesstr = strval(-$minutes);
                }

                if ($hours > -10 ){
                    $hoursstr = "0".strval(-$hours);
                }
                else{
                    $hoursstr = -$hours;
                }
                $totalTime = "-". $hoursstr . ":" . $minutesstr;
            }
            $arr_tmp = array ($value['username'] => array($totalTime, $time));
            $array = $array + $arr_tmp;
            $time = 0;
            $time = $time + intval(substr($value["total_hours"],0,2)) * 60;
            $time = $time + intval(substr($value["total_hours"],3,2));
        }
        //sort the array according to the time "[1]" ( "user" => array ( [0] => time_str, [1] => time_in_minutes_int ) )
        $keys = array_column($array, 1);
        array_multisort($keys, SORT_DESC, $array);

        return view ('leaderboard',['array'=>$array]);
    }
}

