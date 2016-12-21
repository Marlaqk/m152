<?php

if ( !empty( $_FILES ) ) {
    echo 'Hello';
    $tempPath = $_FILES[ 'file' ][ 'tmp_name' ];
    $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);;
    echo 'ralph';
    echo $type;
    $uploadPath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $_FILES[ 'file' ][ 'name' ];
    
    if (!file_exists(dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $type)) {
        mkdir(dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $type, 0777, true);
    }
    move_uploaded_file( $tempPath, $uploadPath );
    if ($type == 'jpeg' || $type == 'jpg'){
        make_thumb($uploadPath, dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR .'thump-'.$_FILES[ 'file' ][ 'name' ], 100, dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR);
    }
    $answer = array( 'answer' => 'File transfer completed' );
    $json = json_encode( $answer );

    echo $json;

} else {

    echo 'No files';

}
function make_thumb($src, $destname, $desired_width, $pathUp) {
    // here I use PHP GD2 library, mit dieser Library öffnet verschiedene möglichkeiten im bereich image editing or information get.
    echo 'helloMakeThumb';
	/* read the source image */
	$source_image = imagecreatefromjpeg($src);
	$width = imagesx($source_image);
	$height = imagesy($source_image);
	
	/* find the "desired height" of this thumbnail, relative to the desired width  */
	$desired_height = floor($height * ($desired_width / $width));
	
	/* create a new, "virtual" image */
	$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
	
	/* copy source image at a resized size */
	imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
	
	/* create the physical thumbnail image to its destination */
	imagejpeg($virtual_image, $destname);

    // wir erstellen ein Wasserzeichen mit GD
    $stamp = imagecreatetruecolor(100, 70);
    imagefilledrectangle($stamp, 0, 0, 150, 150, 0xFFFFFF);
    imagestring($stamp, 5, 0, 20, 'Ralph Scheu', 0x0000FF);
    imagestring($stamp, 3, 0, 40, '(c) 2016-11-29', 0x0000FF);

    // Ränder setzen, Dimensionen ermitteln
    $marge_right = 10;
    $marge_bottom = 10;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);

    // Wasserzeichen mit einer Transparenz von 50% über das Foto legen
    imagecopymerge($source_image, $stamp, imagesx($source_image) - $sx - $marge_right, imagesy($source_image) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 50);

    // Bild speichern, aufräumen
    imagepng($source_image, $pathUp.'photo_stamp.png');
    imagedestroy($source_image);
}
?>