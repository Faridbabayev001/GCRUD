CodeIgniter Secure Authentication Library
=========================================

This is a secure authentication library for codeigniter.

**WARNING**: this is version 2 of this library, a more simplified, easier to use version that is easier to implement in existing code. The original library relied too much on correct model communication that now has been removed. Most of the functionality has been preserved, although some things have been moved to the model as you can see in the example folder.

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
