
@extends('template.auth')

@section('content')
<style>
    body {
        background: url('./images/white-bg.png') !important;
    }
</style>

<div id="content" class="container h-100">
    <div class="row  h-100 justify-content-center align-items-center">
        <div class="col-9  border border-white p-5 m-5 rounded" style="background: #fff">
            <div class="row">
                <div class="col-6">
                    <div>
                        <img class="text-center mx-auto d-block border-0 img-thumbnail" style=" height: 50vh; margin-top: -30px;"
                        src="./images/WKMHLogo.png" alt="">
                    </div>

                    <h4 class="text-center mb-5" style="font-weight: 900">WANINI KIRERI MAGEREZA EMR</h4>
                </div>
                <div class="col-6" style="padding-top: 50px">
                    <form method="post" action="{{ route('login') }}">
                            @csrf
                        <h3 class="text-center mb-5">EMRS LOGIN</h3>
                        <div class="form-group">

                            <input id="email" class="form-control @error('email') border-danger @enderror" style="height: 3.2rem;border-radius:1.25rem"
                                type="email" placeholder="Email Address" name="email" autocomplete="email" autofocus>
                                @error('email')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input id="password" placeholder="Password" style="height: 3.2rem;border-radius:1.25rem"
                                class="form-control @error('password') border-danger @enderror" type="password" name="password" autocomplete="current-password">
                                @error('password')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            {{--
                            @if (Route::has('password.request'))
                                   <br> <a class="text-decoration-none" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                                --}}
                        </div>

                        
                        <input class="mt-2 form-control btn border-0 btn-success" style="height: 3.2rem;" value="Login"
                            type="submit" name="">
                    </form>
                    
                </div>
            </div>
            
        </div>

    </div>
    
</div>


@endsection