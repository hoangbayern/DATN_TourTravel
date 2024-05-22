<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Mạng bán TOUR DU LỊCH trực tuyến hàng đầu Việt Vam | Bamboo Travel')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('page.common.head')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <style>
        #button {
            display: inline-block;
            background-color: #FF9800;
            width: 50px;
            height: 50px;
            text-align: center;
            border-radius: 4px;
            position: fixed;
            bottom: 30px;
            right: 30px;
            transition: background-color .3s,
            opacity .5s, visibility .5s;
            opacity: 0;
            visibility: hidden;
            z-index: 1000;
        }
        #button::after {
            content: "\f077";
            font-family: FontAwesome;
            font-weight: normal;
            font-style: normal;
            font-size: 2em;
            line-height: 50px;
            color: #fff;
        }
        #button:hover {
            cursor: pointer;
            background-color: #333;
        }
        #button:active {
            background-color: #555;
        }
        #button.show {
            opacity: 1;
            visibility: visible;
        }
    </style>
</head>
<body>
    @include('page.common.navbar')
    @yield('content')
    @include('page.common.footer')
    @include('page.common.script')

    <a id="button"></a>
</body>
<!-- Messenger Plugin chat Code -->
{{--<div id="fb-root"></div>--}}

<!-- Your Plugin chat code -->
{{--<div id="fb-customer-chat" class="fb-customerchat">--}}
{{--</div>--}}

{{--<script>--}}
{{--  var chatbox = document.getElementById('fb-customer-chat');--}}
{{--  chatbox.setAttribute("page_id", "102030232294539");--}}
{{--  chatbox.setAttribute("attribution", "biz_inbox");--}}

{{--  window.fbAsyncInit = function() {--}}
{{--    FB.init({--}}
{{--      xfbml            : true,--}}
{{--      version          : 'v12.0'--}}
{{--    });--}}
{{--  };--}}

{{--  (function(d, s, id) {--}}
{{--    var js, fjs = d.getElementsByTagName(s)[0];--}}
{{--    if (d.getElementById(id)) return;--}}
{{--    js = d.createElement(s); js.id = id;--}}
{{--    js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';--}}
{{--    fjs.parentNode.insertBefore(js, fjs);--}}
{{--  }(document, 'script', 'facebook-jssdk'));--}}
{{--</script>--}}

<script>
    var btn = $('#button');

    $(window).scroll(function() {
        if ($(window).scrollTop() > 100) {
            btn.addClass('show');
        } else {
            btn.removeClass('show');
        }
    });

    btn.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop:0}, '300');
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert@2"></script>
</html>
