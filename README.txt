Develop a RESTful web service using PHP and MySQL and an interface for that web service using HTML, CSS, and JavaScript 

The web service should provide and maintain information about the teams and players of a team-based sport of your choice. It must be implement using PHP and PHP alone. Underlying the web service must be a MySQL database storing that information. The PHP Data Objects (PDO) extension of PHP must be used to implement the interactions with the database.
To keep the amount and nature of the information in the database simple, it should comply with the following constraints:
Initially, there is information on three teams;
The information on a team includes (a) its name, (b) the sport that the team is involved in, (c) the average age of the team members stored in the database at any particular point in time.
In addition, for each team there is information on three of its players / team members;
The information on a team member includes (a) their surname, (b) their given names, (c) their nationality, and (d) their date of birth;
The team names and player names in the initial data should only use ASCII characters. Neither the interface, the web service, nor the database should enforce a restriction to ASCII, but instead allow UFT-8.
The restrictions on the number of teams and the number of team members should not influence the design of the database. The database should be able to accommodate an arbitrary number of teams with arbitrarily many team members.
The web service must provide the following functionality via a REST API:
retrieve information on all the teams (this does not include information on the players of each team, but should include a link to the collection resource for all players of each team), sorted by team names;
retrieve information on all players of a specific team;
retrieve information on an existing player of a team;
add a player / team member to an existing team;
delete an existing player / team member from a team;
update information for an existing player / team member of a team.
The web service should expect information (on a new player or updates for an existing player) to be provided in JSON format and also returns information in that format.

The web service should react appropriately to requests that cannot be handled, including a request
relating to a non-existing resource, e.g., deleting a non-existing team member;
adding a team or updating information on a team.
In addition to the web service there should be a minimalistic interface that allows a user to interact with and test the web service (akin to a simplified version of the Postman API client). The interface should have the following elements:
There should be a list of the resources that the web service initially stores information about and examples of the JSON format that needs to be used to provide information on a new player or to update information about an existing player;
a drop-down menu that allows to select a HTTP method;
a text field with a width of 80 characters that allows to enter a resource;
a text area with a width of 80 characters and a height of 5 characters that allows to enter a request body in JSON;
a button that triggers a request to be send to the web service based on the information of the three interface elements;
an area that shows the HTTP status code received in response to a request;
an area that shows the HTTP response body;
a button that clears the content of the three areas that the interface uses to display parts of the HTTP response.
The interface should interact with the web service using Ajax and all operations related to the interface should be implemented using JavaScript.
The bulk of the JavaScript code for the interface should be in a JavaScript library called interface.js. Before submitting your solution, you should create a copy of interface.js named interface.pretty.js in a directory other than your public_html directory, say, your home directory. Then make the file interface.js indecipherable for humans using the command uglifyjs $HOME/interface.pretty.js --compress --mangle > $HOME/public_html/interface.js. Make sure that after performing this operation the interface still works.
Use of PHP and JavaScript frameworks is not allowed.