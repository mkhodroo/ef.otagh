@extends('layouts.guest')

@section('content')
    <div class="col-sm-3" id="login-box">
        <div class="">
            <div class="card-header text-center">
                <img src="{{ url('public/logo.png') }}" class="col-sm-12" alt="logo" style="width: 150px">
                <p style="text-align: justify">
                    مردم شهر و شهرستان شما امسال با خرید کالای باکیفیت و قیمت های عالی در فضای بسیار زیبا نمایشگاه بهاره
                    قدردان تلاش‌های صادقانه آن اتاق خواهد بود.
                    امسال با شعار (عید تا عید) به استقبال سالی عالی و باشکوه میرویم
                </p>
            </div>
            <div class="card-body">
                <form action="javascript:void(0)" method="post" id="login-form">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="email" placeholder="موبایل">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-phone"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="رمز عبور">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary col-sm-12" onclick="submit()">ورود</button>
                </div>
                <hr>
                {{-- <div class="center-align" style="text-align: center">
                <a href="{{ route('register') }}" class="text-center">صفحه ثبت نام</a>
            </div>
            <hr> --}}
                {{-- <div class="center-align" style="text-align: center">
                    <a href="{{ route('password.request') }}" class="text-center">فراموشی رمز</a>
                </div> --}}
                <div class="space"></div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function submit() {
            send_ajax_request(
                "{{ route('login') }}",
                $('#login-form').serialize(),
                function(response) {
                    show_message("به صفحه داشبورد منتقل میشوید")
                    window.location = "{{ url('dashboard') }}"
                },
                function(response) {
                    // console.log(response);
                    show_error(response)
                    hide_loading();
                }
            )
        }
    </script>
@endsection
