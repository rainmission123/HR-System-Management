@extends('layouts.master')

@section('content')

<div class="page-content">

```
<div class="container-fluid">

    <div class="flex items-center justify-between mb-6">
        <h4 class="text-2xl font-semibold text-slate-700 dark:text-zink-100">
            Settings
        </h4>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- System Settings -->
        <div class="card">
            <div class="card-body">
                <h5 class="mb-4 text-lg font-medium">
                    System Settings
                </h5>

                <div class="space-y-4">

                    <div class="flex items-center justify-between">
                        <span>Dark Mode</span>
                        <input type="checkbox" checked>
                    </div>

                    <div class="flex items-center justify-between">
                        <span>Email Notifications</span>
                        <input type="checkbox" checked>
                    </div>

                    <div class="flex items-center justify-between">
                        <span>System Alerts</span>
                        <input type="checkbox" checked>
                    </div>

                </div>
            </div>
        </div>

        <!-- Account Settings -->
        <div class="card">
            <div class="card-body">
                <h5 class="mb-4 text-lg font-medium">
                    Account Settings
                </h5>

                <form>

                    <div class="mb-4">
                        <label class="form-label">
                            Admin Name
                        </label>

                        <input type="text"
                               class="form-input"
                               value="{{ Session::get('name') }}">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            Email Address
                        </label>

                        <input type="email"
                               class="form-input"
                               value="{{ Session::get('email') }}">
                    </div>

                    <button type="button"
                            class="btn bg-custom-500 text-white">
                        Save Changes
                    </button>

                </form>
            </div>
        </div>

    </div>

</div>
```

</div>
@endsection
