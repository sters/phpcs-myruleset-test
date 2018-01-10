<?php

namespace MyRule\Sniff;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class DisallowHashCommentsSniff implements Sniff
{
    /**
     * @return array
     */
    public function register()
    {
        // Process target only T_COMMENT token.
        return [
            T_COMMENT
        ];
    }

    /**
     * @param \PHP_CodeSniffer\Files\File
     * @param int
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        // Get tokens on php script file
        $tokens = $phpcsFile->getTokens();

        // Get the T_COMMENT token.
        // for examle @target01.php >> string(8) "# echo"
        //
        // // var_dump($tokens[$stackPtr]['content']);

        // If T_COMMENT token has first '#', Add phpcs error.
        if ($tokens[$stackPtr]['content']{0} === '#') {
            $error = 'Hash comments are prohibited; found %s';
            $data  = [trim($tokens[$stackPtr]['content'])];
            $phpcsFile->addError($error, $stackPtr, 'Found', $data);
        }

    }
}
