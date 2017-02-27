/**
 * Created by robin on 11/20/16.
 */


(function()
{

    var streaming = false,
        video        = document.querySelector('#video'),
        cover        = document.querySelector('#cover'),
        canvas       = document.querySelector('#canvas'),
        startbutton  = document.querySelector('#startbutton'),
        width = 520,
        height = 0;

    navigator.getMedia = ( navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia);

    navigator.getMedia(
        {
            video: true,
            audio: false
        },
        function(stream)
        {
            if (navigator.mozGetUserMedia)
            {
                video.mozSrcObject = stream;
            }
            else
            {
                var vendorURL = window.URL || window.webkitURL;
                video.src = vendorURL.createObjectURL(stream);
            }
            video.play();
        },
        function(err)
        {
            console.log("An error occured! " + err);
        }
    );

    video.addEventListener('canplay', function(ev)
    {
        if (!streaming)
        {
            height = video.videoHeight / (video.videoWidth/width);
            video.setAttribute('width', width);
            video.setAttribute('height', height);
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            streaming = true;
        }
    }, false);

    function takepicture() {
        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').drawImage(video, 0, 0, width, height);
        var data = canvas.toDataURL('image/png');
        $.ajax({
            type: "post",
            url: 'home.php',
            data: 'pics=' + data,
            success: function(data)
            {
                console.log("success!");
            }
        });

    }

    $('#startbutton').click(function()
    {
        takepicture();
    });
/*
    startbutton.addEventListener('click', function(ev){
        takepicture();
        ev.preventDefault();
    }, false);
*/
})();