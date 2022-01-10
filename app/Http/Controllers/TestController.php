<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
use Session;
use Redirect;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Str;
use Auth;
use Theme;
use Botble\RealEstate\Repositories\Interfaces\ProjectInterface;
use Botble\RealEstate\Repositories\Interfaces\CategoryInterface;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\SeoHelper\SeoOpenGraph;
use SeoHelper;
use Botble\RealEstate\Models\Property;
use Botble\RealEstate\Repositories\Interfaces\PropertyInterface;

class TestController extends Controller
{
  public function  updateData(Request $request){
      $update = DB::table('feedback')->where('id',$request->feed_id)->update([
        "name"=>$request->name,
        "email"=>$request->email,
        "phone"=>$request->phone,
        "message"=>$request->message
      ]);
      return view('feedback');
  }

  public function fetchData(Request $request, $user_id){
       $fetch = DB::table('feedback')->where('id',$user_id)->first();
       // echo $fetch;
      return view('editFeedback',compact('fetch'));
     // return  view('editFeedback');
  }

  public function showData(Request $request){
    return view('feedback');
  }

   public function  destroy(Request $request, $u_id){
       // $delete = DB::table('feedback')->get();
       $res = DB::delete('delete from feedback where id = ?',[$u_id]);
      // return back()->withInput('data deleted successfully');
      // echo "data deleted successfully";
       return redirect()->route('admin.feed')->with('data deleted successfully');
     // // print_r($delete);
     // $delete->delete();
     // if ($res){
     //   $data=[
     //     'status'=>'1',
     //     'msg'=>'success'
     //   ];
     // }

   }
   public function insertmaintenanceData(Request $request){

    $slug = Str::slug($request->name);

    $image = NULL;
    $video = NULL;
    $icon = NULL;
    if($request->hasFile('image')){

        foreach ($request->image as $key => $value) {
            $resizeFileName1 = time();
            $uploadPath1 = 'public/storage/accounts';
            $uploadPathAc1 = 'public/storage/accounts';
            $backImage1= rand(1111,9999).'image'.$resizeFileName1;
            $ext1=strtolower($value->getClientOriginalExtension());
            $image_full_name1=$backImage1.'.'.$ext1;
            $upload_path1=$uploadPath1;
            $success1=$value->move($upload_path1,$image_full_name1);
            $url1 = $uploadPathAc1.'/'.$image_full_name1;
            $imageSS[] = $url1;

        }

        $image = json_encode($imageSS);

        
    }

    if($request->hasFile('video')){
        $resizeFileName2 = time();
        $uploadPath2 = 'public/storage/videos';
        $uploadPathAc2 = 'public/storage/videos';
        $backImage2= rand(1111,9999).'image'.$resizeFileName2;
        $ext2=strtolower($request->video->getClientOriginalExtension());
        $image_full_name2=$backImage2.'.'.$ext2;
        $upload_path2=$uploadPath2;
        $success2=$request->video->move($upload_path2,$image_full_name2);
        $url2 = $uploadPathAc2.'/'.$image_full_name2;
        $video = $url2;

    }



    if($request->hasFile('icon')){
          $resizeFileName3 = time();
          $uploadPath3 = 'public/storage/videos';
          $uploadPathAc3 = 'public/storage/videos';
          $backImage3= rand(1111,9999).'_icon_image_'.$resizeFileName3;
          $ext3=strtolower($request->icon->getClientOriginalExtension());
          $image_full_name3=$backImage3.'.'.$ext3;
          $upload_path3=$uploadPath3;
          $success3=$request->icon->move($upload_path3,$image_full_name3);
          $url3 = $uploadPathAc3.'/'.$image_full_name3;
          $icon = $url3;

      }



     $insert = DB::table('maintenance')->insert([
      "name"=>$request->name,
      "slug"=>$slug,
      "icon"=>$icon,
      "description"=>$request->description,
      "image"=>$image,
      "video"=>$video
     ]);
          return redirect()->back();
   }

