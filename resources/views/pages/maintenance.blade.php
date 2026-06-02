@extends('layouts.master')

@section('content')

<div class="page-content">

<div class="container-fluid">

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

                <button class="btn bg-custom-500 text-white">
                    Clear Cache
                </button>

                <button class="btn bg-yellow-500 text-white">
                    Optimize System
                </button>

                <button class="btn bg-red-500 text-white">
                    Backup Database
                </button>

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
                            <td class="py-3 font-medium">
                                Application Name
                            </td>
                            <td>
                                HR System
                            </td>
                        </tr>

                        <tr>
                            <td class="py-3 font-medium">
                                Framework
                            </td>
                            <td>
                                Laravel 12
                            </td>
                        </tr>

                        <tr>
                            <td class="py-3 font-medium">
                                PHP Version
                            </td>
                            <td>
                                {{ PHP_VERSION }}
                            </td>
                        </tr>

                        <tr>
                            <td class="py-3 font-medium">
                                Database
                            </td>
                            <td>
                                MySQL
                            </td>
                        </tr>

                        <tr>
                            <td class="py-3 font-medium">
                                Environment
                            </td>
                            <td>
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
