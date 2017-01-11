<?php namespace App\Http\Controllers;
use DB;
use Request;
use Redirect;
use Carbon\Carbon;
use Datatables;
use Crypt;
use App\Tbl_account_encashment_history;
use App\Classes\Admin;
use Config;
use App\Tbl_slot;
use App\Tbl_country;
use Session;
use App\Classes\Log;
use App\Tbl_wallet_logs;
class AdminPayoutController extends AdminController
{
	public function index()
	{
		$data["page"] = "Process Payout"; 
        $data['success'] = Session::get('success');
        Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Process payout.");
        if(isset($_POST['processall']))
        {
            $this->processall();
            $success = "Proccessed all payout successfully.";
            Log::Admin(Admin::info()->account_id,Admin::info()->account_username." processed all payout.");

            if(Request::input('processed') == 1)
            {
                 return Redirect::to('admin/transaction/payout/?processed=1')->with('success',$success);
            }
            else
            {
               return Redirect::to('admin/transaction/payout')->with('success',$success);
            }
        }


        // if(Request::input('processed') == 1)
        // {
        //     $request = 'Processed';
        //     $account = $this->processed();
        // }
        // else
        // {
        //     $request = 'Pending';
        //     $account = $this->pending();
        // }

        if(isset($_POST['encashall']))
        {
            $this->encashallwallet();
            $success = "Auto Encashment Success (Processed Request)";
            Log::Admin(Admin::info()->account_id,Admin::info()->account_username." encashed all wallet.");

            if(Request::input('processed') == 1)
            {
                 return Redirect::to('admin/transaction/payout/?processed=1')->with('success',$success);
            }
            else
            {
               return Redirect::to('admin/transaction/payout')->with('success',$success);
            }

        }

        if(isset($_POST['proccess']))
        {
            $this->singleprocess(Request::input('idtoprocess'));
            $success = "Single Process complete (Processed Request)";

            Log::Admin(Admin::info()->account_id,Admin::info()->account_username." processed the payout id #".Request::input('idtoprocess'));

            if(Request::input('processed') == 1)
            {
                 return Redirect::to('admin/transaction/payout/?processed=1')->with('success',$success);
            }
            else
            {
               return Redirect::to('admin/transaction/payout')->with('success',$success);
            }

        }


        if(isset($_POST['cancel_payout']))
        {
            $this->cancel_payout(Request::input('idtoprocess'));
            $success = "Return Wallet complete";

            Log::Admin(Admin::info()->account_id,Admin::info()->account_username." cancel the payout id #".Request::input('idtoprocess'));
            
            if(Request::input('processed') == 1)
            {
                 return Redirect::to('admin/transaction/payout/?processed=1')->with('success',$success);
            }
            else
            {
               return Redirect::to('admin/transaction/payout')->with('success',$success);
            }
        }


        // $data['data'] = $account;   
        return view('admin.transaction.payout',$data);
	}

    public function cancel_payout($id)
    {
            $enc = Tbl_account_encashment_history::where('status','Pending')->where('account_id',$id)->orderBy('account_id','DESC')->get(); 
            
            foreach($enc as $data)
            {
                 $slot = Tbl_slot::id($data->slot_id)->first();


                 $log = 'Your slot #'.$data->slot_id.' encashment has been cancelled and return the '.$data->amount.' amount to your wallet';

                 Log::slot($data->slot_id,$log,$data->amount,"Cancel encashment",$data->slot_id);                      
            } 

            Tbl_account_encashment_history::where('status','Pending')->where('account_id',$id)->orderBy('account_id','DESC')->update(['status'=>'Cancelled']); 
    }

