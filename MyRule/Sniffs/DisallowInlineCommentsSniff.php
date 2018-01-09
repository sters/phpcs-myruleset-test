<?php
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class DisallowInlineCommentsSniff implements Sniff
{
    private $tokens;

    /**
     * @return array
     */
    public function register()
    {
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
        $this->tokens = $phpcsFile->getTokens();

        $tokenPrev = $this->findSomethingFirstOnLine($phpcsFile, $stackPtr);
        $tokenNext = $this->findSomethingLastOnLine($phpcsFile, $stackPtr);

        if ($tokenPrev !== false || $tokenNext !== false) {
            $message = "Disallow Inline comments.";
            $errorCode = 'inline_comments';
            $placeholder = [];

            $phpcsFile->addError($message, $stackPtr, $errorCode, $placeholder);
        }
    }


    private function findSomethingOnLine($phpcsFile, $start, $step=1, $ignore=['T_WHITESPACE'])
    {
        // ref. https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Files/File.php#L2112
        // findFirstOnLine

        $foundTokenPtr = false;

        for ($i = $start + $step; true; $i += $step) {
            if (empty($this->tokens[$i]) || $this->tokens[$i]['line'] != $this->tokens[$start]['line']) {
                break;
            }

            // skip ignore list.
            if (in_array($this->tokens[$i]['type'], $ignore)) {
                continue;
            }

            $foundTokenPtr = $i;
        }

        return $foundTokenPtr;
    }

    private function findSomethingFirstOnLine($phpcsFile, $start)
    {
        return $this->findSomethingOnLine($phpcsFile, $start, -1);
    }

    private function findSomethingLastOnLine($phpcsFile, $start)
    {
        return $this->findSomethingOnLine($phpcsFile, $start, 1);
    }


}
