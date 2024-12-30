<?php

namespace App\Library;

class Filter
{


    public function cleanKey($key)
    {


        if ($key == "")
        {
            return "";
        }

        $key = htmlspecialchars(urldecode($key));
        $key = preg_replace( "/\.\./"           , ""  , $key );
        $key = preg_replace( "/\_\_(.+?)\_\_/"  , ""  , $key );
        $key = preg_replace( "/^([\w\.\-\_]+)$/", "$1", $key );

        return $key;
    }

    public function cleanValue($text)
    {

        // exit($text);

        if ($text == "")
        {
            return "";
        }

        $text = str_replace( "&#032;", " ", $text );
        $text = str_replace( "&"            , "&amp;"         , $text );
        $text = str_replace( "<!--"         , "&#60;&#33;--"  , $text );
        $text = str_replace( "-->"          , "--&#62;"       , $text );
        $text = preg_replace( "/<script/i"  , "&#60;script"   , $text );
        $text = str_replace( ">"            , "&gt;"          , $text );
        $text = str_replace( "<"            , "&lt;"          , $text );
        $text = str_replace( "\""           , "&quot;"        , $text );
        $text = preg_replace( "/\n/"        , "<br />"        , $text ); // Convert literal newlines
        $text = preg_replace( "/\\\$/"      , "&#036;"        , $text );
        $text = preg_replace( "/\r/"        , ""              , $text ); // Remove literal carriage returns
        $text = str_replace( "!"            , "&#33;"         , $text );
        $text = str_replace( "'"            , "&#39;"         , $text ); // IMPORTANT: It helps to increase sql query safety.
        $text = preg_replace( "/\\\(?!&amp;#|\?#)/", "&#092;", $text );

        return $text;
    }



    public  function ipCleaner( $input )
    {
        $input = preg_replace("/([^0-9.])/", "", $input);

        return $input;
    }

    public function md5Cleaner( $input )
    {
        $input = preg_replace("/([^a-zA-Z0-9])/", "", $input);

        return $input;
    }

    public function numberFormat( $number, $type = "," )
    {


        $number = number_format( round( $number ), 0, ' ', $type );

        return $number;
    }


}

?>