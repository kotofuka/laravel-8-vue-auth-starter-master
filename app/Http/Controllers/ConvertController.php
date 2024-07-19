<?php

namespace App\Http\Controllers;

use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Mp3;
use FFMpeg\Format\Audio\Wav;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class ConvertController extends Controller
{
    public function convertWebmToWav(){
        $ffmpeg = FFMpeg::create([
            'ffmpeg.binaries'  => 'C:\FFmpeg\ffmpeg.exe',
            'ffprobe.binaries' => 'C:\FFmpeg\ffprobe.exe'
        ]);
        Log::info("convert");
        Log::info(request()->all());
        Log::info($_FILES);
        $file = $_FILES["voice"];
        $blob = file_get_contents($file['tmp_name']);
        file_put_contents('audio_file.webm', $blob);

        $audio = $ffmpeg->open('audio_file.webm');
        $audio->save(new Mp3(), 'export-mp3.mp3');
        Log::info("mp3 сформирован");
        
        // запуск скрипта на python
        set_time_limit(0);
        //shell_exec("whisper export-wav.wav --language ru --model medium");
        file_put_contents("export-mp3.txt", "");
        shell_exec('C:\Users\Pavel\Downloads\WhisperCMD\main.exe -gpu "AMD Radeon(TM) Graphics" --language ru -m C:\Users\Pavel\Downloads\WhisperCMD\ggml-medium.bin -f export-mp3.mp3 -otxt -nt');

        Log::info("текст переведен");
        $text = file_get_contents('export-mp3.txt');
        Log::info($text);
        

        return response()->json(['text' => $text]);

    }

    public function send(){
        // не используется
        # IAM-token
        $token = "t1.9euelZqRjo_Ml8aem5DNncbHjp2Tme3rnpWak5HKnpSXnp2RzMqcx5XKlsfl8_cnPSFL-e9nRRVu_N3z92drHkv572dFFW78zef1656VmsqUkYyVkpiai5bKk46Nx8iJ7_zF656VmsqUkYyVkpiai5bKk46Nx8iJ.2jcwn8mOKaW9E6P2UXEA-l4AiPdIlLb1XIF_oDyvBJeugwgOBic5Q2ND0JZQPsdAYenLY-SbBdsVhkLijd7EBA"; 

        # Идентификатор каталога
        $folderId = "b1g22jop7gsd5g2fuv3b";
        $url = "stt.api.cloud.yandex.net/speech/v1/stt:recognize";
        $fileName = "export-wav.wav";

        $file = fopen($fileName, "rb");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://stt.api.cloud.yandex.net/speech/v1/stt:recognize?lang=ru-RU&folderId=${folderId}&format=oggopus");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);

        curl_setopt($ch, CURLOPT_INFILE, $file);
        curl_setopt($ch, CURLOPT_INFILESIZE, filesize($fileName));
        $res = curl_exec($ch);
        curl_close($ch);
        $decodedResponse = json_decode($res, true);

        Log::info("Result");
        Log::info($decodedResponse);

        



    }
}
