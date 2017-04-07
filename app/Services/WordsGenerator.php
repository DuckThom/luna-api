<?php

namespace App\Services;

class WordsGenerator
{
    /**
     * Get the list of words
     *
     * @return \stdClass
     */
    public static function getWordList()
    {
        return json_decode(
            file_get_contents(base_path('resources/word-list.json')),
            true
        );
    }

    /**
     * Create a nice string
     *
     * @param  int  $adjectives
     * @param  int  $animals
     * @return string
     */
    public static function make(int $adjectives = 2, int $animals = 1): string
    {
        $words = static::getWordList();
        $string = '';

        for ($adjective = 0; $adjective < $adjectives; $adjective++) {
            $string .= ucfirst($words['adjectives'][array_rand($words['adjectives'])]);
        }

        for ($animal = 0; $animal < $animals; $animal++) {
            $string .= ucfirst($words['animals'][array_rand($words['animals'])]);
        }

        return $string;
    }
}