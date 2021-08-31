#Readme file for process involved in deploying a web application using Docker Containers by Creating Docker Images from Scratch
#The entire implementation of Docker containers and Docker Images were bulid for PHP MYSQL web application on Ubuntu 21.04

#created by : Kalathur Chenchu Kishore Kumar
#Roll No. : M21CS058
 
#Brief Description of Dockers,Containers and Images

#1.Containerization:
Containerization is a form of operating system virtualization,through which it runs applications in secluded user spaces called containers,all using the same shared operating system (OS).

#2.Docker:
Docker is a tool designed to make it easier to create, deploy, and run applications by using containers.
Containers allow a developer to package up an application with all of the parts it needs, such as libraries and other dependencies, and deploy it as one package.
Initially, built for Linux, Docker now runs on Windows and macOS.

#Docker Terms and Tools:

#a)DockerFile:
A DockerFile is a text file that contains instructions on how to build a docker image.
A Dockerfile specifies the operating system that will underlie the container, along with the languages, environmental variables, file locations, network ports, and other components it needs—and what the container will do once we run it.

#b)Docker Hub: 
Docker Hub is the public repository of Docker images that calls itself the “world’s largest library and community for container images.”
It holds over 100,000 container images sourced from commercial software vendors, open-source projects, and individual developers.
It includes images that have been produced by Docker, Inc., certified images belonging to the Docker Trusted Registry, and many thousands of other images. 
All Docker Hub users can share their images at will.
They can also download predefined base images to use as a starting point for any containerization project.

#c)Docker Daemon:
Docker Daemon is the background service running on the host that manages the building, running, and distributing Docker containers.
The daemon is the process that runs in the operating system in which clients speak.

#d)Docker Engine:
Docker Engine is a client-server application that supports the tasks and workflows involved to build, ship, and run container-based applications.
The engine creates a server-side daemon process that hosts images, containers, networks, and storage volumes.

#e)Docker Registry:
The Docker Registry is where the Docker Images are stored.
The Registry can be either a user’s local repository or a public repository like a Docker Hub allowing multiple users to collaborate in building an application.
Even with several teams within the same organization can exchange or share containers by uploading them to the Docker Hub, which is a cloud repository similar to GitHub.

#f)Docker Compose:
Docker-compose is for running multiple containers as a single service. 
It does so by running each container in isolation but allowing the containers to interact with one another.

#g)Docker Swarm:
Docker swarm is a service for containers that allows IT administrators and developers to create and manage a cluster of swarm nodes within the Docker platform.
Each node of Docker swarm is a Docker daemon, and all Docker daemons interact using the Docker API.
A swarm consists of two types of nodes: a manager node and a worker node.
A manager node maintains cluster management tasks. Worker nodes receive and execute tasks from the manager node.

#Steps involved in installing Docker:

step 1:Installing Docker on Ubuntu
	sudo apt install docker docker-compose
step 2:command for checking version,status and enabling docker
	docker version
	sudo systemctl status docker
	sudo systemctl enable docker
step 3:command for checking containers and images in docker
	docker container ls -a
	docker image ls -a
step 4:command for removal containers and images
	docker container rm container_name
	docker rmi image_name
	
#Application Description:

Here In this web application I am collecting a form data from user and inserting the data into a Mysql Database.
The application is present in Apache Webserver and it collects the student details like First_name,Last_name,Gender,Address and Email.
When user clicks submit button the the data is inserted into a database accordingly.
For this I had used Apache Web server and Mysql Database and connectivity is established between the server and database for the flow of data from form to database.

#Process Followed in Developing Web Application using Dockers:

I created a Project folder called as "webapplication" 
Inside that I am creating a yml file called as "Docker-compose.yml".

#1.Laying down docker-compose YML file:

Docker-compose allows us to set the parameters of the necessary images that we want to run in the application.
Here I used Docker hub official images such as PHP Apache and MySQL.
I wrote their parameters in a .yml file.

To set a docker-compose, we need to first select the Docker version we want to use, the services we want to provide, and the containers we want to run.

version: '3.3'
services:
  php-apache-environment:
    container_name:
    
#2.Setting up and running a local PHP Apache server instance:

To set up a PHP Apache container, we need to specify the following environments,

