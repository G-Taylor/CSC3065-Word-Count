<?php
// get count of words
function wordcount($text)
{
    // remove all numbers from the sentence
    $text = preg_replace('/[0-9]+/', "", $text);

    // remove trailing, leading and multiple whitespace
    $text = preg_replace('/\s+/', ' ', trim($text));

    // split sentence into individual words in an array
    $words = explode(" ", $text);

    return count($words);
}