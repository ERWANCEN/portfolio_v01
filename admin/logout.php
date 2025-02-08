<?php
session_start();
session_destroy();
header('Location: /portfolio_v01/admin/login.php');
exit();
