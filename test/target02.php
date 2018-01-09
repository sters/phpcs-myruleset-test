<?php

class Hoge
{
	public function hoge_array()
	{
		// Get DisallowArrayKeyowrdSniff error.
		return array(
			'hoge',
			'huga' => false,
		);
	}

	private function getArray()
	{
		return [
			1, 1, 2, 3, 5,
		];
	}
}

function ArrayArray() {
	return 'return array("ok");';
}


$hoge = eval(ArrayArray());
echo $hoge === [];
