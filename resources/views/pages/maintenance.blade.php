@extends('layouts.master')

@section('content')

<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:md:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4">

<div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

    <!-- Page Title -->
    <div class="flex items-center justify-between mb-6">
        <h4 class="text-2xl font-semibold text-slate-700 dark:text-zink-100">
            Maintenance Center
        </h4>

        <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400">
            System Online
        </span>
    </div>

    <!-- Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

        <div class="card">
            <div class="card-body text-center">
                <h5 class="text-lg font-medium mb-2">
                    System Version
                </h5>

                <p class="text-3xl font-bold text-custom-500">
                    v1.0
                </p>

                <p class="text-slate-500 mt-2">
                    HR Management System
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <h5 class="text-lg font-medium mb-2">
                    Database Status
                </h5>

                <p class="text-3xl font-bold text-green-500">
                    Active
                </p>

                <p class="text-slate-500 mt-2">
                    MySQL Connected
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <h5 class="text-lg font-medium mb-2">
                    Last Update
                </h5>

                <p class="text-3xl font-bold text-blue-500">
                    {{ date('M d') }}
                </p>

                <p class="text-slate-500 mt-2">
                    System Updated
                </p>
            </div>
        </div>

    </div>

    <!-- Maintenance Actions -->
    <div class="card mb-6">
        <div class="card-body">

            <h5 class="text-lg font-medium mb-4">
                Maintenance Tools
            </h5>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <form method="POST" action="{{ route('maintenance.clear-cache') }}">
                    @csrf
                    <button type="submit" class="w-full btn bg-custom-500 text-white">
                        Clear Cache
                    </button>
                </form>

                <form method="POST" action="{{ route('maintenance.optimize') }}">
                    @csrf
                    <button type="submit" class="w-full btn bg-yellow-500 text-white">
                        Optimize System
                    </button>
                </form>

                <form method="POST" action="{{ route('maintenance.backup-database') }}">
                    @csrf
                    <button type="submit" class="w-full btn bg-red-500 text-white">
                        Backup Database
                    </button>
                </form>

            </div>

        </div>
    </div>

    <!-- System Information -->
    <div class="card">
        <div class="card-body">

            <h5 class="text-lg font-medium mb-4">
                System Information
            </h5>

            <div class="overflow-x-auto">
                <table class="table-auto w-full">

                    <tbody>

                        <tr>
                            <td class="py-3 font-medium text-slate-700 dark:text-zink-100">
                                Application Name
                            </td>
                            <td class="py-3 text-right text-slate-500 dark:text-zink-200">
                                HR System
                            </td>
                        </tr>

                        <tr>
                            <td class="py-3 font-medium text-slate-700 dark:text-zink-100">
                                Framework
                            </td>
                            <td class="py-3 text-right text-slate-500 dark:text-zink-200">
                                Laravel {{ app()->version() }}
                            </td>
                        </tr>

                        <tr>
                            <td class="py-3 font-medium text-slate-700 dark:text-zink-100">
                                PHP Version
                            </td>
                            <td class="py-3 text-right text-slate-500 dark:text-zink-200">
                                {{ PHP_VERSION }}
                            </td>
                        </tr>

                        <tr>
                            <td class="py-3 font-medium text-slate-700 dark:text-zink-100">
                                Database
                            </td>
                            <td class="py-3 text-right text-slate-500 dark:text-zink-200">
                                {{ strtoupper(config('database.default')) }}
                            </td>
                        </tr>

                        <tr>
                            <td class="py-3 font-medium text-slate-700 dark:text-zink-100">
                                Environment
                            </td>
                            <td class="py-3 text-right text-slate-500 dark:text-zink-200">
                                {{ app()->environment() }}
                            </td>
                        </tr>

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

</div>
@endsection
