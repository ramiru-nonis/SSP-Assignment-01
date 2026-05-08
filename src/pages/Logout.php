<?php
session_start();
session_unset();
session_destroy();
header("Location: /Celario_lite/cellario_lite/Login");
exit;