   public function maintenanceUpdateFunction(Request $request){
        $sqlList = DB::table('maintenance')->where('id' , $request->id)->first();


        if($request->hasFile('image')){

            foreach ($request->image as $key => $value) {
                $resizeFileName1 = time();
                $uploadPath1 = 'public/storage/accounts';
                $uploadPathAc1 = 'public/storage/accounts';
                $backImage1= rand(1111,9999).'image'.$resizeFileName1;
                $ext1=strtolower($value->getClientOriginalExtension());
                $image_full_name1=$backImage1.'.'.$ext1;
                $upload_path1=$uploadPath1;
                $success1=$value->move($upload_path1,$image_full_name1);
                $url1 = $uploadPathAc1.'/'.$image_full_name1;
                $imageSS[] = $url1;

            }

            $image = json_encode($imageSS);

            
        }else{
            $image = $sqlList->image;
        }

        if($request->hasFile('video')){
            $resizeFileName2 = time();
            $uploadPath2 = 'public/storage/videos';
            $uploadPathAc2 = 'public/storage/videos';
            $backImage2= rand(1111,9999).'image'.$resizeFileName2;
            $ext2=strtolower($request->video->getClientOriginalExtension());
            $image_full_name2=$backImage2.'.'.$ext2;
            $upload_path2=$uploadPath2;
            $success2=$request->video->move($upload_path2,$image_full_name2);
            $url2 = $uploadPathAc2.'/'.$image_full_name2;
            $video = $url2;

        }else{
            $video = $sqlList->video;
        }



        if($request->hasFile('icon')){
            $resizeFileName3 = time();
            $uploadPath3 = 'public/storage/videos';
            $uploadPathAc3 = 'public/storage/videos';
            $backImage3= rand(1111,9999).'_icon_image_'.$resizeFileName3;
            $ext3=strtolower($request->icon->getClientOriginalExtension());
            $image_full_name3=$backImage3.'.'.$ext3;
            $upload_path3=$uploadPath3;
            $success3=$request->icon->move($upload_path3,$image_full_name3);
            $url3 = $uploadPathAc3.'/'.$image_full_name3;
            $icon = $url3;

        }else{
            $icon = $sqlList->icon;
        }



        $slug = Str::slug($request->name);

        $sqlUpdate = DB::table('maintenance')->where('id' , $request->id)->update([
            "name"=>$request->name,
              "slug"=>$slug,
              "icon"=>$icon,
              "description"=>$request->description,
              "image"=>$image,
              "video"=>$video
        ]);

        return redirect()->back();
   }

   public function deleteMaintenanceFunction($id){
    $sqlDelete = DB::table('maintenance')->where('id' , $id)->delete();
    return redirect()->back();
   }

   public function propertyReportFunction(Request $request , $type , $name){
      $sqlInsert = DB::table('property_report')->insert([
        "reportName" => $type,
        "propertyName" => $name,
        "ipAddress" => $request->ip(),
        "createdDate" => date('Y-m-d H:i:s')
      ]);

      return redirect()->back();
   }

   public function pointsadd(Request $request){
     $add = DB::table('points')->insert([
       "property_add_value" =>$request->property_add_value,
       "points_in_rupees" =>$request->points_in_rupees,
       "purchase_points" =>$request->purchase_points
     ]);
        if($add){
          return redirect()->back()->with('data added successfully');
        }else {
          return redirect()->back('something went wrong');
        }
   }

   public function insert(Request $request ){
    
      
         $insert = DB::table('section')->insert([
           'first_name'=>$request->first_name,
           'last_name'=>$request->last_name,
           'email'=>$request->email,
           'phone_number'=>$request->phone_number,
           'address'=>$request->address,

         ]);
         
          $this->send_mail($request);    
        return redirect()->back();
        }

