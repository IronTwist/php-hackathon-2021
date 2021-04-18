# PHP Hackathon
This document has the purpose of summarizing the main functionalities your application managed to achieve from a technical perspective. Feel free to extend this template to meet your needs and also choose any approach you want for documenting your solution.

## Problem statement
*Congratulations, you have been chosen to handle the new client that has just signed up with us.  You are part of the software engineering team that has to build a solution for the new client’s business.
Now let’s see what this business is about: the client’s idea is to build a health center platform (the building is already there) that allows the booking of sport programmes (pilates, kangoo jumps), from here referred to simply as programmes. The main difference from her competitors is that she wants to make them accessible through other applications that already have a user base, such as maybe Facebook, Strava, Suunto or any custom application that wants to encourage their users to practice sport. This means they need to be able to integrate our client’s product into their own.
The team has decided that the best solution would be a REST API that could be integrated by those other platforms and that the application does not need a dedicated frontend (no html, css, yeeey!). After an initial discussion with the client, you know that the main responsibility of the API is to allow users to register to an existing programme and allow admins to create and delete programmes.
When creating programmes, admins need to provide a time interval (starting date and time and ending date and time), a maximum number of allowed participants (users that have registered to the programme) and a room in which the programme will take place.
Programmes need to be assigned a room within the health center. Each room can facilitate one or more programme types. The list of rooms and programme types can be fixed, with no possibility to add rooms or new types in the system. The api does not need to support CRUD operations on them.
All the programmes in the health center need to fully fit inside the daily schedule. This means that the same room cannot be used at the same time for separate programmes (a.k.a two programmes cannot use the same room at the same time). Also the same user cannot register to more than one programme in the same time interval (if kangoo jumps takes place from 10 to 12, she cannot participate in pilates from 11 to 13) even if the programmes are in different rooms. You also need to make sure that a user does not register to programmes that exceed the number of allowed maximum users.
Authentication is not an issue. It’s not required for users, as they can be registered into the system only with the (valid!) CNP. A list of admins can be hardcoded in the system and each can have a random string token that they would need to send as a request header in order for the application to know that specific request was made by an admin and the api was not abused by a bad actor. (for the purpose of this exercise, we won’t focus on security, but be aware this is a bad solution, do not try in production!)
You have estimated it takes 4 weeks to build this solution. You have 2 days. Good luck!*

## Technical documentation
### Data and Domain model
In this section, please describe the main entities you managed to identify, the relationships between them and how you mapped them in the database.

I identified the following entityes: User, Programme and Booking
    -User entity is for security(auth system) and to identifie current logged user to be able to edit(add, delete) programmes(Programme entity) for admin user, and to book programmes (Booking entity relation betweeen user and programmes) for simple users.

    -Booking is use just to relate between UserId and ProgrammeId
    -Programme is to manage programmes (crete, read and delete)

### Application architecture
In this section, please provide a brief overview of the design of your application and highlight the main components and the interaction between them.

All project i made is with Symfony framework, authentification where I register new user and login the user, connection and relation with database (MySql) using Doctrine, after user is logged in he has acces to "Programmes" and "My Bookigs". In "Programmes" user can see al the registered programmes, and he can choose one to view and book. Admin user has the ability to Add new programme and to delete. "My Bookings is to view the programmes you are subscribed to".

###  Implementation
##### Functionalities
For each of the following functionalities, please tick the box if you implemented it and describe its input and output in your application:

[x] Brew coffee \
[x] Create programme \ First check if user is loged as admin to display create button, if that is true admin can press "Add programme button", another route(/programme/create) is displayed where 5 fields are required to fill(name, room, max participants, start programme, end programme) and "Save" button, all fields are required is they are filled corectly new programm is added and I am redirected to a route(/programme) and display the message "New programme creted!".
\
[x] Delete programme \ Same, check if user is logged as admin, if that is true in the display table is shown Action column with "Delete" button, if button is pressed the route(/delete/{id}) is acces with the id of the programme, where function remove is applied(search for programme with the following id in Programme repository and remove it from database), after that user is redirected to route(/programme) and display the message "Programme removed!".
\
[x] Book a programme \ To book a program user have to click on "Programme name" which he wants, after that is displayed route(/show/{id}) with selected programme id, in this place we show all data about programme, olso display the remaining places and a button to book "Book this programme" (if remaining places are 0 i don't display the button to "Book this programme" and show the message "Sorry, this programme is full!", olso, if user hit the button to subscribe every time he visit that programme the message "You are already subscribed!" is displayed). OK so if user hit the "Book this programme" button" the route(/booking/create/{id}) is selected where function for that route is creating adding a new row with reltion between userId and programmeId.

##### Business rules
Please highlight all the validations and mechanisms you identified as necessary in order to avoid inconsistent states and apply the business logic in your application.

- most validation is by frontend check generate by form builder, and display of show action button (e.g. if programme is full of participants then i dont display the "Book this programme" programme).

##### 3rd party libraries (if applicable)
Please give a brief review of the 3rd party libraries you used and how/ why you've integrated them into your project.
-Bootstrap (for design) (just added in base.html.twig).

##### Environment
Please fill in the following table with the technologies you used in order to work at your application. Feel free to add more rows if you want us to know about anything else you used.
| Name | Choice |
| ------ | ------ |
| Operating system (OS) | Windows 10 |
| Database  | e.g. MySQL |
| Web server| e.g. XAMP -> Apache / Symfony server |
| PHP |  8.0.1  |
| IDE | Visual Studio Code |
| Framework | Symfony 5.2.6 |

### Testing
     -commandLine to see the routes (php bin/console debug:routes);
     -using dump() (composer require dump) to display Request/Response;
     -Profiler (composer required profiler), to see better the Request/Response interaction and many more (current user logged in)

## Feedback
In this section, please let us know what is your opinion about this experience and how we can improve it:

1. Have you ever been involved in a similar experience? If so, how was this one different?
   
   It's my first time in a Hackaton.

2. Do you think this type of selection process is suitable for you?
   
    Yes I like and I learned alot on my own.

3. What's your opinion about the complexity of the requirements?
   
   It's quite commplex because is my first time using Symfony framework, I wanted to give a try with the framework, I still have alot to learn about this framework, because everything is different, for example i'm not sure yet how to manage sessions because is easier with pure php (session_start(), $_SESSION['user_name'] = 'razvan'), even user controlle is easer just check if session is set. But I like that "twig template code" to display data with if is_granted("IS_AUTHENTICATED_FULLY") style.

4. What did you enjoy the most?
   
    Learning new stuff about Symfony framework.

5. What was the most challenging part of this anti hackathon?
   
    Using validation with Symfony

6. Do you think the time limit was suitable for the requirements?
   
   For a more advanced programmer is more than enough. For me learning how to use validation with twig and ORM is challenging and time wasting.

7. Did you find the resources you were sent on your email useful?

    Yes.

8. Is there anything you would like to improve to your current implementation?

    - Validating datetime intersection. When adding new programme to database to save a list with time interval of a required Room (ex: Room 1), check and compare if datetime intersect with new datetime given, if there is no intersection programme is saved else trow a new error. I still have to learn how to use try{}catch() with this framework using ProgrammeService.
    - Ability for admin to view and delete bookings of other users. Maybe a dropdown list with users, and everytime a user is selected it will display his bookings with a button "Delete" next to programme name.

9.  What would you change regarding this anti hackathon?

    Nothing, it was quite fun and challange.

I'll put some printscreen of the finished app in a "Preview Project" folder.
                                Thank You, Razvan.