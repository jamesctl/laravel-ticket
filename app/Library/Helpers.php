<?php

namespace App\Library;

class Helpers
{


    static function permissionTd($name = "", $key = "", $color = "#EEEEEE") {


    $output = "";
    if ($key) {
        if ($key == "1") {
            $output .= <<<EOF
    <td><div style="padding-left: 2px; padding-right: 2px; text-align: center; cursor: pointer; background: {$color}; border: solid #3c8dbc 1px;">{$name} </div></td>
EOF;
        }else {
            $output .= <<<EOF
    <td><div onclick="checkbox('{$key}');" style="padding-left: 2px; padding-right: 2px; text-align: center; cursor: pointer; background: {$color}; border: solid #3c8dbc 1px;">{$name} <input type="checkbox" name="{$key}" id="{$key}" value="1" onmouseover="on_mouse=1;" onmouseout="on_mouse=0;"></div></td>
EOF;
        }
    } else if (!$name) {

        $output .= <<<EOF
    <td></td>
EOF;
    } else {

        $output .= <<<EOF
    <td><div style="padding-left: 2px; padding-right: 2px; text-align: center; background: #EEEEEE; border: solid #3c8dbc 1px; font-weight: bold; padding:4px;">{$name}</div></td>
EOF;
    }

    return $output;
}
}