    public function test_mail($request){
      
      $mailHost = $this->getSettingConfig('email_host');
      $mailUserName = $this->getSettingConfig('email_username');
      $mailPassword = $this->getSettingConfig('email_password');
      $mailAddress = $this->getSettingConfig('email_from_address');
      $mailName = $this->getSettingConfig('email_from_name');
      require base_path("vendor\autoload.php");
      echo base_path("vendor\autoload.php");
        $mail = new PHPMailer();   
        $mail->isSMTP();                          
        $mail->SMTPDebug = 3;                                   
        $mail->SMTPAuth = true;  
        $mail->SMTPSecure = 'ssl';                                    
        $mail->Host = $mailHost;
        $mail->Username = $mailUserName;             
        $mail->Password = $mailPassword;                                        
        $mail->Port = 465;                                  
        $mail->setFrom($mailUserName);
        $mail->addAddress('anolsaha6@gmail.com');  
        $mail->isHTML(true);                                                                    
        //  $mail->Subject = $subject;
        //  $mail->Body    = $body;                     
        
        if($mail->send()){
          $status = "success";
      }else{
          $status = "failed";
      }
      

    }

    public function getSettingConfig($key){
      $sqlMail = DB::table('settings')->where('key' , $key)->first();
      return $sqlMail->value;
    }

    public function send_mail($request ){
      
        $html = '';
        $html .= '<p>First Name : '.$request->first_name.'</p>';
        $html .= '<p>Last Name : '.$request->last_name.'</p>';
        $html .= '<p>Email : '.$request->email.'</p>';
        $html .= '<p>Phone Number : '.$request->phone_number.'</p>';
        $html .= '<p>Address : '.$request->address.'</p>';

      
      
      
      $mailHost = $this->getSettingConfig('email_host');
      $mailUserName = $this->getSettingConfig('email_username');
      $mailPassword = $this->getSettingConfig('email_password');
      $mailAddress = $this->getSettingConfig('email_from_address');
      $mailName = $this->getSettingConfig('email_from_name');
      
          
      $subject = "Form Submit Details";
      $body = $html;
      require base_path("vendor/autoload.php");
      $mail = new PHPMailer();   
      $mail->isSMTP();                          
      $mail->SMTPDebug = false ;                                   
      $mail->SMTPAuth = true;  
      $mail->SMTPSecure = 'ssl';                                    
      $mail->Host = $mailHost;
      $mail->Username =$mailUserName;             
      $mail->Password =$mailPassword;                                        
      $mail->Port = 465;                                   
      $mail->setFrom($mailAddress);
      $mail->addAddress($request->email);  
      $mail->isHTML(true);                                                                    
      $mail->Subject = $subject;
      $mail->Body = $body;                     
      
      if($mail->send()){
          $status = "success";
      }else{
          $status = "failed";
      }
      
      
      
    }

    public function paymentRent(Request $request){

     
      $input = $request->all();
  
      $api = new Api('rzp_test_rrXwgtBucWK4kr', 'OXDWdiDGMmomBrdAGJk7pxkY');

      $payment = $api->payment->fetch($input['razorpay_payment_id']);

      if(count($input)  && !empty($input['razorpay_payment_id'])) {
        try {
            $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
            $value = Session::get('payment_details');
            //   echo "<pre>";
            //   print_r($response);
              $insert_payment_details = DB::table('rental_details')->insertGetId([
                      'property_id'=>$value['request']['property_id'],
                      'author_id'=>$value['u_id'],
                      'payment_id'=>$response->id,
                      'amount'=>$value['request']['price'],
                      'email'=>$value['author_details']->email,
                      'status'=> 'A',
                      'created_at'=> date('Y-m-d H:i:s'),
                      'updated_at'=> date('Y-m-d H:i:s')
                  ]);

              $sqlUpdate = DB::table('re_accounts')->where('id' , $value['u_id'])->update([
                "rent" => $insert_payment_details
              ]);
                  $points = DB::table('points')->select('purchase_points')->first();
                  foreach($points as $key=>$valued){
                        
                   }
                   $previous_points = DB::table('re_accounts')->select('points')->where('id',$value['u_id'])->first();
                   foreach($previous_points as $lock=>$v_points){
                       
                   }
                //   echo "<pre>";
                  $purchase_payment = DB::table('rental_details')->select('payment_id')->where('author_id',$value['u_id'])->get();
                //   print_r($purchase_payment);
                if(isset($purchase_payment)){
                   $count = DB::table('rental_details')->select('payment_id')->where('author_id',$value['u_id'])->count();
                  
                    $add = DB::table('re_accounts')->where('id',$value['u_id'])->update([
                   'points'=>$v_points+$valued
                   ]);
                }




                $html = '';
                $html .= '<p>Your rent booked successfully</p>';


                $subject = "Rent Booked Mail";
                $this->send_mail_function_for_all($html , $value['author_details']->email , $subject);


                Session::flash('msg', 'Booked your property successfully');
                return redirect('/');
                  
        } catch (Exception $e) {
            return  $e->getMessage();
            Session::flash('msg',$e->getMessage());
            return redirect()->back();
        }
    }
      
     
    //  return redirect()->back();
       
  }  
    
