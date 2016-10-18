<html>
<head>
    <!--解决 IE6 背景缓存-->
    <!--[if IE 6]>
    <script type="text/javascript">document.execCommand("BackgroundImageCache", false, true);</script><![endif]-->
    <meta charset="utf-8">
    <title>404 Not Found!</title>
    <style type="text/css">
        html {
            background: url(<?=__APP__.'/common/404/images/404_bg.jpg'?>) !important;
        }

        a, fieldset, img {
            border: 0;
        }

        a {
            color: #221919;
            text-decoration: none;
            outline: none;
        }

        a:hover {
            color: #3366cc;
            text-decoration: underline;
        }

        body {
            font-size: 24px;
            color: #B7AEB4;
        }

        body a.link, body h1, body p {
            -webkit-transition: opacity 0.5s ease-in-out;
            -moz-transition: opacity 0.5s ease-in-out;
            transition: opacity 0.5s ease-in-out;
        }

        #wrapper {
            text-align: center;
            margin: 100px auto;
            width: 594px;
        }

        a.link {
            text-shadow: 0px 1px 2px white;
            font-weight: 600;
            color: #3366cc;
            opacity: 1;
        }

        h1 {
            text-shadow: 0px 1px 2px white;
            font-size: 24px;
            opacity: 0;
        }

        img {
            -webkit-transition: opacity 1s ease-in-out;
            -moz-transition: opacity 1s ease-in-out;
            transition: opacity 1s ease-in-out;
            height: 202px;
            width: 199px;
            opacity: 0;
        }

        p {
            text-shadow: 0px 1px 2px white;
            font-weight: normal;
            font-weight: 200;
            opacity: 1;
        }

        .fade {
            opacity: 1;
        }

        .info {
            font-size: 14px;
            color: #a29d9d;
        }

        @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
            #wrapper {
                margin: 40px auto;
                text-align: center;
                width: 280px;
            }
        }
    </style>
</head>
<body>
<div id="wrapper">
    <a href=<?= __ROOT__ ?>><img class="fade" src="<?= __APP__ . '/common/404/images/404.png' ?>"></a>
    <div>
        <h1 class="fade">温馨提示，您访问的地址不存在！</h1>
        <p class="info">
            <label>可能原因：</label>
            网址有错误&gt;请检查地址是否完整或存在多余字符<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;
            网址已失效&gt;可能页面已删除，活动已下线等
        </p>
        <p class="fade">您正在寻找的页面无法找到，
            <a class="link" href=<?= __ROOT__ ?> onclick="history.go(-1)">回到首页?</a></p>

    </div>
</div>
</body>
</html>