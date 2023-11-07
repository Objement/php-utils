<?php

namespace Objement\OmPhpUtils;

class OmNamespaceUtility
{
    /**
     * @param $filepath
     * @return string|null
     * @see https://gist.github.com/naholyr/1885879
     */
    public static function getNamespaceOfFile($filepath): ?string
    {
        $src = file_get_contents($filepath);

        $tokens = token_get_all($src);
        $count = count($tokens);
        $i = 0;
        $namespace = '';
        $namespace_ok = false;
        while ($i < $count) {
            $token = $tokens[$i];
            if (is_array($token) && $token[0] === T_NAMESPACE) {
                // Found namespace declaration
                while (++$i < $count) {
                    if ($tokens[$i] === ';') {
                        $namespace_ok = true;
                        $namespace = trim($namespace);
                        break;
                    }
                    $namespace .= is_array($tokens[$i]) ? $tokens[$i][1] : $tokens[$i];
                }
                break;
            }
            $i++;
        }

        if (!$namespace_ok) {
            return null;
        } else {
            return $namespace;
        }
    }
}
