GCRUD
=========================================

Crud generator (Controller and model)

Requirements
------------

* CodeIgniter 3.0+
* PHP 5.6+
* MySQL


Installation
------------

Download and unpack the contents of the application/libraries folder to your CodeIgniter project.


Controller example
------------------

In the demo folder you can find a fully working example of this library. It also includes a basic user model and an extra .sql script to create the users database table.

Here is an example how you _could_ use the library on your login page:

    // Welcome controller -> imdex method
    $params = array(
    	'folders' => array('admin','site'),
    	'controllers' => array('User','Post','Image'),
    		'tables' => array(
    			'User' => 'users',
    			'Post' => 'posts',
    			'Image' => 'images'
    		)
    	);
    $this->load->library('gcrud',$params);
