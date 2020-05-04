<?php

namespace Munna\Pm;

class PerfectMoney{
    public $account;
    public $password;
    public $payeraccount;
    protected $ssl_fix = ['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]];    

    public function __construct(){
        $this->account = config('perfectmoney.perfect_money_account');
        $this->password = config('perfectmoney.perfect_money_password');
        $this->payeraccount = config('perfectmoney.perfect_money_payeraccount');
    }

    public function getId(){
        return $this->account;
    }

    public function balance($currency = null){
        $url = file_get_contents('https://perfectmoney.is/acct/balance.asp?AccountID=' . $this->account . '&PassPhrase=' . $this->password, false, stream_context_create($this->ssl_fix));
		if(!$url){
		   return ['status' => false, 'message' => 'Connection error'];
		}
		if(!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $url, $result, PREG_SET_ORDER)){
		   return ['status' => false, 'message' => 'Invalid output'];
		}		
        $array = [];
        $c = 0;
		foreach($result as $item)
		{
			if($item[1] == 'ERROR'){
				return ['status' => false, 'message' => $item[2]];
			}else{
                $account = $item[1];
                $firstword = substr($account, 0,1);
                if($firstword == "U"){
                    $firstword = "USD";
                }elseif($firstword == "E"){
                    $firstword = "EURO";
                }elseif($firstword == "G"){
                    $firstword = "Troy oz.";
                }else{
                    $firstword = $firstword;
                }
                if($currency == null){
                    $array[$c]            = new \stdClass();
                    $array[$c]->account   = $item[1];
                    $array[$c]->currency  = $firstword;
                    $array[$c]->balance   = $item[2];
                    $c++;
                }else{
                    if($firstword == $currency){
                        $array = [
                            "account" =>  $item[1],
                            "currency" =>  $firstword,
                            "balance" =>  $item[2],
                        ];
                        break;
                    }
                }
			}
		}
		$array['status'] = true;
		return $array;
    }
    
    public function getName(){
        $url = file_get_contents('https://perfectmoney.is/acct/acc_name.asp?AccountID=' . $this->account . '&PassPhrase=' . $this->password. '&Account='.$this->payeraccount, false, stream_context_create($this->ssl_fix));
		if(!$url){
		   return ['status' => false, 'message' => 'Connection error'];
		}else{
            if($url == "ERROR: Invalid Account"){
                return [
                    'status' => false,
                    'message' => "Invalid Account"
                ];
            }else{
                return [
                    'status' => true,
                    'account' => $url,
                ];
            }
        }
    }


    public function send($receiver, $amount, $payment_id,  $descripion){
        $account = $this->account;
        $password = $this->password;
        $payeraccount = $this->payeraccount;
		$url = file_get_contents('https://perfectmoney.is/acct/confirm.asp?AccountID=' . urlencode(trim($account)) . '&PassPhrase=' . urlencode(trim($password)) . '&Payer_Account=' . urlencode(trim($payeraccount)) . '&Payee_Account=' . urlencode(trim($receiver)) . '&Amount=' . $amount .  (empty($descripion) ? '' : '&Memo=' . urlencode(trim($descripion))) . (empty($payment_id) ? '' : '&PAYMENT_ID=' . urlencode(trim($payment_id))), false, stream_context_create($this->ssl_fix));
		if(!$url){
		   return ['status' => false, 'message' => 'Connection error'];
		}
		if(!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $url, $result, PREG_SET_ORDER)){
		   return ['status' => false, 'message' => 'Invalid output'];
        }
		$data = [];
		foreach($result as $item){
			if($item[1] == 'ERROR'){
				return ['status' => false, 'message' => $item[2]];
			}else{
				$data['data'][$item[1]] = $item[2];
			}
		}		
		$data['status'] = true;		
		return $data;
    }


}