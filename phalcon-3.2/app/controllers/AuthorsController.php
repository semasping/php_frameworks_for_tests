<?php

class AuthorsController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
	    $this->persistent->parameters = null;
	    $parameters = $this->persistent->parameters;
	    if (!is_array($parameters)) {
		    $parameters = [];
	    }
	    $parameters["order"] = "id";
	    $authors = Authors::find($parameters);
	    if (count($authors) == 0) {
		    $this->flash->notice("The search did not find any posts");

		    $this->dispatcher->forward([
			    "controller" => "authors",
			    "action" => "index"
		    ]);

		    return;
	    }
	    $this->view->authors = $authors;
    }

}

