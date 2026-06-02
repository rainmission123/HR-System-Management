@extends('layouts.master')

@section('content')
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:md:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

        <div class="flex flex-col gap-2 mb-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h4 class="text-2xl font-semibold text-slate-800 dark:text-zink-50">Settings</h4>
                <p class="mt-1 text-sm text-slate-500 dark:text-zink-300">Manage your account and system preferences.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-1 text-lg font-semibold text-slate-800 dark:text-zink-50">System Settings</h5>
                    <p class="mb-5 text-sm text-slate-500 dark:text-zink-300">Choose how the HR system behaves while you work.</p>

                    <div class="space-y-3">
                        <label class="flex items-center justify-between gap-4 p-4 border rounded-md cursor-pointer border-slate-200 bg-slate-50/70 dark:border-zink-500 dark:bg-zink-700/50">
                            <span>
                                <span class="block font-medium text-slate-800 dark:text-zink-50">Dark Mode</span>
                                <span class="block mt-1 text-xs text-slate-500 dark:text-zink-300">Switch the dashboard between light and dark theme.</span>
                            </span>
                            <input id="settings-dark-mode" type="checkbox" class="w-5 h-5 border rounded shrink-0 accent-custom-500">
                        </label>

                        <label class="flex items-center justify-between gap-4 p-4 border rounded-md cursor-pointer border-slate-200 bg-slate-50/70 dark:border-zink-500 dark:bg-zink-700/50">
                            <span>
                                <span class="block font-medium text-slate-800 dark:text-zink-50">Email Notifications</span>
                                <span class="block mt-1 text-xs text-slate-500 dark:text-zink-300">Receive updates about attendance, leave, and account changes.</span>
                            </span>
                            <input type="checkbox" checked class="w-5 h-5 border rounded shrink-0 accent-custom-500">
                        </label>

                        <label class="flex items-center justify-between gap-4 p-4 border rounded-md cursor-pointer border-slate-200 bg-slate-50/70 dark:border-zink-500 dark:bg-zink-700/50">
                            <span>
                                <span class="block font-medium text-slate-800 dark:text-zink-50">System Alerts</span>
                                <span class="block mt-1 text-xs text-slate-500 dark:text-zink-300">Show important reminders and system warnings.</span>
                            </span>
                            <input type="checkbox" checked class="w-5 h-5 border rounded shrink-0 accent-custom-500">
                        </label>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="mb-1 text-lg font-semibold text-slate-800 dark:text-zink-50">Account Settings</h5>
                    <p class="mb-5 text-sm text-slate-500 dark:text-zink-300">Review your current administrator profile details.</p>

                    <form class="space-y-4">
                        <div>
                            <label class="form-label text-slate-700 dark:text-zink-100">Admin Name</label>
                            <input type="text" class="form-input dark:bg-zink-700 dark:border-zink-500 dark:text-zink-50" value="{{ Session::get('name') }}" readonly>
                        </div>

                        <div>
                            <label class="form-label text-slate-700 dark:text-zink-100">Email Address</label>
                            <input type="email" class="form-input dark:bg-zink-700 dark:border-zink-500 dark:text-zink-50" value="{{ Session::get('email') }}" readonly>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="p-4 border rounded-md border-slate-200 bg-slate-50/70 dark:border-zink-500 dark:bg-zink-700/50">
                                <span class="block text-xs uppercase text-slate-500 dark:text-zink-300">Role</span>
                                <span class="block mt-1 font-semibold text-slate-800 dark:text-zink-50">Admin</span>
                            </div>

                            <div class="p-4 border rounded-md border-slate-200 bg-slate-50/70 dark:border-zink-500 dark:bg-zink-700/50">
                                <span class="block text-xs uppercase text-slate-500 dark:text-zink-300">Status</span>
                                <span class="inline-flex px-2 py-1 mt-1 text-xs font-medium rounded bg-green-500/10 text-green-500">Active</span>
                            </div>
                        </div>

                        <button type="button" class="w-full text-white btn bg-custom-500 hover:bg-custom-600">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection



@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const darkModeToggle = document.getElementById('settings-dark-mode');
            const html = document.documentElement;

            if (!darkModeToggle) {
                return;
            }

            const syncToggle = () => {
                darkModeToggle.checked = html.getAttribute('data-mode') === 'dark' || html.classList.contains('dark');
            };

            syncToggle();

            darkModeToggle.addEventListener('change', function () {
                const nextMode = darkModeToggle.checked ? 'dark' : 'light';
                html.setAttribute('data-mode', nextMode);
                html.classList.toggle('dark', nextMode === 'dark');
                localStorage.setItem('data-mode', nextMode);
            });
        });
    </script>
@endsection
