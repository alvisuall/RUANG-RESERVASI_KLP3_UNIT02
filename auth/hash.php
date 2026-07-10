<?php

echo "<h3>Admin</h3>";
echo password_hash("admin123", PASSWORD_DEFAULT);

echo "<br><br>";

echo "<h3>Petugas</h3>";
echo password_hash("petugas123", PASSWORD_DEFAULT);

echo "<br><br>";

echo "<h3>Mahasiswa</h3>";
echo password_hash("mahasiswa123", PASSWORD_DEFAULT);

?>