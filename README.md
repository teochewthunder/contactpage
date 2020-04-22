# Contact Us Page

## HTML/CSS
### *Form* tag
  - `action` attribute should be blank because we're referring to the same page.
  - `method` should be POST.
### Anti-CSRF Token
  - hidden field is inside the form. The value is the MD5 value of the session id.
  - The session id is derived by running `session_start()` at the start of the page, then calling the `session_id()` function.

## Validation
  - Placeholders are created below each input. Each has the class `error`.
  - Each placeholder has an error message.
  - If there is no PHP error associated with the input, the placeholder is hidden using the class `hide`.
### JavaScript Validation
  - in the form tag, use the `onsubmit` attribute to trigger the `validateForm()` function. This basically checks that the Name, Email and Comments are not blank values, and that the Email is valid.
  - Note that Email is only checked for syntatic correctness, and not `actual` validity.
  - We are not using Regular Expressions to check for valid Email because there are way too many variables.
  - In the JavaScript, set all elements with the class of `error` to `error hide`.
  - During validtion, for each error, push the id of the appropriate element into the `errors` array.
  - After validating, iterate through the `errors` array and set the appropriate element's class to `error`.

### PHP Validation
  - This is a failsafe in case JavaScript is turned off.
  - Input values are gathered.
  - Values are validated, and the apprpriate PHP key-value pair in the `errors` associative array set to `true` or `false`.
  - The placeholders will appear or disappear based on the `true` or `false` values.

## PHP Mailing
  - Use the value from the `txtEmail` text box after it has been validated.
  - The PHP `mail()` function is used to send the email. Note that this function only determines if the data used in the function is valid, and will return `true` if so, whether or not it actually sends the email.
  
## Map
  - This is an iframe.
  - The contents are from the Google Maps API.
  - A Google Account is required, after which a custom map needs to be created and shared.
  
  **Note:** Email format validation works as intended in Chrome and Firefox, but does not work *quite* the same in IE and Safari.
