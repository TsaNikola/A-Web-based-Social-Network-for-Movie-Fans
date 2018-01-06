<?php // trap for bad bots
$htaccess = "/var/www/public_html/.htaccess"; // specify correct path to root .htaccess file
$content  = "SetEnvIf Remote_Addr ^".str_replace(".",'\.',$_SERVER["REMOTE_ADDR"])."$ goodbye\r\n";
$handle   = fopen($htaccess, 'r');
$content .= fread($handle, filesize($htaccess));
fclose($handle);
$handle = fopen($htaccess, 'w+');
fwrite($handle, $content, strlen($content));
fclose($handle);

$txt.=
   "
----------------------------------------------------------------------------".
   "Banned IP: "  . $_SERVER["REMOTE_ADDR"] . "\r\n" .
    "User Agent: " . $_SERVER["HTTP_USER_AGENT"] . "\r\n" .
    "Referrer: "   . $_SERVER["HTTP_REFERER"]."
----------------------------------------------------------------------------
";

$myfile = fopen(getcwd()."/blocked-bots.txt", "a+") or die("Unable to open file");
fwrite($myfile, $txt);
fclose($myfile);
die("Sorry no access.");
?>