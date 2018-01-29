<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Data as FrontData;


class PostswcController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $posts = null;
        $frontCache = new FrontData(
            [
                'lifetime' => 172800,
            ]
        );
        $cache = new BackFile(
            $frontCache,
            [
                'cacheDir' => '../app/cache/',
            ]
        );

        $cacheKey = 'posts.cache';

        $posts = $cache->get($cacheKey);

        if ($posts === null) {

            $this->persistent->parameters = null;
            $parameters = $this->persistent->parameters;
            if (!is_array($parameters)) {
                $parameters = [];
            }
            //$parameters["limit"] = "100";
            //$parameters["limit"] = array('number' => 100, 'offset' => 10);
            $parameters["order"] = "id";

            $posts = Posts::find($parameters);
            $cache->save($cacheKey, $posts);
        }

	    if (count($posts) == 0) {
		    $this->flash->notice("The search did not find any posts");

		    $this->dispatcher->forward([
			    "controller" => "postsCache",
			    "action" => "index"
		    ]);

		    return;
	    }
        //var_dump($posts);
	    $this->view->posts = $posts;
    }

    /**
     * Searches for posts
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Posts', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $posts = Posts::find($parameters);
        if (count($posts) == 0) {
            $this->flash->notice("The search did not find any posts");

            $this->dispatcher->forward([
                "controller" => "posts",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $posts,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a post
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $post = Posts::findFirstByid($id);
            if (!$post) {
                $this->flash->error("post was not found");

                $this->dispatcher->forward([
                    'controller' => "posts",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $post->id;

            $this->tag->setDefault("id", $post->id);
            $this->tag->setDefault("title", $post->title);
            $this->tag->setDefault("body", $post->body);
            $this->tag->setDefault("slug", $post->slug);
            $this->tag->setDefault("author_id", $post->author_id);
            $this->tag->setDefault("post_type_id", $post->post_type_id);
            
        }
    }

    /**
     * Creates a new post
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "posts",
                'action' => 'index'
            ]);

            return;
        }

        $post = new Posts();
        $post->id = $this->request->getPost("id");
        $post->title = $this->request->getPost("title");
        $post->body = $this->request->getPost("body");
        $post->slug = $this->request->getPost("slug");
        $post->author_id = $this->request->getPost("author_id");
        $post->post_type_id = $this->request->getPost("post_type_id");
        

        if (!$post->save()) {
            foreach ($post->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "posts",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("post was created successfully");

        $this->dispatcher->forward([
            'controller' => "posts",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a post edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "posts",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $post = Posts::findFirstByid($id);

        if (!$post) {
            $this->flash->error("post does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "posts",
                'action' => 'index'
            ]);

            return;
        }

        $post->id = $this->request->getPost("id");
        $post->title = $this->request->getPost("title");
        $post->body = $this->request->getPost("body");
        $post->slug = $this->request->getPost("slug");
        $post->author_id = $this->request->getPost("author_id");
        $post->post_type_id = $this->request->getPost("post_type_id");
        

        if (!$post->save()) {

            foreach ($post->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "posts",
                'action' => 'edit',
                'params' => [$post->id]
            ]);

            return;
        }

        $this->flash->success("post was updated successfully");

        $this->dispatcher->forward([
            'controller' => "posts",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a post
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $post = Posts::findFirstByid($id);
        if (!$post) {
            $this->flash->error("post was not found");

            $this->dispatcher->forward([
                'controller' => "posts",
                'action' => 'index'
            ]);

            return;
        }

        if (!$post->delete()) {

            foreach ($post->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "posts",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("post was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "posts",
            'action' => "index"
        ]);
    }

}
