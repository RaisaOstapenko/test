<?PHP
function getFilesSize($path)
{
$fileSize = 0;
$dir = scandir($path);
foreach($dir as $file)
{
if (($file!='.') && ($file!='..'))
if(is_dir($path . '/' . $file))
$fileSize += getFilesSize($path.'/'.$file);
else
$fileSize += filesize($path . '/' . $file);
}
return $fileSize;
}
?>