<?php

/**
 * ApplicationController is the main class needed for the system to function.
 * It is here where the top-level functions and methods are written to use in the program.
 * It's also here where the PageController object is created.
 */

class ApplicationController extends ApplicationModel
{
    public function __construct()
    {
        new PageController();
    }

    /**
     * @param $name // Name of svg
     * @return bool|string // Returns the svg
     *
     * This method returns and loads an svg by given name from the img/svg folder.
     */

    public static function load_svg($name): bool|string
    {
        $file = BASEDIR . SVG . $name . '.svg';
        if (file_exists($file)) return file_get_contents($file);
        else {
            echo $file;
            exit;
        }
    }

    /**
     * @param $raw_data // Input data
     * @return string // Output sting
     *
     * Check the string and sanitize it for non-html characters
     */

    public static function sanitize($raw_data): string
    {
        $data = htmlspecialchars($raw_data);
        return self::escape($data);
    }

    /**
     * @param $value // Input value from sanitize function
     * @return string // Output string
     *
     * Further checks for illegal use of symbols and characters in the input.
     */

    public static function escape($value): string
    {
        $return = '';
        for ($i = 0; $i < strlen($value); ++$i) {
            $char = $value[$i];
            $ord = ord($char);
            if ($char !== "'" && $char !== "\"" && $char !== '\\' && $ord >= 32 && $ord <= 126) $return .= $char;
            else $return .= '\\x' . dechex($ord);
        }
        return $return;
    }
}