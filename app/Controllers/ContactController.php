<?php

namespace app\Controllers;

class ContactController
{
    public function index()
    {
        return 'Contact form GET Page';
    }

    public function send()
    {
        return 'Contact form POST Page';
    }
}