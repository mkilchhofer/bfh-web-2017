<?php

// Tool to generate password hashes for debugging purpose
//
// Usage: http://SERVER_URL/core/helpers/pw.php?password=<MyPassword>

echo password_hash($_GET['password'], PASSWORD_BCRYPT, ['cost' => 12,])."\n";
