class Solution {

    /**
     * @param Integer $x
     * @return Boolean
     */
    function isPalindrome($x) {
        $str = (string) $x;
        if ($str === strrev($str)){
            return true;
        }
            return false;
    }
}