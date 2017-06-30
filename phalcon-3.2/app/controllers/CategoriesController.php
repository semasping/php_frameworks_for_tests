<?php

class CategoriesController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
	    $this->persistent->parameters = null;
	    $parameters = $this->persistent->parameters;
	    if (!is_array($parameters)) {
		    $parameters = [];
	    }
	    $parameters["order"] = "id";
	    $categories = Categories::find($parameters);
	    if (count($categories) == 0) {
		    $this->flash->notice("The search did not find any categories");

		    $this->dispatcher->forward([
			    "controller" => "categories",
			    "action" => "index"
		    ]);

		    return;
	    }
	    $this->view->categories = $categories;
    }

}

