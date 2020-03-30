### Set up this project

**_Database_:**

First set up a mysql -v5.7 database named chuck_norris_jokes on channel 3306\
user = root, no password

**_Dependencies_:**

composer install

**_Run the server_:**

symfony server:start\
yarn run dev-server\
(if needed run npm install yarn)

**_Run the migrations_:**

php bin/console make:migration\
php bin/console doctrine:migrations:migrate


**_Routes_:**

Root of the project:\
localhost:8000

10 random jokes come from:\
http://api.icndb.com/jokes/random/10

To save a joke to favorites:\
http://localhost:8000/save/[number]\
(example http://localhost:8000/save/1)

To remove a joke:
http://localhost:8000/save/[number]\
(example http://localhost:8000/save/1)

For all favorite jokes:\
http://localhost:8000/favorites