The container name - this is just a random name that we would like to name your PHP container.
For example container_name: php-apache.

The container image - this the official PHP image, the version of PHP Apache we want to use. 
In this case, we are pulling image: php:8.0-apache from the Docker hub.

The volume - this will set up our present working src directory for your code/source files. 
If we have to run a PHP script, that file would have to be in that directory.
Such as:
volumes:
  - ./php/src:/var/www/html/

The port numbers - This defines the ports where the script will run from. It will set up an Apache server port mapping to the port on our local computer.
For example:
ports:
  - 8000:80

This means that we are setting up an Apache server to expose port 80. Port 8000 reaches out to the PHP scripts and executes them in a browser from within Docker containers.

This is how our docker-compose.yml should look like.

version: '3.3'
services:
  php-apache-environment:
    container_name: php-apache
    image: php:8.0-apache
    volumes:
      - ./php/src:/var/www/html/
    ports:
      - 8000:80

Now we test it out and run a "docker-compose up". That’s going to pull all the information, download the Apache server, build the image, and run the container.

To ensure the container is set to execute the PHP scripts, Let's open the defined local host post in the browser,i.e., http://localhost:8000/.

#3.Serving a dynamic PHP-driven website to collect form Data:

Let’s try to execute some PHP code and get the output in the browser. Now we will be executing the scripts from the directory that we defined in the volumes of your docker-compose.

In this case we are using ./php/src.

Heading on to our project directory "webapplication" ➙ ./php/src, create an index.php file and I had written PHP script to collect form data.

Refresh on our browser (http://localhost:8000/), and the results of this index.php file are visible.

#4.Setting up a MySQL database container:

Now we probably want to set up a database to interact with our website. We will create another service to provide MySQL support inside the PHP container.

Let’s add the MySQL service into the docker-compose.yml file. To setup MySQL, we need to customize some environment, such as:

Password authentication. To use and access a MySQL server, you need to set authentication environments that will allow us to access the defined MySQL server and its services, such as a database. We will use MYSQL_USER: MYSQL_USER and MYSQL_PASSWORD: MYSQL_PASSWORD to connect to MySQL and access the MYSQL_DATABASE: MYSQL_DATABASE.

A restart policy set to "restart: always".
This restarts the service whenever any defined configuration changes.

db:
    container_name: db
    image: mysql
    restart: always
    environment:
        MYSQL_ROOT_PASSWORD: MYSQL_ROOT_PASSWORD
        MYSQL_DATABASE: MY_DATABASE
        MYSQL_USER: MYSQL_USER
        MYSQL_PASSWORD: MYSQL_PASSWORD
    ports:
        - "9906:3306"

We need to add some MySQL support tools inside the PHP container for the two services (db and php-apache) to work correctly. This tool includes mysqli.

Inside our project directory "webapplication", head to the /php folder, create a Docker file, name it Dockerfile and add the following PHP configurations.

FROM php:8.0-apache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y

Here we have created a custom PHP Apache image and an environment that will install mysqli, a PHP extension that will connect the PHP Apache to the MySQL server.

Now we need to build this custom image inside php-apache service in the docker-compose.yml file. PHP Apache also depends on the db service to connect to MySQL. We need to configure it by specifying a depends_on: environment.

This is how our docker-compose.yml file should look like.

version: '3.3'
services:
    php-apache-environment:
        container_name: php-apache
        build:
            context: ./php
            dockerfile: Dockerfile
        depends_on:
            - db
        volumes:
            - ./php/src:/var/www/html/
            - 8000:80
        ports:
    db:
        container_name: db
        image: mysql
        restart: always
        environment:
            MYSQL_ROOT_PASSWORD: MYSQL_ROOT_PASSWORD
            MYSQL_DATABASE: MYSQL_DATABASE
            MYSQL_USER: MYSQL_USER
            MYSQL_PASSWORD: MYSQL_PASSWORD
        ports:
            - "9906:3306"

Run docker-compose up to pull and set up the MySQL environment. MySQL will be added to the container.

Let’s test if the container is working as expected. Heading over to the index.php file and the following PHP MySQL connection code.

<?php
//These are the defined authentication environment in the db service

// The MySQL service named in the docker-compose.yml.
$host = 'db';

// Database use name
$user = 'MYSQL_USER';

//database user password
$pass = 'MYSQL_PASSWORD';

// check the MySQL connection status
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected to MySQL server successfully!";
}
?>

