<?php

namespace Adwisemedia\Utilities;

class Dir
{
    /**
     * List directory
     *
     * @param type $dirpath
     * @return array
     */
    public static function list($dirpath, $get = 'all', $exclude = [])
    {
        if (! is_dir($dirpath) || ! is_readable($dirpath)) {
            $error = __FUNCTION__ . ": Argument should be a path to valid,";
            $error .= " readable directory (" . var_export($dirpath, true) . " provided)";

            error_log($error);
            return null;
        }

        $paths = [];
        $dir = realpath($dirpath);
        $dh = opendir($dir);
        $ignore = ['.', '..', '.DS_Store'];

        while (( $f = readdir($dh) ) !== false) {
            if (! in_array($f, $ignore)) {
                $item = "$dir" . DIRECTORY_SEPARATOR . "$f";

                switch ($get) {
                    case 'directories':
                        if (is_dir($item) && ! in_array($f, $exclude)) {
                            $paths[] = $item;
                        }
                        break;

                    case 'files':
                        if (! is_dir($item) && ! in_array($f, $exclude)) {
                            $paths[] = $item;
                        }
                        break;

                    default:
                        if (! in_array($f, $exclude)) {
                            $paths[] = $item;
                        }
                        break;
                }
            }
        }

        closedir($dh);
        return $paths;
    }
}
