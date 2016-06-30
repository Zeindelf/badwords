<?php

namespace Badwords;

use Badwords\Config\Config;

/**
 * Badwords - Filtra palavras indesejadas
 *
 * @link https://github.com/zeindelf/badwords/ The Badwords GitHub project
 * @author Wellington Barreto <zeindelf@hotmail.com>
 * @copyright Copyright (c) 2016, Zeindelf
 */
class Badwords
{
	//------------------------------------------------------------
    //  PUBLIC METHODS
    //------------------------------------------------------------

	/**
	 * Verifica se a palavra informada existe no filtro
	 *
	 * No parâmetro $extra, informe um array com as chaves
	 * 'badwords' e/ou 'ignored'. Como valor das chaves, informe-os
	 * em um array, como:
	 *
	 * $extra = [
	 * 		'badwords' => ['palavraUm', 'palavraDois', ...],
	 * 		'ignored'  => ['palavraTres', 'palavraQuatro', ...],
	 * ];
	 *
	 * 'badwords' são palavras que deseja acrescentar ao filtro
	 * 'ignored' são palavras que serão ignoradas pelo filtro
	 *
	 * @param string 	$string 	Palavra a ser verificada
	 * @param array 	$extra 		Array com informações adicionais
	 * @return boolean
	 */
	public static function verify($string, array $extra = null)
	{
		require_once __DIR__ . '/Config/Filter.php';
		$string = static::doubleChars($string);

		$getFilter = Config::get('filter');

		if ( !is_null($extra) ):
			if ( array_key_exists('badwords', $extra) ):
				$getFilter = array_merge($extra['badwords'], $getFilter);
			endif;

			if ( array_key_exists('ignored', $extra) ):
				for ( $i = 0; $i < count($extra['ignored']); $i++ ):
					$extra['ignored'][$i] = static::doubleChars($extra['ignored'][$i]);
				endfor;

				for ( $i = 0; $i < count($getFilter); $i++ ):
					foreach ( $extra['ignored'] as $ignored ):
						if ( is_int(strripos($ignored, $getFilter[$i])) ):
							$arr[] = $i;
						endif;
					endforeach;
				endfor;

				if ( isset($arr) ):
					foreach ( $arr as $a ):
						unset($getFilter[$a]);
					endforeach;
				endif;
			endif;
		endif;

		foreach ( $getFilter as $filter ):
			if ( is_int(strripos($string, $filter)) ):
				return true;
			endif;
		endforeach;

		return false;
	}

	/**
	 * Retira ocorrências de caracteres rapetidos na string para verificação
	 *
	 * @param string 	$string 	String para verificação
	 * @return string 	String sem caracteres repetidos
	 */
	public static function doubleChars($string)
	{
		$string = static::unreadableString($string);

		$letter = range('a', 'z');
		$letter[] = '!';
		$qntChar = 5;

		for ( $i = 0; $i < count($letter); $i++ ):
			for ( $j = 0; $j < $qntChar; $j++ ):
				$repeat = str_repeat($letter[$i], $j);
				$arrString = str_split($repeat);
			endfor;

			$arr[] = $arrString;
		endfor;

		for ( $i = 0; $i < count($arr); $i++ ):
			for ( $j = 0; $j < count($arr[$i]); $j++ ):
				$newRepeat[] = str_repeat($arr[$i][$j], $j + 1);
			endfor;
		endfor;

		$doubleChar = array_chunk($newRepeat, $qntChar - 1);

		for ( $i = 0; $i < count($doubleChar); $i++ ):
			for ( $j = 1; $j <= 5; $j++ ):
				$string = str_replace($doubleChar[$i], $letter[$i], $string);
			endfor;
		endfor;

		return $string;
	}

	/**
	 * Converte caracteres especiais e números em letras associadas
	 *
	 * @param string 	$string 	String para ser convertida
	 * @param bool 		$lower 		Retorna em lowercase caso true
	 * @return string
	 */
	public static function unreadableString($string)
	{
		$arrString['special'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞß@àáâãäåæç&èéêëìíîïðñòóôõöøùúûýýþÿ$°ºª';
		$arrString['number']  = '0123456789';
		$unreadable = $arrString['special'] . $arrString['number'];

		$arrString['string']  = 'aaaaaaaceeeeiiiidnoooooouuuuuybbaaaaaaaaceeeeeiiiidnoooooouuuyybysooa';
		$arrString['letters'] = 'oizeasbtbg';
		$readable = $arrString['string'] . $arrString['letters'];

		$string = strtr(utf8_decode($string), utf8_decode($unreadable), $readable);

        return strtolower(utf8_encode($string));
	}
}