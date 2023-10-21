<div>
    <div class="container mt-2">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="card mt-3 rounded-4">
                    <div class="card-body">
                        <div class="container">
                            <h2 class="mt-2 mb-2 text-center"><strong>Sign up</strong></h2>
                            <form wire:submit="register">
                                <label class="form-label mt-4 required"><strong>Username</strong></label>
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5"></path>
                                            <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z"></path>
                                         </svg>
                                    </span>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" wire:model.blur="username" placeholder="Username" />
                                </div>
                                @error('username')
                                    <div class="mt-1 text-danger">{{ $message }}</div>
                                @enderror
                                <label class="form-label mt-3 required"><strong>Email address</strong></label>
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-at" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                            <path d="M16 12v1.5a2.5 2.5 0 0 0 5 0v-1.5a9 9 0 1 0 -5.5 8.28"></path>
                                        </svg>
                                    </span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model.blur="email" placeholder="Email address" />
                                </div>
                                @error('email')
                                    <div class="mt-1 text-danger">{{ $message }}</div>
                                @enderror
                                <label class="form-label mt-3 required"><strong>Password</strong></label>
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z"></path>
                                            <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0"></path>
                                            <path d="M8 11v-4a4 4 0 1 1 8 0v4"></path>
                                        </svg>
                                    </span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" wire:model.blur="password" placeholder="Password" />
                                </div>
                                @error('password')
                                    <div class="mt-1 text-danger">{{ $message }}</div>
                                @enderror
                                <div class="mt-3 mb-3 text-center">
                                    <button type="submit" class="btn btn-danger w-100">
                                        <div wire:loading.remove wire:target="register">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                                <path d="M16 19h6"></path>
                                                <path d="M19 16v6"></path>
                                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                                            </svg>
                                        </div>
                                        <div wire:loading wire:target="register">
                                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                        </div>
                                        Sign up
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    Already have an account? <a wire:navigate href="{{ route('login') }}" wire:navigate class="text-danger">Sign in</a>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</div>
