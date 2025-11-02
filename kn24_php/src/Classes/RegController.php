<?php

namespace Classes;

use Classes\Viewer;

class RegController{
    
    public function show(){
        Viewer::show('reg', [
            'title' => 'Реєстрація',
        ]);
    }
}