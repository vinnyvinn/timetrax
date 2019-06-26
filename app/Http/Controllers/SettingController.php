<?php

namespace App\Http\Controllers;

use App\Overtime;
use App\OvertimeSlab;
use App\Role;
use App\Setting;
use App\Http\Requests;
use Handlers\MiscOperations;
use App\Rate;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\LeaveType;
use App\importRepo\Leaves;
class SettingController extends Controller
{

    public function leavePage()
    {
        return view('settings.leave.index')->withConfigs(Setting::all())->withSlabs(Rate::all());
    }
    public function leavImport(){
        $leaves=LeaveType::get();
        return view('settings.leave.import',['leaves'=>$leaves]);
    }
    public function leaveHR(){
        $leaves= new Leaves();
        if($leaves->handle()){
            return response()->json(["status"=>'success']);
        }else{
            return respone()->json(["status"=>'error']);
        }
    }
    public function overtimePage()
    {

        return view('settings.overtime.index')->withConfigs(Overtime::with('slabs')->get())->withSetting(Setting::all());
    }

    public function miscPage()
    {

        return view('settings.misc.index')->withConfigs(Setting::all());
    }

    public function retrieveConfigs()
    {
        return view('settings.settings')->with('configs', Setting::all())->withSlabs(Rate::all());
    }

    public function overtime()
    {
        $settings = Setting::where('setting_key', 'overtime')->get()
            ->each(function ($value) {
                $value->options = ['Enabled', 'Disabled'];
            });

        return view('settings.select')->withSetting($settings->first());
    }

    public function saveOvertime(Request $request)
    {
        $this->validate($request, [
            'overtime' => 'required|in:enabled,disabled'
        ]);
        Setting::where('setting_key', 'overtime')->update(['setting_value' => $request->overtime]);
        
        cacheSettings();

        flash('Overtime setting successfully changed');
        return redirect('settings');
    }

    public function overtimeStandardType()
    {
        $settings = Setting::where('setting_key', 'standard_type')->get()
            ->each(function ($value) {
                $value->options = ['Rate', 'Slab'];
            });

        return view('settings.select')->withSetting($settings->first());
    }

    public function saveOvertimeStandardType(Request $request)
    {
        $this->validate($request, [
            'standard_type' => 'required|in:rate,slab'
        ]);
        $setting = Setting::where('setting_key', 'overtime')->get()->first()->setting_value;
        if($setting == "" || $setting == "disabled") {
            flash('Overtime must be enabled first', 'error');
            return redirect()->back();
        }
        Overtime::where('name', 'like', '%standard%')->update(['type' => ucfirst($request->standard_type)]);
        Setting::where('setting_key', 'standard_type')->update(['setting_value' => $request->standard_type]);
        
        cacheSettings();

        flash('You successfully changed overtime standard type setting');
        return redirect('settings/overtime-settings');
    }

    public function overtimeSpecialType()
    {
        $settings = Setting::where('setting_key', 'special_type')->get()
            ->each(function ($value) {
                $value->options = ['Rate', 'Slab'];
            });

        return view('settings.select')->withSetting($settings->first());
    }

    public function saveOvertimeSpecialType(Request $request)
    {
        $this->validate($request, [
            'special_type' => 'required|in:rate,slab'
        ]);
        $setting = Setting::where('setting_key', 'overtime')->get()->first()->setting_value;
        if($setting == "" || $setting == "disabled") {
            flash('Overtime must be enabled first', 'error');
            return redirect()->back();
        }

        Overtime::where('name', 'like', '%special%')->update(['type' => ucfirst($request->special_type)]);
        Setting::where('setting_key', 'special_type')->update(['setting_value' => $request->special_type]);
        
        cacheSettings();

        flash('You successfully changed overtime special type setting');
        return redirect('settings/overtime-settings');
    }

