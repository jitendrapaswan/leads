<?php
  // get catery tree in depth
    function get_category_tree($vid, $parent = 0, $depth = -1, $max_depth = NULL){
        $CI=& get_instance();
        static $children, $parents, $terms;
        
        if(!isset($children[$vid])){
            $children[$vid] = array();
            $parents[$vid] = array();
            $terms[$vid] = array();
            
            //get categories from DB
            $result = $CI->db->get('category')->result();
            foreach($result as $term){
                $children[$vid][$term->parent_id][] = $term->cat_id;
                $parents[$vid][$term->cat_id][] = $term->parent_id;
                $terms[$vid][$term->cat_id] = $term;
            }
        }
        
        $max_depth = (!isset($max_depth)) ? count($children[$vid]) : $max_depth;
        $tree = array();
        
        // Keeps track of the parents we have to process, the last entry is used
        // for the next processing step.
        $process_parents = array();
        $process_parents[] = $parent;
        
        // Loops over the parent terms and adds its children to the tree array.
        // Uses a loop instead of a recursion, because it's more efficient.
        while (count($process_parents)) {
            $parent = array_pop($process_parents);
            // The number of parents determines the current depth.
            $depth = count($process_parents);
            if ($max_depth > $depth && !empty($children[$vid][$parent])) {
                $has_children = FALSE;
                $child = current($children[$vid][$parent]);
                do {
                    if (empty($child)) {
                        break;
                    }
                    $term = $terms[$vid][$child];
                    if (count($parents[$vid][$term->cat_id]) > 1) {
                        // We have a term with multi parents here. Clone the term,
                        // so that the depth attribute remains correct.
                        $term = clone $term;
                    }
                    $term->depth = $depth;
                    unset($term->parent);
                    $term->parents = $parents[$vid][$term->cat_id];
                    $tree[] = $term;
                    if (!empty($children[$vid][$term->cat_id])) {
                        $has_children = TRUE;

                        // We have to continue with this parent later.
                        $process_parents[] = $parent;
                        // Use the current term as parent for the next iteration.
                        $process_parents[] = $term->cat_id;

                        // Reset pointers for child lists because we step in there more often
                        // with multi parents.
                        reset($children[$vid][$term->cat_id]);
                        // Move pointer so that we get the correct term the next time.
                        next($children[$vid][$parent]);
                        break;
                    }
                } while ($child = next($children[$vid][$parent]));
                
                if (!$has_children) {
                    // We processed all terms in this hierarchy-level, reset pointer
                    // so that this function works the next time it gets called.
                    reset($children[$vid][$parent]);
                }
            }
        }
        return $tree;
    }
    
    
function category_select($selected = 0) {
    $tree = get_category_tree(1);
    $options = array();
    
    //$out = '<select name="asd" class="span12 chosen-select" name="selParentIndustry" id="selParentIndustry">';
 $out = '<option value="0"> None </option>';
     if ($tree) {
         foreach ($tree as $term) {
                     $d = $term->depth > 0 ? $term->depth + $term->depth : $term->depth;
               if($selected > 0 && $selected == $term->cat_id)
               {
                $out .= '<option value="'.$term->cat_id.'" selected="selected">'.str_repeat('-', $d) .' '.$term->cat_name.'</option>';
               }
               else {
                $out .= '<option value="'.$term->cat_id.'">'.str_repeat('-', $d) .' '.$term->cat_name.'</option>';
               }
             
         }
     }
 //$out .= '</select>';
    return $out;
}  


function time_passed($timestamp){
    //type cast, current time, difference in timestamps
    $timestamp      = (int) $timestamp;
    $current_time   = time();
    $diff           = $current_time - $timestamp;
   
    //intervals in seconds
    $intervals      = array (
        'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60
    );
   
    //now we just find the difference
    if ($diff == 0)
    {
        return 'just now';
    }   

    if ($diff < 60)
    {
        return $diff == 1 ? $diff . ' second ago' : $diff . ' seconds ago';
    }       

    if ($diff >= 60 && $diff < $intervals['hour'])
    {
        $diff = floor($diff/$intervals['minute']);
        return $diff == 1 ? $diff . ' minute ago' : $diff . ' minutes ago';
    }       

    if ($diff >= $intervals['hour'] && $diff < $intervals['day'])
    {
        $diff = floor($diff/$intervals['hour']);
        return $diff == 1 ? $diff . ' hour ago' : $diff . ' hours ago';
    }   

    if ($diff >= $intervals['day'] && $diff < $intervals['week'])
    {
        $diff = floor($diff/$intervals['day']);
        return $diff == 1 ? $diff . ' day ago' : $diff . ' days ago';
    }   

    if ($diff >= $intervals['week'] && $diff < $intervals['month'])
    {
        $diff = floor($diff/$intervals['week']);
        return $diff == 1 ? $diff . ' week ago' : $diff . ' weeks ago';
    }   

    if ($diff >= $intervals['month'] && $diff < $intervals['year'])
    {
        $diff = floor($diff/$intervals['month']);
        return $diff == 1 ? $diff . ' month ago' : $diff . ' months ago';
    }   

    if ($diff >= $intervals['year'])
    {
        $diff = floor($diff/$intervals['year']);
        return $diff == 1 ? $diff . ' year ago' : $diff . ' years ago';
    }
}

?>
