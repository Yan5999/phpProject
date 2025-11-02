<?php

namespace Classes;

use Classes\Viewer;

class HomePageController{
    
    public function show(){
        Viewer::show('home', [
            'title' => 'Головна сторінка',
        ]);
    }
}