    public function overtimeStandardRate()
    {
        $settings = Setting::where('setting_key', 'standard_rate')->get()
            ->each(function ($value) {
                $value->limits = [0, 10, 0.1];
            });

        return view('settings.slider')->withSetting($settings->first());
    }

    public function saveOvertimeStandardRate(Request $request)
    {
        $this->validate($request, [
            'standard_rate' => 'required|numeric'
        ]);
        $current = Setting::where('setting_key', 'standard_type')->orWhere('setting_key', 'overtime')->get()
            ->keyBy('setting_key')
            ->map(function ($value) {
                return $value->setting_value;
            });
        if ($current['overtime'] == '' || $current['overtime'] == 'disabled') {
            flash('Enable overtime first before changing this setting', 'error');
            return redirect()->back();
        } elseif ($current['standard_type'] == '' || $current['standard_type'] == 'slab') {
            flash('Overtime standard type must be set to rate first', 'error');
            return redirect()->back();
        }

        Overtime::where('name', 'like', '%standard%')->update(['rate' => $request->standard_rate]);
        Setting::where('setting_key', 'standard_rate')->update(['setting_value' => $request->standard_rate]);
        
        cacheSettings();

        flash('You successfully changed overtime standard rate setting');
        return redirect('settings/overtime-settings');
    }

    public function overtimeStandardSlab()
    {

        return view('settings.slabs')
            ->withSlabs(Overtime::where('name', 'like', '%standard%')->get()->first()->slabs)
            ->withTitle("Overtime Standard slabs");
    }

    public function saveOvertimeStandardSlab(Request $request)
    {
        $setting = Setting::where('setting_key', 'overtime')->get()->first()->setting_value;
        if($setting == "" || $setting == "disabled") {
            flash('Overtime must be enabled first', 'error');
            return redirect()->back();
        }
        if(Overtime::where('name', 'like', '%standard%')->first()->type == 'Rate') {
            flash('Standard type overtime must be set to slab first', 'error');
            return redirect()->back();
        }
        $data = array();
        Overtime::with('slabs')->where('name', 'like', '%standard%')->get()->first()->slabs()->delete();
        for ($i = 0; $i < count($request['ending_']); $i++) {
            if($request['beginning_'][$i] == '' || $request['ending_'][$i] == '' || $request['rate_'][$i] == '') {
                flash("None of the fields can be left blank, try again, $i slabs have been saved", 'error');
                return redirect()->back();
            }
            if($request['beginning_'][$i] > $request['ending_'][$i] || $request['beginning_'][$i] == $request['ending_'][$i]) {
                flash("One of the slabs was incorrectly formed, try again, $i slabs have been saved", 'error');
                return redirect()->back();
            }
            $data = [
                'ending' => $request['ending_'][$i], 'beginning' => $request['beginning_'][$i], 'rate' => $request['rate_'][$i]
            ];
            Overtime::where('name', 'like', '%standard%')->first()->slabs()->create($data);
        }

        cacheSettings();
        
        flash('You updated the standard slabs');
        return redirect('settings/overtime-settings');
    }

    public function overtimeSpecialRate()
    {
        $settings = Setting::where('setting_key', 'special_rate')->get()
            ->each(function ($value) {
                $value->limits = [0, 10, 0.1];
            });

        return view('settings.slider')->withSetting($settings->first());
    }

    public function saveOvertimeSpecialRate(Request $request)
    {
        $this->validate($request, [
            'special_rate' => 'required|numeric'
        ]);
        $current = Setting::where('setting_key', 'special_type')->orWhere('setting_key', 'overtime')->get()
            ->keyBy('setting_key')
            ->map(function ($value) {
                return $value->setting_value;
            });
        if ($current['overtime'] == '' || $current['overtime'] == 'disabled') {
            flash('Enable overtime first before changing this setting', 'error');
            return redirect()->back();
        } elseif ($current['special_type'] == '' || $current['special_type'] == 'slab') {
            flash('Overtime special type must be set to rate first', 'error');
            return redirect()->back();
        }

        Overtime::where('name', 'like', '%special%')->update(['rate' => $request->special_rate]);
        Setting::where('setting_key', 'special_rate')->update(['setting_value' => $request->special_rate]);
        
        cacheSettings();

        flash('You successfully changed the special rate setting');
        return redirect('settings/overtime-settings');
    }

