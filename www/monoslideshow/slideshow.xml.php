<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache');
echo('<?xml version="1.0" encoding="utf-8"?>' . chr(10));
?>
<slideshow>	
	<preferences kenBurnsMode="random" controlAlpha="50" controlAutoHide="true" showControls="false" controlDelay="3" controlLineWidth="2" controlRoundedCorners="10"/>
	<album thumbnail="images/logo.png" title="Construtora Resgate" description="Slideshow Resgate" imagePath="images/slides" thumbnailPath="images/slides">
<?php
$d = dir("../images/slides");
while (false !== ($arquivo = $d->read())) {
	if(($arquivo != ".") && ($arquivo != "..") && ($arquivo != "album.jpg"))
    echo(chr(9) . chr(9) . '<img src="' . $arquivo.'"/>' . chr(10));
}
$d->close();
?>	</album>	
</slideshow>