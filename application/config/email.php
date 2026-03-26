<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'smtp.office365.com', 
    //'smtp_port' => 587,
    'smtp_port' => 587,
    //'smtp_user' => 'sgiubertec@outlook.com',
    //'smtp_pass' => 'VRtnHs6mqkpuWnU',
    'smtp_user' => 'contato@ubertec.ind.br',
    //'smtp_user' => 'siteubertec@outlook.com',
    'smtp_pass' => 'Qop01627',
    //'smtp_user' => 'keven@ubertec.ind.br',
    //'smtp_pass' => 'Vuc19706',
    'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
    'mailtype' => 'text', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '60', //in seconds
    'charset' => 'utf-8',
    'wordwrap' => TRUE
);*/
/*$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'smtp.office365.com', 
    'smtp_port' => 587,
    'smtp_user' => 'sgiubertec@outlook.com',
    'smtp_pass' => 'VRtnHs6mqkpuWnU',
    'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
    'mailtype' => 'text', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '60', //in seconds
    'charset' => 'utf-8',
    'wordwrap' => TRUE
);*/

$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'smtp-relay.brevo.com', 
    'smtp_port' => 465,
    'smtp_user' => 'ubertec.usinagem@gmail.com',
    'smtp_pass' => '280byv39zJKdFT7Y',
    'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
    'mailtype' => 'text', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '60', //in seconds
    'charset' => 'utf-8',
    'wordwrap' => TRUE
);