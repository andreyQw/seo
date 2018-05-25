<?php
return array(
    //----------------------------
    // set your paypal credential
    //----------------------------

    'client_id' =>'AdgVkuYrhEll9bo0gRVXnpoSGWid4bdhZl2WVOpX4yE02RP-mIM388PSFlHAT_vHmViaX_qwCtQyhVGw',
    'secret' => 'EKetOXNAa4AWWntwkuNJyet87sUOo-HDR8SkDt_sGUWGCEFQLOsM63_-fIaak3Td_CDZD1wOewkAZ_Q5',

    //----------------
    // SDK Setup
    //---------------

    'settings' => array(

        // Set Paypal Mode 2 option 'Live' or 'sandbox'

        'mode' => 'sandbox',

        // Set maximum request time

        'http.ConnectionTimeOut' => 100,

        // Set log Enabled or not

        'log.LogEnabled' => true,

        // Specify the file that want to write on

        'log.FileName' => storage_path('/logs/paypal.log'),

        //-----------------------------------------------------------------
        //Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
        //Logging is most verbose in the 'FINE' level and decreases as you
        //-----------------------------------------------------------------

        'log.LogLevel' => 'FINE'
    ),
);