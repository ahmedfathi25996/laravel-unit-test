<?php
return array(
    // set your paypal credential

    'client_id' => 'AdxpHmvdzdHiwR2e__6yIrCEwsEiqQhG_zPrtkwY0_UAg7i7byC7oar3CcWlZyMmtL53clGjDbF4RJ_p',
    'secret' => 'EHYSJqyxPux4iDtGqsWkOhk0QhkP1BbGWvL1G2hD5B6wyrzpJFcQY5DoxZA1aOeVUBx6ZFa_k7rWefNs',
    'user_email' =>'sb-ko7y92919642@business.example.com',
    'revel_company_price' => 10,
    'time_expire_revel' => 10,

    /**
     * SDK configuration
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */

        'mode' => 'sandbox',

        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 3000,
        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,
        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/payments/paypal_'. date('d-m-y') . '.log',
        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);
