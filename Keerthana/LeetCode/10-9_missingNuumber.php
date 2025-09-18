class Solution {

    /**
     * @param Integer[] $nums
     * @return Integer
     */
    function missingNumber($nums) {
        for($i = 0;$i<=count($nums);$i++){
            if (!in_array($i, $nums, true)){
                return $i;
            }
        }
    }
}
