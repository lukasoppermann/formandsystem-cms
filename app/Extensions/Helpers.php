<?php
function csp_none(){
    $nonce = hash('sha256',time().uniqid(rand(), true));

    foreach(config('security.content.profiles') as $name => $profile){

        if( isset($profile['script-src']) ){
            config([
                "security.content.profiles.$name.script-src" => array_merge(
                    (array)$profile['script-src'],
                    ["'nonce-".$nonce."'"]
                )
            ]);
        }

    }

    return "nonce=".$nonce;
}
