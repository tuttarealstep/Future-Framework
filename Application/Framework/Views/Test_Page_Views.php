<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $titolo; ?></title>
    <link href='https://fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
    <style>
        body
        {
            font-family: 'Lato', sans-serif;
            margin-left: auto;
            margin-right: auto;
            margin-top: 10%;
            margin-bottom: auto;
            text-align: center;
        }
    </style>
    <style type="text/css" id="gwd-text-style">
        p {
            margin: 0px;
        }
        h1 {
            margin: 0px;
        }
        h2 {
            margin: 0px;
        }
        h3 {
            margin: 0px;
        }
    </style>
    <style type="text/css">
        html,
        body {
            width: 100%;
        }
        body {
            transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
            -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
            -moz-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
            transform-style: preserve-3d;
            -webkit-transform-style: preserve-3d;
            -moz-transform-style: preserve-3d;
            background-color: transparent;
        }
        .gwd-img-8y2q {
            left: 169px;
            width: 100px;
            height: 150px;
            transform-style: preserve-3d;
            -webkit-transform-style: preserve-3d;
            -moz-transform-style: preserve-3d;
            transform: translate3d(30px, 0px, 0px) rotateZ(180deg);
            -webkit-transform: translate3d(30px, 0px, 0px) rotateZ(180deg);
            -moz-transform: translate3d(30px, 0px, 0px) rotateZ(180deg);
            top: -149px;
        }
        body .gwd-gen-1ms0gwdanimation {
            animation: gwd-gen-1ms0gwdanimation_gwd-keyframes 1.5s linear 0s 1 normal forwards;
            -webkit-animation: gwd-gen-1ms0gwdanimation_gwd-keyframes 1.5s linear 0s 1 normal forwards;
            -moz-animation: gwd-gen-1ms0gwdanimation_gwd-keyframes 1.5s linear 0s 1 normal forwards;

        }
        @keyframes gwd-gen-1ms0gwdanimation_gwd-keyframes {
            0% {
                transform: translate3d(0px, -350px, 0px) rotateZ(180deg);
                animation-timing-function: linear;
                top: -200px;
            }
            50% {
                animation-timing-function: linear;
            }
            86.67% {
                transform: translate3d(0px, 0px, 0px) rotateZ(0deg);
                animation-timing-function: linear;
            }
            95.33% {
                transform: translate3d(0px, 20px, 0px) rotateZ(0deg);
                animation-timing-function: linear;
            }
            100% {
                transform: translate3d(0px, 100px, 0px) rotateZ(0deg);
                animation-timing-function: linear;
            }
            100% {

                content: url('http://localhost/Application/Framework/Views/Style/light_on.png');
            }
        }
    </style>
</head>

<body>
<h1 class="futuretitle"><?php echo $titolo; ?></h1>
<img src="http://localhost/Application/Framework/Views/Style/light.png?fix" class="gwd-img-8y2q gwd-gen-1ms0gwdanimation" style="">
</body>

</html>