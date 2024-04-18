@extends('admin.layouts.main')
@section('title', 'Quản lý du lịch')
@section('style-css')
    <!-- fullCalendar -->
@stop
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lý du lịch</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
                        {{--<li class="breadcrumb-item"><a href="#">Quản lý bán hàng</a></li>--}}
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@stop

@section('script')
    <link rel="stylesheet" href="https://code.highcharts.com/css/highcharts.css">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    {{-- <script src="https://code.highcharts.com/modules/exporting.js"></script> --}}
    {{-- <script src="https://code.highcharts.com/modules/export-data.js"></script> --}}
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script type="text/javascript">
        let dataTransaction = $("#container").attr('data-json');
        dataTransaction  =  JSON.parse(dataTransaction);

        let listday = $("#container2").attr("data-list-day");
        listday = JSON.parse(listday);

        let listMoneyMonth = $("#container2").attr('data-money');
        listMoneyMonth = JSON.parse(listMoneyMonth);

        let listMoneyMonthDefault = $("#container2").attr('data-money-default');
        listMoneyMonthDefault = JSON.parse(listMoneyMonthDefault);

        let listday2 = $("#container3").attr("data-list-day");
        listday2 = JSON.parse(listday2);

        let listMoneyMonth2 = $("#container3").attr('data-money');
        listMoneyMonth2 = JSON.parse(listMoneyMonth2);



        Highcharts.chart('container', {

            chart: {
                styledMode: true
            },

            title: {
                text: 'Trạng thái các tour du lịch'
            },

            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr']
            },

            series: [{
                type: 'pie',
                allowPointSelect: true,
                keys: ['name', 'y', 'selected', 'sliced'],
                data: dataTransaction,
                showInLegend: true
            }]
        });

        Highcharts.chart('container2', {
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Thống kê lượng khách hàng đặt tour trong tháng'
            },
            subtitle: {
                text: 'Dữ liệu thống kê'
            },
            xAxis: {
                categories: listday
            },
            yAxis: {
                title: {
                    text: 'Số lượng khách hàng'
                },
                labels: {
                    formatter: function () {
                        return this.value ;
                    }
                }
            },
            tooltip: {
                crosshairs: true,
                shared: true
            },
            plotOptions: {
                spline: {
                    marker: {
                        radius: 4,
                        lineColor: '#666666',
                        lineWidth: 1
                    }
                }
            },
            series: [
                {
                    name: 'Tổng số người lớn',
                    marker: {
                        symbol: 'square'
                    },
                    data: listMoneyMonth
                },
                {
                    name: 'Tổng số trẻ em',
                    marker: {
                        symbol: 'square'
                    },
                    data: listMoneyMonthDefault
                },

            ]
        });
        Highcharts.chart('container3', {
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Thống kê Doanh thu trong tháng'
            },
            subtitle: {
                text: 'Dữ liệu thống kê'
            },
            xAxis: {
                categories: listday2
            },
            yAxis: {
                title: {
                    text: 'Tiền'
                },
                // number_format($totalPrice, 0,',','.')
                labels: {
                    formatter: function () {
                        return this.value ;
                    }
                }
            },
            tooltip: {
                crosshairs: true,
                shared: true
            },
            plotOptions: {
                spline: {
                    marker: {
                        radius: 4,
                        lineColor: '#666666',
                        lineWidth: 1
                    }
                }
            },
            series: [
                {
                    name: 'Doanh thu',
                    marker: {
                        symbol: 'square'
                    },
                    data: listMoneyMonth2
                },

            ]
        });
    </script>
@stop
