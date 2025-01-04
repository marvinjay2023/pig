<?php
session_start();
session_destroy();
unset($_SESSION['admin_id']);
unset($_SESSION['user']);

header('location: /login');