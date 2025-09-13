class Solution {

// Input: s = "anagram", t = "nagaram"
// Input: s = "anagram", t = "nagara"

// Output: true

    /**
     * @param String $s
     * @param String $t
     * @return Boolean
     */
    function isAnagram($s, $t) {
        $s = str_split($s);
        $t = str_split($t);

        sort($s);
        sort($t);

        if(implode('', $s) == implode('', $t)){
            return true;
        }
        return false;
    }
}