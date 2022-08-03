<?php

namespace app\utils;

class ConstantUtil
{
    public static function rootDir():string {
        return dirname(__DIR__); // D:\PHP\PHPMVCFramework
    }

    public static function autoImportDir(array $dirs) {
        foreach ($dirs as $dir) {
            $dirName = !is_string($dir) ? $dir[0] : $dir;
            $skip = !is_string($dir) ? $dir[1] : false;
            $files = scandir(dirname(__DIR__) . '/'.$dirName);
            foreach ($files as $file) {
                if ($file === '.'  ||
                    $file === '..' ||
                    !is_file(dirname(__DIR__) . '/'.$dirName.'/' . $file) ||
                    (is_array($skip) && in_array($file, $skip))
                ){
                    continue;
                }
                require_once dirname(__DIR__) . '/'. $dirName .'/' . $file;
            }
        }
    }


    public static function findProperty(array $conditions) { // ['column', 'operator', 'value']
        $where = " WHERE ";
        foreach ($conditions as $index =>$condition) {
            $column = $condition['column'];
            $operator = $condition['operator'];
            $value = $condition['value'];
            switch ($operator) {
                case '=':
                    $where .= "$column = $value";
                    break;
                case 'like':
                    $where .= "$column LIKE '%$value%'";
                    break;
                case '>':
                    $where .= "$column > $value";
                    break;
                case '<':
                    $where .= "$column < $value";
                    break;
                case '>=':
                    $where .= "$column >= $value";
                    break;
                case '=<':
                    $where .= "$column =< $value";
                    break;
            }
            if($index !== count($conditions) - 1) {
                $where .= " AND ";
            }
        }
        return $where;
    }
}