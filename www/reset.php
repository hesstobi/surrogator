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

list($md5, $sha256) = getHashes($shib_mail);

shell_exec('rm -r ' . $varDir . '*/' . $md5 . '.*');
shell_exec('rm -r ' . $varDir . '*/' . $sha256 . '.*');
shell_exec('rm ' . $varDir . 'square/' . $shib_mail . '.*');
shell_exec('rm ' . $rawDir . $shib_mail . '.*');
shell_exec('git -C ' . $rawDir . ' checkout -- ' . $shib_mail . '.*');
shell_exec('php ' . __DIR__ . '/../surrogator.php ');

$results = array(
	'status'  => 'ok',
);

echo json_encode($results);

function getHashes($emailAddress)
{
    return array(
        md5($emailAddress), hash('sha256', $emailAddress)
    );
}


?>
