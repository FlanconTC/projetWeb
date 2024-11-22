<?php 

public function hello($prenom="World", Environment $twig){
    return new Response ("Hello $prenom");
}

?>