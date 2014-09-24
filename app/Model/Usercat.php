<?php

class Usercat extends AppModel {

	var $name="Usercat";

	

	var $validate =  array(

		'category_name' => array(

			'noblank' => array(

				'rule'    => 'notEmpty',

				'message' => 'Please enter category name'

    		),

			'unique' =>array(

				'rule'    => 'isUnique',

				'message' => 'This category name has already been taken.'

			)

		)

	);	

	

}



?>
