@extends('layouts.master')

@php
    $displayName = $profileDetail->name ?? Session::get('name') ?? 'HR User';
    $email = $profileDetail->email ?? Session::get('email') ?? 'N/A';
    $position = $profileDetail->position ?? $profileDetail->designation ?? Session::get('position') ?? 'HR Administrator';
    $department = $profileDetail->department ?? Session::get('department') ?? 'Human Resources';
    $location = $profileDetail->location ?? Session::get('location') ?? 'N/A';
    $status = $profileDetail->status ?? Session::get('status') ?? 'Active';
    $joinDate = $profileDetail->join_date ?? 'N/A';
    $phone = $profileDetail->phone_number ?? 'N/A';
    $avatar = $profileDetail->avatar ?? Session::get('avatar');
    $nameParts = preg_split('/\s+/', trim($displayName));
    $initials = collect($nameParts)->filter()->map(fn ($part) => strtoupper(substr($part, 0, 1)))->take(2)->implode('');
@endphp

@section('content')
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Account Profile</h5>
            </div>
            <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                <li class="text-slate-400 dark:text-zink-200">Pages</li>
                <li class="text-slate-700 dark:text-zink-100">Account</li>
            </ul>
        </div>

        <div class="grid grid-cols-1 gap-5 xl:grid-cols-12">
            <div class="xl:col-span-4 2xl:col-span-3">
                <div class="card">
                    <div class="card-body">
                        <div class="flex flex-col items-center text-center">
                            <div class="relative">
                                @if(!empty($avatar))
                                    <img src="{{ asset('assets/images/'.$avatar) }}" alt="{{ $displayName }}" class="object-cover rounded-full size-28 border border-slate-200 dark:border-zink-500">
                                @else
                                    <div class="flex items-center justify-center font-semibold rounded-full size-28 bg-custom-100 text-custom-600 dark:bg-custom-500/20 dark:text-custom-300 text-3xl">
                                        {{ $initials ?: 'HR' }}
                                    </div>
                                @endif
                            </div>
                            <h5 class="mt-4 mb-1 text-17">{{ $displayName }}</h5>
                            <p class="text-slate-500 dark:text-zink-200">{{ $position }}</p>
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 mt-3 text-xs font-medium rounded border bg-green-100 border-green-200 text-green-600 dark:bg-green-500/20 dark:border-green-500/20">
                                <span class="size-1.5 rounded-full bg-green-500"></span>
                                {{ $status }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mt-6">
                            <div class="p-3 text-center rounded-md bg-slate-50 dark:bg-zink-600">
                                <h6 class="mb-1 text-16">{{ $department }}</h6>
                                <p class="text-xs text-slate-500 dark:text-zink-200">Department</p>
                            </div>
                            <div class="p-3 text-center rounded-md bg-slate-50 dark:bg-zink-600">
                                <h6 class="mb-1 text-16">2026</h6>
                                <p class="text-xs text-slate-500 dark:text-zink-200">HR System</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="xl:col-span-8 2xl:col-span-9">
                <div class="card">
                    <div class="card-body">
                        <div class="flex flex-col gap-3 mb-5 md:flex-row md:items-center">
                            <div class="grow">
                                <h6 class="text-15">Personal Information</h6>
                                <p class="mt-1 text-slate-500 dark:text-zink-200">Account details used across the HR management system.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="p-4 border rounded-md border-slate-200 dark:border-zink-500">
                                <p class="mb-1 text-xs uppercase text-slate-400">Full Name</p>
                                <h6 class="text-15">{{ $displayName }}</h6>
                            </div>
                            <div class="p-4 border rounded-md border-slate-200 dark:border-zink-500">
                                <p class="mb-1 text-xs uppercase text-slate-400">Email Address</p>
                                <h6 class="text-15 break-all">{{ $email }}</h6>
                            </div>
                            <div class="p-4 border rounded-md border-slate-200 dark:border-zink-500">
                                <p class="mb-1 text-xs uppercase text-slate-400">Role / Position</p>
                                <h6 class="text-15">{{ $position }}</h6>
                            </div>
                            <div class="p-4 border rounded-md border-slate-200 dark:border-zink-500">
                                <p class="mb-1 text-xs uppercase text-slate-400">Department</p>
                                <h6 class="text-15">{{ $department }}</h6>
                            </div>
                            <div class="p-4 border rounded-md border-slate-200 dark:border-zink-500">
                                <p class="mb-1 text-xs uppercase text-slate-400">Phone Number</p>
                                <h6 class="text-15">{{ $phone }}</h6>
                            </div>
                            <div class="p-4 border rounded-md border-slate-200 dark:border-zink-500">
                                <p class="mb-1 text-xs uppercase text-slate-400">Location</p>
                                <h6 class="text-15">{{ $location }}</h6>
                            </div>
                            <div class="p-4 border rounded-md border-slate-200 dark:border-zink-500">
                                <p class="mb-1 text-xs uppercase text-slate-400">Join Date</p>
                                <h6 class="text-15">{{ $joinDate }}</h6>
                            </div>
                            <div class="p-4 border rounded-md border-slate-200 dark:border-zink-500">
                                <p class="mb-1 text-xs uppercase text-slate-400">Login Date</p>
                                <h6 class="text-15">{{ now()->format('F d, Y') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-3 text-15">Account Summary</h6>
                        <p class="text-slate-500 dark:text-zink-200">
                            This profile belongs to an HR System user. Use the HR Management menu to manage employees, leave requests, departments, holidays, and attendance records.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
