// imports


// global vars
var localStream = null;
var streamConstraints = {"audio": true};

//functions
// testing stand number 1
// function StartRecord(){ // альтернативное название "getUserMerdia_click"
//     console.log("StartRecord");
//     navigator.webkitGetUserMedia(streamConstraints, getUserMedia_success, getUserMedia_error);
//     console.log(streamConstraints);

// }

// function getUserMedia_success(stream){
//     console.log("getUserMedia_success():", stream);
//     var context = new webkitaudiocontext();
//     var mediaStreamSource = context.createmediastreamsource(stream);
//     console.log("mediaStreamSource:", mediaStreamSource);
// }

// function getUserMedia_error(error){
//     console.log("getUserMedia_error():", error);
    
// }

// testing stand number 2
// function StartRecord(){
//     console.log("StratRecord()");
//     navigator.mediaDevices.getUserMedia({"audio":true}).then(function(stream){
//         console.log("Поток найден:", stream);
//         var context = new (window.AudioContext);
//         var mediaStreamSource = context.createMediaStreamSource(stream);
//         console.log("mediaStreamSource:", mediaStreamSource);
//         var recorder = new MediaRecorder(stream);
        
//         console.log("recorder:", recorder);
//     }).catch(function(err){
//         console.log("возникла ошибка:");
//         console.log(err.name + ": " + err.message);
//     });

// }

// function callback(stream){
//     console.log("callback()")
//     var audioContext = new(window.AudioContext || window.webkitAudioContext);
//     console.log("audioContext:", audioContext);
// }


// testing stand number 3
var audioChunks = [];
navigator.mediaDevices.getUserMedia({audio:true})
    .then(stream => {
        console.log("getUserMedia_success, stream", stream);
        rec = new MediaRecorder(stream);
        console.log("MediaRecorder:", rec);
        rec.ondataavailable = e => {
            console.log("e:", e);
            audioChunks.push(e.data);
            if (rec.state == "inactive"){
               console.log("завершенный файл", e.data);
               var blobUrl = URL.createObjectURL(e.data);
               var link = document.createElement("a");
               link.href = blobUrl;
               link.download = "aDefaultFileName.webm";
            }
        }
    })
    .catch(e=>console.log(e));

function StartRecord(){
    console.log("StartRecord");
    rec.start();
}

function StopRecord(){
    console.log("StopRecord");
    rec.stop();
    console.log("audioChunks:", audioChunks);

}

function PauseRecord(){
    console.log("PauseRecord");
    rec.pause();
}
// other