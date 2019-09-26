<?php 


	function myfunction() {
		
	}

	function limit_text($text, $limit) {
      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          $text = substr($text, 0, $pos[$limit]) . '...';
      }
      return $text;
  }

  function ordinal($number) {
      $ends = array('th','st','nd','rd','th','th','th','th','th','th');
      if ((($number % 100) >= 11) && (($number%100) <= 13))
          return $number. 'th';
      else
          return $number. $ends[$number % 10];
  }

  function random_string($length) {
        $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random_string = substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
        return $random_string;
  }

  function tap($value, $callback)
  {
      $callback($value);
   
      return $value;
  }