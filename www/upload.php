<?php

namespace surrogator;

require '../vendor/autoload.php';

$cfgFile = __DIR__ . '/../data/surrogator.config.php';
if (!file_exists($cfgFile)) {
    $cfgFile = '/etc/surrogator.config.php';
    if (!file_exists($cfgFile)) {
        err(
            500,
            "Configuration file does not exist.",
            "Copy data/surrogator.config.php.dist to data/surrogator.config.php"
        );
        exit(2);
    }
}
require $cfgFile;
require __DIR__ . '/shib_attr.php';

$storage = new \Upload\Storage\FileSystem($rawDir,true);
$file = new \Upload\File('profileFile', $storage);

// Optionally you can rename the file on upload

$file->setName($shib_mail);

// Validate file upload
// MimeType List => http://www.iana.org/assignments/media-types/media-types.xhtml
$file->addValidations(array(
    // Ensure file is of type "image/png or jpeg"
    new \Upload\Validation\Mimetype(array('image/png', 'image/jpeg')),
    new \Upload\Validation\Size('5M')
));

// Access data about the file that has been uploaded
$data = array(
    'name'       => $file->getNameWithExtension(),
    'extension'  => $file->getExtension(),
    'mime'       => $file->getMimetype(),
    'size'       => $file->getSize(),
    'md5'        => $file->getMd5(),
    'dimensions' => $file->getDimensions()
);

// Try to upload file
try {
    // Success!
    shell_exec('rm ' . __DIR__ . '/../raw/' . $shib_mail . '.*');
    $file->upload();
	$output = shell_exec('php ' . __DIR__ . '/../surrogator.php ');

	$results = array(
    	'status'  => 'ok',
    	'file_data' => $data,
		'surroggator' => $output
	);

	echo json_encode($results);


} catch (\Exception $e) {
    // Fail!
    $errors = $file->getErrors();

	$results = array(
    	'status'  => 'error',
    	'error' => $errors
	);

	echo json_encode($results);

}



?>
