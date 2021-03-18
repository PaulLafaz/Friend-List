# Friend-List

### Overview
This is a Friend List web application I've created whist studying Web Application Develoment at Swinburne University.
The following code presents a web app that allows users to create an account that hold their friends as well as some 
basic information about them.

### Interesting Facts:
* Initially this web app was hosted on Swinburne's Mercury Server but for the sake of testing Xampp was used.

* The user can sign up and login to their friend list

 _Login Page:_ | _Signup Page:_
-----------------------------------------------|---------------------------------------------------
<img src="https://github.com/PaulLafaz/Friend-List/blob/main/images/loginPage.PNG"> | <img src="https://github.com/PaulLafaz/Friend-List/blob/main/images/signupPage.PNG">

* There is a great level of input validation with a "Password" and "Confirm Password Feature".


* The details of all users are store in an SQL database using phpMyAdmin. The database contains 2 seperate tables, 1 for storing the login information
and 1 for containing their user they have in their friend list.


* As soon as the user logs in, they get redirected to their friend list. There, the user has the option of "Unfriending" users they no longer
want to be friends with.

 _User's Friend List_ |  
-----------------------------------------------| 
<img src="https://github.com/PaulLafaz/Friend-List/blob/main/images/friendList.PNG" width="544" height="534" /> |

<br>

* The user can also go to the **'Add Frined Page'** where they can add any user in the database as their friend.

_Add Friends Page_ |  
-----------------------------------------------| 
<img src="https://github.com/PaulLafaz/Friend-List/blob/main/images/addFriendList.PNG" width="550" height="475"/> |