    public function processall()
    {
            $e = Tbl_account_encashment_history::where('status','Processed')->orderBy('processed_no','DESC')->first(); 
            if(!isset($e))
            {
                $e = 1;
            }
            else
            {
                $e = $e->processed_no + 1;
            }

            $enc = Tbl_account_encashment_history::where('status','Pending')->orderBy('account_id','DESC')->get(); 
            
            foreach($enc as $data)
            {

                    if(!isset($forprocess))
                    {
                        $forprocess = $data->account_id;
                    }
                    else
                    {
                        if($forprocess == $data->account_id)
                        {
                            $e = $e;
                        }
                        else
                        {
                            $forprocess = $data->account_id;
                            $e = $e + 1;
                        }
                    }


                    $update['processed_no'] = $e; 
                    $update['status'] = 'Processed'; 
                    Tbl_account_encashment_history::where('request_id',$data->request_id)->update($update);                  
            }     
    }
    public function encashallwallet()
    {
            $e = Tbl_account_encashment_history::where('status','Processed')->orderBy('processed_no','DESC')->first(); 
            $slot = Tbl_slot::orderBy('slot_owner','ASC')->get();
            if(!isset($e->processed_no))
            {
              $e = 1;
            }
            else
            {
                $e->processed_no + 1;
            }

            foreach($slot as $data)
            {
                $slot_wallet = Tbl_wallet_logs::where("slot_id", $data->slot_id)->wallet()->sum('wallet_amount');
                if($slot_wallet != 0 && $slot_wallet >= 0)
                {
                    if(!isset($forprocess))
                    {
                        $forprocess = $data->slot_owner;
                    }
                    else
                    {
                        if($forprocess == $data->slot_owner)
                        {
                            $e = $e;
                        }
                        else
                        {
                            $forprocess = $data->slot_owner;
                            $e = $e + 1;
                        }
                    }

                    $totald = 0;
                    $deduction = Tbl_country::where('tbl_country.country_id',2)->deduct2()->deductioncountry2()->get();
                    foreach($deduction as $d)
                    {
                        if($d->percent == 1)
                        {
                            $totald = ($totald) + ($data->slot_wallet * ($d->deduction_amount/100));
                        }
                        else
                        {
                            $totald = ($totald) + ($d->deduction_amount);
                        }
                    }

                    $insert['slot_id'] = $data->slot_id;
                    $insert['account_id'] = $data->slot_owner;
                    $insert['amount'] = $slot_wallet;
                    $insert['encashment_date'] = Carbon::now();
                    $insert['deduction'] = $totald;
                    $insert['type'] = 'Cheque';
                    $insert['status'] = 'Processed';
                    $insert['processed_no'] = $e; 

                    // $update['slot_wallet'] = $data->slot_wallet - $data->slot_wallet;
                    // Tbl_slot::where('slot_id',$data->slot_id)->update($update);
                    Tbl_account_encashment_history::insert($insert);  
                    Log::slot($data->slot_id,'Encashed all remaining wallet by '.Admin::info()->account_name. '(' .Admin::info()->admin_position_name.')',0 - $slot_wallet,"Encash all wallet",$data->slot_id);                
                }
            }
    }

    public static function currency_format($price)
    {
        $currency = Config::get('app.currency');
        return number_format($price, 2);
    }

    public function singleprocess($id)
    {
            $e = Tbl_account_encashment_history::where('status','Processed')->orderBy('processed_no','DESC')->first(); 
            if(!isset($e))
            {
                $e = 1;
            }
            else
            {
                $e = $e->processed_no + 1;
            }

            $enc = Tbl_account_encashment_history::where('status','Pending')->where('account_id',$id)->orderBy('account_id','DESC')->get(); 
            
            foreach($enc as $data)
            {

                    if(!isset($forprocess))
                    {
                        $forprocess = $data->account_id;
                    }
                    else
                    {
                        if($forprocess == $data->account_id)
                        {
                            $e = $e;
                        }
                        else
                        {
                            $forprocess = $data->account_id;
                            $e = $e + 1;
                        }
                    }


                    $update['processed_no'] = $e; 
                    $update['status'] = 'Processed'; 
                    Tbl_account_encashment_history::where('request_id',$data->request_id)->update($update);                  
            } 
    }

