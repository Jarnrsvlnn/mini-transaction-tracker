<?php

function formatTransactionAmount(float $amount): string
{
    $isNegative = $amount < 0;

    return ($isNegative ? '-' : '') . '$' . number_format(abs($amount), 2);
}

function formatTransactionDate(string $transactionDate): string
{
    return date('M d, Y', strtotime($transactionDate));
}
