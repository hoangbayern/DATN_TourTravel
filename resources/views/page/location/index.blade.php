@extends('page.layouts.page')
@section('title', 'Tours - Tin tức Du lịch - Thông tin Du lịch, Tin tức Du Lịch Việt Nam 2021')
@section('style')
@stop
@section('content')
    <section class="hero-wrap" style="background-image: url({{ asset('/page/images/bg_1.jpg') }}); height: 200px">
        <div class="container">
            <div class="row no-gutters slider-text align-items-end justify-content-center">
                <div class="col-md-9 ftco-animate pt-50 text-center mt-50" style="margin-top: 105px">
                    <h1 class="mb-0 bread">Địa điểm</h1>
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('page.home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a></span> <span>Danh sách<i class="fa fa-chevron-right"></i></span></p>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section ftco-no-pb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="search-wrap-1 ftco-animate fadeInUp ftco-animated">
                        @include('page.common.searchTour')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="sidebar-box ftco-animate fadeInUp ftco-animated">
                        <div class="categories">
                            <h3>Danh sách điểm đến hot</h3>
                            @foreach($locations as $location)
                                <li class="nav-item {{ request()->is('dia-diem/*') ? 'active' : ''}}"><a href="{{ route('location', ['id' => $location->id, 'slug' => safeTitle($location->l_name)]) }}" class="nav-link">{{ $location->l_name }}</a></li>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    @if($tours->count() > 0)
                        @foreach($tours as $tour)
                            @include('page.common.itemTourNew', compact('tour'))
                        @endforeach
                    @else
                        <div class="text-center no-tours_location">
                            <p>Hiện tại không có Tour nào phù hợp với tìm kiếm của bạn.</p>
                            <p>Hãy thử thay đổi tiêu chí tìm kiếm hoặc <a href="{{ route('page.home') }}">quay lại trang chủ</a> để khám phá thêm nhiều thông tin thú vị khác.</p>
                            <p>Nếu bạn cần hỗ trợ, vui lòng <a href="{{ route('contact.index') }}">liên hệ với chúng tôi</a>.</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row mt-5">
                <div class="col text-center">
                    <div class="block-27">
                        {{ $tours->links('page.pagination.default') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('script')
@stop