    public function pending()
    {
            $account = Tbl_account_encashment_history::selectRaw('tbl_account_encashment_history.account_id, sum(amount) as sum')
                                                ->account()
                                                ->selectRaw('tbl_account.account_name, tbl_account.account_name')
                                                ->selectRaw('tbl_account_encashment_history.account_id, sum(deduction) as deduction')
                                                ->selectRaw('count(*) as count, slot_id')
                                                ->selectRaw('tbl_account_encashment_history.account_id, tbl_account_encashment_history.account_id')
                                                ->selectRaw('tbl_account.account_username, tbl_account.account_username')
                                                ->selectRaw('type, type')
                                                ->where('status','Pending')
                                                ->groupBy('account_id')
                                                ->groupBy('type')
                                                ->get();  

            foreach($account as $key => $a)
            {
                if(!isset($account[$key]->total))
                {
                    $account[$key]->total = $this->currency_format(($a->sum - $a->deduction)); 
                }
                else
                {
                    $account[$key]->total =  $this->currency_format(($account[$key]->total + $a->sum) - $a->deduction); 
                }
                 $account[$key]->sum =  $this->currency_format($a->sum);
                 $account[$key]->deduction = $this->currency_format($a->deduction);
                 $account[$key]->json = json_encode(Tbl_account_encashment_history::where('account_id',$a->account_id)->where('status','Pending')->where('type',$a->type)->get());
                 $d  = Tbl_account_encashment_history::where('account_id',$a->account_id)->orderBy('encashment_date','DESC')->where('status','Pending')->where('type',$a->type)->first();
                 $account[$key]->date = $d->encashment_date;   
            }

            return $account;
    }

    public function processed()
    {
            $account = Tbl_account_encashment_history::selectRaw('tbl_account_encashment_history.account_id, sum(amount) as sum')
                                                ->account()
                                                ->selectRaw('tbl_account.account_name, tbl_account.account_name')
                                                ->selectRaw('tbl_account_encashment_history.account_id, sum(deduction) as deduction')
                                                ->selectRaw('count(*) as count, slot_id')
                                                ->selectRaw('tbl_account_encashment_history.account_id, tbl_account_encashment_history.account_id')
                                                ->selectRaw('type, type')
                                                ->selectRaw('processed_no, processed_no')
                                                ->where('status','Processed')
                                                ->groupBy('processed_no')
                                                ->groupBy('type')
                                                ->get();  

            foreach($account as $key => $a)
            {
                if(!isset($account[$key]->total))
                {
                    $account[$key]->total = $this->currency_format(($a->sum - $a->deduction)); 
                }
                else
                {
                    $account[$key]->total =  $this->currency_format(($account[$key]->total + $a->sum) - $a->deduction); 
                }
                $account[$key]->sum =  $this->currency_format($a->sum);
                $account[$key]->deduction = $this->currency_format($a->deduction);
                $account[$key]->json = json_encode(Tbl_account_encashment_history::where('account_id',$a->account_id)->where('processed_no',$a->processed_no)->where('status','Processed')->where('type',$a->type)->get());
                $d  = Tbl_account_encashment_history::where('account_id',$a->account_id)->orderBy('encashment_date','DESC')->where('status','Processed')->where('type',$a->type)->first();
                $account[$key]->date = $d->encashment_date;   
            }

            return $account; 
    }

