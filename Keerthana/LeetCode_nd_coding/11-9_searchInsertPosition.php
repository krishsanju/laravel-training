class Solution {

// Input: nums = [1,3,3,5,6], target = 5
// Output: 2


    /**
     * @param Integer[] $nums
     * @param Integer $target
     * @return Integer
     */
    function searchInsert($nums, $target) {
        for($i = 0 ; $i < count($nums); $i++){
            if($nums[$i] >= $target ){
                return $i;
            }
        }
        return $i;
    }
}