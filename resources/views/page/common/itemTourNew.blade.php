@if($tour->t_status < 2)
    <div class="vnt-tour" id="row_search">
        <div class="row">
            <div class="wrapSearch col-12">
                <div class="mda-box-item d-flex">
                    <div class="daySearch">
                        <div class="day">{{ \Carbon\Carbon::parse($tour->t_start_date)->format('d') }}</div>
                        <div class="divider"></div>
                        <div class="moyear">{{ \Carbon\Carbon::parse($tour->t_start_date)->format('m/Y') }}</div>
                    </div>
                    <div class="mda-box-img">
                        <a class="img-tour" href="{{ route('tour.detail', ['id' => $tour->id, 'slug' => safeTitle($tour->t_title)]) }}">
                            @if( $tour->t_sale > 0)
                                <span  class="price">Sale {{ $tour->t_sale }}%</span>
                            @endif
                            @if( $tour->t_sale > 0)
                                <span class="price" style="margin-left:100px">
           {{ number_format($tour->t_price_adults-($tour->t_price_adults*$tour->t_sale/100),0,',','.') }} vnd/người <br>
           <span style="text-decoration: line-through;margin-left:35px;color:#ddd">{{ number_format($tour->t_price_adults),0,',','.' }}</span>
        </span>
                            @else
                                <span class="price" >
           {{ number_format($tour->t_price_adults-($tour->t_price_adults*$tour->t_sale/100),0,',','.') }} vnd/người</span>
                            @endif
                            <img class="lazy" src="{{ $tour->t_image ? asset(pare_url_file($tour->t_image)) : asset('admin/dist/img/no-image.png') }}">
                            <div class="short-description">{!! the_excerpt($tour->t_content, 200) !!}</div>
                        </a>
                        <div class="mda-box-lb">{{ isset($tour->t_starting_gate) ? $tour->t_starting_gate : '' }}</div>
                    </div>
                    <div class="mda-box-fig d-flex flex-column justify-content-between">
                        <div>
                            <a class="mda-box-name" href="{{ route('tour.detail', ['id' => $tour->id, 'slug' => safeTitle($tour->t_title)]) }}" title="{{ $tour->t_title }}">
                                {{ the_excerpt($tour->t_title, 100) }}
                            </a>
                            <p class="mda-time">
                                <span>Thời gian</span>
                                <span>{{ $tour->t_schedule }}</span>
                            </p>
                        </div>
                        <div>
                            <div class="mda-info">
                                    <?php $number = $tour->t_number_guests - $tour->t_number_registered ?>
                                <div class="mda-box-price">
                                    <div class="mda-lb">
                                        <span>Số chỗ : {{ $tour->t_number_guests  }} - Còn trống: {{  $number  }} </span>
                                    </div>
                                    <p class="mda-box-p">
                                        <span class="mda-price"><span class="mda-money-red">4,299,000 đ</span></span>
                                    </p>
                                </div>
                            </div>
                            <div class="linkTo">
                                <a href="https://dulichviet.com.vn/du-lich-trong-nuoc/du-lich-buon-ma-thuot-pleiku-kon-tum-khu-du-lich-mang-den-tu-sai-gon-gia-tot?idschedule=100152" title="Du lịch Buôn Ma Thuột - Pleiku - Kon Tum khu du lịch Măng Đen từ Sài Gòn giá tốt 2024"><span>Chi tiết</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Repeat the above block for other wrapSearch divs -->

        </div>
    </div>
@endif
