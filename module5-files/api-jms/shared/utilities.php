<?php
class Utilities{ 
    public function getPaging($pageJMS, $total_rowsJMS, $records_per_pageJMS, $page_urlJMS){ 
    
        $paging_arrJMS=array(); 

        
        $paging_arrJMS["first"] = $pageJMS > 1 ? "{$page_urlJMS}page=1" : ""; 

  
        $total_pagesJMS = ceil($total_rowsJMS / $records_per_pageJMS); 

   
        $rangeJMS = 2; 

        
        $initial_numJMS = $pageJMS - $rangeJMS; 

        $condition_limit_numJMS = ($pageJMS + $rangeJMS) + 1; 

        $paging_arrJMS['pages']=array(); 
        $page_countJMS=0; 

        for($xJMS=$initial_numJMS; $xJMS < $condition_limit_numJMS; $xJMS++){ 
            
            if(($xJMS > 0) && ($xJMS <= $total_pagesJMS)){ 
                $paging_arrJMS['pages'][$page_countJMS]["page"]=$xJMS;
                $paging_arrJMS['pages'][$page_countJMS]["url"]="{$page_urlJMS}page={$xJMS}";
                $paging_arrJMS['pages'][$page_countJMS]["current_page"] = $xJMS==$pageJMS ? "yes" : "no";
                $page_countJMS++;
            }
        }

        $paging_arrJMS["last"] = $pageJMS < $total_pagesJMS ? "{$page_urlJMS}page={$total_pagesJMS}" : ""; 

        return $paging_arrJMS;
    }
}

?>