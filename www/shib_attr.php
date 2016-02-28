
<?php

$shib_provider = $_SERVER["Shib-Identity-Provider"] ?: "None";
$shib_id =  $_SERVER["Shib-Application-ID"] ?: "None";
$shib_session = $_SERVER["Shib-Session-ID"] ?: "None";
$shib_eppn =   $_SERVER["eppn"] ?: "muster";
$shib_sn =  $_SERVER["sn"] ?: "Mustermann";
$shib_givenName =  $_SERVER["givenName"] ?: "Max";
$shib_displayName =  $_SERVER["displayName"] ?: "Max Mustermann";
$shib_mail =   $_SERVER["mail"] ?: "max.mustermann@tu-dresden.de";
$shib_affiliation =   $_SERVER["affiliation"] ?: "member@tu-dresden.de";

?>
