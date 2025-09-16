<?php

declare(strict_types=1);

/** OBJECIVES
 * 1. Create a function that is able to read
 * every csv file in the transaction_files directory
 * 2. Store those collected data inside an array
 */

// function to get the csv file and return it as an array

function getTransactionFile(string $dirPath): array
{
    $filesArray = [];
    foreach (scandir($dirPath) as $file) {
        if (is_dir($file)) {
            continue;
        }
        $filesArray[] = $dirPath . $file;
    }

    return $filesArray;
}

// function that loops through an array and gets the contents

function readTransactionFile(array $fileArray): array{
    $contents = [];
    foreach($fileArray as $file) {
        if(($csvFile = fopen($file, 'r')) !== false)  {
            while(($fileContent = fgetcsv($csvFile, 1000, ','))) {
                $contents[] = $fileContent;
            }
        }
    }

    return $contents;
}