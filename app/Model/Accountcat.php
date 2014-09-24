<?php

class Accountcat extends AppModel {

	var $name="Accountcat";

	

	var $validate =  array(

		'accountCategory' => array(

			'noblank' => array(

				'rule'    => 'notEmpty',

				'message' => 'Please enter account category'

    		),

			'unique' =>array(

				'rule'    => 'isUnique',

				'message' => 'This account category name has already been taken.'

			)

		)

	);	

	

}



?>