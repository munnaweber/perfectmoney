<?php 
namespace Munna\Pm\Facade;

use Illuminate\Support\Facades\Facade;

class PerfectMoney extends Facade{
    protected static function getFacadeAccessor(){
        return 'perfectmoney';
    }
}