<?php

session_start();
session_destroy();

header("Location: /Proyecto_2/LK-Games/public/Pages/login.php");