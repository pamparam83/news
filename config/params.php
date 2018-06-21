<?php

return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'domain@example.com',
    'user.passwordResetTokenExpire' => 3600, // one day
    'user.rememberMeDuration' => 3600 * 24 * 30, // 30 days
    'HostInfo' => 'http://news.test',
    'photoPath' => dirname(__DIR__, 1) . '/public_html',
];
