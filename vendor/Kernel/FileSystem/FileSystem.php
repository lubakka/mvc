<?php
/**
 * Created by PhpStorm.
 * User: lboykov
 * Date: 15-1-25
 * Time: 18:11
 */

namespace Kernel\FileSystem;

class FileSystem {

    public function __construct(){

    }

    public function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new \InvalidArgumentException(sprintf('"%s" must be a directory.', $dirPath));
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                $this->deleteDir($file);
            } else {
                if (true !== @unlink($file)) {
                    throw new \Exception(sprintf('Failed to remove file "%s".', $file));
                }
            }
        }
        if (true !== @rmdir($dirPath)) {
            throw new \Exception(sprintf('Failed to remove directory "%s".', $dirPath));
        }

        //return $this;
    }

    public function deleteFile($file){
        if (!is_file($file)){
            throw new \InvalidArgumentException(sprintf('"%s" must be a file.', $file));
        }
        if (true !== @unlink($file)) {
            throw new \Exception(sprintf('Failed to remove file "%s".', $file));
        }
        return $this;
    }
}