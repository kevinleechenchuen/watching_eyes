<?php 
    function convertCurrency($currency) {
        switch ($currency) {
            case 'USD':
                return '$';
            case 'GBP':
                return '£';
            case 'EUR':
                return '€';
            default:
                return $currency;
        }
    }
?>