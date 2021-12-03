<?php

require 'vendor/autoload.php';

$shortopts  = "";
$shortopts .= "i:";
$shortopts .= "f:";
$shortopts .= "L::";
$shortopts .= "P::";
$shortopts .= "S::";

$longopts  = array(
    "input:",
    "format:",
    "include-letter::",
    "include-punctuation::",
    "include-symbol::",
);

$options = getopt($shortopts, $longopts);

// Condition #1
if (!(isset($options['i']) || isset($options['input']))) {
    help();
    exit(1);
}

$filename = $options['i'] ?? $options['input'];

if (!file_exists($filename)) {
    help();
    exit(1);
}

if (!($text = file_get_contents($filename))) {
    help();
    exit(1);
}

$regex = '/[^[:punct:][:lower:]]/';

if (preg_match($regex, $text)) {
    help();
    exit(2);
}

// Condition #2
if (!(isset($options['f']) || isset($options['format']))) {
    help();
    exit(3);
}

$format = $options['f'] ?? $options['format'];

// Condition #3
if (!in_array($format, ['non-repeating', 'least-repeating', 'most-repeating'])) {
    help();
    exit(3);
}

$includeLetter = isset($options['L']) || isset($options['include-letter']);
$includePunctuation = isset($options['P']) || isset($options['include-punctuation']);
$includeSymbol = isset($options['S']) || isset($options['include-symbol']);

if (!($includeLetter || $includePunctuation || $includeSymbol)) {
    help();
    exit(4);
}

echo "\n> File: $filename\n";


$checkFileContents = new OccurrenceService();
if (!$checkFileContents->checkOccurrence($text, $format, $includeLetter, $includePunctuation, $includeSymbol)) {
    help();
}


function help() {
    echo "\nscript.php version 1.0 2021-12-02 by Raimonds Linde\n";
    echo "\nOptions:\n";
    echo "  -i, --input*\t\t\t\t (required) Input file\n";
    echo "  -f, --format\t\t\t\t (required) One of the formats: non-repeating, least-repeating, most-repeating\n";
    echo "  -L, --include-letter**\t\t (optional) Include letter condition\n";
    echo "  -P, --include-punctuation**\t\t (optional) Include punctuation condition\n";
    echo "  -S, --include-symbol**\t\t (optional) Include symbol condition\n";
    echo "* input file can only contain lowercase letters, punctuations and symbols\n";
    echo "** required at least one optional parameter\n";
}