@extends('Front/layout')
@section('title_name','Registration Page')
@section('container')

<section id="aa-myaccount">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
        <div class="aa-myaccount-area">         
            <div class="row">

              <div class="col-md-6">
                <div class="aa-myaccount-register">                 
                 <h4>Register</h4>
                 <form action="" class="aa-login-form" id="frmRegistration">
                    <label for="">Name<span>*</span></label>
                    <input type="text" name="name" placeholder="Name" required>
                    <div id="name_error" class="field_error"></div>
                    <label for="">Email address<span>*</span></label>
                    <input type="email" name="email" placeholder="Email" required>
                    <div id="email_error" class="field_error"></div>
                    <label for="">Phone Number<span>*</span></label>
                    <input type="text" name="mobile" placeholder="Phone Number" required>
                    <div id="mobile_error" class="field_error"></div>
                    <label for="">Password<span>*</span></label>
                    <input type="password" name="password" placeholder="Password" required>
                    <div id="password_error" class="field_error"></div>
                    <button type="submit" id="btnRegistration" class="aa-browse-btn">Register</button>  
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