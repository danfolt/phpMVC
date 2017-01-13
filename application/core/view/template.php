<?php

class Template_View extends View
{
	public function __construct($page)
	{
		parent::__construct($page);
	}

	public function ShowForm($data)
	{
		if ($data) // edit
		{
			foreach ($data as $key => $value) 
			{
				if ($key == 'filename') $filename = $value;
				if ($key == 'contents') $contents = $value;
			}
		}

		$path = str_replace('/', ' / ', $filename);

		include GENER_DIR . 'form.php';

		$form_object = new FormBuilder();

		$form_title = 'Edit Template';
		$form_image = 'img/32x32/list_edit.png';
		$form_width = '100%';
		
		$form_object->init($form_title, $form_image, $form_width);

		$form_action = 'index.php?route=' . MODULE_NAME;

		$form_object->set_action($form_action);

		$form_inputs = array(
			array(
				'caption' => 'Template', 
				'data' => array(
					'type' => 'label', 'id' => 'path', 'name' => 'path', 'value' => $path,
					),
				),
			array(
				'caption' => 'Content', 
				'data' => array(
					'type' => 'textarea', 'id' => 'contents', 'name' => 'contents', 'rows' => 30, 'value' => $contents, 'required' => 'required',
					),
				),
			);

		$form_object->set_inputs($form_inputs);
		
		$form_hiddens = array(
			array(
				'type' => 'hidden', 'id' => 'filename', 'name' => 'filename', 'value' => $filename,
				),
			);
			
		$form_object->set_hiddens($form_hiddens);

		$form_buttons = array(
			array(
				'type' => 'save', 'id' => 'save_button', 'name' => 'save_button', 'value' => 'Save',
				),
			array(
				'type' => 'close', 'id' => 'update_button', 'name' => 'update_button', 'value' => 'Update',
				),
			array(
				'type' => 'cancel', 'id' => 'cancel_button', 'name' => 'cancel_button', 'value' => 'Cancel',
				),
			);
		
		$form_object->set_buttons($form_buttons);

		$result = $form_object->build_form();

		return $result;
	}
}

?>