    public function overtimeSpecialSlab()
    {

        return view('settings.slabs')
            ->withSlabs(Overtime::where('name', 'like', '%special%')->get()->first()->slabs)
            ->withTitle("Overtime Special slabs");;
    }

    public function saveOvertimeSpecialSlab(Request $request)
    {
        $setting = Setting::where('setting_key', 'overtime')->get()->first()->setting_value;
        if($setting == "" || $setting == "disabled") {
            flash('Overtime must be enabled first', 'error');
            return redirect()->back();
        }
        if(Overtime::where('name', 'like', '%special%')->first()->type == 'Rate') {
            flash('Special type overtime must be set to slab first', 'error');
            return redirect()->back();
        }

        $data = array();
        Overtime::with('slabs')->where('name', 'like', '%special%')->get()->first()->slabs()->delete();

        for ($i = 0; $i < count($request['ending_']); $i++) {
            if($request['ending_'][$i] == '' || $request['beginning_'][$i] == '' || $request['rate_'][$i] == '') {
                flash("None of the fields can be left blank, try again, $i slabs have been saved", 'error');
                return redirect()->back();
            }
            if($request['beginning_'][$i] > $request['ending_'][$i] || $request['beginning_'][$i] == $request['ending_'][$i]) {
                flash("One of the slabs was incorrectly formed, $i slabs have been saved, try again", 'error');
                return redirect()->back();
            }
            $data = [
                'ending' => $request['ending_'][$i], 'beginning' => $request['beginning_'][$i], 'rate' => $request['rate_'][$i]
            ];
            Overtime::where('name', 'like', '%special%')->first()->slabs()->create($data);
        }
        
        cacheSettings();

        flash('You updated the special slabs');
        return redirect('settings/overtime-settings');
    }

    public function leave()
    {
        $settings = Setting::where('setting_key', 'leave')->get()
            ->each(function ($value) {
                $value->options = ['Enabled', 'Disabled'];
            });

        return view('settings.select')->withSetting($settings->first());
    }

    public function saveLeave(Request $request)
    {
        $this->validate($request, [
            'leave' => 'required|in:enabled,disabled'
        ]);
        Setting::where('setting_key', 'leave')->update(['setting_value' => $request->leave]);
        if(Cache::has(Setting::CACHE_KEY)) {
            Cache::forget(Setting::CACHE_KEY);
        }
        Cache::rememberForever(Setting::CACHE_KEY, function () {
            return Setting::all(['setting_key', 'setting_value']);
        });
        
        cacheSettings();

        flash('You have successfully changed leave setting');
        return redirect('settings');
    }

    public function leaveMinimumDays()
    {
        $settings = Setting::where('setting_key', 'leave_min_working_days')->get()
            ->each(function ($value) {
                $value->limits = [0, 30, 1];
            });

        return view('settings.slider')->withSetting($settings->first());
    }

    public function saveLeaveMinimumDays(Request $request)
    {
        $this->validate($request, [
            'leave_min_working_days' => 'required|integer'
        ]);

        $current = Setting::where('setting_key', 'leave')->get();
        $current = $current->first();
        if ($current->setting_value == 'disabled' || $current->setting_value == '') {
            flash('Enable leave first before changing this option', 'error');
            return redirect()->back();
        } elseif (intval($request->leave_min_working_days) > 30 || intval($request->leave_min_working_days) < 0) {
            flash('Number of days specified does not fall in the range expected', 'error');
            return redirect()->back();
        } else {
            Setting::where('setting_key', 'leave_min_working_days')->update(['setting_value' => $request->leave_min_working_days]);
            
            cacheSettings();

            flash('You have successfully changed minimum working days setting');
            return redirect('settings/leave-settings');
        }
    }

