<?php

namespace app\Controllers;

use core\Controller;
use core\Database;

class BaseController extends Controller
{
    protected Database $db;
    public function __construct()
    {
        $this->db = new Database();
    }
}