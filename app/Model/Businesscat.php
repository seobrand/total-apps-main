<?php

class Businesscat extends AppModel {

	var $name = "Businesscat";
	var $useTable = 'business_categories';
	

	var $validate =  array(
		'category_name' => array(
			'noblank' => array(
				'rule'    => 'notEmpty',
				'message' => 'Please enter business category name'
    		),
			'unique' =>array(
				'rule'    => 'isUnique',
				'message' => 'This business category name has already been taken.'
			)
		)
	);	
	
	public $hasMany = array(
        'Subcat' => array(
            'className' => 'Businesscat',
            'foreignKey' => 'parent_id',
        	'dependent'     => true
        )
    );

	

}



?>
