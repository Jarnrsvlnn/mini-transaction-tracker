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

// function that loops through an array and gets the contents then returns as an array

function readTransactionFile(array $fileArray): array
{
    $contents = [];
    foreach ($fileArray as $file) {
        if (($csvFile = fopen($file, 'r')) !== false) {
            while (($fileContent = fgetcsv($csvFile, 1000, ','))) {
                $contents[] = extractTransaction($fileContent);
            }
        }
    }

    return $contents;
}

/**
 * this function extracts each description to able to do something with them
 * , for example it extracts only the number and removes all of the symbols
 * that may disrupt our calculation on amount later on
 */

function extractTransaction(array $transactionRow): array
{
    [$date, $checkNumber, $description, $amount] = $transactionRow;

    $findSymbols = ['$', ','];
    $amount = (float) str_replace($findSymbols, '', $amount);

    return [
        'date' => $date,
        'checkNumber' => $checkNumber,
        'description' => $description,
        'amount' => $amount
    ];
}
