// get video ui element
var music = document.getElementById('udpf-player');
var pButton = document.getElementById('pButton');
var playhead = document.getElementById('playhead');
var timeline = document.getElementById('timeline');
var time_update = document.getElementById('timeup');
var download = document.getElementById('download');
var buffer=document.getElementById('bufffers');
var audioplayer = document.getElementById('audioplayer');
var volume=document.getElementById('volume');
var volumebar=document.getElementById('volumebar');
///////////// initial setting
 timeline_width();
 var timelineWidth = timeline.offsetWidth - playhead.offsetWidth;
/////////////////////////////////// son variable
var duration;
var onplayhead = false;

////////////////////////////////////event listener

//set initial with and on resize window
 timeline_width();
window.addEventListener("resize",timeline_width,false);

// set volume on mouse down
 volume.addEventListener("mousedown",function(e){
                 volume_percentage(e.pageX);         
         },false);

//download on click
download.addEventListener('click', function () {
    window.location=music.src;
}, false);

// update  buffer on timeupdate
music.addEventListener('timeupdate', function() {
    buffer.style.width = (music.buffered.end(0)*100/(music.duration)) + '%';
},false);

// on outo play change logo
music.addEventListener('play',function() {
        pButton.className = '';
        pButton.className = 'pause';
},false);

// time update on timeupdate
music.addEventListener('timeupdate', timeUpdate, false);

//  move mouse head and update curreent time on clic on time line
timeline.addEventListener('click', function (event) {
    moveplayhead(event);
music.currentTime = duration * clickPercent(event);
}, false);

//playerhead move down on mouse down
playhead.addEventListener('mousedown', mouseDown, false);

//
window.addEventListener('mouseup', mouseUp, false);


var onplayhead = false;


music.addEventListener('canplaythrough', function () {
    duration = music.duration;
            if(fancyTimeFormat(music.duration)=="0:NaN")
    time_update.innerHTML=fancyTimeFormat(music.currentTime)+" live" ;
    else
    time_update.innerHTML=fancyTimeFormat(music.currentTime)+"/"+ fancyTimeFormat(duration) ;
}, false);

window.onload = function(){
//randombg("body");
};

//////////////////////////function 

function clickPercent(e) {
    return (e.pageX - timeline.offsetLeft) / timelineWidth;
}

function mouseDown() {
    onplayhead = true;
    window.addEventListener('mousemove', moveplayhead, true);
    music.removeEventListener('timeupdate', timeUpdate, false);
}


function mouseUp(e) {
    if (onplayhead == true) {
        moveplayhead(e);
        window.removeEventListener('mousemove', moveplayhead, true);
        music.currentTime = duration * clickPercent(e);
        music.addEventListener('timeupdate', timeUpdate, false);
    }
    onplayhead = false;
}

// when we move head by mouse
function moveplayhead(e) {
    var newMargLeft = e.pageX - timeline.offsetLeft;
    if (newMargLeft >= 0 && newMargLeft <= timelineWidth) {
        playhead.style.marginLeft = newMargLeft + 'px';
    }
    if (newMargLeft < 0) {
        playhead.style.marginLeft = '0px';
  
    }
    if (newMargLeft > timelineWidth) {
        playhead.style.marginLeft = timelineWidth + 'px';

    }
}


function timeUpdate() {
    var playPercent = timelineWidth * (music.currentTime / music.duration);
    playhead.style.marginLeft = playPercent + 'px';
    if (music.currentTime == duration) {
        pButton.className = '';
        pButton.className = 'play';
    }
    if(fancyTimeFormat(music.duration)=="0:NaN")
    time_update.innerHTML=fancyTimeFormat(music.currentTime)+" live" ;
    else
    time_update.innerHTML=fancyTimeFormat(music.currentTime)+"/"+ fancyTimeFormat(music.duration) ;
}

function play() {
    if (music.paused) {
        music.play();
        pButton.className = '';
        pButton.className = 'pause';
    } else {
        music.pause();
        pButton.className = '';
        pButton.className = 'play';
    }
}

function volume_percentage(x)
               {
        var percentage =100*(x - volume.offsetLeft) / volume.offsetWidth;
        volumebar.style.width=percentage+"%";
        music.volume=percentage/100;
               }
               
function timeline_width()
         {
              var px=time_update.offsetLeft - pButton.offsetLeft - pButton.offsetWidth-15;
             var audioplayerwidth= 100*(px)/audioplayer.offsetWidth; // in %
              timeline.style.width=px+"px";
             //timeline.style.width=audioplayerwidth+"%";
             timelineWidth = timeline.offsetWidth - playhead.offsetWidth;
         }

function fancyTimeFormat(time)
{    // Hours, minutes and seconds
    var hrs = ~~(time / 3600);
    var mins = ~~((time % 3600) / 60);
    var secs = Math.round(time%60);
    // Output like "1:01" or "4:03:59" or "123:03:59"
    var ret = "";
    if (hrs > 0) {
        ret += "" + hrs + ":" + (mins < 10 ? "0" : "");
    }
    ret += "" + mins + ":" + (secs < 10 ? "0" : "");
    ret += "" + secs;
    return ret;
}
