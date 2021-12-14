

## BOOKS

Steps to follow:
From terminal
1. Run git clone https://github.com/marianDdev/laravel-books-JWT-auth.git
2. Run cd laravel-books-JWT-auth
3. Run composer install
4. Run cp .env.example .env (Add your DB credentials to .env)
5. Run php artisan key:generate
6. Run php artisan migrate && php artisan db:seed
7. Run php artisan serve
8. Go to link localhost:8000
    * If you are using macos, I recommend skipping steps 7 and 8 and install Valet instead, because configures your Mac to always run Nginx in the background when your machine starts and proxies all requests on the *.test domain to point to sites installed on your local machine.
        From terminal from inside laravel-books-JWT-auth directory
        . Run valet install
        . Run valet link books
        . Run valet secure books
        . Go to link https://books.test
9. Register to an account from the list with valid email and password
10. If you want to add a book, from your dashboard click on the "Add a book" link and fill the form.
11. If you want to see all the books added to your account, click on the "List <you account's name> Books" link.
12. You can only delete a book from your account if it was added 2 days ago. Otherwise, you will see this text: 
"This book was added more than two days ago and cannot be deleted." instead of a delete button.

####STEPS FOR DEVELOPERS TO FETCH BOOKS OR A SPECIFIC BOOK
For API testing I recommend using POSTMAN or any other collaboration platform for API development.    
Before jumping to POSTMAN, in your project, go to config/auth.php and change the default guard value from "web" to "api".
In POSTMAN.
1. If you haven't registered yet from the browser, you can REGISTER from POSTMAN
    Make a POST request to https://books.test/api/register with the following params:
     - name
     - email
     - password (min 6 characters)
     - password_confirmation
     - account_id (in integer from 1 to 5)
    The success response has status code 201 and should look like this:
    {
        "message": "User successfully registered on account with id 1",
        "user": {
            "name": "Your Name",
            "email": "your@email.com",
            "account_id": "1",
            "updated_at": "2021-12-14T21:37:21.000000Z",
            "created_at": "2021-12-14T21:37:21.000000Z",
            "id": 18
        }
    }

    2. For login make a GET request to  https://books.test/api/login. The body of the request must be form-data with the following key => value pairs:
    KEY  ------------------- VALUE
    email => youremail@email.com
    password = your-password
    
    Copy the token without double quotes from the response body
   
    3. For fetching the books added to your account, make a GET request to https://books.test/api/books, select the authorization type Bearer Token and insert the token from the earlier step.
    4. For getting a book added to your account, make a GET request to https://books.test/api/books/{id}, select the authorization type Bearer Token and insert the token from the earlier step.
        If the book id added by you as a route param doesn't exist, you will receive a list with the available books ids in the response 
