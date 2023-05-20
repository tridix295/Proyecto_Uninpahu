<?php
use Illuminate\Support\Facades\DB;
class connectBD{
    private function bootBD(){
        try{
            DB::connection()->getPdo();
        }catch(\Exception $e){
            //...
        }
    }
}
?>