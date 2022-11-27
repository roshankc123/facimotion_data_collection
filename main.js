feather.replace();

const controls = document.querySelector('.controls');
const cameraOptions = document.querySelector('.video-options>select');
const video = document.querySelector('video');
const canvas = document.querySelector('canvas');
const screenshotImage = document.querySelector('.screenshot-image');
const buttons = [...controls.querySelectorAll('button')];
let streamStarted = false;

const [play, pause, screenshot] = buttons;

const constraints ={
  video: {
    width: {
      min: 700,
      ideal: 1280,
      max: 2560,
    },
    height: {
      min: 450,
      ideal: 720,
      max: 1440
    },
    facingMode: 'user'
  }
}

const getCameraSelection = async () => {
  const devices = await navigator.mediaDevices.enumerateDevices();
  const videoDevices = devices.filter(device => device.kind === 'videoinput');
  const options = videoDevices.map(videoDevice => {
    return `<option value="${videoDevice.deviceId}">${videoDevice.label}</option>`;
  });
  cameraOptions.innerHTML = options.join('');
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

const startStream = async (constraints) => {
  const stream = await navigator.mediaDevices.getUserMedia(constraints);
  handleStream(stream);
};

const handleStream = (stream) => {
  video.srcObject = stream;
  play.classList.add('d-none');
  pause.classList.remove('d-none');
  screenshot.classList.remove('d-none');
  streamStarted = true;
};


getCameraSelection();


cameraOptions.onchange = () => {
    const updatedConstraints = {
      ...constraints,
      deviceId: {
        exact: cameraOptions.value
      }
    };
    startStream(updatedConstraints);
  };
  
  const pauseStream = () => {
    video.pause();
    play.classList.remove('d-none');
    pause.classList.add('d-none');
  };
  
  const doScreenshot = () => {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    console.log("screenshot")
    canvas.getContext('2d').drawImage(video, 0, 0);
    screenshotImage.src = canvas.toDataURL('image/jpg');
    console.log(screenshotImage)
    screenshotImage.classList.remove('d-none');
  };
  

  // $.ajax({
  //   type: "POST",
  //   url: "script.php",
  //   data: { 
  //      imgBase64: dataURL
  //   }
  // }).done(function(o) {
  //   console.log('saved'); 
  //   // If you want the file to be visible in the browser 
  //   // - please modify the callback in javascript. All you
  //   // need is to return the url to the file, you just saved 
  //   // and than put the image in your browser.
  // });


  pause.onclick = pauseStream;
  screenshot.onclick = doScreenshot;