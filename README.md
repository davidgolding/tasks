# tasks
Code exercise and sample

### Structure and Design Considerations
My first priority in working through the exercise was to write as little code as possible
while hitting the core benchmarks. I chose the Li3 (Lithium) framework for the backend API
for its modularity and balance in both object-oriented and aspect-oriented programming
paradigms. Using the `ngResource` class in AngularJS allowed the frontend interface to
minimize the amount of interfacing with the API.

### Li3 Structure
The API uses a light amount of PHP programming, starting with an index.php dispatcher
to invoke the `api/config/bootstrap.php` file. The purpose of separating the include
routines from the index.php file is to maintain a semantic scheme across the application.
Individual files in `api/config` reflect aspects (in the AOP sense), in other words
concerns the cut across the application, like bootstrapping, connecting data sources,
routing requests and responses, and defining namespaces.

The rest of the API remains simple yet patterned on an object-oriented scheme. The
`api/controllers` directory houses the classes responsible for performing any
strictly procedural logic. The `api/models` directory holds the classes responsible for
interfacing with data sources and supplying the data layer of the application. All that
remains is the `api/extensions` and `api/resources` directories, each with minimal elements:
`resources` would contain any vendor or stand-alone resource files, such as the Sqlite3
database, or should the application grow, any additional non-webroot resources; `extensions`
allows for quick and consistent separation of tasks not fitting the controller or model
logics, in this case a `Rest` class for defining a set list of response codes.

The API itself follows REST HTTP convention: a GET, POST, PUT, and DELETE request on a
semantic URI string defines the interaction between the frontend (or any interface for
that matter) and the expected response. The `api/config/routes.php` file defines these
request paths and routes them to the `api/controllers/ItemsController.php` class for
interpretation.

From there, `ItemsController` works with `api/models/Items.php` to query the data source
and supply content as a JSON string. A basic whitelist maintained by another model, `Users`,
allows for a quick authentication check before responding with actual content. All responses
carry an HTTP response code relevant to the request.

### AngularJS Structure
The API remains agnostic to the interface that manipulates the content, which in this case
is an AngularJS front end in HTML5. In the `www/js/app.angular.js` file, the `TasksController`
uses an `Items` resource object to perform a starting GET request on the API and populate
the `$scope` with a data model. Deletions to the task list send a DELETE request to the API
and refreshes the content with a new GET request. Additions POST to the API, and edits PUT.

The presentation layer was my lowest priority: I would want the Angular code to be minimal,
allowing for easy CSS swapping. Ideally, writing changes to CSS and HTML would have almost
no impact on either the API or the `app.angular.js` script.
