<?php
class Post extends AppModel{
    public $name = "Post";
    
    //public $actsAs = array('Uploader.FileValidation');
  //  public $actsAs = array('Uploader.Attachment');
    
    public $actsAs = array( 
	'Uploader.Attachment' => array(
		'image_url' => array(
			'transforms' => array(
				array('method' => 'scale', 'percent' => .3, 'dbColumn' => 'path_scaled'),
				array('method' => 'resize', 'width' => 50, 'height' => 50, 'dbColumn' => 'path') // Removes original image and uses this one instead
			)
		)
	)
    );
    
    public $validate = array(
      'title'=>array(
            'rule'=>'notEmpty',
            'message'=>'Title can\'t be blank'
      )  ,
      'body'=>array(
            'rule'=>'notEmpty',
            'message'=>'Body can\'t be blank'
      )
    );
    
    
    
    public function isOwnedBy($post, $user) {
        return $this->field('id', array('id' => $post, 'user_id' => $user)) === $post;
    }
}
?>
