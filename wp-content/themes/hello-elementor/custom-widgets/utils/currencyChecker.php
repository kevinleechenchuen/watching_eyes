<?php 
    function convertCurrency($currency) {
        switch ($currency) {
            case 'USD':
                return '$';
            case 'GBP':
                return '£';
            default:
                return $currency;
        }
    }
?>