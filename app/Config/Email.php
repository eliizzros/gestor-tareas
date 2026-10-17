<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail  = 'svelasquezr8@miumg.edu.gt';
    public string $fromName   = 'Sandra';
    public string $recipients = '';

    public string $userAgent = 'CodeIgniter';
    public string $protocol  = 'smtp';
    public string $mailPath  = '/usr/sbin/sendmail';

    public string $SMTPHost = 'smtp.gmail.com';
    public string $SMTPUser = 'svelasquezr8@miumg.edu.gt';
    public string $SMTPPass = 'bvyzmklisujyxwzd';
    public int $SMTPPort    = 587;
    public int $SMTPTimeout = 15;
    public bool $SMTPKeepAlive = false;
    public string $SMTPCrypto  = 'tls';

    public bool $wordWrap = true;
    public int $wrapChars = 765;
    public string $mailType = 'html';
    public string $charset  = 'UTF-8';
    public bool $validate   = false;
    public int $priority    = 3;
    public string $CRLF     = "\r\n";
    public string $newline  = "\r\n";
    public bool $BCCBatchMode = false;
    public int $BCCBatchSize  = 200;
    public bool $DSN = false;
}