    public function insert_packers(Request $request){
       $insert_pm = DB::table('packers_movers')->where('id' , $request->id)->update([
            'details'=>$request->details
           ]);
           return redirect()->back();
        
        
    }
     
     public function packers_email_insert(Request $request){
        $insert_packers_email = DB::table('packers_email')->insert([
         'moving_from'=>$request->moving_from,
         'moving_to'=>$request->moving_to,
         'name'=>$request->name,
         'email'=>$request->email,
         'phone_number'=>$request->phone_number,
         'property_type'=>$request->property_type
         ]);
          $this->send_packers_mail($request);  
         return redirect()->back();
     }


    //  public function offerImageAddFunction(Request $rec){
    //     $image = NULL;
    //     if($rec->hasFile('image')){
    //         $resizeFileName1 = time();
    //         $uploadPath1 = 'public/storage/accounts';
    //         $uploadPathAc1 = 'public/storage/accounts';
    //         $backImage1= rand(1111,9999).'offer_cou_image'.$resizeFileName1;
    //         $ext1=strtolower($rec->image->getClientOriginalExtension());
    //         $image_full_name1=$backImage1.'.'.$ext1;
    //         $upload_path1=$uploadPath1;
    //         $success1=$rec->image->move($upload_path1,$image_full_name1);
    //         $url1 = $uploadPathAc1.'/'.$image_full_name1;
    //         $image = $url1;
    //     }


    //     $sqlInsert = DB::table('offer_section')->insert([
    //         "image" => $image
    //     ]);

    //     return redirect()->back();
    //  }
    
    
     public function offerImageAddFunction(Request $rec){
        //  print_r($rec->image);
         
        $images = NULL;
        if($rec->hasFile('image')){
            foreach ($rec->image as $key => $value) {
            $resizeFileName = time();
            $uploadPath1 = 'public/storage/accounts';
            $uploadPathAc1 = 'public/storage/accounts';
            $backImage1= rand(1111,9999).'image'.$resizeFileName;
            $ext1=strtolower($value->getClientOriginalExtension());
            $image_full_name1=$backImage1.'.'.$ext1;
            $upload_path1=$uploadPath1;
            $success1=$value->move($upload_path1,$image_full_name1);
            $url1 = $uploadPathAc1.'/'.$image_full_name1;
            $images[] = $url1;

            }
        $image = json_encode($images);
        // print_r($image);
        }


        $sqlInsert = DB::table('offer_section')->insert([
            "image" => $image
        ]);

        return redirect()->back();
        
     }
    

     public function offerImageUpdateFunction(Request $rec){
        $image = NULL;
        if($rec->hasFile('image')){
            $resizeFileName1 = time();
            $uploadPath1 = 'public/storage/accounts';
            $uploadPathAc1 = 'public/storage/accounts';
            $backImage1= rand(1111,9999).'offer_cou_image'.$resizeFileName1;
            $ext1=strtolower($rec->image->getClientOriginalExtension());
            $image_full_name1=$backImage1.'.'.$ext1;
            $upload_path1=$uploadPath1;
            $success1=$rec->image->move($upload_path1,$image_full_name1);
            $url1 = $uploadPathAc1.'/'.$image_full_name1;
            $image = $url1;
        }


        $sqlInsert = DB::table('offer_section')->where('id' , $rec->id)->update([
            "image" => $image
        ]);

        return redirect()->back();
     }

