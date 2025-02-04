<?php

namespace Dipta995\LaravelCodiceFiscale;

class CodiceFiscale
{
    protected $jsonPath;

    public function __construct()
    {
        // Set the path to the JSON file within the package
        $this->jsonPath = __DIR__ . '/../resources/data.json';
    }

    /**
     * Retrieve and decode JSON data.
     *
     * @return array
     * @see LUOGO_NASCITA
     */
    public function getJsonData()
    {
        if (file_exists($this->jsonPath)) {
            $content = file_get_contents($this->jsonPath);
            $data = json_decode($content, true);
            return $data ?: [];
        }

        return [];
    }

    /**
     * Process four parameters.
     *
     * @param mixed $surname
     * @param mixed $name
     * @param mixed $dob
     * @param mixed $gender
     * @param mixed $placeCode
     * @return array
     */
    public static function generateCodiceFiscale($surname, $name, $dob, $gender, $placeCode)
    {
        $surnameCode = self::extractCode($surname);
        $nameCode = self::extractCode($name, true);
        $dobCode = self::getDateCode($dob, $gender);

        $partialCode = strtoupper($surnameCode . $nameCode . $dobCode . $placeCode);
        $controlChar = self::getControlCharacter($partialCode);

        return $partialCode . $controlChar;
    }

    private static function extractCode($string, $isName = false)
    {
        $consonants = preg_replace('/[^BCDFGHJKLMNPQRSTVWXYZ]/i', '', $string);
        $vowels = preg_replace('/[^AEIOU]/i', '', $string);

        if ($isName && strlen($consonants) >= 4) {
            $consonants = $consonants[0] . $consonants[2] . $consonants[3];  // Skip 2nd consonant
        }

        $code = substr($consonants . $vowels . 'XXX', 0, 3);
        return strtoupper($code);
    }

    private static function getDateCode($dob, $gender)
    {
        $months = ['A', 'B', 'C', 'D', 'E', 'H', 'L', 'M', 'P', 'R', 'S', 'T'];
        $date = date_create($dob);

        $year = date_format($date, 'y');
        $month = $months[(int)date_format($date, 'm') - 1];
        $day = (int)date_format($date, 'd');

        if (strtoupper($gender) === 'F') {
            $day += 40;
        }

        return $year . $month . str_pad($day, 2, '0', STR_PAD_LEFT);
    }

    private static function getControlCharacter($code)
    {
        // Values for odd and even positions
        $oddValues = [
            '0' => 1,  '1' => 0,  '2' => 5,  '3' => 7,  '4' => 9,
            '5' => 13, '6' => 15, '7' => 17, '8' => 19, '9' => 21,
            'A' => 1,  'B' => 0,  'C' => 5,  'D' => 7,  'E' => 9,
            'F' => 13, 'G' => 15, 'H' => 17, 'I' => 19, 'J' => 21,
            'K' => 2,  'L' => 4,  'M' => 18, 'N' => 20, 'O' => 11,
            'P' => 3,  'Q' => 6,  'R' => 8,  'S' => 12, 'T' => 14,
            'U' => 16, 'V' => 10, 'W' => 22, 'X' => 25, 'Y' => 24,
            'Z' => 23
        ];

        $evenValues = [
            '0' => 0,  '1' => 1,  '2' => 2,  '3' => 3,  '4' => 4,
            '5' => 5,  '6' => 6,  '7' => 7,  '8' => 8,  '9' => 9,
            'A' => 0,  'B' => 1,  'C' => 2,  'D' => 3,  'E' => 4,
            'F' => 5,  'G' => 6,  'H' => 7,  'I' => 8,  'J' => 9,
            'K' => 10, 'L' => 11, 'M' => 12, 'N' => 13, 'O' => 14,
            'P' => 15, 'Q' => 16, 'R' => 17, 'S' => 18, 'T' => 19,
            'U' => 20, 'V' => 21, 'W' => 22, 'X' => 23, 'Y' => 24,
            'Z' => 25
        ];

        $sum = 0;
        for ($i = 0; $i < strlen($code); $i++) {
            $char = $code[$i];
            if (($i + 1) % 2 === 1) {  // Odd positions (1-based index)
                $sum += $oddValues[$char] ?? 0;
            } else {                  // Even positions
                $sum += $evenValues[$char] ?? 0;
            }
        }

        $controlChar = chr(($sum % 26) + ord('A'));
        return $controlChar;
    }
}
