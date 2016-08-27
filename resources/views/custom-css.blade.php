<?php
    $columns['sm'] = config('user.grid-sm');
    $columns['md'] = config('user.grid-md');
    $columns['lg'] = config('user.grid-sm');

    $css ="<style>";
        foreach($columns as $key => $value){
            for($i=1; $i <= $value; $i++ ){
                $css.=".o-grid__user-column--".$key."-".$i.'of'.$value.'{';
                if($i < $value){
                    $css.="flex:0 0 calc(".(100/$value)*$i."% - .5rem);";
                    $css.="margin-right: .5rem;";
                }
                else {
                    $css.="flex:0 0 calc(".(100/$value)*$i."%);";
                }
                $css.="}";
            }
        }
    $css .="</style>";
?>
{!!$css!!}
