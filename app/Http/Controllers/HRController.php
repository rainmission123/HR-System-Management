<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Session;
use Validator;
use App\Models\User;
use App\Models\Leave;
use App\Models\Holiday;
use App\Models\Department;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\LeaveInformation;
use Illuminate\Validation\Rule;

class HRController extends Controller
{
    /** Employee list */
    public function employeeList()
    {
        $employeeList = User::all();

        $latestUser = User::whereNotNull('user_id')
            ->orderBy('id', 'DESC')
            ->first();

        if ($latestUser && preg_match('/KH-(\d+)/', $latestUser->user_id, $matches)) {
            $nextNumber = (int) $matches[1] + 1;
        } else {
            $nextNumber = 1;
        }

        $employeeId = 'KH-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $roleName   = DB::table('role_type_users')->get();
        $position   = DB::table('position_types')->get();
        $department = DB::table('departments')->get();
        $statusUser = DB::table('user_types')->get();

        return view('HR.employee', compact(
            'employeeList',
            'employeeId',
            'roleName',
            'position',
            'department',
            'statusUser'
        ));
    }

    /** save record employee */
    public function employeeSaveRecord(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
        ]);

        try {
            $latestUser = User::whereNotNull('user_id')->orderBy('id', 'DESC')->first();

            if ($latestUser && preg_match('/KH-(\d+)/', $latestUser->user_id, $matches)) {
                $nextNumber = (int) $matches[1] + 1;
            } else {
                $nextNumber = 1;
            }

            $employeeId = 'KH-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $photo = null;

            if ($request->hasFile('photo')) {
                $photo = time() . '_' . preg_replace('/\s+/', '_', strtolower($request->name)) . '.' . $request->photo->extension();
                $request->photo->move(public_path('assets/images/user'), $photo);
            }

            $register = new User();
            $register->user_id      = $employeeId;
            $register->name         = $request->name;
            $register->email        = $request->email;
            $register->position     = $request->position ?? 'N/A';
            $register->department   = $request->department ?? 'N/A';
            $register->role_name    = $request->role_name ?? 'Employee';
            $register->status       = $request->status ?? 'Active';
            $register->phone_number = $request->phone_number ?? null;
            $register->location     = $request->location ?? null;
            $register->join_date    = $request->join_date ?? now();
            $register->experience   = $request->experience ?? 0;
            $register->designation  = $request->designation ?? 'N/A';
            $register->avatar       = $photo;
            $register->password     = Hash::make('Hello@123');
            $register->save();

            return redirect()->back()->with('success', 'Employee added successfully.');

        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /** Update Record Employee */
    public function employeeUpdateRecord(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($request->id)],
        ]);

        try {
            $user = User::find($request->id);

            // Handle photo upload
            if ($request->hasFile('photo')) {
                $photo = $request->name . '-' . time() . '.' . $request->photo->extension();
                $request->photo->move(public_path('assets/images/user'), $photo);

                // Delete old photo if exists
                if (!empty($user->avatar) && file_exists(public_path('assets/images/user/' . $user->avatar))) {
                    unlink(public_path('assets/images/user/' . $user->avatar));
                }

                // Update user avatar with new photo
                $user->avatar = $photo;
            }

            // Update other fields
            $user->name         = $request->name;
            $user->email        = $request->email;
            $user->position     = $request->position;
            $user->department   = $request->department;
            $user->role_name    = $request->role_name;
            $user->status       = $request->status;
            $user->phone_number = $request->phone_number;
            $user->location     = $request->location;
            $user->join_date    = $request->join_date;
            $user->experience   = $request->experience;
            $user->designation  = $request->designation;

            $user->save();

            flash()->success('Update record successfully :)');
            return redirect()->back();

        } catch (\Exception $e) {
            \Log::info($e);
            DB::rollback();
            flash()->error('Update record fail :)');
            return redirect()->back();
        }
    }

    /** Delete Record Employee */
    public function employeeDeleteRecord(Request $request)
    {
        try {
            $deleteRecord = User::findOrFail($request->id_delete);
            $deleteRecord->delete();
            $photoPath = public_path('assets/images/user/'.$request->del_photo);
            if (!empty($request->del_photo) && file_exists($photoPath)) {
                unlink($photoPath);
            }

            flash()->success('Delete record successfully :)');
            return redirect()->back();
        } catch(\Exception $e) {
            \Log::info($e);
            DB::rollback();
            flash()->error('Delete record fail :)');
            return redirect()->back();
        }
    }

    /** holiday Page */
    public function holidayPage()
    {
        $holidayList = Holiday::all();
        return view('HR.holidays',compact('holidayList'));
    }

    /** save record holiday */
    public function holidaySaveRecord(Request $request)
    {
        $request->validate([
            'holiday_type' => 'required|string',
            'holiday_name' => 'required|string',
            'holiday_date' => 'required|string',
        ]);
    
        try {
            // Use updateOrCreate to handle both creation and update
            $holiday = Holiday::updateOrCreate(
                ['id' => $request->idUpdate],
                [
                    'holiday_type' => $request->holiday_type,
                    'holiday_name' => $request->holiday_name,
                    'holiday_date' => $request->holiday_date,
                ]
            );
    
            flash()->success('Holiday created or updated successfully :)');
            return redirect()->back();
        } catch (\Exception $e) {
            \Log::error($e); // Log the error
            flash()->error('Failed to add holiday :)');
            return redirect()->back();
        }
    }

    /** delete record */
    public function holidayDeleteRecord(Request $request) 
    {
        try {
            // Find the holiday record or fail if not found
            $holiday = Holiday::findOrFail($request->id_delete);
            $holiday->delete();

            flash()->success('Holiday deleted successfully :)');
            return redirect()->back();
        } catch (\Exception $e) {
            \Log::error($e); // Log the error
            flash()->error('Failed to delete holiday :)');
            return redirect()->back();
        }
    }

    /** get information leave */
    public function getInformationLeave(Request $request)
    {
        try {

            $numberOfDay = $request->number_of_day;
            $leaveType   = $request->leave_type;
            
            $leaveDay = LeaveInformation::where('leave_type', $leaveType)->first();
            
            if ($leaveDay) {
                $days = $leaveDay->leave_days - ($numberOfDay ?? 0);
            } else {
                $days = 0; // Handle case if leave type doesn't exist
            }
            
            $data = [
                'response_code' => 200,
                'status'        => 'success',
                'message'       => 'Get success',
                'leave_type'    => $days,
                'number_of_day' => $numberOfDay,
            ];
            
            return response()->json($data);

        } catch (\Exception $e) {
            // Log the exception and return an appropriate response
            \Log::error($e->getMessage());
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    /** leave Employee */
    public function leaveEmployee()
    {
        $annualLeave = LeaveInformation::where('leave_type','Annual Leave')->select('leave_days')->first();
       
        $leave = Leave::where('staff_id', Session::get('user_id'))->get();
        // $leaves = Leave::where('staff_id', Session::get('user_id'))->whereIn('leave_type')->get();
        return view('HR.LeavesManage.leave-employee',compact('leave'));
    }

    /** create Leave Employee */
    public function createLeaveEmployee()
    {
        $leaveInformation = LeaveInformation::all();
        return view('HR.LeavesManage.create-leave-employee',compact('leaveInformation'));
    }

    /** save record leave */
    public function saveRecordLeave(Request $request)
    {
        $request->validate([
            'leave_type' => 'required|string',
            'date_from'  => 'required',
            'date_to'    => 'required',
            'reason'     => 'required',
        ]);

        try {
           
            $save  = new Leave;
            $save->staff_id         = Session::get('user_id');
            $save->employee_name    = Session::get('name');
            $save->leave_type       = $request->leave_type;
            $save->remaining_leave  = $request->remaining_leave;
            $save->date_from        = $request->date_from;
            $save->date_to          = $request->date_to;
            $save->number_of_day    = $request->number_of_day;
            $save->leave_date       = json_encode($request->leave_date);
            $save->leave_day        = json_encode($request->select_leave_day);
            $save->status           = 'Pending';
            $save->reason           = $request->reason;
            $save->save();
    
            flash()->success('Apply Leave successfully :)');
            return redirect()->back();
        } catch (\Exception $e) {
            \Log::error($e); // Log the error
            flash()->error('Failed Apply Leave :)');
            return redirect()->back();
        }
    }

    /** view detail leave employee */
    public function viewDetailLeave($staff_id)
    {
        $leaveInformation = LeaveInformation::all();
        $leaveDetail = Leave::where('staff_id', $staff_id)->latest()->firstOrFail();
        $leaveDate   = json_decode($leaveDetail->leave_date, true); // Decode JSON to array
        $leaveDay    = json_decode($leaveDetail->leave_day, true); // Decode JSON to array

        return view('HR.LeavesManage.view-detail-leave',compact('leaveInformation','leaveDetail','leaveDate','leaveDay'));
    }

    /** leave HR */
    public function leaveHR()
    {
        $leaves = Leave::latest()->get();
        $today = now()->startOfDay();
        $todayLeaves = $leaves->filter(function ($leave) use ($today) {
            if ($leave->status !== 'Approved') {
                return false;
            }

            try {
                $from = $leave->date_from ? \Carbon\Carbon::parse($leave->date_from)->startOfDay() : null;
                $to = $leave->date_to ? \Carbon\Carbon::parse($leave->date_to)->startOfDay() : null;

                return $from && $to && $from->lte($today) && $to->gte($today);
            } catch (\Exception $e) {
                return false;
            }
        })->count();
        $pendingLeaves = Leave::where('status', 'Pending')->count();
        $approvedLeaves = Leave::where('status', 'Approved')->count();
        $declinedLeaves = Leave::where('status', 'Declined')->count();

        return view('HR.LeavesManage.leave-hr', compact(
            'leaves',
            'todayLeaves',
            'pendingLeaves',
            'approvedLeaves',
            'declinedLeaves'
        ));
    }

    /** attendance */
   public function attendance()
    {
        $employees = User::where('role_name', 'Employee')->get();
        $selectedEmployee = $employees->firstWhere('user_id', request('employee_id')) ?: $employees->first();
        $attendanceRecords = collect();
        $attendanceSummary = [
            'present' => 0,
            'absent' => 0,
            'leave' => 0,
            'work_minutes' => 0,
            'overtime_minutes' => 0,
        ];

        if ($selectedEmployee) {
            $attendanceRecords = Attendance::where('user_id', $selectedEmployee->id)
                ->latest('attendance_date')
                ->take(30)
                ->get();

            $attendanceSummary = [
                'present' => $attendanceRecords->where('status', 'present')->count(),
                'absent' => $attendanceRecords->where('status', 'absent')->count(),
                'leave' => $attendanceRecords->where('status', 'leave')->count(),
                'work_minutes' => $attendanceRecords->sum('work_minutes'),
                'overtime_minutes' => $attendanceRecords->sum('overtime_minutes'),
            ];
        }

        return view('HR.Attendance.attendance', compact(
            'employees',
            'selectedEmployee',
            'attendanceRecords',
            'attendanceSummary'
        ));
    }

    /** create Leave HR */
    public function createLeaveHR()
    {
        $users = User::all();
        $leaveInformation = LeaveInformation::all();
        return view('HR.LeavesManage.create-leave-hr',compact('users','leaveInformation'));
    }

    /** save leave record created by HR */
    public function saveRecordLeaveByHR(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:users,user_id',
            'leave_type' => 'required|string',
            'date_from'  => 'required',
            'date_to'    => 'required',
            'reason'     => 'required|string',
        ]);

        try {
            $user = User::where('user_id', $request->employee_id)->firstOrFail();

            Leave::create([
                'staff_id' => $user->user_id,
                'employee_name' => $user->name,
                'leave_type' => $request->leave_type,
                'remaining_leave' => $request->remaining_leave,
                'date_from' => $request->date_from,
                'date_to' => $request->date_to,
                'number_of_day' => $request->number_of_day,
                'leave_date' => json_encode($request->leave_date),
                'leave_day' => json_encode($request->select_leave_day),
                'status' => 'Approved',
                'approved_by' => Session::get('name') ?: optional(auth()->user())->name,
                'reason' => $request->reason,
            ]);

            flash()->success('Leave created successfully :)');
            return redirect()->route('hr/leave/hr/page');
        } catch (\Exception $e) {
            \Log::error($e);
            flash()->error('Failed to create leave :)');
            return redirect()->back()->withInput();
        }
    }

    /** approve or decline leave */
    public function updateLeaveStatus(Request $request)
    {
        $request->validate([
            'leave_id' => 'required|exists:leaves,id',
            'status' => 'required|in:Approved,Declined,Pending',
        ]);

        $leave = Leave::findOrFail($request->leave_id);
        $leave->status = $request->status;
        $leave->approved_by = $request->status === 'Pending'
            ? null
            : (Session::get('name') ?: optional(auth()->user())->name);
        $leave->save();

        flash()->success('Leave status updated successfully :)');
        return redirect()->back();
    }

    /** delete leave */
    public function deleteLeaveRecord(Request $request)
    {
        $request->validate([
            'leave_id' => 'required|exists:leaves,id',
        ]);

        Leave::findOrFail($request->leave_id)->delete();
        flash()->success('Leave deleted successfully :)');
        return redirect()->back();
    }

    /** attendance Main */
    public function attendanceMain()
    {
        $employees = User::where('role_name', 'Employee')->latest()->get();
        $month = now()->startOfMonth();
        $daysInMonth = $month->daysInMonth;
        $records = Attendance::whereBetween('attendance_date', [
            $month->toDateString(),
            $month->copy()->endOfMonth()->toDateString(),
        ])->get();

        $presentToday = Attendance::whereDate('attendance_date', now()->toDateString())
            ->where('status', 'present')
            ->count();
        $absentToday = Attendance::whereDate('attendance_date', now()->toDateString())
            ->where('status', 'absent')
            ->count();

        return view('HR.Attendance.attendance-main', [
            'employees' => $employees,
            'daysInMonth' => $daysInMonth,
            'month' => $month,
            'attendanceMatrix' => $records->keyBy(function ($record) {
                return $record->user_id.'-'.$record->attendance_date->format('Y-m-d');
            }),
            'totalEmployees' => $employees->count(),
            'presentToday' => $presentToday,
            'absentToday' => $absentToday,
            'workingDays' => now()->daysInMonth,
        ]);
    }

    /** mark attendance */
    public function markAttendance(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'attendance_date' => 'required|date',
            'status' => 'required|in:present,absent,leave',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'meal_break_minutes' => 'nullable|integer|min:0|max:240',
            'notes' => 'nullable|string|max:1000',
        ]);

        $workMinutes = 0;
        $overtimeMinutes = 0;
        $mealBreak = (int) ($request->meal_break_minutes ?? 60);
        $checkInTime = null;
        $checkOutTime = null;

        if ($request->status === 'present' && $request->check_in && $request->check_out) {
            $checkIn = \Carbon\Carbon::createFromFormat('H:i', $request->check_in);
            $checkOut = \Carbon\Carbon::createFromFormat('H:i', $request->check_out);
            $checkInTime = $request->check_in;
            $checkOutTime = $request->check_out;

            if ($checkOut->greaterThan($checkIn)) {
                $workMinutes = max(0, $checkIn->diffInMinutes($checkOut) - $mealBreak);
                $overtimeMinutes = max(0, $workMinutes - 480);
            }
        }

        Attendance::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'attendance_date' => $request->attendance_date,
            ],
            [
                'status' => $request->status,
                'check_in' => $checkInTime,
                'check_out' => $checkOutTime,
                'meal_break_minutes' => $mealBreak,
                'work_minutes' => $workMinutes,
                'overtime_minutes' => $overtimeMinutes,
                'notes' => $request->notes,
                'marked_by' => Session::get('name') ?: optional(auth()->user())->name,
            ]
        );

        flash()->success('Attendance updated successfully :)');
        return redirect()->back();
    }

    /** department */
    public function department()
    {
        $departmentList = Department::all();
        return view('HR.department',compact('departmentList'));
    }

    /** save record department */
    public function saveRecordDepartment(Request $request)
    {
        $request->validate([
            'department'      => 'required|string',
            'head_of'         => 'required|string',
            'phone_number'    => 'required|integer',
            'email'           => 'required|email',
            'total_employee'  => 'required|integer',
        ]);
    
        try {
            // Use updateOrCreate to handle both creation and update
            $department = Department::updateOrCreate(
                ['id' => $request->id_update],
                [
                    'department'     => $request->department,
                    'head_of'        => $request->head_of,
                    'phone_number'   => $request->phone_number,
                    'email'          => $request->email,
                    'total_employee' => $request->total_employee,
                ]
            );
    
            flash()->success('Department created or updated successfully :)');
            return redirect()->back();
        } catch (\Exception $e) {
            \Log::error($e);
            flash()->error('Failed to add or update department :)');
            return redirect()->back();
        }
    }

    /** delete record department */
    public function deleteRecordDepartment(Request $request)
    {
        try {
            // Find the department or fail if not found
            $department = Department::findOrFail($request->id_delete);
            $department->delete();
            
            flash()->success('Record deleted successfully :)');
            return redirect()->back();
        } catch (\Exception $e) {
            \Log::error($e); // Log the error
            flash()->error('Failed to delete record :)');
            return redirect()->back();
        }
    }

}
