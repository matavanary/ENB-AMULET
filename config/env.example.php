<?php
/**
 * Configuration Template (คัดลอกไฟล์นี้เป็น env.php เพื่อใช้งานจริง)
 */

return [
    'RUNNING_IN' => 'LOCAL', // 'LOCAL' | 'LOCAL_SERVER' | 'PRODUCTION'
    'TECHNOLOGY' => 'sqlsrv', // 'sqlsrv' | 'mysql'
    
    'ENVIRONMENTS' => [
        'LOCAL' => [
            'HOST'     => 'localhost',
            'USERNAME' => 'sa',
            'PASSWORD' => 'your_password',
            'DATABASE' => 'AMULET',
            'WEBURL'   => 'http://localhost/enomban/REPO.GITHUB/ENB-AMULET/',
        ],
        'LOCAL_SERVER' => [
            'HOST'     => '61.91.5.111',
            'USERNAME' => 'sa',
            'PASSWORD' => 'your_password',
            'DATABASE' => 'AMULET',
            'WEBURL'   => 'http://203.150.225.30:84/',
        ],
        'PRODUCTION' => [
            'HOST'     => 'RK02',
            'USERNAME' => 'sa',
            'PASSWORD' => 'your_password',
            'DATABASE' => 'AMULET',
            'WEBURL'   => 'http://203.150.225.30:84/',
        ]
    ]
];
