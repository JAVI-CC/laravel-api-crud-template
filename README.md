<p align="center"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></p>

<span>Application made with Laravel 10 that consists of the creation of a CRUD of a user and system authentication api that contains the following functionalities:</span>
<ul>
  <li>Relationships between different models.</li>
  <li>Primary key format UUID.</li>
  <li>Contains endpoints of type GET, POST, PUT and DELETE</li>
  <li>Postman collection.json file to import and create use endpoints.</li>
  <li>Requests validations.</li>
  <li>Exception handling.</li>
  <li>Feature testing.</li>
  <li>Email sending Notification to recovery password.</li>
  <li>Email sending notification to verify the user.</li>
  <li>Factories.</li>
  <li>Traits.</li>
  <li>Middleware.</li>
  <li>Policies.</li>
  <li>Observers.</li>
  <li>Cached data.</li>
  <li>File Storage.</li>
  <li>Notifications with broadcast.</li>
  <li>Exports in Excel and PDF format.</li>
  <li>Blade Email Templates.</li>
  <li>Multi language support.</li>
  <li>Migration file to create all the tables in the database.</li>
  <li>Seeders are in JSON format.</li>
  <li>PHP 8.2.*</li>
  <li>Search filters of the games that are inserted in the database.</li>
  <li>Websockets with Pusher.</li>
  <li>Users contain different roles and permissions.</li>
  <li>The project contains the files to deploy it in Docker.</li> 
</ul> 

<h3>Headers</h3>
<table>
<thead>
<tr>
<th>Key</th>
<th>Value</th>
</tr>
</thead>
<tbody>
<tr>
<td>Authorization</td>
<td>{Token provided by Sanctum}</td>
</tr>
<tr>
<td>Accept</td>
<td>application/json</td>
</tr>
<tr>
<td>Content-Type</td>
<td>application/json</td>
</tr>
</tbody>
</table>

<h3>Setup</h3>
<pre>
<code>$ composer install && php artisan key:generate && php artisan storage:link && php artisan migrate --seed && php artisan test</code>
</pre>

<h3>User admin credentials</h3>
<span>User: <b>admin@email.com</b></span><br>
<span>Password: <b>password</b></span>

<hr>

<h3>Endpoints Auth:</h3>
<table>
<thead>
<tr>
<th>Method</th>
<th>Path</th>
<th>Description</th>
<th>Auth</th>
<th>Is Admin</th>
</tr>
</thead>
<tbody>
<tr>
<td>POST</td>
<td>/api/auth/login</td>
<td>Login a user</td>
<td>No</td>
<td>No</td>
</tr>
<tr>
<td>GET</td>
<td>/api/auth/check</td>
<td>Check if user authenticated</td>
<td>Yes</td>
<td>No</td>
</tr>
<tr>
<td>GET</td>
<td>/api/auth/logout</td>
<td>Log out a user</td>
<td>Yes</td>
<td>No</td>
</tr>
<tr>
<td>POST</td>
<td>/api/auth/change/password</td>
<td>Change the password for the authenticated user</td>
<td>Yes</td>
<td>No</td>
</tr>
<tr>
<td>POST</td>
<td>/api/auth/recovery/password</td>
<td>An email is sent to reset the password</td>
<td>No</td>
<td>No</td>
</tr>
<tr>
<td>POST</td>
<td>/api/user/verification/email/notification</td>
<td>Sending an email to confirm the verification of the authenticated user</td>
<td>Yes</td>
<td>No</td>
</tr>
<tr>
<td>GET</td>
<td>/api/user/verification/email/{id}/{hash}</td>
<td>Verify authenticated user</td>
<td>Yes</td>
<td>No</td>
</tr>
</tbody>
</table>