     public function deleteOfferFunction($id){
        $sqlInsert = DB::table('offer_section')->where('id' , $id)->delete();
        return redirect()->back();
     }

     public function bankAccountUpdateFunction(Request $rec){
        
      $sql = DB::table('bank_account_details')->where('userId' , auth('account')->user()->id)->get();
      if(count($sql) == 0){
        $sqlInsert = DB::table('bank_account_details')->insert([
          "holderName" => $rec->holderName,
          "accountNumber" => $rec->accountNumber,
          "bankName" => $rec->bankName,
          "ifscCode" => $rec->ifscCode,
          "userId" => auth('account')->user()->id,
          "bankBranchName" => $rec->bankBranchName,
          "createdDate" => date('Y-m-d H:i:s')
        ]);
      }else{
        $sqlUpdate = DB::table('bank_account_details')->where('userId' , auth('account')->user()->id)->update([
          "holderName" => $rec->holderName,
          "accountNumber" => $rec->accountNumber,
          "bankName" => $rec->bankName,
          "ifscCode" => $rec->ifscCode,
          "bankBranchName" => $rec->bankBranchName,
          "createdDate" => date('Y-m-d H:i:s')
        ]);
      }
      return redirect()->back();
     }

     public function activetionKycFunction($userId , $authorId){
        $sqlUser = DB::table('re_accounts')->where('id' , $authorId)->first();
        $sqlUserAc = DB::table('re_accounts')->where('id' , $userId)->first();

        $html = '';
        $html .= '<table cellpadding="5">';
        $html .=    '<tr>';
        $html .=        '<td>Name : '.$sqlUserAc->first_name.' '.$sqlUserAc->last_name.'</td>';
        $html .=    '</tr>';
        $html .=    '<tr>';
        $html .=        '<td>'.$sqlUserAc->type.' Name : '.$sqlUserAc->otherName.'</td>';
        $html .=    '</tr>';
        $html .=    '<tr>';
        $html .=        '<td>Address : '.$sqlUserAc->address.'</td>';
        $html .=    '</tr>';
        $html .=    '<tr>';
        $html .=        '<td>Gender : '.$sqlUserAc->gender.'</td>';
        $html .=    '</tr>';
        $html .=    '<tr>';
        $html .=        '<td>Adhaar Number : '.$sqlUserAc->adhaarNo.'</td>';
        $html .=    '</tr>';
        $html .=    '<tr>';
        $html .=        '<td>Adhaar Image : <a href="'.asset($sqlUserAc->adhaarImage).'" download style="border: 1px solid #00000069;padding: 6px;text-decoration: none;background: #31a9cd;color: white;">Download</a></td>';
        $html .=    '</tr>';
        $html .=    '<tr>';
        $html .=        '<td>Email : '.$sqlUserAc->email.'</td>';
        $html .=    '</tr>';
        $html .=    '<tr>';
        $html .=        '<td>Phone Number : '.$sqlUserAc->phone.'</td>';
        $html .=    '</tr>';
        // $html .=    '<tr>';
        // $html .=        '<td>Image : <a href="'.asset($sqlUserAc->adhaarImage).'" download>Download</a></td>';
        // $html .=    '</tr>';
        $html .=    '<tr>';
        $html .=        '<td>Signature : <a href="'.asset($sqlUserAc->signatureImage).'" download style="border: 1px solid #00000069;padding: 6px;text-decoration: none;background: #31a9cd;color: white;">Download</a></td>';
        $html .=    '</tr>';
        $html .=    '<tr>';
        $html .=        '<td><a href="'.url('activeOwner/'.$userId).'" style="border: 1px solid #00000069;padding: 6px;text-decoration: none;background: darkturquoise;color: white;">Active Now</a></td>';
        $html .=    '</tr>';
        $html .= '</table>';

        $subject = "Activation Details";
        
        $emailSend = $this->send_mail_function($html , $sqlUser->email , $subject);

        if($emailSend){
            Session::flash('msg', 'Sended your approval please wait ...when approved your kyc details then you will be book you property');
            return redirect()->back();  
        }else{
            Session::flash('msg', 'Sended your approval please wait ...when approved your kyc details then you will be book you property');
            return redirect()->back();
        }
     }


