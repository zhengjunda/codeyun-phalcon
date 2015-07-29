<?php
namespace VE\Tutorial;
use VE\Common\BaseModule;
class Module extends BaseModule{
	public function init(){

	}
	/*****************
	 * Method :boot
	 * @Executed when the application handles its first request
	 * ----------
	 * Method :beforeStartModule 
	 * @Before initialize a module ,only when modules are registered
	 * ----------
	 * Method :afterStartModule
	 * @After initialize a module,only when modules are registered
	 * ----------
	 * Method :beforeHandleRequest
	 * @Before execute the dispatch loop
	 * ----------
	 * Method :afterHandleRequest
	 * @After execute the dispatch loop
	 */

}

/****************
** set dispatchers include Exception error
**

$dispatcher = $di['dispatcher'];

// Pass the processed router parameters to the dispatcher
$dispatcher->setControllerName($router->getControllerName());
$dispatcher->setActionName($router->getActionName());
$dispatcher->setParams($router->getParams());

try {

    // Dispatch the request
    $dispatcher->dispatch();

} catch (Exception $e) {

    //An exception has occurred, dispatch some controller/action aimed for that

    // Pass the processed router parameters to the dispatcher
    $dispatcher->setControllerName('errors');
    $dispatcher->setActionName('action503');

    // Dispatch the request
    $dispatcher->dispatch();

}

//Get the returned value by the latest executed action
$response = $dispatcher->getReturnedValue();

//Check if the action returned is a 'response' object
if ($response instanceof Phalcon\Http\ResponseInterface) {

    //Send the request
    $response->send();
}

**/

