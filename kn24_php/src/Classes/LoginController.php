<?php

namespace Classes;

use Classes\Viewer;

class LoginController{
    
    public function show(){
        Viewer::show('login', [
            'title' => 'Вхід',
        ]);
    }
}