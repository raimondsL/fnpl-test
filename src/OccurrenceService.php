<?php

class OccurrenceService
{
    private $letters = 'abcdefghijklmnopqrstuvwxyz';
    private $punctuations = '.?!,:;-[]{}()\'"';
    private $symbols = '#$%&*+\/<=>@^_`|~';
    private $lettersData = [];
    private $punctuationsData = [];
    private $symbolsData = [];
    private $regex = '/[^[:punct:][:lower:]]/';

    // Condition #4
    public function checkOccurrence(&$text, string $format, $includeLetter = false, $includePunctuation = false, $includeSymbol = false)
    {
        if (!strlen($text)) {
            echo "Error: text not found!\n";
            return false;
        }

        if (preg_match($this->regex, $text)) {
            echo "Error: unvalid characters found!\n";
            return false;
        }

        if (!in_array($format, ['non-repeating', 'least-repeating', 'most-repeating'])) {
            echo "Error: allowed formats [non-repeating, least-repeating, most-repeating]\n";
            return false;
        }

        if (!($includeLetter || $includePunctuation || $includeSymbol)) {
            echo "Error: at least one option must be provided [include-letter, include-punctuation, include-symbol]\n";
            return false;
        }

        if ($includeLetter) {
            foreach (str_split($this->letters) as $key) {
                $this->lettersData[$key] = 0;
            }
        }

        if ($includePunctuation) {
            foreach (str_split($this->punctuations) as $key) {
                $this->punctuationsData[$key] = 0;
            }
        }

        if ($includeSymbol) {
            foreach (str_split($this->symbols) as $key) {
                $this->symbolsData[$key] = 0;
            }
        }

        for ($i = 0; $i < strlen($text); $i++) {
            if ($includeLetter && isset($this->lettersData[$text[$i]])) {
                $this->lettersData[$text[$i]] += 1;
            }
            if ($includePunctuation && isset($this->punctuationsData[$text[$i]])) {
                $this->punctuationsData[$text[$i]] += 1;
            }
            if ($includeSymbol && isset($this->symbolsData[$text[$i]])) {
                $this->symbolsData[$text[$i]] += 1;
            }
        }

        switch ($format) {
            case 'non-repeating':
                if ($includeLetter) {
                    $keys = array_keys($this->lettersData, 1);
                    echo "> Non repeating letters: " . ($keys ? implode($keys) : 'None') . "\n";
                }
                if ($includePunctuation) {
                    $keys = array_keys($this->punctuationsData, 1);
                    echo "> Non repeating punctuations: " . ($keys ? implode($keys) : 'None') . "\n";
                }
                if ($includeSymbol) {
                    $keys = array_keys($this->symbolsData, 1);
                    echo "> Non repeating symbols: " . ($keys ? implode($keys) : 'None') . "\n";
                }
                break;
            case 'least-repeating':
                if ($includeLetter) {
                    $this->lettersData = array_filter($this->lettersData, fn ($v) => $v != 0);
                    if ($this->lettersData) {
                        $min = min($this->lettersData);
                        $keys = array_keys($this->lettersData, $min);
                        echo "> Least repeating letters: " . implode($keys) . " ($min times)\n";
                    } else {
                        echo "> Least repeating letters: None\n";
                    }
                }
                if ($includePunctuation) {
                    $this->punctuationsData = array_filter($this->punctuationsData, fn ($v) => $v != 0);
                    if ($this->punctuationsData) {
                        $min = min($this->punctuationsData);
                        $keys = array_keys($this->punctuationsData, $min);
                        echo "> Least repeating punctuations: " . implode($keys) . " ($min times)\n";
                    } else {
                        echo "> Least repeating punctuations: None\n";
                    }
                }
                if ($includeSymbol) {
                    $this->symbolsData = array_filter($this->symbolsData, fn ($v) => $v != 0);
                    if ($this->symbolsData) {
                        $min = min($this->symbolsData);
                        $keys = array_keys($this->symbolsData, $min);
                        echo "> Least repeating symbols: " . implode($keys) . " ($min times)\n";
                    } else {
                        echo "> Least repeating symbols: None\n";
                    }
                }
                break;
            case 'most-repeating':
                if ($includeLetter) {
                    $min = max($this->lettersData) ?: -1;
                    $keys = array_keys($this->lettersData, $min);
                    echo "> Most repeating letters: " . ($keys ? implode($keys) . " ($min times)" : 'None') . "\n";
                }
                if ($includePunctuation) {
                    $min = max($this->punctuationsData) ?: -1;
                    $keys = array_keys($this->punctuationsData, $min);
                    echo "> Most repeating punctuations: " . ($keys ? implode($keys) . " ($min times)" : 'None') . "\n";
                }
                if ($includeSymbol) {
                    $min = max($this->symbolsData) ?: -1;
                    $keys = array_keys($this->symbolsData, $min);
                    echo "> Most repeating symbols: " . ($keys ? implode($keys) . " ($min times)" : 'None') . "\n";
                }
                break;
        }

        return true;
    }
}