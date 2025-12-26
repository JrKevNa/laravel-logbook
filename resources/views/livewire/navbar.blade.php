<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <link
        rel="canonical"
        href="https://getbootstrap.com/docs/5.3/examples/headers/"
    />
    <link href="{{ asset('css/navbar.css') }}" rel="stylesheet" />
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }
        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: #0000001a;
            border: solid rgba(0, 0, 0, 0.15);
            border-width: 1px 0;
            box-shadow: inset 0 0.5em 1.5em #0000001a,
                inset 0 0.125em 0.5em #00000026;
        }
        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }
        .bi {
            vertical-align: -0.125em;
            fill: currentColor;
        }
        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }
        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;
            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }
        .bd-mode-toggle {
            z-index: 1500;
        }
        .bd-mode-toggle .bi {
            width: 1em;
            height: 1em;
        }
        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }
    </style>
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check2" viewBox="0 0 16 16">
            <path
                d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"
            ></path>
        </symbol>
        <symbol id="circle-half" viewBox="0 0 16 16">
            <path
                d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"
            ></path>
        </symbol>
        <symbol id="moon-stars-fill" viewBox="0 0 16 16">
            <path
                d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"
            ></path>
            <path
                d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"
            ></path>
        </symbol>
        <symbol id="sun-fill" viewBox="0 0 16 16">
            <path
                d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"
            ></path>
        </symbol>
    </svg>

    <div class="container">
        <header
            class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom"
        >
            <div class="col-md-3 mb-2 mb-md-0">
                <a
                    href="/dashboard"
                    class="d-inline-flex link-body-emphasis text-decoration-none"
                >
                    <i class="bi bi-bootstrap" style="font-size: 2rem;"></i>
                </a>
            </div>
            <ul
                class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0"
            >
                <li>
                    <a href="/dashboard" class="nav-link px-2"
                        >Dashboard</a
                    >
                </li>
                <li class="nav-item position-relative">
                    <a href="{{ route('projects') }}" class="nav-link px-2">
                        Project
                        @if($projectCount > 0)
                            <span class="position-absolute top-0 start-90 translate-middle badge rounded-pill bg-danger">
                                {{ $projectCount }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="nav-item position-relative">
                    <a href="{{ route('to-do-list') }}" class="nav-link px-2">
                        To Do List
                        @if($todoCount > 0)
                            <span class="position-absolute top-0 start-90 translate-middle badge rounded-pill bg-danger">
                                {{ $todoCount }}
                            </span>
                        @endif
                    </a>
                </li>
                <li><a href="{{ route('logbook') }}" class="nav-link px-2">My Logbook</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Report
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('daily-report') }}">Daily Report</a></li>
                        <li><a class="dropdown-item" href="{{ route('user-report') }}">User Report</a></li>
                    </ul>
                </li>
                @auth
                    @if(auth()->user()->roles->contains('name', 'admin'))
                        <li><a href="{{ route('users') }}" class="nav-link px-2">Users</a></li>
                    @endif
                @endauth

            </ul>
            <div class="col-md-3 text-end">
                @auth
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center gap-2 ms-auto"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding: .375rem .75rem;">
                            <i class="bi bi-person-circle"></i>
                            <span>{{ auth()->user()->name }}</span>
                        </button>

                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="bi bi-person"></i> Profile
                                </a>
                            </li>
                            <li>
                                <button class="dropdown-item" type="button" wire:click="logout">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Show profile icon when user is logged in -->
                    {{-- <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="profileDropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="bi bi-person"></i> Profile
                                </a>
                            </li>
                            <li>
                                <button class="dropdown-item" type="button" wire:click="logout">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </li>
                        </ul>
                    </div> --}}

                {{-- @else
                    <!-- Show login/register when user is not logged in -->
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">
                        Login
                    </a>

                    <a href="{{ route('register') }}" class="btn btn-primary">
                        Register
                    </a> --}}
                @endauth
            </div>
        </header>
    </div>
</div>
