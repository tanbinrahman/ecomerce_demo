@extends('Front/layout')
@section('title_name','Change Password')
@section('container')

<section id="aa-myaccount">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
        <div class="aa-myaccount-area">         
            <div class="row">

              <div class="col-md-6">
                <div class="aa-myaccount-register">                 
                 <h4>Forgot Password</h4>
                 <form action="" class="aa-login-form" id="frmUpdatePassword">
                    
                    
                   
                    <label for="">Password<span>*</span></label>
                    <input type="password" name="password" placeholder="Password" required>
                    <div id="password_error" class="field_error"></div>
                    <button type="submit" id="btnUpdatePassword" class="aa-browse-btn">Update Password</button>  
                    @csrf                  
                  </form>
                </div>
                <div id="thank_you_msg" class="field_error"></div>
              </div>
            </div>          
         </div>
       </div>
     </div>
   </div>
 </section>

@endsection