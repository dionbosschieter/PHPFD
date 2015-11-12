<?php

namespace phpfd\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class FileSystemDetector extends Command
{

    private $fileSystemFunctions = ["basename", "chgrp", "chmod", "chown", "clearstatcache", "copy", "delete", 
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

    protected function configure()
    {
        $this
            ->setName('find')
            ->setDescription('Searches php files in a given path (current path by default)');

        $this->addOption('path', 'p', InputOption::VALUE_REQUIRED, '', getcwd());
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $directory = new RecursiveDirectoryIterator($input->getOption('path'));

        foreach (new RecursiveIteratorIterator($directory) as $filename=>$current) {
            if (is_file($current->getPathName()) === false)
                continue;

            $output->writeln($this->checkFileSystemCalls($current->getPathName()));
        }
    }

    /**
     * @return string
     */
    private function checkFileSystemCalls($path)
    {
        $fileBody = file_get_contents($path);

        $functions = [];
        foreach ($this->fileSystemFunctions as $fileSystemFunction) {
            if (strpos($fileBody, "$fileSystemFunction(")) {
                $functions[] =  "$fileSystemFunction()";
            }
        }
        if (count($functions) > 0)
            return $path . ' : ' . implode(',', $functions);

        return null;
    }
}
