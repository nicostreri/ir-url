<?php

class Base62Test extends TestCase
{
    public function testConvertDeconvert(){
        for ($i=0; $i<= 50; $i++){
            $this->assertTrue(Helpers::convertBase62SymbolToInt(Helpers::convertIntToBase62Symbol($i)) == $i);
        }
    }
}