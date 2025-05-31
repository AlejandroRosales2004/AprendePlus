<?php
session_start();
session_unset();
session_destroy();
header("Location: /AprendePlus/frontend/login.html");
exit;
