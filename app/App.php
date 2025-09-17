<?php

declare(strict_types=1);

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

function readTransactionFile(array $fileArray, ?callable $transactionHandler = null): array
{
    $contents = [];
    foreach ($fileArray as $file) {
        if (($csvFile = fopen($file, 'r')) !== false) {
            while (($fileContent = fgetcsv($csvFile, 1000, ','))) {
                if ($transactionHandler !== null) {
                    $fileContent = $transactionHandler($fileContent);
                }
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

function calculateTransactions(array $transactions): array {
    $totalTransactions = ['income' => 0, 'expense' => 0, 'net' => 0];

    foreach($transactions as $transaction) {
        if ($transaction['amount'] >= 0) { // checks if the amount is income
            $totalTransactions['income'] += $transaction['amount'];
        }
        else { // checks if the amount is an expense
            $totalTransactions['expense'] += $transaction['amount'];
        }
    }

    $totalTransactions['net'] = $totalTransactions['income'] + $totalTransactions['expense'];

    return $totalTransactions;
}
