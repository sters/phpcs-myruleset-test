<?php

echo 'NG...'; // inline comment!

function hoge () { //hogehoge//
	if (/*hogehoge*/ true ) {
		echo 'NG!!';
	}
}


// this is normal comment
echo 'OK!';