    public function data()
    {

            if(Request::input('processed') == 1)
            {
                $account = Tbl_account_encashment_history::selectRaw('tbl_account_encashment_history.account_id, sum(amount) as sum')
                                                    ->account()
                                                    ->selectRaw('tbl_account.account_name, tbl_account.account_name')
                                                    ->selectRaw('tbl_account_encashment_history.account_id, sum(deduction) as deduction')
                                                    ->selectRaw('count(*) as count, slot_id')
                                                    ->selectRaw('tbl_account_encashment_history.account_id, tbl_account_encashment_history.account_id')
                                                    ->selectRaw('type, type')
                                                    ->selectRaw('request_id, request_id')
                                                    ->selectRaw('processed_no, processed_no')
                                                    ->selectRaw('tbl_account.account_username, tbl_account.account_username')
                                                    ->selectRaw('checked, checked')
                                                    ->selectRaw('encashment_date, encashment_date')
                                                    ->where('status','Processed')
                                                    ->groupBy('processed_no')
                                                    ->groupBy('type')
                                                    ->orderBy('processed_no','ASC')
                                                    ->get();  

                foreach($account as $key => $a)
                {
                    if(!isset($account[$key]->total))
                    {
                        $account[$key]->total = $this->currency_format(($a->sum - $a->deduction)); 
                    }
                    else
                    {
                        $account[$key]->total =  $this->currency_format(($account[$key]->total + $a->sum) - $a->deduction); 
                    }
                    $account[$key]->sum =  $this->currency_format($a->sum);
                    $account[$key]->deduction = $this->currency_format($a->deduction);
                    $account[$key]->json = json_encode(Tbl_account_encashment_history::where('account_id',$a->account_id)->where('processed_no',$a->processed_no)->where('status','Processed')->where('type',$a->type)->get());
                    $d  = Tbl_account_encashment_history::where('account_id',$a->account_id)->orderBy('encashment_date','DESC')->where('status','Processed')->where('type',$a->type)->first();
                    $account[$key]->date = $d->encashment_date;   
                }
            }
            else
            {
                    $account = Tbl_account_encashment_history::selectRaw('tbl_account_encashment_history.account_id, sum(amount) as sum')
                                                        ->account()
                                                        ->selectRaw('request_id, request_id')
                                                        ->selectRaw('checked, checked')
                                                        ->selectRaw('tbl_account.account_name, tbl_account.account_name')
                                                        ->selectRaw('tbl_account_encashment_history.account_id, sum(deduction) as deduction')
                                                        ->selectRaw('count(*) as count, slot_id')
                                                        ->selectRaw('tbl_account_encashment_history.account_id, tbl_account_encashment_history.account_id')
                                                        ->selectRaw('tbl_account.account_username, tbl_account.account_username')
                                                        ->selectRaw('type, type')
                                                        ->where('status','Pending')
                                                        ->groupBy('account_id')
                                                        ->groupBy('type')
                                                        ->get();  

                    foreach($account as $key => $a)
                    {
                        if(!isset($account[$key]->total))
                        {
                            $account[$key]->total = $this->currency_format(($a->sum - $a->deduction)); 
                        }
                        else
                        {
                            $account[$key]->total =  $this->currency_format(($account[$key]->total + $a->sum) - $a->deduction); 
                        }
                         $account[$key]->sum =  $this->currency_format($a->sum);
                         $account[$key]->deduction = $this->currency_format($a->deduction);
                         $account[$key]->json = json_encode(Tbl_account_encashment_history::where('account_id',$a->account_id)->where('status','Pending')->where('type',$a->type)->get());
                         $d  = Tbl_account_encashment_history::where('account_id',$a->account_id)->orderBy('encashment_date','DESC')->where('status','Pending')->where('type',$a->type)->first();
                         $account[$key]->date = $d->encashment_date;   
                    }

            }


             return Datatables::of($account) ->addColumn('json','<a class="showmodal-b" json="{{$json}}" style="cursor:pointer;">Breakdown</a>')
                                             ->addColumn('checked','<input type="checkbox" {{$checked == 0 ?  "" : "checked"}} type="form-control" class="checked_container" request_id="{{$request_id}}">')
                                             ->addColumn('process','<a class="showmodal-p" style="cursor:pointer;" accid="{{$account_id}}"  accnm="{{$account_name}}" total="{{$total}}" deduction="{{$deduction}}" sum="{{$sum}}" type="{{$type}}">Proccess</a>')
                                             ->make(true);
    }
    
    public function checked()
    {
        $id     = Request::input("id");
        
        $payout = Tbl_account_encashment_history::where("request_id",$id)->first();
        
        if($payout)
        {
            if($payout->checked == 0)
            {
                $update["checked"] = 1;
            }
            else
            {
                $update["checked"] = 0;
            }
            
            Tbl_account_encashment_history::where("request_id",$id)->update($update);
        }    
            
        
        return json_encode("Success");
    }
}