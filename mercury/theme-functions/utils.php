<?php
function renderBreakTagInString($string)
{
    $wordToFind  = "##";
    $replace = "<br>";
    return str_replace($wordToFind, $replace, $string);
}