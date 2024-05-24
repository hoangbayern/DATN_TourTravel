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
                                        <span><span class="fa fa-user"> Số chỗ : {{ $tour->t_number_guests  }} - Còn trống: {{  $number  }}</span></span>
                                    </div>
                                    <p class="mda-box-p">
                                        <span><span class="fa fa-user"> Đã xác nhận: {{ $tour->t_number_registered }}</span></span>
                                    </p>
                                    @if($tour->t_number_registered<$tour->t_number_guests)

                                        <a style="color: #3c3b3b; font-size: 14px; margin-right: 102px"><span class="fa fa-user"></span> Số người đang đăng ký: {{ $tour->t_follow  }} </a>
                                    @endif
                                    @if($number-$tour->t_follow<2 && $tour->t_number_registered!=$tour->t_number_guests)
                                        <a style="color:red">Sắp hết </a>
                                    @endif
                                </div>
                            </div>
                            <div class="linkTo">
                                <a href="{{ route('tour.detail', ['id' => $tour->id, 'slug' => safeTitle($tour->t_title)]) }}"><span>Chi tiết</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Repeat the above block for other wrapSearch divs -->

        </div>
    </div>
@endif
