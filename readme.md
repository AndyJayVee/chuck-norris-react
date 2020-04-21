### Set up this project
\
**_Database_:**\
First set up a mysql -v5.7 database named chuck_norris_jokes on channel 3306\
user = root, no password

**_Dependencies_:**\
If needed first install symfony and yarn:\
https://symfony.com/download
```text
npm install yarn
```

Install dependencies:
```text
composer install
yarn install
```

**_Run the server_:**
```text
yarn run dev --watch
symfony server:start --port=8000
```
**_Run the migrations_:**
```text
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

**_Open browser_:**
```text
symfony open:local
```
(opens in https://127.0.0.1:8000)

**_Routes_:**\
Root of the project:\
localhost:8000

10 random jokes come from:\
https://api.icndb.com/jokes/random/10

To save a joke to favorites:\
https://localhost:8000/save/[number]\
(example https://localhost:8000/save/1)

To remove a joke:
https://localhosts:8000/save/[number]\
(example https://localhost:8000/save/1)

For all favorite jokes:\
https://localhost:8000/favorites