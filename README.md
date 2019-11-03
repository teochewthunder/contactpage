# Contact Us Page (in progress)

## HTML/CSS
  ### *Form* tag
  - *action* attribute should be blank because we're referring to the same page.
  - *method* should be POST.
  ### Anti-CSRF Token
  - hidden field is inside the form. The value is the MD5 value of the session id.
  - The session id is derived by running *session_start()* at the start of the page, then calling the *session_id()* function.

## Map

## JavaScript Validation

## PHP Validation

## PHP Mailing
