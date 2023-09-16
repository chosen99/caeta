<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style>
        .screenshot-image {
            border-radius: 4px;
            border: 2px solid whitesmoke;
            box-shadow: 5px 2px 5px 2px rgba(0, 0, 0, 0.1);
            position: absolute;
            top: 100px;
            bottom: 5px;
            left: 10px;
            background: white;
        }

        .display-cover {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 70%;
            margin: 5% auto;
            position: relative;
        }

        video {
        //margin: 5% auto;
            width: 100%;
            background: rgba(0,0,0,0.2);
        }

        .video-options {
            position: absolute;
            left: 20px;
            top: 30px;
        }

        .controls {
            position: absolute;
            right: 20px;
            top: 20px;
            display: flex;

        }

        .controls > button {
            width: 45px;
            height: 45px;
            text-align: center;
            border-radius: 100%;
            margin: 0 6px;
            background: transparent;

        &:hover {
        svg {
            color: white !important;
        }
        }
        }


        @media (min-width: 300px) and (max-width: 400px) {
            .controls {
                flex-direction: column;

            button {
                margin: 5px 0 !important;
            }
        }
        }

        .controls > button > svg {
            height: 20px;
            width: 18px;
            text-align: center;
            margin: 0 auto;
            padding: 0;
        }

        .controls button:nth-child(1) {
            border: 2px solid #D2002E;

        svg {
            color: #D2002E;

        }
        }

        .controls button:nth-child(2) {
            border: 2px solid #008496;

        svg {
            color: #008496;
        }
        }

        .controls button:nth-child(3) {
            border: 2px solid #00B541;

        svg {
            color: #00B541;
        }
        }

        .controls > button {
            width: 45px;
            height: 45px;
            text-align: center;
            border-radius: 100%;
            margin: 0 6px;
            background: transparent;

        &:hover {
        svg {
            color: white;
        }
        }
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }
        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
    <title>Document</title>
</head>
<body>
<div class="display-cover">
    <video autoplay></video>
    <canvas class="d-none"></canvas>

    <div class="video-options">
        <select name="" id="" class="custom-select">
            <option value="">Select camera</option>
        </select>
    </div>

    <img class="screenshot-image d-none" alt="">

    <div class="controls">
        <button class="btn btn-danger play" title="Play"><i data-feather="play-circle"></i></button>
        <button class="btn btn-info pause d-none" title="Pause"><i data-feather="pause"></i></button>
        <button class="btn btn-outline-success screenshot d-none" title="ScreenShot"><i data-feather="image"></i></button>
    </div>
</div>
<div class="container-fluid text-center">
    <label class="switch">
        <input type="checkbox" checked>
        <span class="slider round"></span>
    </label>
</div>

<script src="https://unpkg.com/feather-icons"></script>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script>
    feather.replace();

    const controls = document.querySelector('.controls');
    const cameraOptions = document.querySelector('.video-options>select');
    const video = document.querySelector('video');
    const canvas = document.querySelector('canvas');
    const screenshotImage = document.querySelector('img');
    const buttons = [...controls.querySelectorAll('button')];
    let streamStarted = false;

    const [play, pause, screenshot] = buttons;

    const constraints = {
        video: {
            width: {
                //min: 1280,
                ideal: 1920,
                //max: 2560,
            },
            height: {
                //min: 720,
                ideal: 1080,
                //max: 1440
            },
            facingMode: 'environment'
        }
    };

    cameraOptions.onchange = () => {
        const updatedConstraints = {
            ...constraints,
            deviceId: {
                exact: cameraOptions.value
            }
        };
        startStream(updatedConstraints);
    };

    play.onclick = () => {
        if (streamStarted) {
            video.play();
            play.classList.add('d-none');
            pause.classList.remove('d-none');
            return;
        }
        if ('mediaDevices' in navigator && navigator.mediaDevices.getUserMedia) {
            const updatedConstraints = {
                ...constraints,
                deviceId: {
                    exact: cameraOptions.value
                }
            };
            startStream(updatedConstraints);
        }
    };

    const pauseStream = () => {
        video.pause();
        play.classList.remove('d-none');
        pause.classList.add('d-none');
    };

    const doScreenshot = () => {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0);
        screenshotImage.src = canvas.toDataURL('image/webp');
        screenshotImage.classList.remove('d-none');
    };

    pause.onclick = pauseStream;
    screenshot.onclick = doScreenshot;

    const startStream = async (constraints) => {
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        let stream_settings = stream.getVideoTracks()[0].getSettings();
        handleStream(stream);
        let stream_width = stream_settings.width;
        let stream_height = stream_settings.height;
        $(".screenshot-image").width(stream_width*0.1).height(stream_height*0.1);
    };

    const handleStream = (stream) => {
        video.srcObject = stream;
        play.classList.add('d-none');
        pause.classList.remove('d-none');
        screenshot.classList.remove('d-none');

    };

    const getCameraSelection = async () => {
        const devices = await navigator.mediaDevices.enumerateDevices();
        const videoDevices = devices.filter(device => device.kind === 'videoinput');
        const options = videoDevices.map(videoDevice => {
            return `<option value="${videoDevice.deviceId}">${videoDevice.label}</option>`;
        });
        cameraOptions.innerHTML = options.join('');
    };
    getCameraSelection();
</script>
</body>
</html>