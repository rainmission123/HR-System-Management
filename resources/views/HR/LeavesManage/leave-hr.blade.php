@extends('layouts.master')
@section('content')
    <div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">Leave Manage (HR)</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li class="text-slate-400 dark:text-zink-200">Leaves Manage</li>
                    <li class="text-slate-700 dark:text-zink-100">Leave Manage (HR)</li>
                </ul>
            </div>

            <div class="grid grid-cols-1 gap-x-5 md:grid-cols-2 xl:grid-cols-12">
                <div class="xl:col-span-3">
                    <div class="card">
                        <div class="flex items-center gap-3 card-body">
                            <div class="flex items-center justify-center rounded-md size-12 text-15 bg-custom-100 text-custom-500 dark:bg-custom-500/20 shrink-0"><i data-lucide="file-bar-chart-2"></i></div>
                            <div class="grow">
                                <h5 class="mb-1 text-16"><span class="counter-value" data-target="{{ $leaves->count() }}">0</span></h5>
                                <p class="text-slate-500 dark:text-zink-200">Total Leaves</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xl:col-span-3">
                    <div class="card">
                        <div class="flex items-center gap-3 card-body">
                            <div class="flex items-center justify-center text-green-500 bg-green-100 rounded-md size-12 text-15 dark:bg-green-500/20 shrink-0"><i data-lucide="calendar-check"></i></div>
                            <div class="grow">
                                <h5 class="mb-1 text-16"><span class="counter-value" data-target="{{ $todayLeaves }}">0</span></h5>
                                <p class="text-slate-500 dark:text-zink-200">Today Leaves</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xl:col-span-3">
                    <div class="card">
                        <div class="flex items-center gap-3 card-body">
                            <div class="flex items-center justify-center text-purple-500 bg-purple-100 rounded-md size-12 text-15 dark:bg-purple-500/20 shrink-0"><i data-lucide="check-circle"></i></div>
                            <div class="grow">
                                <h5 class="mb-1 text-16"><span class="counter-value" data-target="{{ $approvedLeaves }}">0</span></h5>
                                <p class="text-slate-500 dark:text-zink-200">Approved Leaves</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xl:col-span-3">
                    <div class="card">
                        <div class="flex items-center gap-3 card-body">
                            <div class="flex items-center justify-center text-yellow-500 bg-yellow-100 rounded-md size-12 text-15 dark:bg-yellow-500/20 shrink-0"><i data-lucide="loader"></i></div>
                            <div class="grow">
                                <h5 class="mb-1 text-16"><span class="counter-value" data-target="{{ $pendingLeaves }}">0</span></h5>
                                <p class="text-slate-500 dark:text-zink-200">Pending Leaves</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="grid grid-cols-1 gap-4 mb-5 lg:grid-cols-2 xl:grid-cols-12">
                        <h6 class="text-15 grow">Leave Requests</h6>
                        <div class="xl:col-span-2 xl:col-start-11">
                            <div class="ltr:lg:text-right rtl:lg:text-left">
                                <a href="{{ route('hr/create/leave/hr/page') }}" type="button" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                    <i data-lucide="plus" class="inline-block size-4"></i>
                                    <span class="align-middle">Add Leave</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <table id="alternativePagination" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">No</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Employee Name</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Leave Type</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Reason</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">No Of Days</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">From</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">To</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Status</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leaves as $leave)
                                @php
                                    $statusClass = match($leave->status) {
                                        'Approved' => 'bg-green-100 border-green-100 text-green-500 dark:bg-green-400/20',
                                        'Declined' => 'bg-red-100 border-red-100 text-red-500 dark:bg-red-400/20',
                                        default => 'bg-yellow-100 border-yellow-100 text-yellow-500 dark:bg-yellow-400/20',
                                    };
                                @endphp
                                <tr>
                                    <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">{{ $loop->iteration }}</td>
                                    <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">{{ $leave->employee_name }}</td>
                                    <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">{{ $leave->leave_type }}</td>
                                    <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">{{ $leave->reason }}</td>
                                    <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">{{ $leave->number_of_day }}</td>
                                    <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">{{ $leave->date_from }}</td>
                                    <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">{{ $leave->date_to }}</td>
                                    <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">
                                        <span class="px-2.5 py-0.5 inline-block text-xs font-medium rounded border {{ $statusClass }}">{{ $leave->status ?: 'Pending' }}</span>
                                    </td>
                                    <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">
                                        <div class="flex gap-2">
                                            <form action="{{ route('hr/leave/update-status') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="leave_id" value="{{ $leave->id }}">
                                                <input type="hidden" name="status" value="Approved">
                                                <button type="submit" class="flex items-center justify-center text-green-500 transition-all duration-200 ease-linear bg-green-100 rounded-md size-8 hover:text-white hover:bg-green-500 dark:bg-green-500/20 dark:hover:bg-green-500" title="Approve"><i data-lucide="check" class="size-4"></i></button>
                                            </form>
                                            <form action="{{ route('hr/leave/update-status') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="leave_id" value="{{ $leave->id }}">
                                                <input type="hidden" name="status" value="Declined">
                                                <button type="submit" class="flex items-center justify-center text-yellow-500 transition-all duration-200 ease-linear bg-yellow-100 rounded-md size-8 hover:text-white hover:bg-yellow-500 dark:bg-yellow-500/20 dark:hover:bg-yellow-500" title="Decline"><i data-lucide="x" class="size-4"></i></button>
                                            </form>
                                            <form action="{{ route('hr/leave/delete') }}" method="POST" onsubmit="return confirm('Delete this leave request?')">
                                                @csrf
                                                <input type="hidden" name="leave_id" value="{{ $leave->id }}">
                                                <button type="submit" class="flex items-center justify-center text-red-500 transition-all duration-200 ease-linear bg-red-100 rounded-md size-8 hover:text-white hover:bg-red-500 dark:bg-red-500/20 dark:hover:bg-red-500" title="Delete"><i data-lucide="trash-2" class="size-4"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-3.5 py-8 text-center text-slate-500 dark:text-zink-200">No leave records yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@section('script')
@endsection
@endsection