     public function activeOwnerFunction($userId){
        $sqlUserActive = DB::table('re_accounts')->where('id' , $userId)->update([
            "addressApprove" => "yes"
        ]);

        return redirect('/');
     }
     
     
     public function send_packers_mail($request ){
      
        $html = '';
        $html .= '<p>Moving From : '.$request->moving_from.'</p>';
        $html .= '<p>Moving To : '.$request->moving_to.'</p>';
        $html .= '<p>Name : '.$request->name.'</p>';
        $html .= '<p>Email : '.$request->email.'</p>';
        $html .= '<p>Mobile Number : '.$request->phone_number.'</p>';
        $html .= '<p>Property Type : '.$request->property_type.'</p>';

      
      
      
      
      
          
      $subject = "verification from roomlet";
      $body = $html;
      require base_path("vendor/autoload.php");
      $mail = new PHPMailer();   
      $mail->isSMTP();                          
      $mail->SMTPDebug = false ;                                   
      $mail->SMTPAuth = true;  
      $mail->SMTPSecure = 'ssl';                                    
      $mail->Host = 'mail.sapcotechnologies.com';
      $mail->Username ='check@sapcotechnologies.com';             
      $mail->Password ='check@2021';                                        
      $mail->Port = 465;                                   
      $mail->setFrom($request->email);
      $mail->addAddress('check@sapcotechnologies.com');  
      $mail->isHTML(true);                                                                    
      $mail->Subject = $subject;
      $mail->Body = $body;                     
      
      if($mail->send()){
          $status = "success";
      }else{
          $status = "failed";
      }
      
      
      
    }



    public function cronSave(){
        $date = date('Y-m-d');
        ////////////////////  BEFORE 5 DAYS REMAINDER /////////////////////////
        // $sqlTrans = DB::table('rental_details')->where('status' , 'A')->get();
        // if(count($sqlTrans) > 0){
        //     foreach ($sqlTrans as $key => $value) {
        //         $modifyDate = date('Y-m-d',strtotime($value->created_at));
        //         $oneMonthCalculate = date('Y-m-d', strtotime('+1 month', strtotime($modifyDate)));
        //         $beforeFiveDays = date('Y-m-d', strtotime('-5 day', strtotime($oneMonthCalculate)));

        //         if ($date == $beforeFiveDays) {
        //             $html = '';
        //             $html .= 'Your rent property will be expire with in 5 days please pay your rent.';
        //         }
        //     }
        // }
        ////////////////////////////////////////////////////////////////////////
        ////////////////////  BEFORE 3 DAYS REMAINDER /////////////////////////
        // $sqlTrans = DB::table('rental_details')->where('status' , 'A')->get();
        // if(count($sqlTrans) > 0){
        //     foreach ($sqlTrans as $key => $value) {
        //         $modifyDate = date('Y-m-d',strtotime($value->created_at));
        //         $oneMonthCalculate = date('Y-m-d', strtotime('+1 month', strtotime($modifyDate)));
        //         $beforeFiveDays = date('Y-m-d', strtotime('-3 day', strtotime($oneMonthCalculate)));

        //         if ($date == $beforeFiveDays) {
        //             $html = '';
        //             $html .= 'Your rent property will be expire with in 5 days please pay your rent.';
        //         }
        //     }
        // }
        ////////////////////////////////////////////////////////////////////////

    }


        public function send_mail_function($body , $email , $subject){
      
                
              
              $mailHost = $this->getSettingConfig('email_host');
              $mailUserName = $this->getSettingConfig('email_username');
              $mailPassword = $this->getSettingConfig('email_password');
              $mailAddress = $this->getSettingConfig('email_from_address');
              $mailName = $this->getSettingConfig('email_from_name');
              
                  
              
              
              require base_path("vendor/autoload.php");
              $mail = new PHPMailer();   
              $mail->isSMTP();                          
              $mail->SMTPDebug = false ;                                   
              $mail->SMTPAuth = true;  
              $mail->SMTPSecure = 'ssl';                                    
              $mail->Host = $mailHost;
              $mail->Username =$mailUserName;             
              $mail->Password =$mailPassword;                                        
              $mail->Port = 465;                                   
              $mail->setFrom($mailAddress);
              $mail->addAddress($email);  
              $mail->isHTML(true);                                                                    
              $mail->Subject = $subject;
              $mail->Body = $body;                     
              
              if($mail->send()){
                  $status = "success";
              }else{
                  $status = "failed";
              }
      
      
      
    }



