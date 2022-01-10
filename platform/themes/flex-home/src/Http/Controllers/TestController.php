<?php

namespace Theme\FlexHome\Http\Controllers;

use Theme\FlexHome\Http\Controllers\TestController;

class TestController extends Controllers {

   public function getState(Request $request){
   	return  "hello";
   }

}