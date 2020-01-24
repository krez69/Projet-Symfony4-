<?php


namespace App\Service;


class Slugify
{
    public function generate(string $input): string
    {

        $input = preg_replace('#[^\\pL\d]+#u', '-', $input);
        $input= trim($input, '-');
        if (function_exists('iconv'))
        {
            $input = iconv('utf-8', 'us-ascii//TRANSLIT', $input);
        }
        $input = strtolower($input);
        $input = preg_replace('#[^-\w]+#', '', $input);
        if (empty($input))
        {
            return 'n-a';
        }
        return $input;
    }
}