<template>

<div class="container">
    <button @click="StartRecord">Начать запись</button>
    <!-- <input type="button" id="start_button" value="начать запись" onclick="StartRecord">
    <input type="button" id="pause_button" value="остановить запись" onclick="PauseRecord">
    <input type="button" id="stop_button" value="закончить запись" onclick="StopRecord">
    <a download="aDefaultNameFile.webm" href="#" id="link">загрузить</a> -->

</div>

    
</template>

<script>
export default {
    methods: {
        StartRecord(){
            console.log("StartRecord");
            this.rec.start();
        },

        StopRecord(){
            console.log("StopRecord");
            rec.stop();
            console.log("audioChunks:", audioChunks);

        },

        PauseRecord(){
            console.log("PauseRecord");
            rec.pause();
        }
    },

    setup() {
        var audioChunks = [];
        //var rec;
        console.log("setup()");
        navigator.mediaDevices.getUserMedia({audio:true})
            .then(stream => {
                console.log("getUserMedia_success, stream", stream);
                let rec = new MediaRecorder(stream);
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

                        // axios({
                        //     method: "post",
                        //     url: "/convert",
                        //     data: {
                        //         data: e
                        //     }
                        // });

                    //var blob = response.blob;
                    }
                }
            })
            .catch(e=>console.log(e));
    }
}

    
</script>