<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
class SupplierController extends Controller
{
    public function createsupplier(){
        $customer_id    = Session::get('id');
        $token          = config('token');
        $curl           = curl_init();
        $data           = array(
            'token'         => $token,
            'customer_id'   => $customer_id,
        );
        $endpoint_url = config('endpoint_project');
        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint_url.'/api/createsupplier',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>  $data,
            CURLOPT_HTTPHEADER => array(
                'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
            ),
        ));
 
        $response = curl_exec($curl);
        $sign = json_decode($response);
        curl_close($curl);
        if($sign->message == 'success'){
            return view("template/frontend/userdashboard/pages/supplier/CreateSupplier");
        }else{
           return back()->with('error','Something Went Wrong');
        }
    }
    
    public function addsupplier(Request $req){
        
        $customer_id=Session::get('id');
        $token= config('token');
        $curl = curl_init();
        $data = array(
            'token'=>$token ?? "",
            'companyname'=>$req->companyname ?? "",
            'Companyaddress'=>$req->Companyaddress ?? "",
            'companyemail'=>$req->companyemail ?? "",
            'contactpersonname'=>$req->contactpersonname ?? "",
            'contactpersonemail'=>$req->contactpersonemail ?? "",
            'personcontactno'=>$req->personcontactno ?? "",
            'customer_id'=>$customer_id ?? "",
            'payment_method'=>$req->payment_method
        );
        
        $endpoint_url = config('endpoint_project');
        // dd($endpoint_url);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint_url.'/api/addsupplier',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>  $data,
            CURLOPT_HTTPHEADER => array(
                'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
            ),
        ));
 
        $response = curl_exec($curl);
        //   echo $response;
        $sign = json_decode($response);
        // dd();
      
        curl_close($curl);
        if($sign->message == 'success'){
            return redirect()->route('viewsupplier'); 
            // return back()->with('success','Supplier has been added successfully.');
        }else{
           return back()->with('error','Something Went Wrong');
        }
      
    }
    
    public function viewsupplier(){
        $customer_id=Session::get('id');
        $curl = curl_init();
        $data = array('customer_id'=>$customer_id);
        $endpoint_url = config('endpoint_project');
        // dd($endpoint_url);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint_url.'/api/fetchsupplier',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>  $data,
            CURLOPT_HTTPHEADER => array(
                'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
            ),
        ));
  
        $response = curl_exec($curl);
        //   echo $response;die;
        $sign = json_decode($response);
    
        if($sign->message == 'success'){
            $supplier = $sign->fetchedsupplier; 
            return view("template/frontend/userdashboard/pages/supplier/viewsupplier",compact('supplier'));
        }else{
            return view("template/frontend/userdashboard/pages/supplier/viewsupplier")->with('error','Supplier is not Available.');
        }
    }
    
    public function supplier_wallet_trans($id){
        $customer_id=Session::get('id');
        $curl = curl_init();
        $data = array('customer_id'=>$customer_id,'supplier_id'=>$id);
        
        $endpoint_url = config('endpoint_project');
        // dd($endpoint_url);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint_url.'/api/supplier_wallet_trans',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>  $data,
            CURLOPT_HTTPHEADER => array(
                'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
            ),
        ));
  
        $response = curl_exec($curl);
        //   echo $response;die;
        $sign = json_decode($response);
    
        if($sign->message == 'success'){
            $supplier = $sign->suppliers_trans; 
            return view("template/frontend/userdashboard/pages/supplier/wallet_transactions",compact('supplier'));
        }else{
            return view("template/frontend/userdashboard/pages/supplier/wallet_transactions")->with('error','Supplier is not Available.');
        }
    }
    
    public function deletesupplier($id){
        // dd($id);
   
   
    $curl = curl_init();
        // $currentURL = \URL::current();
              
        
    $data = array('id'=>$id);
        
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/deletesupplier',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
  
      $response = curl_exec($curl);
    //   echo $response;die;
    $sign = json_decode($response);
    
     if($sign->message == 'success'){
        
          return back()->with('success','Supplier has been deleted successfully.');
      }else{
          return back()->with('error','Supplier is not deleted...something went wrong!.');
      }
    }
    
    public function editsupplier($id){
        // dd("edit");
   
    $curl = curl_init();
       
        
    $data = array('id'=>$id);
        
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/editsupplier',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
  
      $response = curl_exec($curl);
    //   echo $response;die;
    $sign = json_decode($response);
    
     if($sign->message == 'success'){
         $supplier = $sign->fetchedsupplier;
        //  dd($supplier);
          return view("template/frontend/userdashboard/pages/supplier/editsupplier",compact('supplier'));
      }else{
           return back()->with('error','Supplier is no longer Available in Our record.');
      }
    
        
    }
    
    public function updatesupplier(Request $req,$id){
        // dd($id);
    
   
    $curl = curl_init();
    
              
        
    $data = array(
    'id'=>$id,
    'companyname'=>$req->companyname ?? "",
    'Companyaddress'=>$req->Companyaddress ?? "",
    'companyemail'=>$req->companyemail ?? "",
    'contactpersonname'=>$req->contactpersonname ?? "",
    'contactpersonemail'=>$req->contactpersonemail ?? "",
    'personcontactno'=>$req->personcontactno ?? "",
    
    );
        
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/updatesupplier',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
  
      $response = curl_exec($curl);
    //   echo $response;die;
    $sign = json_decode($response);
    
     if($sign->message == 'success'){
        return redirect()->route('viewsupplier'); 
        //  return back()->with('success','Supplier is Updated.');
      }else{
        return back()->with('error','Something Went Wrong');
      }
    
        
    }
    
    public function createseat(){
        // dd("gdgd");
        $curl = curl_init();
        // $currentURL = \URL::current();
        $customer_id = 1; 
        
    $data = array('customer_id'=>$customer_id);
        
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/fetchallsupplierforseats',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
  
      $response = curl_exec($curl);
    //   echo $response;die;
    $sign = json_decode($response);
    
     if($sign->message == 'success'){
         $supplier = $sign->fetchedsupplier;
         $airline = $this->fetchairline();
        //  dd($airline);
          return view("template/frontend/userdashboard/pages/supplier/Createseat",compact('supplier','airline'));
      }
        
        
        
    }
    
    public function createseat1(){
        // dd("gdgd");
        $curl = curl_init();
        // $currentURL = \URL::current();
        $customer_id = 1; 
        
    $data = array('customer_id'=>$customer_id);
        
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/fetchallsupplierforseats',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
  
      $response = curl_exec($curl);
    //   echo $response;die;
    $sign = json_decode($response);
    
     if($sign->message == 'success'){
         $supplier = $sign->fetchedsupplier;
         $airline = $this->fetchairline();
        //  dd($airline);
          return view("template/frontend/userdashboard/pages/supplier/Createseat1",compact('supplier','airline'));
      }
        
        
        
    }
    
    public function addseat(Request $req){
    //   dd($req);
    $customer_id=Session::get('id');
    // dd($customer_id);
    $token= config('token');
    $curl = curl_init();
  
    
    $data = array(
    'customer_id'=>$customer_id ?? "0",
    'token'=>$token ?? "",
    'flight_type'=>$req->flight_type ?? "",
    'selected_flight_airline'=>$req->selected_flight_airline ?? "",
    'supplier'=>$req->supplier ?? "",
    'no_of_stays'=>$req->no_of_stays ?? "",
    'departure_airport_code'=>$req->departure_airport_code ?? "",
    'arrival_airport_code'=>$req->arrival_airport_code ?? "",
    'other_Airline_Name2'=>$req->other_Airline_Name2 ?? "",
    'departure_Flight_Type'=>$req->departure_Flight_Type ?? "",
    'departure_flight_number'=>$req->departure_flight_number ?? "",
    'departure_time'=>$req->departure_time ?? "",
    'arrival_time'=>$req->arrival_time ?? "",
    'total_Time'=>$req->total_Time ?? "",
    
     'more_departure_airport_code' => json_encode($req->more_departure_airport_code) ?? "",
      'more_arrival_airport_code' => json_encode($req->more_arrival_airport_code) ?? "",
      'more_other_Airline_Name2' => json_encode($req->more_other_Airline_Name2) ?? "",
      'more_departure_Flight_Type' => json_encode($req->more_departure_Flight_Type) ?? "",
      'more_departure_flight_number' => json_encode($req->more_departure_flight_number) ?? "",
      'more_departure_time' => json_encode($req->more_departure_time) ?? "",
      'more_arrival_time' => json_encode($req->more_arrival_time) ?? "",
      'more_total_Time' => json_encode($req->more_total_Time) ?? "",
    
    'return_departure_airport_code'=>$req->return_departure_airport_code ?? "",
    'return_arrival_airport_code'=>$req->return_arrival_airport_code ?? "",
    'return_other_Airline_Name2'=>$req->return_other_Airline_Name2 ?? "",
    'return_departure_Flight_Type'=>$req->return_departure_Flight_Type ?? "",
    'return_departure_flight_number'=>$req->return_departure_flight_number ?? "",
    'return_departure_time'=>$req->return_departure_time ?? "",
    'return_arrival_time'=>$req->return_arrival_time ?? "",
    'return_total_Time'=>$req->return_total_Time ?? "",
    
     "return_more_departure_airport_code" => json_encode($req->return_more_departure_airport_code) ?? "",
      "return_more_arrival_airport_code" => json_encode($req->return_more_arrival_airport_code) ?? "",
      "return_more_other_Airline_Name2" => json_encode($req->return_more_other_Airline_Name2) ?? "",
      "return_more_departure_Flight_Type" => json_encode($req->return_more_departure_Flight_Type) ?? "",
      "return_more_departure_flight_number" => json_encode($req->return_more_departure_flight_number) ?? "",
      "return_more_departure_time" => json_encode($req->return_more_departure_time) ?? "",
      "return_more_arrival_time" => json_encode($req->return_more_arrival_time) ?? "",
      "return_more_total_Time" => json_encode($req->return_more_total_Time) ?? "",
    
    'flights_per_person_price'=>$req->flights_per_person_price ?? "",
    'flights_number_of_seat'=>$req->flights_number_of_seat ?? "",
    'flights_per_seat_price'=>$req->flights_per_seat_price ?? "",
    'flights_per_child_price'=>$req->flights_per_child_price ?? "",
    'flights_per_infant_price'=>$req->flights_per_infant_price ?? "",
    'flights_total_price'=>$req->flights_total_price ?? "",
    'connected_flights_duration_details'=>$req->connected_flights_duration_details ?? "",
    'terms_and_conditions'=>$req->terms_and_conditions ?? "",
    );
    
   
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/createseat',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
  
      $response = curl_exec($curl);
 //echo $response;die;
    $sign = json_decode($response);
    // dd();
      
      curl_close($curl);
      if($sign->message == 'success'){
          return back()->with('success','Flight has been added successfully.');
      }else{
           return back()->with('error','Flight is not Added.');
      }
      
    }
    
    public function addseat1(Request $req){
        
        $departure_airport_code     = $req->departure_airport_code ?? "";
        $arrival_airport_code       = $req->arrival_airport_code ?? "";
        $other_Airline_Name2        = $req->other_Airline_Name2 ?? "";
        $departure_Flight_Type      = $req->departure_Flight_Type ?? "";
        $departure_flight_number    = $req->departure_flight_number ?? "";
        $departure_time             = $req->departure_time ?? "";
        $arrival_time               = $req->arrival_time ?? "";
        $total_Time                 = $req->total_Time ?? "";
        
        $main_departure_array= [];
        if(isset($departure_airport_code) && $departure_airport_code != null && $departure_airport_code != ''){
            foreach($departure_airport_code as $key => $val){
                if($val != '' && $val != null){
                    $dep_singel_arr=[
                        'departure'                 => $val,
                        'arival'                    => $arrival_airport_code[$key],
                        'airline'                   => $other_Airline_Name2[$key],
                        'departure_flight_type'     => $departure_Flight_Type[$key],
                        'departure_flight_number'   => $departure_flight_number[$key],
                        'departure_time'            => $departure_time[$key],
                        'arrival_time'              => $arrival_time[$key],
                        'total_Time'                => $total_Time[$key] ?? "",
                    ];
                    array_push($main_departure_array,$dep_singel_arr);
                }
            }
            $main_departure_array = json_encode($main_departure_array);
        }else{
            $main_departure_array = '';
        }
        
        $return_departure_airport_code  = $req->return_departure_airport_code ?? "";
        $return_arrival_airport_code    = $req->return_arrival_airport_code ?? "";
        $return_other_Airline_Name2     = $req->return_other_Airline_Name2 ?? "";
        $return_departure_Flight_Type   = $req->return_departure_Flight_Type ?? "";
        $return_departure_flight_number = $req->return_departure_flight_number ?? "";
        $return_departure_time          = $req->return_departure_time ?? "";
        $return_arrival_time            = $req->return_arrival_time ?? "";
        $return_total_Time              = $req->return_total_Time ?? "";
        
        $main_return_array= [];
        if(isset($departure_airport_code) && $departure_airport_code != null && $departure_airport_code != ''){
            foreach($return_departure_airport_code as $key => $val){
                if($val != '' && $val != null){
                    $dep_singel_arr=[
                        'departure'                 => $val,
                        'arival'                    => $return_arrival_airport_code[$key],
                        'airline'                   => $return_other_Airline_Name2[$key],
                        'departure_flight_type'     => $return_departure_Flight_Type[$key],
                        'departure_flight_number'   => $return_departure_flight_number[$key],
                        'departure_time'            => $return_departure_time[$key],
                        'arrival_time'              => $return_arrival_time[$key],
                        'total_Time'                => $return_total_Time[$key],
                    ];
                    array_push($main_return_array,$dep_singel_arr);
                }
            }
            $main_return_array = json_encode($main_return_array);
        }else{
            $main_return_array = '';
        }
     
        $customer_id=Session::get('id');
        $token= config('token');
        $curl = curl_init();
  
        $data = array(
            'customer_id'                           => $customer_id ?? "0",
            'token'                                 => $token ?? "",
            
            'dep_supplier'                          => $req->supplier ?? "",
            'dep_flight_type'                       => $req->flight_type ?? "",
            'dep_airline'                           => $req->selected_flight_airline ?? "",
            'dep_no_of_stay'                        => $req->no_of_stays ?? "",
            'dep_object'                            => $main_departure_array ?? "",
            
            'return_supplier'                       => $req->return_supplier ?? "",
            'return_flight_type'                    => $req->return_flight_type ?? "",
            'return_airline'                        => $req->return_selected_flight_airline ?? "",
            'return_no_of_stay'                     => $req->return_no_of_stays ?? "",
            'return_object'                         => $main_return_array,
            
            'flights_per_person_price'              => $req->flights_per_person_price ?? "",
            'flights_number_of_seat'                => $req->flights_number_of_seat ?? "",
            'flights_per_seat_price'                => $req->flights_per_seat_price ?? "",
            'flights_per_child_price'               => $req->flights_per_child_price ?? "",
            'flights_per_infant_price'              => $req->flights_per_infant_price ?? "",
            'flights_total_price'                   => $req->flights_total_price ?? "",
            
            'connected_flights_duration_details'    => $req->connected_flights_duration_details ?? "",
            'terms_and_conditions'                  => $req->terms_and_conditions ?? "",
        );
        // dd($data);
        
        $endpoint_url = config('endpoint_project');
        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint_url.'/api/createseat1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>  $data,
            CURLOPT_HTTPHEADER => array(
                'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
            ),
        ));
 
        $response = curl_exec($curl);
        $sign = json_decode($response);
        curl_close($curl);
        if($sign->message == 'success'){
            return redirect()->route('viewseat');
        }else{
           return back()->with('error','Flight is not Added.');
        }
    }
    
    public function viewseat(){
        // dd("gdgd");
    $customer_id=Session::get('id');
   
    $curl = curl_init();
        
    $data = array('customer_id'=>$customer_id);
        
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/fetchseat',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
  
      $response = curl_exec($curl);
        //  echo $response;die;
    $sign = json_decode($response);
    
     if($sign->message == 'success'){
         $flight = $sign->fetchedsupplier; 
         $flight_count = $sign->tours_arr; 
        
       
          return view("template/frontend/userdashboard/pages/supplier/viewseat",compact('flight','flight_count'));
      }else{
          return view("template/frontend/userdashboard/pages/supplier/viewseat")->with('error','Flights are not Available.');
      }
    
    }
    
    public function deleteseat($id){
        // dd($id);
   
   
    $curl = curl_init();
        // $currentURL = \URL::current();
              
        
    $data = array('id'=>$id);
        
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/deleteseat',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
  
      $response = curl_exec($curl);
    //   echo $response;die;
    $sign = json_decode($response);
    
     if($sign->message == 'success'){
        
          return back()->with('success','Flight has been deleted successfully.');
      }else{
          return back()->with('error','Flight is not deleted...something went wrong!.');
      }
    }
    
    public function editseat($id){
        // dd("edit");
   
    $curl = curl_init();
       
        
    $data = array('id'=>$id);
        
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/editseat',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
  
      $response = curl_exec($curl);
    //   echo $response;die;
    $sign = json_decode($response);
    
     if($sign->message == 'success'){
         $flights_details = $sign->fetchedsupplier;
      
         
           $curl = curl_init();
        // $currentURL = \URL::current();
        $customer_id = 1; 
        
    $data = array('customer_id'=>$customer_id);
        
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/fetchallsupplierforseats',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
  
      $response = curl_exec($curl);
    //   echo $response;die;
    $sign = json_decode($response);
         
        if($sign->message == 'success'){
        $supplier = $sign->fetchedsupplier; 
        }else{
        $supplier = null; 
        }
         
          $airline = $this->fetchairline();
         
         
         
         
         
        //  dd($supplier);
          return view("template/frontend/userdashboard/pages/supplier/editseat",compact('flights_details','supplier','airline'));
      }else{
           return back()->with('error','Flight is no longer Available in Our record.');
      }
    
        
    }
    
    public function updateseat(Request $req,$id){
        // dd($req);
    $customer_id=Session::get('id');
    $token= config('token');
    $curl = curl_init();
 
    
    $data = array(
    'id'=>$id ?? "",
    'customer_id'=>$customer_id ?? "",
    'token'=>$token ?? "",
    'flight_type'=>$req->flight_type ?? "",
    'supplier'=>$req->supplier ?? "",
    'selected_flight_airline'=>$req->selected_flight_airline ?? "",
    'no_of_stays'=>$req->no_of_stays ?? "",
    'departure_airport_code'=>$req->departure_airport_code ?? "",
    'arrival_airport_code'=>$req->arrival_airport_code ?? "",
    'other_Airline_Name2'=>$req->other_Airline_Name2 ?? "",
    'departure_Flight_Type'=>$req->departure_Flight_Type ?? "",
    'departure_flight_number'=>$req->departure_flight_number ?? "",
    'departure_time'=>$req->departure_time ?? "",
    'arrival_time'=>$req->arrival_time ?? "",
    'total_Time'=>$req->total_Time ?? "",
    
     'more_departure_airport_code' => json_encode($req->more_departure_airport_code) ?? "",
      'more_arrival_airport_code' => json_encode($req->more_arrival_airport_code) ?? "",
      'more_other_Airline_Name2' => json_encode($req->more_other_Airline_Name2) ?? "",
      'more_departure_Flight_Type' => json_encode($req->more_departure_Flight_Type) ?? "",
      'more_departure_flight_number' => json_encode($req->more_departure_flight_number) ?? "",
      'more_departure_time' => json_encode($req->more_departure_time) ?? "",
      'more_arrival_time' => json_encode($req->more_arrival_time) ?? "",
      'more_total_Time' => json_encode($req->more_total_Time) ?? "",
    
    'return_departure_airport_code'=>$req->return_departure_airport_code ?? "",
    'return_arrival_airport_code'=>$req->return_arrival_airport_code ?? "",
    'return_other_Airline_Name2'=>$req->return_other_Airline_Name2 ?? "",
    'return_departure_Flight_Type'=>$req->return_departure_Flight_Type ?? "",
    'return_departure_flight_number'=>$req->return_departure_flight_number ?? "",
    'return_departure_time'=>$req->return_departure_time ?? "",
    'return_arrival_time'=>$req->return_arrival_time ?? "",
    'return_total_Time'=>$req->return_total_Time ?? "",
    
     "return_more_departure_airport_code" => json_encode($req->return_more_departure_airport_code) ?? "",
      "return_more_arrival_airport_code" => json_encode($req->return_more_arrival_airport_code) ?? "",
      "return_more_other_Airline_Name2" => json_encode($req->return_more_other_Airline_Name2) ?? "",
      "return_more_departure_Flight_Type" => json_encode($req->return_more_departure_Flight_Type) ?? "",
      "return_more_departure_flight_number" => json_encode($req->return_more_departure_flight_number) ?? "",
      "return_more_departure_time" => json_encode($req->return_more_departure_time) ?? "",
      "return_more_arrival_time" => json_encode($req->return_more_arrival_time) ?? "",
      "return_more_total_Time" => json_encode($req->return_more_total_Time) ?? "",
    
     'flights_per_person_price'=>$req->flights_per_person_price ?? "",
    'flights_number_of_seat'=>$req->flights_number_of_seat ?? "",
    'flights_per_seat_price'=>$req->flights_per_seat_price ?? "",
    'flights_per_child_price'=>$req->flights_per_child_price ?? "",
    'flights_per_infant_price'=>$req->flights_per_infant_price ?? "",
     'flights_total_price'=>$req->flights_total_price ?? "",
    'connected_flights_duration_details'=>$req->connected_flights_duration_details ?? "",
    'terms_and_conditions'=>$req->terms_and_conditions ?? "",
    );
  
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/updateseat',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
      $response = curl_exec($curl);
    //   echo $response;die;
    $sign = json_decode($response);
    
     if($sign->message == 'success'){
     
          return back()->with('success','Seat is Updated Sucessfully.');
      }else{
          return back()->with('error','Something went wrong while update.');
      }
    
        
    }
    
    public function addnewflight(Request $req){
     dd($req->title);
    
    $curl = curl_init();
  
    
    $data = array(
    'customer_id'=>$customer_id ?? "",
    );
    
   
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/createseat',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
  
      $response = curl_exec($curl);
    //   echo $response;die;
    $sign = json_decode($response);
    // dd();
      
      curl_close($curl);
      if($sign->message == 'success'){
          return back()->with('success','Flight has been added successfully.');
      }else{
           return back()->with('error','Flight is not Added.');
      }
      
    }
    
    function fetchairline(){
            $curl = curl_init();
        // $currentURL = \URL::current();
        $customer_id = 1; 
        
    $data = array('customer_id'=>$customer_id);
        
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/fetchairline',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
  
      $response = curl_exec($curl);
    //   echo $response;die;
      $sign = json_decode($response);
    
     if($sign->message == 'success'){
         $airline = $sign->fetchedairline;
          return $airline;
      }
     
        
    }
    
    public function save_flight_payment_recieved_and_remaining(Request $req){
    //   dd($req);
     $curl = curl_init();
    $data = array(
    'flightId'=>$req->flightId ?? "",
    'payingidentityemail'=>$req->payingidentityemail ?? "",
    'payingidentityid'=>$req->payingidentityid ?? "",
    'date'=>$req->date ?? "",
    'total_amount'=>$req->total_amount ?? "",
    'remaining_amount'=>$req->remaining_amount ?? "",
    'amount_paid'=>$req->amount_paid ?? "",
    'payment_method'=>$req->payment_method
    );
    
   
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/save_flight_payment_recieved_and_remaining',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
      $response = curl_exec($curl);
    //   echo $response;die;
    $sign = json_decode($response);
    // dd();
      
      curl_close($curl);
      if($sign->status == 'success'){
          return back()->with('success','Payment has been added successfully.');
      }else{
           return back()->with('error','Payment is not Added.');
      }
   }
   
    public function supplier_stats($id){
     $curl = curl_init();
	$token= config('token');
    $data = array(
    'supplier_id'=>$id,
    'token'=>$token
    );
    
    
   
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/supplier_stats_details',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
      $response = curl_exec($curl);
    //   echo $response;die;
    $stats_data = json_decode($response);
    $stats_data = $stats_data->supplier_data;
    // print_r($stats_data);
    // die;
      curl_close($curl);
    
    // $status_data = '';
    //   if($sign->status == 'success'){
           return view("template/frontend/userdashboard/pages/supplier/supplier_stats",compact('stats_data'));
    //   }else{
    //       return back()->with('error','Payment is not Added.');
    //   }
   }
   
    public function get_suppliers_flights_detail(Request $req){
    //   dd($req);
     $curl = curl_init();

    $data = array(
    'supplierId'=>$req->supplierId ?? "",
    );
    
   
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/get_suppliers_flights_detail',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
      $response = curl_exec($curl);
    //   echo $response;die;
    $sign = json_decode($response);
    // dd();
      
      curl_close($curl);
      if($sign->message == 'success'){
           $suppliers = $sign->fetchedsupplier;
         return $suppliers;
      }
   }
   
    public function get_suppliers_flights_rute(Request $req){
            //   dd($req->flight);
        $flight_id = $req->flight;
 
          $curl = curl_init();

    $data = array(
    'flight_id'=>$flight_id ?? "",
    );
    
   
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/get_suppliers_flights_rute',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
      $response = curl_exec($curl);
    //   echo $response;die;
    $sign = json_decode($response);
    // dd();
      
      curl_close($curl);
      if($sign->message == 'success'){
           $suppliers = $sign->fetchedsupplier;
         return $suppliers;
      }
   }
   
    public function view_seat_occupancy($id){
            //   dd($req->flight);
        $flight_id = $id;
 
          $curl = curl_init();

    $data = array(
    'flight_id'=>$flight_id ?? "",
    );
    
   
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/view_seat_occupancy',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
      $response = curl_exec($curl);
    //   echo $response;die;
    $sign = json_decode($response);
    // dd();
      curl_close($curl);
      if($sign->message == 'success'){
           $suppliers = $sign->fetchedsupplier;
        return view("template/frontend/userdashboard/pages/supplier/seatoccupancy",compact('suppliers'));
      }
   }
   
    public function invoice_for_occupancy($id){
            //   dd($req->flight);
        $tour_id = $id;
 
          $curl = curl_init();

    $data = array(
    'tour_id'=>$tour_id ?? "",
    );
    
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/invoice_for_occupancy',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
      $response = curl_exec($curl);
    //   echo $response;die;
    $sign = json_decode($response);
    // dd($sign);
      
      curl_close($curl);
      if($sign->message == 'success'){
           $invoices = $sign->fetchedsupplier;
        return view("template/frontend/userdashboard/pages/supplier/invoice_for_occupancy",compact('invoices'));
      }
   }
   
    public function fetchflightrate(Request $req){
            //   dd($req->flight);
        $tourId = $req->tourId;
 
          $curl = curl_init();

    $data = array(
    'tourId'=>$tourId ?? "",
    );
    
   
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/fetchflightrate',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
      $response = curl_exec($curl);
    //   echo $response;die;
    $sign = json_decode($response);
    // dd($sign);
      
      curl_close($curl);
      if($sign->message == 'success'){
           $invoices = $sign->fetchedsupplier;
        return $invoices;
      }
   }
   
    public function pax_details($id){
            //   dd($req->flight);
        $invoice_no = $id;
 
          $curl = curl_init();

    $data = array(
    'invoice_no'=>$invoice_no ?? "",
    );
    
   
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/pax_details',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
      $response = curl_exec($curl);
    //   echo $response;die;
    $sign = json_decode($response);
    // dd($sign);
      
      curl_close($curl);
      if($sign->message == 'success'){
           $invoices = $sign->fetchedsupplier;
       return view("template/frontend/userdashboard/pages/supplier/pax_details",compact('invoices'));
      }
   }
   
    public function passport_Supplier1(){
        // dd("edit");
 
    
    return view("template/frontend/userdashboard/pages/supplier/passport_Supplier");
    
        
    }
    
    public function passport_Supplier2(){
        // dd("edit");
 
    
    return view("template/frontend/userdashboard/pages/supplier/dynamsoft");
    
        
    }
    
    public function Uploadpassport(Request $req){
        // dd($req->all());
        
        
        if($req->file('file')){
          
                $img_file = $req->file('file');
                $name_gen = hexdec(uniqid());
                $img_ext = strtolower($img_file->getClientOriginalExtension());
                $img_name = $name_gen.".".$img_ext;
                $upload = 'public/images/passportimg/';
                $file_upload = $img_file->move($upload,$img_name);
                if($file_upload){
                echo $img_name;
                }
            
        }
 
    
    
    
        
    }
    
    public function view_chart(){
        
       
       
       $curl = curl_init();

    $data = array(
   
    );
    
   
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/fetchallhotels',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
      $response = curl_exec($curl);
    //   echo $response;die;
    $sign = json_decode($response);
    // dd($sign);
     
      curl_close($curl);
      if($sign->message == 'success'){
           $hotels = $sign->fetchedsupplier;
       return view("template/frontend/userdashboard/pages/supplier/view_chart",compact('hotels'));
      }
       
       
        
       
       
 
    
        
    }
    
    public function chart_data(Request $req){
       $curl = curl_init();
    $data = array(
    "hotel_id"=>$req->hotel,
    "startDate" => $req->startDate,
    "includingDate" => $req->includingDate,
    );
 
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/fetchhotelrecord',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
      $response = curl_exec($curl);
    // echo $response;die;
    $sign = json_decode($response);
    // dd($sign);
      curl_close($curl);
      return [
     "dates" => $sign->dates,
     "rooms_records" => $sign->rooms_records,
  
 
     ];


    }
    
    public function supplierdetail(Request $req){
        
    //   dd("here");
    
      
       
       $curl = curl_init();

    $data = array(
    "supplier_id"=>$req->supplier_id,
    );
    
   
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/supplierdetail',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
      $response = curl_exec($curl);
    //   echo $response;die;
    $sign = json_decode($response);
    // dd($sign->dates);
      
      curl_close($curl);
      
    
    
     if($sign->message == 'success'){
         $sup = $sign->fetchedsupplier; 
        echo json_encode($sup);
      }else{
          return back()->with('error','Flight is not deleted...something went wrong!.');
      }
       
        
       
       
 
    
    
        
    }
    
    public function getbooking(Request $req){
    //   dd($req);
     $curl = curl_init();
    
    $data = array(
    "hotel"=>$req->hotel,
    "roomid"=>$req->roomid,
    "suplier"=>$req->suplier,
    "type"=>$req->type,
    "currentDate"=>$req->current_date,
    "startDate"=>$req->startDate,
    "includingDate"=>$req->includingDate,
    );
    $endpoint_url = config('endpoint_project');
    // dd($endpoint_url);
      curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint_url.'/api/getbooking',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>  $data,
      CURLOPT_HTTPHEADER => array(
        'Cookie: laravel_session=gnq21xtzzbBtgOgSa0iVWPIX9vSDzHcKrUozAnSL'
      ),
      ));
      $response = curl_exec($curl);
    //   echo $response;die;
      $sign = json_decode($response);
    // dd($sign->dates);
      
      curl_close($curl);

     if($sign->message == 'success'){
         $sup =[
             'record'=>$sign->fetchedsupplier,
             'type'=>$sign->type,
             ];
             
        //  dd($sup);
        echo json_encode($sup);
      }else{
          return back()->with('error','Flight is not deleted...something went wrong!.');
      }
       
        
       
       
 
    

    
        
    }
}
