<?php
try {
	$db = new PDO('mysql:host=localhost;dbname=pig','root','admin123');
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	die('<h4 style="color:red">Incorrect Connection Details</h4>');
}