<?php

class DB{

	private static function Pdo(){
		try{
			$pdo= new PDO('mysql:host=localhost;dbname=todo', 'root', '');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			$pdo ='database error :/';
		}
		return $pdo;
	}

	public static function Query($q, $d=[]){
		$return = self::Pdo()->prepare($q);
		$return->execute($d);
		return $return;
	}
}



?>