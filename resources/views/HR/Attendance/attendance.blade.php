@extends('layouts.master')

@section('content')
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Attendance</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="text-slate-700 dark:text-zink-100">Employee Attendance</li>
            </ul>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-5">
            <div class="lg:col-span-4 xl:col-span-3">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('hr/attendance/page') }}" class="mb-5">
                            <label for="employee_id" class="inline-block mb-2 text-base font-medium">Select Employee</label>
                            
                            <select class="form-input border-slate-200 dark:border-zink-500
                                dark:text-zink-100 dark:bg-zink-700
                                focus:outline-none focus:border-custom-500" name="employee_id" id="employee_id" onchange="this.form.submit()">
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->user_id }}" @selected(optional($selectedEmployee)->user_id === $employee->user_id)>
                                        {{ $employee->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>

                        <div class="text-center">
                            <div class="mx-auto rounded-full size-20 bg-slate-100 dark:bg-zink-600">
                                <img src="{{ !empty(optional($selectedEmployee)->avatar) ? URL::to('assets/images/'.$selectedEmployee->avatar) : URL::to('assets/images/user.png') }}" alt="" class="h-20 w-20 rounded-full object-cover">
                            </div>
                            <h6 class="mt-3 mb-1 text-16">{{ optional($selectedEmployee)->name ?? 'No Employee' }}</h6>
                            <p class="text-slate-500 dark:text-zink-200">{{ optional($selectedEmployee)->position ?? optional($selectedEmployee)->designation ?? 'N/A' }}</p>
                        </div>

                        <div class="mt-5 overflow-x-auto">
                            <table class="w-full mb-0">
                                <tbody>
                                    <tr>
                                        <td class="px-3.5 py-2.5 first:pl-0 border-y border-transparent text-slate-500 dark:text-zink-200">Employee ID</td>
                                        <td class="px-3.5 py-2.5 last:pr-0 border-y border-transparent font-semibold">{{ optional($selectedEmployee)->user_id ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-3.5 py-2.5 first:pl-0 border-y border-transparent text-slate-500 dark:text-zink-200">Department</td>
                                        <td class="px-3.5 py-2.5 last:pr-0 border-y border-transparent font-semibold">{{ optional($selectedEmployee)->department ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-3.5 py-2.5 first:pl-0 border-y border-transparent text-slate-500 dark:text-zink-200">Join Date</td>
                                        <td class="px-3.5 py-2.5 last:pr-0 border-y border-transparent font-semibold">{{ optional($selectedEmployee)->join_date ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-3.5 py-2.5 first:pl-0 border-y border-transparent text-slate-500 dark:text-zink-200">Total Hours</td>
                                        <td class="px-3.5 py-2.5 last:pr-0 border-y border-transparent font-semibold">{{ number_format(($attendanceSummary['work_minutes'] ?? 0) / 60, 2) }} Hrs</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 xl:col-span-9">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-5">
                    <div class="card">
                        <div class="flex items-center gap-4 card-body">
                            <div class="flex items-center justify-center rounded-md size-12 text-green-500 bg-green-100 text-15 dark:bg-green-500/20 shrink-0"><i data-lucide="check"></i></div>
                            <div class="grow">
                                <h5 class="mb-1 text-16"><span class="counter-value" data-target="{{ $attendanceSummary['present'] ?? 0 }}">0</span></h5>
                                <p class="text-slate-500 dark:text-zink-200">Present Days</p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="flex items-center gap-4 card-body">
                            <div class="flex items-center justify-center text-red-500 bg-red-100 rounded-md size-12 text-15 dark:bg-red-500/20 shrink-0"><i data-lucide="x-octagon"></i></div>
                            <div class="grow">
                                <h5 class="mb-1 text-16"><span class="counter-value" data-target="{{ $attendanceSummary['absent'] ?? 0 }}">0</span></h5>
                                <p class="text-slate-500 dark:text-zink-200">Absent Days</p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="flex items-center gap-4 card-body">
                            <div class="flex items-center justify-center text-yellow-500 bg-yellow-100 rounded-md size-12 text-15 dark:bg-yellow-500/20 shrink-0"><i data-lucide="clock"></i></div>
                            <div class="grow">
                                <h5 class="mb-1 text-16"><span class="counter-value" data-target="{{ (int) (($attendanceSummary['overtime_minutes'] ?? 0) / 60) }}">0</span></h5>
                                <p class="text-slate-500 dark:text-zink-200">Overtime Hours</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($selectedEmployee)
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-4 text-15">Mark Attendance</h6>
                        <form method="POST" action="{{ route('hr/attendance/mark') }}" class="grid grid-cols-1 gap-4 md:grid-cols-6">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $selectedEmployee->id }}">
                            <div>
                                <label class="inline-block mb-2 text-base font-medium">Date</label>
                                <input type="date" name="attendance_date" value="{{ now()->toDateString() }}" class="form-input border-slate-200 dark:border-zink-500
                                    dark:text-zink-100 dark:bg-zink-700">
                            </div>
                            <div>
                                <label class="inline-block mb-2 text-base font-medium">Status</label>
                                <select name="status"
                                    class="form-input border-slate-200 dark:border-zink-500
                                    dark:text-zink-100 dark:bg-zink-700">
                                    <option value="present">Present</option>
                                    <option value="absent">Absent</option>
                                    <option value="leave">Leave</option>
                                </select>
                            </div>
                            <div>
                                <label class="inline-block mb-2 text-base font-medium">Check In</label>
                                <input type="time" name="check_in" value="08:00" class="form-input border-slate-200 dark:border-zink-500
                                    dark:text-zink-100 dark:bg-zink-700">
                            </div>
                            <div>
                                <label class="inline-block mb-2 text-base font-medium">Check Out</label>
                                <input type="time" name="check_out" value="17:00" class="form-input border-slate-200 dark:border-zink-500
                                    dark:text-zink-100 dark:bg-zink-700">
                            </div>
                            <div>
                                <label class="inline-block mb-2 text-base font-medium">Break</label>
                                <input type="number" name="meal_break_minutes" value="60" min="0" class="form-input border-slate-200 dark:border-zink-500
                                    dark:text-zink-100 dark:bg-zink-700">
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="w-full text-white btn bg-custom-500 border-custom-500 hover:bg-custom-600">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-4 text-15">Recent Attendance</h6>
                        <div class="overflow-x-auto">
                            <table class="w-full whitespace-nowrap">
                                <thead class="ltr:text-left rtl:text-right bg-slate-100 text-slate-500 dark:text-zink-200 dark:bg-zink-600">
                                    <tr>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Date</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Status</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Check In</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Check Out</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Work Hours</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Overtime</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($attendanceRecords as $record)
                                    <tr>
                                        <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">{{ $record->attendance_date->format('d M, Y') }}</td>
                                        <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">{{ ucfirst($record->status) }}</td>
                                        <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">{{ $record->check_in ?? '-' }}</td>
                                        <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">{{ $record->check_out ?? '-' }}</td>
                                        <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">{{ number_format($record->work_minutes / 60, 2) }} Hrs</td>
                                        <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">{{ number_format($record->overtime_minutes / 60, 2) }} Hrs</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-3.5 py-6 text-center border-y border-slate-200 dark:border-zink-500 text-slate-500 dark:text-zink-200">No attendance records yet.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
