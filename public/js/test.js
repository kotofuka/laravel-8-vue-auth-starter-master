// imports

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
            console.log("type: ", typeof(e))
            if (rec.state == "inactive"){
               console.log("завершенный файл", e.data);
            //    let response = fetch('/convert', {
            //     method: "post",
            //     body: e
            //    }).catch(function(e){
            //     console.log("error: " + e);
            //    });
               //console.log("fetch was done");

                axios({
                    method: "post",
                    url: "/convert",
                    data: {
                        data: e
                    }
                });

               //var blob = response.blob;
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