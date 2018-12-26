<?php
/**
 * helper functions
 *
 * Class that include all helper functions of project
 *
 * @author Nicolas Streri
 */
class Helpers{
    private static $arraySymbol = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";


    /**
     * convert a integer in his representation in a positional notation with base 62
     *
     * @param integer number to convert
     * @return string
     */
    public static function convertIntToBase62Symbol($number){
        $chars = str_split(Helpers::$arraySymbol);

        $result = array();
        $cant=0;

        $temp = $number;
        do{
            //Calculation of division
            $result[$cant] =  $chars[$temp % 62];
            $cant++;
            $temp = floor($temp/62);//$temp % 62;
        }while($temp != 0);
        return implode(array_reverse($result));
    }

    /**
     * convert a string that represent a number in positional notation with base 62 in integer
     *
     * @param string representation
     * @return integer
     */
    public static function convertBase62SymbolToInt($stringNum){
        $chars = str_split(Helpers::$arraySymbol);
        $num = 0;
        $fin = strlen($stringNum)-1;
        for($i=0; $i<=$fin; $i++){
            $num += array_search($stringNum[$i],$chars) * pow(62, $fin - $i);
        }
        return $num;
    }

    /**
     * Get the country code of the visit
     * @return string
     */
    public static function getCodeCountry(){
        //Todo: Implement.
        return 'AR';
        return $_SERVER["HTTP_CF_IPCOUNTRY"];
    }
}