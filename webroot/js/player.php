<?php
$url= $_GET['url'];
$players = explode("/",parse_url($url)['path'])[3];
?>
<?php
header('Content-Type: text/javascript');
$drive = "var playerInstance = jwplayer('VoHuuNhan');
playerInstance.setup({
width: '100%',
height: '100%',
title: '',
controls: true,
displaytitle: false,
aspectratio: '16:9',
fullscreen: 'true',
primary: 'html5',
mute: false,
provider: 'http',
sources: [
{file: 'https://www.googleapis.com/drive/v3/files/$players?alt=media&key=AIzaSyDdoetN4aDmDBc6Y11CUGK4nhZ0pvZbXOw',type: 'mp4',label: '1080'}
],
        abouttext: 'Developer By Võ Hữu Nhân',
        aboutlink: 'https://www.facebook.com/SPT.Nhan'
    
    });";
$mp4 = "var playerInstance = jwplayer('VoHuuNhan');
playerInstance.setup({
width: '100%',
height: '100%',
title: '',
controls: true,
displaytitle: false,
aspectratio: '16:9',
fullscreen: 'true',
primary: 'html5',
mute: false,
provider: 'http',
sources: [
{file: '$url',type: 'mp4',label: '1080'}
],
        abouttext: 'Developer By Võ Hữu Nhân',
        aboutlink: 'https://www.facebook.com/SPT.Nhan'
});";
?>
<?php
$nhan = $_GET['url'];
if (strpos($nhan, 'https://drive.google.com') !== false) {
echo $drive;}
if (strpos($nhan, '.mp4') !== false) {
echo $mp4;}
if (strpos($nhan, 'fembed.com') !== false) {
$style = 'top:0;left:0;width:100%;height:100%';
echo 'document.getElementById("VoHuuNhan").innerHTML = "<iframe style='.$style.' src='.$url.'></iframe>";';
}
if (strpos($nhan, 'youtube.com') !== false) {
echo 'document.getElementById("VoHuuNhan").innerHTML = "<iframe width="100%" height="100%" src='.$url.' frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>";';
}

?>