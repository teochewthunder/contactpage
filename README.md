# Contact Us Page (in progress)

## HTML/CSS
  ### *Form* tag
  - *action* attribute should be blank because we're referring to the same page.
  - *method* should be POST.
  ### Anti-CSRF Token
  - hidden field is inside the form. The value is the MD5 value of the session id.
  - The session id is derived by running *session_start()* at the start of the page, then calling the *session_id()* function.

## JavaScript Validation

## PHP Validation

## PHP Mailing
  - Use the value from the *txtEmail* text box after it has been validated.
  - The PHP *mail()* function is used to send the email. Note that this function only determines if the data used in the function is valid, and will return *true* if so, whether or not it actually sends the email.
  
## Map
