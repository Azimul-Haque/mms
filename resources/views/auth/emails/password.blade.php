<center>
  <div style="border: 1px solid #ACACAC; padding: 10px; max-width: 500px;">
    <center>
      <img src="{{ asset('images/logo.png') }}" width="100px; height: auto;">
      <p style="font-size: 30px; color: #1B237D;"><b>Killa</b>Consultancy</p>
      <p style="font-size: 25px"><b>Your Password Reset Link</b></p>
    
      <p style="font-size: 20px">
        To reset your password, please click below<br/>
        <big><a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}">Click Here</a></big><br/>
        Or,<br/>
        <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}" style="font-size: 13px;"> {{ $link }} </a>
      </p>
      <br/><br/>
      <p style="font-size: 12px; color: #ACACAC;">
        This is a auto-generated email from Killa Consultancy. This email arrived to you because you (or may be someone else!) have requested to reset the password associated with this email address. If you are getting this email by mistake, please ignore it.
      </p>
      <p style="font-size: 12px; color: #ACACAC;">
        &copy; @php echo date('Y'); @endphp <a href="http://killabd.com/">Killa Consultancy</a>, Mirpur, Dhaka, Bangladesh
      </p>
    </center>
  </div>
</center>