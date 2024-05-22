@extends('page.layouts.page')
@section('title', 'Liên hệ')
@section('style')
    <!-- Add any additional styles if needed -->
    <style>
    </style>
@stop
@section('seo')
@stop
@section('content')
    <section class="hero-wrap hero-wrap-2" style="background-image: url({{ asset('/page/images/bg_1.jpg') }}); height: 205px">
        <div class="container">
            <div class="row no-gutters slider-text align-items-end justify-content-center">
                <div class="col-md-9 ftco-animate pb-5 text-center" style="margin-top: 105px">
                    <h1 class="mb-0 bread">Liên hệ</h1>
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('page.home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a></span> <span>Liên hệ <i class="fa fa-chevron-right"></i></span></p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-no-pb contact-section mb-4">
        <div class="container">
            <div class="row d-flex contact-info">
                <div class="col-md-3 d-flex">
                    <div class="align-self-stretch box p-4 text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-map-marker"></span>
                        </div>
                        <h3 class="mb-2">Địa chỉ</h3>
                        <p> Duy Tien, Ha Nam</p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="align-self-stretch box p-4 text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-phone"></span>
                        </div>
                        <h3 class="mb-2">Số điện thoại liên hệ</h3>
                        <p><a href="tel://0987082683">0987082683</a></p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="align-self-stretch box p-4 text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-paper-plane"></span>
                        </div>
                        <h3 class="mb-2">Địa chỉ email</h3>
                        <p><a href="mailto:hoangdm2002@gmail.com">hoangdm2002@gmail.com</a></p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="align-self-stretch box p-4 text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-fw fa-facebook-f"></span>
                        </div>
                        <h3 class="mb-2">Website</h3>
                        <p><a href="https://portfolio-hoanghh.vercel.app/" target="_blank">Portfolio</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section contact-section ftco-no-pt">
        <div class="container">
            <div class="row block-9">
                <div class="col-md-12 order-md-last d-flex">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d119490.78142350457!2d105.89003422353161!3d20.625313633798353!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135cf554a9671d1%3A0xc2092e8b77356f08!2zRHV5IFRpw6puLCBIw6AgTmFtLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1715620096424!5m2!1svi!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="ftco-section contact-section ftco-no-pt">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-md-7 text-center heading-section ftco-animate">
                    <h2 class="mb-4">Liên hệ với chúng tôi</h2>
                </div>
            </div>
            <div class="row block-9">
                <div class="col-md-6 order-md-last d-flex">
                    <form action="#" method="POST" class="bg-light p-5 contact-form">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" placeholder="Họ và tên" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="phone" placeholder="Số điện thoại" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="subject" placeholder="Chủ đề" required>
                        </div>
                        <div class="form-group">
                            <textarea name="message" cols="30" rows="7" class="form-control" placeholder="Nội dung" required></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Gửi" class="btn btn-primary py-3 px-5">
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <h2 class="tourName">Bamboo Travel &amp; Du Lịch Việt</h2>
                    <div class="text-center mb-2 text-xl">LIÊN HỆ ĐẶT PHÒNG</div>
                    <div class="beWrap text-center mb-3">
                        <div class="be"><span class="fa fa-envelope text-center"><a href="mailto:hoangdm2002@gmail.com">hoangdm2002@gmail.com</a></span></div>
                    </div>
                    <div class="phoneWrap">
                        <div class="hotline"><a href="tel:0987082683">0987082683</a></div>
                    </div> <div class="img text-center"><img src="//dulichviet.com.vn/images/form/2.jpg" alt=""></div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-intro ftco-section ftco-no-pt">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <div class="img" style="background-image: url({{ asset('page/images/bg_2.jpg') }});">
                        <div class="overlay"></div>
                        <h2>Chào mừng bạn đến với Fun Travel</h2>
                        <p>Chúng tôi sẽ đem đến trãi nghiệm các tour du lịch tốt nhất dành cho bạn</p>
                        <p class="mb-0"><a href="#" class="btn btn-primary px-4 py-3">Liên hệ qua Messenger của chúng tôi</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('script')
@stop
