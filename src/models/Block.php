<?php
namespace Blocks;

/**
 *
 */
class Block extends Model
{
	// Model properties

	protected $tableName = 'blocks';
	protected $settingsTableName = 'blocksettings';
	protected $foreignKeyName = 'block_id';
	protected $classSuffix = 'Block';
	public $hasSettings = true;

	protected $attributes = array(
		'name'         => AttributeType::Name,
		'handle'       => array('type' => AttributeType::Handle, 'reservedWords' => 'id,date_created,date_updated,uid,title'),
		'class'        => AttributeType::ClassName,
		'instructions' => AttributeType::Text,
		'required'     => AttributeType::Boolean,
		'sort_order'   => AttributeType::SortOrder
	);

	// Block subclass properties

	public $blocktypeName;

	public $required;

	protected $settingsTemplate;
	protected $columnType = AttributeType::Text;


	/**
	 * Get the content column type
	 * @return string
	 */
	public function getColumnType()
	{
		return $this->columnType;
	}

	/**
	 * Display the blocktype's settings
	 *
	 * @param $idPrefix
	 * @param $namePrefix
	 * @return string
	 */
	public function displaySettings($idPrefix, $namePrefix)
	{
		if (empty($this->settingsTemplate))
			return '';

		$variables = array(
			'idPrefix'   => $idPrefix,
			'namePrefix' => $namePrefix,
			'settings'   => $this->settings
		);

		$template = b()->controller->loadTemplate($this->settingsTemplate, $variables, true);
		return $template;
	}

	/**
	 * Display the field
	 * @return string
	 */
	public function displayField($data)
	{
		if (empty($this->fieldTemplate))
			return '';

		$variables = array(
			'handle'   => $this->handle,
			'settings' => $this->settings,
			'data'     => $data
		);

		$template = b()->controller->loadTemplate($this->fieldTemplate, $variables, true);
		return $template;
	}

	/**
	 * Provides an opportunity to modify the post data before it gets saved to the database.
	 * This function is required for blocktypes that post array data that can't be converted to a string.
	 * @param mixed $data
	 * @return string
	 */
	public function modifyPostData($data)
	{
		return (string)$data;
	}

}