/****************
** set router 
**
/:module  
	/([a-zA-Z0-9_-]+)
	Matches a valid module name with alpha-numeric characters only

/:controller
	/([a-zA-Z0-9_-]+)
	Matches a valid controller name with alpha-numeric characters only

/:action
	/([a-zA-Z0-9_]+)
	Matches a valid action name with alpha-numeric characters only

/:params
	(/.*)*
	Matches list of optional words separated by slashes. Use only this placeholder at the end of a route
	
/:namespace 
	/([a-zA-Z0-9_-]+)
	Matches a single level namespace name

/:int
	/([0-9]+)
	Matches an integer parameter

-----------------------------------------------------
        // Return "year" parameter
        $year = $this->dispatcher->getParam("year");

        // Return "month" parameter
        $month = $this->dispatcher->getParam("month");

        // Return "day" parameter
        $day = $this->dispatcher->getParam("day");

-----------------------------------------------------
		$router->add(
			"/documentation/{chapter}/{name}.{type:[a-z]+}",
			array(
				"controller" => "documentation",
				"action"     => "show"
			)
		);

		public function showAction()
		{

			// Returns "name" parameter
			$name = $this->dispatcher->getParam("name");

			// Returns "type" parameter
			$type = $this->dispatcher->getParam("type");

		}
-----------------------------------------------------
		// Short form
		$router->add("/posts/{year:[0-9]+}/{title:[a-z\-]+}", "Posts::show");

		// Array form
		$router->add(
			"/posts/([0-9]+)/([a-z\-]+)",
			array(
			   "controller" => "posts",
			   "action"     => "show",
			   "year"       => 1,
			   "title"      => 2,
			)
		);
-----------------------------------------------------
		$router = new Phalcon\Mvc\Router(false);

		$router->add('/:module/:controller/:action/:params', array(
			'module' => 1,
			'controller' => 2,
			'action' => 3,
			'params' => 4
		));

-----------------------------------------------------
		$router->add("/login", array(
			'module' => 'backend',
			'controller' => 'login',
			'action' => 'index',
		));

		$router->add("/products/:action", array(
			'module' => 'frontend',
			'controller' => 'products',
			'action' => 1,
		));
-----------------------------------------------------
		$router->add("/:namespace/login", array(
			'namespace' => 1,
			'controller' => 'login',
			'action' => 'index'
		));
		$router->add("/login", array(
			'namespace' => 'Backend\Controllers',
			'controller' => 'login',
			'action' => 'index'
		));
-----------------------------------------------------
		// This route only will be matched if the HTTP method is GET
		$router->addGet("/products/edit/{id}", "Products::edit");

		// This route only will be matched if the HTTP method is POST
		$router->addPost("/products/save", "Products::save");

		// This route will be matched if the HTTP method is POST or PUT
		$router->add("/products/update")->via(array("POST", "PUT"));
-----------------------------------------------------
		//The action name allows dashes, an action can be: /products/new-ipod-nano-4-generation
		$router
			->add('/products/{slug:[a-z\-]+}', array(
				'controller' => 'products',
				'action' => 'show'
			))
			->convert('slug', function($slug) {
				//Transform the slug removing the dashes
				return str_replace('-', '', $slug);
			});
-----------------------------------------------------
		$router = new \Phalcon\Mvc\Router();

		//Create a group with a common module and controller
		$blog = new \Phalcon\Mvc\Router\Group(array(
			'module' => 'blog',
			'controller' => 'index'
		));

		//All the routes start with /blog
		$blog->setPrefix('/blog');

		//Add a route to the group
		$blog->add('/save', array(
			'action' => 'save'
		));

		//Add another route to the group
		$blog->add('/edit/{id}', array(
			'action' => 'edit'
		));

		//This route maps to a controller different than the default
		$blog->add('/blog', array(
			'controller' => 'blog',
			'action' => 'index'
		));
-----------------------------------------------------
		class BlogRoutes extends Phalcon\Mvc\Router\Group
		{
			public function initialize()
			{
				//Default paths
				$this->setPaths(array(
					'module' => 'blog',
					'namespace' => 'Blog\Controllers'
				));

				//All the routes start with /blog
				$this->setPrefix('/blog');

				//Add a route to the group
				$this->add('/save', array(
					'action' => 'save'
				));

				//Add another route to the group
				$this->add('/edit/{id}', array(
					'action' => 'edit'
				));

				//This route maps to a controller different than the default
				$this->add('/blog', array(
					'controller' => 'blog',
					'action' => 'index'
				));

			}
		}
		//Add the group to the router
		$router->mount(new BlogRoutes());
-----------------------------------------------------
		// Creating a router
		$router = new \Phalcon\Mvc\Router();

		// Define routes here if any
		// ...

		// Taking URI from $_GET["_url"]
		$router->handle();

		// or Setting the URI value directly
		$router->handle("/employees/edit/17");

		// Getting the processed controller
		echo $router->getControllerName();

		// Getting the processed action
		echo $router->getActionName();

		//Get the matched route
		$route = $router->getMatchedRoute();
-----------------------------------------------------
		$route = $router->add("/posts/{year}/{title}", "Posts::show");

		$route->setName("show-posts");

		//or just

		$router->add("/posts/{year}/{title}", "Posts::show")->setName("show-posts");

		// returns /posts/2012/phalcon-1-0-released
		echo $url->get(array(
			"for" => "show-posts",
			"year" => "2012",
			"title" => "phalcon-1-0-released"
		));
-----------------------------------------------------
		//Setting a specific default
		$router->setDefaultModule('backend');
		$router->setDefaultNamespace('Backend\Controllers');
		$router->setDefaultController('index');
		$router->setDefaultAction('index');

		//Using an array
		$router->setDefaults(array(
			'controller' => 'index',
			'action' => 'index'
		));
-----------------------------------------------------
		$router = new \Phalcon\Mvc\Router();

		//Remove trailing slashes automatically
		$router->removeExtraSlashes(true);
-----------------------------------------------------
Match Callbacks
Sometimes, routes must be matched if they meet specific conditions, you can add arbitrary conditions to routes using the ¡®beforeMatch¡¯ callback, if this function return false, the route will be treaded as non-matched:

		$router->add('/login', array(
			'module' => 'admin',
			'controller' => 'session'
		))->beforeMatch(function($uri, $route) {
			//Check if the request was made with Ajax
			if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'xmlhttprequest') {
				return false;
			}
			return true;
		});
-----------------------------------------------------
You can re-use these extra conditions in classes:

		class AjaxFilter
		{
			public function check()
			{
				return $_SERVER['HTTP_X_REQUESTED_WITH'] == 'xmlhttprequest';
			}
		}
-----------------------------------------------------
And use this class instead of the anonymous function:

		$router->add('/get/info/{id}', array(
			'controller' => 'products',
			'action' => 'info'
		))->beforeMatch(array(new AjaxFilter(), 'check'));
-----------------------------------------------------
Hostname Constraints
The router allow to set hostname constraints, this means that specific routes or a group of routes can be restricted to only match if the route also meets the hostname constraint:

		$router->add('/login', array(
			'module' => 'admin',
			'controller' => 'session',
			'action' => 'login'
		))->setHostName('admin.company.com');
-----------------------------------------------------
Hostname can also be regular expressions:
		$router->add('/login', array(
			'module' => 'admin',
			'controller' => 'session',
			'action' => 'login'
		))->setHostName('([a-z+]).company.com');
-----------------------------------------------------
In groups of routes you can set up a hostname constraint that apply for every route in the group:

		//Create a group with a common module and controller
		$blog = new \Phalcon\Mvc\Router\Group(array(
			'module' => 'blog',
			'controller' => 'posts'
		));

		//Hostname restriction
		$blog->setHostName('blog.mycompany.com');

		//All the routes start with /blog
		$blog->setPrefix('/blog');

		//Default route
		$blog->add('/', array(
			'action' => 'index'
		));

		//Add a route to the group
		$blog->add('/save', array(
			'action' => 'save'
		));

		//Add another route to the group
		$blog->add('/edit/{id}', array(
			'action' => 'edit'
		));

		//Add the group to the router
		$router->mount($blog);
-----------------------------------------------------
URI Sources
By default the URI information is obtained from the $_GET[¡®_url¡¯] variable, this is passed by the Rewrite-Engine to Phalcon, you can also use $_SERVER[¡®REQUEST_URI¡¯] if required:

		$router->setUriSource(Router::URI_SOURCE_GET_URL); // use $_GET['_url'] (default)
		$router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI); // use $_SERVER['REQUEST_URI'] (default)
-----------------------------------------------------
Testing your routes
Since this component has no dependencies, you can create a file as shown below to test your routes:
-----------------------------------------------------
		//These routes simulate real URIs
		$testRoutes = array(
			'/',
			'/index',
			'/index/index',
			'/index/test',
			'/products',
			'/products/index/',
			'/products/show/101',
		);

		$router = new Phalcon\Mvc\Router();

		//Add here your custom routes
		//...

		//Testing each route
		foreach ($testRoutes as $testRoute) {

			//Handle the route
			$router->handle($testRoute);

			echo 'Testing ', $testRoute, '<br>';

			//Check if some route was matched
			if ($router->wasMatched()) {
				echo 'Controller: ', $router->getControllerName(), '<br>';
				echo 'Action: ', $router->getActionName(), '<br>';
			} else {
				echo 'The route wasn\'t matched by any route<br>';
			}
			echo '<br>';

		}
-----------------------------------------------------
Annotations Router
This component provides a variant that¡¯s integrated with the annotations service. Using this strategy you can write the routes directly in the controllers instead of adding them in the service registration:
		$di['router'] = function() {

			//Use the annotations router
			$router = new \Phalcon\Mvc\Router\Annotations(false);

			//Read the annotations from ProductsController if the uri starts with /api/products
			$router->addResource('Products', '/api/products');

			return $router;
		};
-----------------------------------------------------
The annotations can be defined in the following way:

		//@RoutePrefix("/api/products")
		class ProductsController
		{

			// @Get("/")
			public function indexAction()
			{

			}

			 // @Get("/edit/{id:[0-9]+}", name="edit-robot")
			public function editAction($id)
			{

			}

			// @Route("/save", methods={"POST", "PUT"}, name="save-robot")
			public function saveAction()
			{

			}

			
			 //@Route("/delete/{id:[0-9]+}", methods="DELETE",
			 //conversors={id="MyConversors::checkId"})

			public function deleteAction($id)
			{

			}

			public function infoAction($id)
			{

			}


**/
