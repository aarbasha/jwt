<?php

namespace App\Http\Traits;


trait GlobalTraits
{
        public function SendResponse($Data=null ,$Massage=null , $status=null ){

            $array = [
                'data' => $Data,
                'Massage'=> $Massage,
                'status'=> $status
            ];
            return response($array);
        }

        public function ValdationInput(){

        }

}