<h3>Endpoints Users:</h3>
<table>
<thead>
<tr>
<th>Method</th>
<th>Path</th>
<th>Description</th>
<th>Auth</th>
<th>Is Admin</th>
</tr>
</thead>
<tbody>
<tr>
<td>GET</td>
<td>/api/user</td>
<td>Get all the users</td>
<td>Yes</td>
<td>Yes</td>
</tr>
<tr>
<td>GET</td>
<td>/api/user/{id}</td>
<td>Get a user</td>
<td>Yes</td>
<td>Yes</td>
</tr>
<tr>
<td>POST</td>
<td>/api/user</td>
<td>Add new user</td>
<td>Yes</td>
<td>Yes</td>
</tr>
<tr>
<td>PUT</td>
<td>/api/user/{id}</td>
<td>Update a user</td>
<td>Yes</td>
<td>Yes</td>
</tr>
<tr>
<td>DELETE</td>
<td>/api/user/{id}</td>
<td>Delete a user</td>
<td>Yes</td>
<td>Yes</td>
</tr>
<tr>
<td>GET</td>
<td>/api/user/export/excel</td>
<td>Export all users in Excel format</td>
<td>Yes</td>
<td>Yes</td>
</tr>
<tr>
<td>GET</td>
<td>/api/user/export/pdf</td>
<td>Export all users in Pdf format</td>
<td>Yes</td>
<td>Yes</td>
</tr>
</tbody>
</table>

<h3>Endpoints Roles:</h3>
<table>
<thead>
<tr>
<th>Method</th>
<th>Path</th>
<th>Description</th>
<th>Auth</th>
<th>Is Admin</th>
</tr>
</thead>
<tbody>
<tr>
<td>GET</td>
<td>/api/roles</td>
<td>Get all the roles</td>
<td>Yes</td>
<td>Yes</td>
</tr>
</tbody>
</table>

<br>

<h2>Configure values in the .env file</h2>
<pre><code>
<strong>PUSHER_APP_ID=""</strong>
<strong>PUSHER_APP_KEY=""</strong>
<strong>PUSHER_APP_SECRET=""</strong>
<strong>PUSHER_APP_CLUSTER=""</strong>
</code></pre>

<pre><code>
<strong>MAIL_MAILER=""</strong>
<strong>MAIL_HOST=""</strong>
<strong>MAIL_PORT=""</strong>
<strong>MAIL_USERNAME=""</strong>
<strong>MAIL_PASSWORD=""</strong>
<strong>MAIL_FROM_ADDRESS=""</strong>
</code></pre>

<pre><code>
<strong>DB_TEST_CONNECTION=""</strong>
<strong>DB_TEST_HOST=""</strong>
<strong>DB_TEST_PORT=""</strong>
<strong>DB_TEST_DATABASE=""</strong>
<strong>DB_TEST_USERNAME=""</strong>
<strong>DB_TEST_PASSWORD=""</strong>
</code></pre>

<pre><code>
<strong>DOMAIN_FRONTEND="http://localhost:9000"</strong>
</code></pre>

<br>

<h2>Deploy to Docker <g-emoji class="g-emoji" alias="whale" fallback-src="https://github.githubassets.com/images/icons/emoji/unicode/1f433.png">🐳</g-emoji></h2>

<span>Docker repository: <a href="https://hub.docker.com/r/javi98/laravel-api-crud-template" target="_blank">https://hub.docker.com/r/javi98/laravel-api-crud-template</a></span>

<h4>Containers:</h4>
<ul>
<li><span>php:8.2.13-fpm</span> - <code>:9000</code></li>
<li><span>nginx:alpine</span> - <code>:8000->80/tcp</code></li>
<li><span>mariadb:11.2.2</span> - <code>:3306</code></li>
<li><span>mailhog:v1.0.1</span> - <code>:1025 # smtp server</code> <code>:8025 # web ui</code></li>
</ul>

<h4>Containers structure:</h4>
<div class="highlight highlight-source-shell"><pre>├── laravel-api-crud-template-app
├── laravel-api-crud-template-web
├── laravel-api-crud-template-db
└── laravel-api-crud-template-smtp</pre></div>

<h4>Setup:</h4>
<pre>
<code>$ git clone https://github.com/JAVI-CC/Laravel-API-CRUD-Template.git
$ cd Laravel-API-CRUD-Template
$ cp .env.example .env
$ docker-compose up -d
$ docker-compose exec app chmod +x ./docker-compose-config/run.sh
$ docker-compose exec app ./docker-compose-config/run.sh</code>
</pre>

<span>Once you have the containers deployed, you can access the API at </span> <a href="http://localhost:8000" target="_blank">http://localhost:8000</a>
