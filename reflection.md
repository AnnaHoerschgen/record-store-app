# Reflection

1. **require_login() explanation**  
require_login() ensures that a user cannot access certain pages or actions unless they are logged in.  
It runs whenever a restricted action is triggered (anything not in $public_actions) or when a restricted view is requested (anything not in $public_views).  
If the user is not logged in, it redirects them to the login page. This enforces access control across the site.

2. **Login process step-by-step**  
- User fills out the login form and clicks the "Login" button.  
- The form sends a POST request with `action=login` to index.php.  
- The `case 'login'` block in index.php handles the logic.  
- It fetches the user from the database using user_find_by_username().  
- password_verify() checks the submitted password against the stored hash.  
- If successful, $_SESSION['user_id'] and $_SESSION['full_name'] are set.  
- The user is then redirected to the 'list' view (all records).

3. **What is stored in $_SESSION['cart']**  
$_SESSION['cart'] is an array of record IDs.  
When "Add to Cart" is clicked, the record's ID is appended to this array.  
It stores only integers representing the records, not the full record details.

4. **$records_in_cart and why records_by_ids() is needed**  
$records_in_cart is generated in index.php using records_by_ids($_SESSION['cart']).  
It converts the IDs stored in the session into full record information (title, artist, format, price) so that the cart page can display meaningful data.  
We cannot just use the raw IDs because we need all the record details to show in the table.

5. **Complete Purchase process**  
When "Complete Purchase" is clicked, the `case 'checkout'` block in index.php runs.  
It loops through each record ID in $_SESSION['cart'] and calls purchase_create() to insert a row into the `purchases` table for each item.  
After all purchases are recorded, $_SESSION['cart'] is cleared, and the 'checkout_success' view is displayed.
