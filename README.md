Cliner
===================

This is a command line utility framework to help us script up good tools in php. 

The idea is to incorporate basic MVC setup to allow us to write scripts in a very organized fashion. 
We want to let you create different command and functions and invoke them this way: 

<pre><code>php cliner.php [controller] [action] [argv0....]</code></pre>

Routing: 
The command: <pre><code>php cliner.php [controller] [action] [argv0....]</code></pre>

will maps to <pre><code>NameController::action(argv....)</code></pre>

Directory Setup
===================
All your code goes into the app directory. Generally you want to put your business logic in the controller folder. 


Name Convention
===================
You should name all your controllers: [Name]Controller.php