Save the file and refresh your http://localhost:8000/ web address.

The PHP Apache and MySQL environments are now set, and we can start developing our PHP-driven application and communicate with the MySQL server.

#5.Setting the PHPMyAdmin service

The MySQL connection is now okay.

Here our application interacts with a database,we would probably want an interface to interact with our data. We will add PHPMyAdmin services to provide us with an interface to interact with the MySQL database.

adding a PHPMyAdmin service as shown below.

phpmyadmin:
    image: phpmyadmin/phpmyadmin
    ports:
        - '8080:80'
    restart: always
    environment:
        PMA_HOST: db
    depends_on:
        - db
        
Open http://localhost:8080/ on the browser to access the PHPMyAdmin.

To login to the Phpmyadmin panel,I used username as root and password as MYSQL_ROOT_PASSWORD. The password was already set in the MySQL environment variables (MYSQL_ROOT_PASSWORD:MYSQL_ROOT_PASSWORD)

#6.Accessing the form content and Pushing into Mysql Database in PHPMyAdmin

In that Phpmyadmin I had created a Database name called as "MYSQL_DATABASE" and Table name as "student_details" and it has 5 columns namely First_name,Last_name,Gender,Address and Email.

Firstly inside src folder under Php in "webapplication" I had created two files namely:
1.index.php
2.insert.php

index.php contains the form data as shown below:

<!DOCTYPE html>
<html lang="en">
<head>
<title>Form to store data</title>
</head>

<body>
<center>
<h1>Storing Form data in Database</h1>
<form action="insert.php" method="post">	
<p>
<label for="firstName">First Name:</label>
<input type="text" name="first_name" id="firstName">
</p>
<p>
<label for="lastName">Last Name:</label>
<input type="text" name="last_name" id="lastName">
</p>
<p>
<label for="Gender">Gender:</label>
<input type="text" name="gender" id="Gender">
</p>
<p>
<label for="Address">Address:</label>
<input type="text" name="address" id="Address">
</p>
<p>
<label for="emailAddress">Email Address:</label>
<input type="text" name="email" id="emailAddress">
</p>
<input type="submit" value="Submit">
</form>
</center>
</body>

When user enters the data and click on submit then this form takes action insert.php which is as shown below

<!DOCTYPE html>
<html>
<head>
<title>Inserting details</title>
</head>
<body>
<center>
<?php
$host = 'db';

// Database use name
$user = 'MYSQL_USER';

//database user password
$pass = 'MYSQL_PASSWORD';

//database name
$name = 'MYSQL_DATABASE';

// check the MySQL connection status
$conn = new mysqli($host, $user, $pass, $name);
// Check connection
if($conn === false)
{
	die("ERROR: Could not connect. ". mysqli_connect_error());
}

// Taking all 5 values from the form data(input)
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$gender = $_REQUEST['gender'];
$address = $_REQUEST['address'];
$email = $_REQUEST['email'];

// Performing insert query execution
// here our table name is college
$sql = "INSERT INTO student_details VALUES ('$first_name','$last_name','$gender','$address','$email')";

if(mysqli_query($conn, $sql)){
echo "<h3>data stored in a database successfully."
. " Please browse your localhost php my admin"
. " to view the updated data</h3>";

echo nl2br("\n$first_name\n $last_name\n "
. "$gender\n $address\n $email");
} else{
echo "ERROR: Hush! Sorry $sql. "
. mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
</center>
</body>
</html>

Now this insert.php will push the form data into MYSQL_DATABASE under student_details table in phpmyadmin.

The Docker images that were created for this web application are:

kishore@kishore-VirtualBox:~/webapplication/php/src$ docker images

REPOSITORY                              TAG          IMAGE ID       CREATED        SIZE
webapplication_php-apache-environment   latest       0275193e344b   14 hours ago   497MB
php                                     8.0-apache   a91619aa5b87   4 days ago     477MB
mysql                                   latest       5a4e492065c7   13 days ago    514MB
phpmyadmin/phpmyadmin                   latest       2e5141bbcbfb   2 months ago   474MB

This is the sample web application which I done with the help of the docker containers and docker images.

