@extends('layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="flex flex-col gap-2 mb-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h4 class="text-2xl font-semibold text-slate-800 dark:text-zink-50">Settings</h4>
                    <p class="mt-1 text-sm text-slate-500 dark:text-zink-300">Manage your account and system preferences.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-5">
                            <h5 class="text-lg font-semibold text-slate-800 dark:text-zink-50">System Settings</h5>
                            <p class="mt-1 text-sm text-slate-500 dark:text-zink-300">Choose how the HR system behaves while you work.</p>
                        </div>

                        <div class="space-y-3">
                            <label class="flex items-center justify-between gap-4 p-4 border rounded-md cursor-pointer border-slate-200 bg-slate-50/70 dark:border-zink-500 dark:bg-zink-700/50">
                                <span>
                                    <span class="block font-medium text-slate-800 dark:text-zink-50">Dark Mode</span>
                                    <span class="block mt-1 text-xs text-slate-500 dark:text-zink-300">Switch the dashboard between light and dark theme.</span>
                                </span>
                                <input id="settings-dark-mode" type="checkbox" class="w-5 h-5 border rounded shrink-0 accent-custom-500 border-slate-300 dark:border-zink-400">
                            </label>

                            <label class="flex items-center justify-between gap-4 p-4 border rounded-md cursor-pointer border-slate-200 bg-slate-50/70 dark:border-zink-500 dark:bg-zink-700/50">
                                <span>
                                    <span class="block font-medium text-slate-800 dark:text-zink-50">Email Notifications</span>
                                    <span class="block mt-1 text-xs text-slate-500 dark:text-zink-300">Receive updates about attendance, leave, and account changes.</span>
                                </span>
                                <input type="checkbox" checked class="w-5 h-5 border rounded shrink-0 accent-custom-500 border-slate-300 dark:border-zink-400">
                            </label>

                            <label class="flex items-center justify-between gap-4 p-4 border rounded-md cursor-pointer border-slate-200 bg-slate-50/70 dark:border-zink-500 dark:bg-zink-700/50">
                                <span>
                                    <span class="block font-medium text-slate-800 dark:text-zink-50">System Alerts</span>
                                    <span class="block mt-1 text-xs text-slate-500 dark:text-zink-300">Show important reminders and system warnings.</span>
                                </span>
                                <input type="checkbox" checked class="w-5 h-5 border rounded shrink-0 accent-custom-500 border-slate-300 dark:border-zink-400">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="mb-5">
                            <h5 class="text-lg font-semibold text-slate-800 dark:text-zink-50">Account Settings</h5>
                            <p class="mt-1 text-sm text-slate-500 dark:text-zink-300">Review your current administrator profile details.</p>
                        </div>

                        <form class="space-y-4">
                            <div>
                                <label for="admin-name" class="form-label text-slate-700 dark:text-zink-100">Admin Name</label>
                                <input id="admin-name" type="text" class="form-input dark:bg-zink-700 dark:border-zink-500 dark:text-zink-50" value="{{ Session::get('name') }}" readonly>
                            </div>

                            <div>
                                <label for="admin-email" class="form-label text-slate-700 dark:text-zink-100">Email Address</label>
                                <input id="admin-email" type="email" class="form-input dark:bg-zink-700 dark:border-zink-500 dark:text-zink-50" value="{{ Session::get('email') }}" readonly>
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div class="p-4 border rounded-md border-slate-200 bg-slate-50/70 dark:border-zink-500 dark:bg-zink-700/50">
                                    <span class="block text-xs uppercase text-slate-500 dark:text-zink-300">Role</span>
                                    <span class="block mt-1 font-semibold text-slate-800 dark:text-zink-50">{{ Session::get('role_name') ?? 'HR Administrator' }}</span>
                                </div>
                                <div class="p-4 border rounded-md border-slate-200 bg-slate-50/70 dark:border-zink-500 dark:bg-zink-700/50">
                                    <span class="block text-xs uppercase text-slate-500 dark:text-zink-300">Status</span>
                                    <span class="inline-flex px-2 py-1 mt-1 text-xs font-medium rounded bg-green-500/10 text-green-500">Active</span>
                                </div>
                            </div>

                            <button type="button" class="w-full btn bg-custom-500 text-white hover:bg-custom-600 sm:w-auto">
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
