<?php
class Koneksi
{
	private $host = "localhost";
	private $user = "root";
	private $pass = "";
	private $dbname = "ukom2018_rplb_151610345";
	protected $db;
	
	function __construct()
	{
		try {
			$this->db = new PDO("mysql:host={$this->host};dbname={$this->dbname}",$this->user,$this->pass);
			$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			die("Koneksi gagal : ".$e->getMessage());
		}
	}
}
?>