    public function send_mail_function_for_all($body , $email , $subject){
  
            
          
          $mailHost = $this->getSettingConfig('email_host');
          $mailUserName = $this->getSettingConfig('email_username');
          $mailPassword = $this->getSettingConfig('email_password');
          $mailAddress = $this->getSettingConfig('email_from_address');
          $mailName = $this->getSettingConfig('email_from_name');
          
              
          
          
          require base_path("vendor/autoload.php");
          $mail = new PHPMailer();   
          $mail->isSMTP();                          
          $mail->SMTPDebug = false ;                                   
          $mail->SMTPAuth = true;  
          $mail->SMTPSecure = 'ssl';                                    
          $mail->Host = $mailHost;
          $mail->Username =$mailUserName;             
          $mail->Password =$mailPassword;                                        
          $mail->Port = 465;                                   
          $mail->setFrom($email);
          $mail->addAddress($mailAddress);  
          $mail->isHTML(true);                                                                    
          $mail->Subject = $subject;
          $mail->Body = $body;                     
          
          if($mail->send()){
              $status = "success";
          }else{
              $status = "failed";
          }
  
  
  
}
    
    public function pay_description(){
        return view('payment-description');
        // echo "hello";
    }
    
    public function add_pay_description(Request $request){
        $insert_payDescription = DB::table('pay-description')->where('id' , $request->id)->update([
                'security_deposit' => $request->security_deposit,
                'gst'              => $request->gst,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
            
            return redirect()->back();
    }

    public function couponAddFunction(Request $rec){
      DB::table('coupon_section')->insert([
        "title" => $rec->title,
        "code" => $rec->code,
        "percentage" => $rec->percentage,
        "expiryDate" => date('Y-m-d',strtotime($rec->expiryDate)),
        "createdDate" => date('Y-m-d H:i:s')
      ]);
      return redirect()->back();
    }


    public function couponUpdateFunction(Request $rec){
        DB::table('coupon_section')->where('id' , $rec->id)->update([
        "title" => $rec->title,
        "code" => $rec->code,
        "percentage" => $rec->percentage,
        "expiryDate" => date('Y-m-d',strtotime($rec->expiryDate)),
        "createdDate" => date('Y-m-d H:i:s')
      ]);
      return redirect()->back();
    }

    public function deleteCouponFunction($id){
      $sqlInsert = DB::table('coupon_section')->where('id' , $id)->delete();
      return redirect()->back();
   }


   public function couponApplyFunction(Request $rec){
      $sqlCoupon = DB::table('coupon_section')->where('code' , $rec->couponText)->first();
      if(isset($sqlCoupon)){
        Session::put('discountCoupon',$sqlCoupon->percentage);
        return redirect()->back();
      }else{
        return redirect()->back()->withErrors('Invalid Coupon');
      }
   }


   public function searchSectionFunction(
        Request $request,
        PropertyInterface $propertyRepository,
        CategoryInterface $categoryRepository,
        BaseHttpResponse $response
   ){
      // echo "<pre>";
      // print_r($request->all());


      SeoHelper::setTitle(__('Projects'));

        $perPage = (int)$request->input('per_page') ? (int)$request->input('per_page') : (int)theme_option('number_of_projects_per_page',
            12);



      $filters = [
            'keyword'     => $request->input('k'),
            'type'      => $request->input('type'),
            'price'   => $request->input('budget'),
            'number_bedroom'   => $request->input('bedroom'),
            'cat_type'    => $request->input('section'),
            'category_id' => $request->input('category_id'),
            'location'    => $request->input('location'),
        ];



        $params = [
            'paginate' => [
                'per_page'      => $perPage ?: 12,
                'current_paged' => (int)$request->input('page', 1),
            ],
            'order_by' => ['re_projects.created_at' => 'DESC'],
            'with'  => config('plugins.real-estate.real-estate.properties.relations')
        ];


        $properties = $propertyRepository->getProperties($filters, $params);

        

        if ($request->ajax()) {
            if ($request->input('minimal')) {
                return $response->setData(Theme::partial('search-suggestion', ['items' => $properties]));
            }

            return $response->setData(Theme::partial('real-estate.properties.items', ['properties' => $properties]));
        }


        Theme::breadcrumb()
            ->add(__('Home'), route('public.index'))
            ->add(__('Properties'), route('public.properties'));

        $categories = $categoryRepository->pluck('name', 'id');

        return Theme::scope('real-estate.properties', compact('properties', 'categories'))->render();


   }

   public function getDetailsSearchFunction(Request $rec){
      if($rec->type == 'resi'){
          ?>
                <div class="col-md-3 col-sm-6 pr-md-1">
                    <?=Theme::partial('real-estate.filters.categories')?>
                </div>
                <div class="col-md-3 col-sm-6 px-md-1">
                    <?=Theme::partial('real-estate.filters.Budget')?>
                </div>
                <div class="col-md-3 col-sm-6 px-md-1">
                    <?=Theme::partial('real-estate.filters.bedroom')?>
                </div>
                <div class="col-md-3 col-sm-6 pl-md-1">
                    <?=Theme::partial('real-estate.filters.available')?>
                </div>
          <?php
      }elseif($rec->type == 'com'){
            ?>
                <div class="col-md-3 col-sm-6 pr-md-1">
                    <?=Theme::partial('real-estate.filters.categories')?>
                </div>
                <div class="col-md-3 col-sm-6 px-md-1">
                    <?=Theme::partial('real-estate.filters.Budget')?>
                </div>
                <div class="col-md-3 col-sm-6 pl-md-1">
                    <?=Theme::partial('real-estate.filters.available')?>
                </div>
            <?php
      }elseif($rec->type == 'pg'){
            ?>
                <div class="col-md-3 col-sm-6 pr-md-1">
                    <?=Theme::partial('real-estate.filters.categories')?>
                </div>
                <div class="col-md-3 col-sm-6 px-md-1">
                    <?=Theme::partial('real-estate.filters.Budget')?>
                </div>
                <div class="col-md-3 col-sm-6 px-md-1">
                    <?=Theme::partial('real-estate.filters.bedroom')?>
                </div>
                <div class="col-md-3 col-sm-6 pl-md-1">
                    <?=Theme::partial('real-estate.filters.available')?>
                </div>
                <div class="col-md-3 col-sm-6 px-md-1">
                    <?=Theme::partial('real-estate.filters.tennent')?>
                </div>
            <?php
      }elseif($rec->type == 'flat'){
            ?>
                <div class="col-md-3 col-sm-6 pr-md-1">
                    <?=Theme::partial('real-estate.filters.categories')?>
                </div>
                <div class="col-md-3 col-sm-6 px-md-1">
                    <?=Theme::partial('real-estate.filters.Budget')?>
                </div>
                <div class="col-md-3 col-sm-6 px-md-1">
                    <?=Theme::partial('real-estate.filters.bedroom')?>
                </div>
                <div class="col-md-3 col-sm-6 pl-md-1">
                    <?=Theme::partial('real-estate.filters.available')?>
                </div>
                <div class="col-md-3 col-sm-6 px-md-1">
                    <?=Theme::partial('real-estate.filters.tennent')?>
                </div>
            <?php
      }elseif($rec->type == 'palot'){
            ?>
                <div class="col-md-3 col-sm-6 pr-md-1">
                    <?=Theme::partial('real-estate.filters.categories')?>
                </div>
                <div class="col-md-3 col-sm-6 pl-md-1">
                    <?=Theme::partial('real-estate.filters.available')?>
                </div>
            <?php
      }
   }





    



}
