<div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-3">
                        <span class="avatar avatar-xl rounded-circle ms-2" style="background-image: url(@if(auth()->user()->image == null) 'https://ui-avatars.com/api/?name={{ auth()->user()->username }}&background=DE6060&color=fff&rounded=true&size=112' @else {{ asset(auth()->user()->image) }} @endif)"></span>
                    </div>
                    <div class="col-9">
                        <h1>
                            {{ auth()->user()->username }}
                        </h1>
                        <h3>
                            {{ auth()->user()->credential ?? 'tests' }}
                        </h3>
                        <h4 class="text-secondary">
                            0 Followers &#8226; 0 Following
                        </h4>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="ms-2">
                        {{ auth()->user()->description ?? 'test' }}
                    </div>
                </div>
                <hr>
            </div>
            <div class="col-6">

            </div>
        </div>
    </div>
</div>
