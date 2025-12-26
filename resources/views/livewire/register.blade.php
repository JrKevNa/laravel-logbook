<div class="d-flex justify-content-center align-items-center" style="height: 100vh; overflow:hidden;">
    {{-- The Master doesn't talk, he acts. --}}
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
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
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
    </style>

    <link href="{{ asset('css/register.css') }}" rel="stylesheet">

    
    <div class="body-login text-center">
        <main class="form-signin w-100 m-auto" style="background-color: #f5f7fa; border: 1px solid #d0d4da; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
            <form wire:submit.prevent="register">
                <h1 class="h1 mb-3 fw-bold">Register</h1>

                <div class="form-floating mb-2">
                    <input type="text" wire:model.lazy="companyName" class="form-control @error('companyName') is-invalid @enderror" id="floatingName" placeholder="Your Company Name">
                    <label for="floatingName">Company Name</label>
                    @error('companyName') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <hr>

                <div class="form-floating mb-2">
                    <input type="text" wire:model.lazy="name" class="form-control @error('name') is-invalid @enderror" id="floatingName" placeholder="Your Name">
                    <label for="floatingName">Full Name</label>
                    @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="form-floating mb-2">
                    <input type="text" wire:model.lazy="nik" class="form-control @error('nik') is-invalid @enderror" id="floatingName" placeholder="Your NIK">
                    <label for="floatingName">NIK</label>
                    @error('nik') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="form-floating mb-2">
                    <input type="email" wire:model.lazy="email" class="form-control @error('email') is-invalid @enderror" id="floatingEmail" placeholder="name@example.com">
                    <label for="floatingEmail">Email address</label>
                    @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                {{-- <div class="form-floating mb-2">
                    <input type="password" wire:model.lazy="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                    @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="password" wire:model.lazy="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="floatingPasswordConfirm" placeholder="Confirm Password">
                    <label for="floatingPasswordConfirm">Confirm Password</label>
                </div> --}}

                <button class="w-100 btn btn-lg btn-primary"
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="register">

                    <span wire:loading.remove wire:target="register">
                        Register
                    </span>

                    <span wire:loading wire:target="register">
                        <div class="spinner-border spinner-border-sm" role="status"></div>
                    </span>

                </button>

                <!-- Login link -->
                <p class="mt-3">
                    Already have an account? 
                    <a href="{{ route('login') }}">Sign in here</a>
                </p>

                {{-- <p class="mt-5 mb-3 text-muted">&copy; 2017–2022</p> --}}
            </form>
        </main>
    </div>
</div>