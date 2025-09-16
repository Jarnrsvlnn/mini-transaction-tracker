<?php

declare(strict_types = 1);

/** OBJECIVES
 * 1. Create a function that is able to read
 * every csv file in the transaction_files directory
 * 2. Store those collected data inside an array
 */

// function to get the csv file and return it as an array

function getTransactionFile(string $filename): array {
    foreach(scandir(FILES_PATH) as $file) {
        if (is_file($file)) {
            
        }
    }
}