    public function leaveRate()
    {
        $settings = Setting::where('setting_key', 'leave_rate')->get()
            ->each(function ($value) {
                $value->limits = [0, 10, 0.1];
            });

        return view('settings.slider')->withSetting($settings->first());
    }

    public function saveLeaveRate(Request $request)
    {
        $this->validate($request, [
            'leave_rate' => 'required|numeric'
        ]);

        $current = Setting::where('setting_key', 'leave')->get();
        $current = $current->first();
        if ($current->setting_value == 'disabled' || $current->setting_value == '') {
            flash('Enable leave first before changing this option', 'error');
            return redirect()->back();
        } elseif (intval($request->leave_rate) > 10 || intval($request->leave_rate) < 0) {
            flash('Number of days specified does not fall in the range expected', 'error');
            return redirect()->back();
        } else {
            Setting::where('setting_key', 'leave_rate')->update(['setting_value' => $request->leave_rate]);
            
            cacheSettings();

            flash("Leave rate successful set");
            return redirect('settings/leave-settings');
        }
    }

    public function leaveAccrual()
    {
        $settings = Setting::where('setting_key', 'leave_accrual')->get()
            ->each(function ($value) {
                $value->options = ['Enabled', 'Disabled'];
            });

        return view('settings.select')->withSetting($settings->first());
    }

    public function saveLeaveAccrual(Request $request)
    {
        $this->validate($request, [
            'leave_accrual' => 'required|in:enabled,disabled'
        ]);

        $current = Setting::where('setting_key', 'leave')->get();
        $current = $current->first();
        if ($current->setting_value == 'disabled' || $current->setting_value == '') {
            flash('Enable leave first before changing this option', 'error');
            return redirect()->back();
        } else {
            Setting::where('setting_key', 'leave_accrual')->update(['setting_value' => $request->leave_accrual]);
            
            cacheSettings();

            flash('Leave accrual setting successfull set');
            return redirect('settings/leave-settings');
        }
    }

    public function multipleCheckins()
    {
        $settings = Setting::where('setting_key', 'multiple_checkins')->get()
            ->each(function ($value) {
                $value->options = ['Enabled', 'Disabled'];
            });

        return view('settings.select')->withSetting($settings->first());
    }

    public function saveMultipleCheckins(Request $request)
    {
        $this->validate($request, [
            'multiple_checkins' => 'required|in:enabled,disabled'
        ]);
        Setting::where('setting_key', 'multiple_checkins')->update(['setting_value' => $request->multiple_checkins]);
        
        cacheSettings();

        flash('You have successfully changed multiple checkins settings');
        return redirect('settings');
    }

    public function undertime(Request $request)
    {
        $settings = Setting::where('setting_key', 'undertime')->get()
            ->each(function ($value) {
                $value->options = ['Enabled', 'Disabled'];
            });
        return view('settings.select')->withSetting($settings->first());
    }

    public function saveUndertime(Request $request)
    {
        $this->validate($request, [
            'undertime' => 'required|in:enabled,disabled'
        ]);
        Setting::where('setting_key', 'undertime')->update(['setting_value' => $request->undertime]);
        
        cacheSettings();

        flash('You have successfully changed undertime setting');
        return redirect('settings');
    }

    public function changePrefix()
    {
         $setting = Setting::where('setting_key', 'payroll_number_prefix')->first();


         return view('settings.payroll-prefix')->withSetting($setting);

    }
    public function updatePrefix(Request $request)
    {
         $setting = Setting::where('setting_key', 'payroll_number_prefix')->first();

         $setting->setting_value = $request->payroll_number_prefix;
         $setting->save();

         cacheSettings();
         flash('You have successfully updated payroll number prefix setting');
         return redirect('settings');

    }

}
