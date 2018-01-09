<?php
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class DisallowArrayKeywordSniff implements Sniff
{
    /**
     *
     * @return array
     */
    public function register()
    {
        return [
            T_ARRAY
        ];
    }

    /**
     * @param \PHP_CodeSniffer\Files\File
     * @param int
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $closerPtr = $tokens[$stackPtr]['parenthesis_closer'];
        $arrayTokens = array_slice($tokens, $stackPtr, $closerPtr - $stackPtr + 1);
        $programCode = '';
        foreach ($arrayTokens as $token) {
            if ($token['type'] !== 'T_WHITESPACE') {
                $programCode .= $token['content'];
            }
        }

        $message = "Disallow array() keyword. \n%s";
        $errorCode = 'array_keywords';
        $placeholder = [
            trim($programCode),
        ];

        $phpcsFile->addError($message, $stackPtr, $errorCode, $placeholder);
    }
}
