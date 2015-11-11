<?php 

if (count($argv) != 2)
    exit;

$fileSystemFunctions = ["basename", "chgrp", "chmod", "chown", "clearstatcache", "copy", "delete", 
    "dirname", "disk_free_space", "disk_total_space", "diskfreespace", "fclose", "feof", "fflush", 
    "fgetc", "fgetcsv", "fgets", "fgetss", "file_exists", "file_get_contents", "file_put_contents", 
    "file", "fileatime", "filectime", "filegroup", "fileinode", "filemtime", "fileowner", "fileperms", 
    "filesize", "filetype", "flock", "fnmatch", "fopen", "fpassthru", "fputcsv", "fputs", "fread", 
    "fscanf", "fseek", "fstat", "ftell", "ftruncate", "fwrite", "glob", "is_dir", "is_executable", 
    "is_file", "is_link", "is_readable", "is_uploaded_file", "is_writable", "is_writeable", "lchgrp", 
    "lchown", "link", "linkinfo", "lstat", "mkdir", "move_uploaded_file", "parse_ini_file", 
    "parse_ini_string", "pathinfo", "pclose", "popen", "readfile", "readlink", "realpath_cache_get", 
    "realpath_cache_size", "realpath", "rename", "rewind", "rmdir", "set_file_buffer", "stat", 
    "symlink", "tempnam", "tmpfile", "touch", "umask", "unlink"];

function checkFileSystemCalls($path, $fileSystemFunctions)
{
    $fileBody = file_get_contents($path);

    $usedFunctions = [];
    foreach ($fileSystemFunctions as $fileSystemFunction) {
        if (strpos($fileBody, "$fileSystemFunction(")) {
            $usedFunctions[] = $fileSystemFunction;
        }
    }
    if (count($usedFunctions) > 0)
      echo $path . ' : ' . implode(',', $usedFunctions) . PHP_EOL;
}

$directory = new RecursiveDirectoryIterator($argv[1]);

foreach (new RecursiveIteratorIterator($directory) as $filename=>$current) {
    if (is_file($current->getPathName()) === false)
        continue;

    checkFileSystemCalls($current->getPathName(), $fileSystemFunctions);
}
