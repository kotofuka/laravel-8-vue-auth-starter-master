<template>
    <div class="container">
        <button @click="setup">Начать работу</button>
        <button @click="startRecord">Начать запись</button>
        <button @click="pauseRecord">Приостановить запись</button>
        <button @click="stopRecord">Завершить запись</button>
    </div>
</template>

<script>

import axios from "axios";
import Vue from "vue"

export default {
    // props: {
    //     record: {type: MediaRecorder | null, default: null}
    // },
    // data: function(){
    //     return {
    //         record: this.record,
    //     }
    // },
    methods: {
        startRecord: function(){
            console.log("Start operation");
            this.record.start();
        },

        stopRecord: function(){
            console.log("Stop operation");
            this.record.stop();
        },

        pauseRecord: function(){
            console.log("Pause operation");
            this.record.pause();
        },

        blobToFile(blob, fileName){
            let b = blob;
            b.name = fileName;
            b.lastModifiedDate = new Date();
            return blob;
        },

        setup: function(){
            var audioChunks = [];
            //var rec;
            navigator.mediaDevices.getUserMedia({audio:true})
                .then(stream => {
                    console.log("getUserMedia_success, stream", stream);
                    this.record = new MediaRecorder(stream);
                    console.log("MediaRecorder:", this.record);
                    this.record.ondataavailable = e => {
                        console.log("e:", e);
                        audioChunks.push(e.data);
                        //console.log("type:", typeof(e))
                        if (this.record.state == "inactive"){
                            console.log("завершенный файл", e.data);
 
                            let formData = new FormData();
                            formData.append("voice", e.data);
                            return axios.post("/convert", formData, {
                                headers: {
                                    "Content-Type": "multipart/form-data",
                                },
                            });
                        }
                    }
                })
                .catch(e=>console.log(e));
        
        },
    }
}

    // var audioChunks = [];
    // //var rec;
    // navigator.mediaDevices.getUserMedia({audio:true})
    //     .then(stream => {
    //         console.log("getUserMedia_success, stream", stream);
    //         this.record = new MediaRecorder(stream);
    //         console.log("MediaRecorder:", this.record);
    //         this.record.ondataavailable = e => {
    //             console.log("e:", e);
    //             audioChunks.push(e.data);
    //             console.log("type: ", typeof(e))
    //             if (this.record.state == "inactive"){
    //             console.log("завершенный файл", e.data);
    //             //    let response = fetch('/convert', {
    //             //     method: "post",
    //             //     body: e
    //             //    }).catch(function(e){
    //             //     console.log("error: " + e);
    //             //    });
    //             //console.log("fetch was done");

    //                 // axios({
    //                 //     method: "post",
    //                 //     url: "/convert",
    //                 //     data: {
    //                 //         data: e
    //                 //     }
    //                 // });

    //             //var blob = response.blob;
    //             }
    //         }
    //     })
    //     .catch(e=>console.log(e));



    

</script>