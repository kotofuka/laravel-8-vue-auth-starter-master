

<template>
    <div class="container">
        <button @click="setup">Начать работу</button>
        <button @click="startRecord">Начать запись</button>
        <button @click="pauseRecord">Приостановить запись</button>
        <button @click="stopRecord">Завершить запись</button>
        <button @click="voiceStart">Начать работу с помощником</button>

        <div v-if="corrs['text'] !== undefined">
           
            <input v-model="text_input" id="textfield"></input>
        </div>
    </div>
</template>

<script>

import axios from "axios";
import Vue from "vue"
import Artyom from "artyom.js"


export default {
    data () {
        return {
            text_input:null,
            corrs: [],
            Jar: new Artyom()
        }
    },
    methods: {

        text_input_func: function(){

            this.text_input=this.corrs['text'];
            console.log("text", this.text_input);
            // if (this.corrs['text'] !== ""){
            //     console.log("text", this.corrs['text']);
            //     console.log("document value", document.getElementById('textfield'));
            //     document.getElementById("textfield").value = this.corrs['text'];
            // }
        },

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
        
        // точка входа
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
                            }).then(response => {
                                console.log(response.data);
                                this.corrs = response.data;
                                console.log("corrs text field:", this.corrs['text']);
                                if (this.corrs['text'] !== undefined){
                                    this.text_input_func();
                                }
                                //console.log("len of obj 'corrs':", Object.keys(this.corrs).len);

                            }).catch(err => {
                                console.log("Error:", err);
                            });
                        }
                    }
                })
                .catch(e=>console.log(e));
        
        },

        voiceStart: function(){
            this.Jar.on(["старт", "стоп", "закончить", "подготовиться"]).then((i) => {
                switch (i){
                    case 0:
                        this.startRecord();
                        break;
                    
                    case 1:
                        this.pauseRecord();
                        break;
                    
                    case 2:
                        this.stopRecord();
                        break;
                    
                    case 3:
                        this.setup();
                }
            });
            
            this.Jar.initialize({
                lang: "ru-Ru",
                continuous: true,
                soundex: true,
                debug:true,
                executionKeyWord: "приступим",
                listen: true,
                name: "Волга"
            }).then(() => {
                console.log("Jar has been succesfully inintialized");
            }).catch((err) => {
                console.log("Jar couldn't be initialized: ", err);
            });
            
        }
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