<?php

namespace common\helpers;

class FolderManager
{

    public static function makeDirectory($alias, $path, $gitignore = true)
    {

        if ($alias == '@api' || $alias == '@backend' || $alias == '@frontend') {
            $fullpath = \Yii::getAlias($alias) . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR;
        } else {
            $fullpath = \Yii::getAlias('@web');
        }

        $fullpath .= $path;

        if (!is_dir($fullpath)) {
            mkdir($fullpath, 0755, true);

            echo is_file($fullpath . DIRECTORY_SEPARATOR . '.gitignore');
            if ($gitignore) {
                self::overwriteFile($fullpath . DIRECTORY_SEPARATOR . '.gitignore', '*' . PHP_EOL . '!.gitignore');
            }
        }
    }

    public function overwriteFile($filepath, $content)
    {
        $myfile = fopen($filepath, "w") or die("Unable to open file!");
        fwrite($myfile, $content);
        fclose($myfile);
    }
}