@extends('layouts.master')

@section('content')
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Main Attendance</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="text-slate-700 dark:text-zink-100">{{ $month->format('F Y') }}</li>
            </ul>
        </div>

        <div class="grid grid-cols-1 gap-x-5 md:grid-cols-2 xl:grid-cols-4">
            <div class="card">
                <div class="flex items-center gap-4 card-body">
                    <div class="flex items-center justify-center rounded-md size-12 text-sky-500 bg-sky-100 text-15 dark:bg-sky-500/20 shrink-0"><i data-lucide="users-2"></i></div>
                    <div class="overflow-hidden grow">
                        <h5 class="mb-1 text-16"><span class="counter-value" data-target="{{ $totalEmployees }}">0</span></h5>
                        <p class="truncate text-slate-500 dark:text-zink-200">Total Employees</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="flex items-center gap-4 card-body">
                    <div class="flex items-center justify-center text-red-500 bg-red-100 rounded-md size-12 text-15 dark:bg-red-500/20 shrink-0"><i data-lucide="user-x-2"></i></div>
                    <div class="overflow-hidden grow">
                        <h5 class="mb-1 text-16"><span class="counter-value" data-target="{{ $absentToday }}">0</span></h5>
                        <p class="truncate text-slate-500 dark:text-zink-200">Absent Today</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="flex items-center gap-4 card-body">
                    <div class="flex items-center justify-center text-green-500 bg-green-100 rounded-md size-12 text-15 dark:bg-green-500/20 shrink-0"><i data-lucide="user-check-2"></i></div>
                    <div class="overflow-hidden grow">
                        <h5 class="mb-1 text-16"><span class="counter-value" data-target="{{ $presentToday }}">0</span></h5>
                        <p class="truncate text-slate-500 dark:text-zink-200">Present Today</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="flex items-center gap-4 card-body">
                    <div class="flex items-center justify-center rounded-md size-12 text-custom-500 bg-custom-100 text-15 dark:bg-custom-500/20 shrink-0"><i data-lucide="briefcase"></i></div>
                    <div class="overflow-hidden grow">
                        <h5 class="mb-1 text-16"><span class="counter-value" data-target="{{ $workingDays }}">0</span></h5>
                        <p class="truncate text-slate-500 dark:text-zink-200">Days This Month</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="flex flex-col gap-3 mb-5 md:flex-row md:items-center">
                    <div class="grow">
                        <h6 class="text-15">Monthly Attendance</h6>
                        <p class="text-slate-500 dark:text-zink-200">Click an employee name to mark daily attendance.</p>
                    </div>
                    <a href="{{ route('hr/attendance/page') }}" class="text-white btn bg-custom-500 border-custom-500 hover:bg-custom-600">Mark Attendance</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead class="ltr:text-left rtl:text-right bg-slate-100 text-slate-500 dark:text-zink-200 dark:bg-zink-600">
                            <tr class="*:px-3.5 *:py-2.5 *:font-semibold *:border-b *:border-slate-200 *:dark:border-zink-500">
                                <th>Employee Name</th>
                                @for($day = 1; $day <= $daysInMonth; $day++)
                                    <th class="text-center">{{ str_pad($day, 2, '0', STR_PAD_LEFT) }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employees as $employee)
                            <tr class="*:px-3.5 *:py-2.5 *:border-y *:border-slate-200 *:dark:border-zink-500">
                                <td>
                                    <a href="{{ route('hr/attendance/page', ['employee_id' => $employee->user_id]) }}" class="transition-all duration-200 ease-linear text-custom-500 hover:text-custom-600">{{ $employee->name }}</a>
                                </td>
                                @for($day = 1; $day <= $daysInMonth; $day++)
                                    @php
                                        $date = $month->copy()->day($day)->format('Y-m-d');
                                        $record = $attendanceMatrix->get($employee->id.'-'.$date);
                                    @endphp
                                    <td class="text-center">
                                        @if(!$record)
                                            <span class="text-slate-400">-</span>
                                        @elseif($record->status === 'present')
                                            <i data-lucide="check" class="mx-auto text-green-500 size-4"></i>
                                        @elseif($record->status === 'leave')
                                            <span class="px-2 py-0.5 text-xs rounded bg-yellow-100 text-yellow-600 dark:bg-yellow-500/20">L</span>
                                        @else
                                            <i data-lucide="x" class="mx-auto text-red-500 size-4"></i>
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ $daysInMonth + 1 }}" class="px-3.5 py-6 text-center border-y border-slate-200 dark:border-zink-500 text-slate-500 dark:text-zink-200">No employees yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
