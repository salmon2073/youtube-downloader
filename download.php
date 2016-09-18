<?php
error_reporting(0);
set_time_limit(0);
$dlStart = false;
$command = "youtube-dl --newline ".$_REQUEST["url"]." 2>&1 &";
$handle = popen($command,'r');

echo "<!DOCTYPE html>\n";
echo "<html>\n";
echo "<head>\n";
echo "<meta charset='utf-8'>\n";
echo "</head>\n";
echo "<body>\n";
echo "<p>ダウンロードを開始します</p>\n";


while(!feof($handle)) {

    $log = fgets($handle);
    $log =  str_replace(array("\r\n", "\r", "\n"), '', $log);

    if(preg_match('/\[download\]/',$log)){
        if(!$dlStart){
            echo "<p><div id='progress'></div></p>\n";
            $dlStart = true;
        }
        echo "<script>document.getElementById( 'progress' ).innerHTML = '{$log}';</script>\n";
        ob_flush();
        flush();
    }else if(preg_match('/WARNING/',$log)){
        
    }else{
        echo "<p>".$log."</p>\n";
        ob_flush();
        flush();
    }      
}

pclose($handle);
echo "<p>処理が終了しました</p>\n";
echo "</body>\n";
echo "</html>";
?>