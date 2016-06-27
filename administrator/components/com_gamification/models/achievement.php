<?php
/**
 * @package      Gamification Platform
 * @subpackage   Components
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class GamificationModelAchievement extends JModelAdmin
{
    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param   string $type   The table type to instantiate
     * @param   string $prefix A prefix for the table class name. Optional.
     * @param   array  $config Configuration array for model. Optional.
     *
     * @return  GamificationTableAchievement
     * @since   1.6
     */
    public function getTable($type = 'Achievement', $prefix = 'GamificationTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param   array   $data     An optional array of data for the form to interrogate.
     * @param   boolean $loadData True if the form is to load its own data (default case), false if not.
     *
     * @return  JForm   A JForm object on success, false on failure
     * @since   1.6
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm($this->option . '.achievement', 'achievement', array('control' => 'jform', 'load_data' => $loadData));
        if (!$form) {
            return false;
        }

        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return  mixed   The data for the form.
     * @since   1.6
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState($this->option . '.edit.achievement.data', array());
        if (!$data) {
            $data = $this->getItem();

            if (isset($data->rewards) and $data->rewards !== '') {
                $rewards = new \Joomla\Registry\Registry($data->rewards);

                $data->rewards = $rewards->toArray();
            }
        }

        return $data;
    }

    /**
     * Save data into the DB
     *
     * @param array $data The data about item
     *
     * @return  int
     */
    public function save($data)
    {
        $id        = Joomla\Utilities\ArrayHelper::getValue($data, 'id');
        $title     = Joomla\Utilities\ArrayHelper::getValue($data, 'title');
        $context   = Joomla\Utilities\ArrayHelper::getValue($data, 'context');
        $groupId   = Joomla\Utilities\ArrayHelper::getValue($data, 'group_id', 0, 'int');
        $published = Joomla\Utilities\ArrayHelper::getValue($data, 'published', 0, 'int');
        $note      = Joomla\Utilities\ArrayHelper::getValue($data, 'note');
        $params      = Joomla\Utilities\ArrayHelper::getValue($data, 'params', array(), 'array');
        $description = Joomla\Utilities\ArrayHelper::getValue($data, 'description');
        $activityText = Joomla\Utilities\ArrayHelper::getValue($data, 'activity_text');

        $customData = $this->prepareCustomData($data);
        $rewards    = $this->prepareRewards($data);

        if (!$note) {$note = null;}
        if (!$description) {$description = null;}

        // Load a record from the database
        $row = $this->getTable();
        /** @var $row GamificationTableAchievement */

        $row->load($id);

        $row->set('title', $title);
        $row->set('context', $context);
        $row->set('custom_data', $customData);
        $row->set('rewards', $rewards);
        $row->set('group_id', $groupId);
        $row->set('published', $published);
        $row->set('note', $note);
        $row->set('description', $description);
        $row->set('activity_text', $activityText);

        $this->prepareImage($row, $data);

        $row->store(true);

        return $row->get('id');
    }

    /**
     * Prepare images to saving.
     *
     * @param GamificationTableAchievement $table
     * @param array                  $data
     *
     * @since    1.6
     */
    protected function prepareImage($table, $data)
    {
        if (!empty($data['image'])) {
            // Delete old image if I upload new one.
            if ($table->get('image')) {
                $params     = JComponentHelper::getParams($this->option);
                /** @var  $params Joomla\Registry\Registry */

                $filesystemHelper   = new Prism\Filesystem\Helper($params);
                $mediaFolder        = $filesystemHelper->getMediaFolder();
                
                $fileImage  = JPath::clean(JPATH_ROOT .DIRECTORY_SEPARATOR .$mediaFolder. DIRECTORY_SEPARATOR. $table->get('image'));
                $fileSmall  = JPath::clean(JPATH_ROOT .DIRECTORY_SEPARATOR .$mediaFolder. DIRECTORY_SEPARATOR. $table->get('image_small'));
                $fileSquare = JPath::clean(JPATH_ROOT .DIRECTORY_SEPARATOR .$mediaFolder. DIRECTORY_SEPARATOR. $table->get('image_square'));

                if (is_file($fileImage)) {
                    JFile::delete($fileImage);
                }

                if (is_file($fileSmall)) {
                    JFile::delete($fileSmall);
                }

                if (is_file($fileSquare)) {
                    JFile::delete($fileSquare);
                }

            }
            $table->set('image', $data['image']);
            $table->set('image_small', $data['image_small']);
            $table->set('image_square', $data['image_square']);
        }
    }

    /**
     * Prepare custom data.
     *
     * @param array $data
     *
     * @return string
     */
    protected function prepareCustomData($data)
    {
        $customData = Joomla\Utilities\ArrayHelper::getValue($data, 'custom_data', [], 'array');
        
        $results = array();
        $filter  = JFilterInput::getInstance();
        
        foreach ($customData as $values) {
            $key   = trim($filter->clean($values['key'], 'cmd'));
            $value = trim($filter->clean($values['value'], 'string'));

            if (!$key) {
                continue;
            }
            
            $results[$key] = $value;
        }
        
        $customData = new Joomla\Registry\Registry($results);

        return $customData->toString();
    }

    /**
     * Prepare rewards that will be given for accomplishing this unit.
     *
     * @param array  $data
     *
     * @return string
     */
    protected function prepareRewards($data)
    {
        $rewards = Joomla\Utilities\ArrayHelper::getValue($data, 'rewards', [], 'array');

        $rewards['points'] = trim($rewards['points']);
        $rewards['points_id'] = (int)$rewards['points_id'];

        // Prepare badge IDs.
        $results = array();
        foreach ($rewards['badge_id'] as $itemId) {
            $itemId   = (int)$itemId;
            if (!$itemId) {
                continue;
            }

            $results[] = $itemId;
        }
        $rewards['badge_id'] = $results;

        // Prepare rank IDs.
        $results = array();
        foreach ($rewards['rank_id'] as $itemId) {
            $itemId   = (int)$itemId;
            if (!$itemId) {
                continue;
            }

            $results[] = $itemId;
        }
        $rewards['rank_id'] = $results;

        // Prepare badge IDs.
        $results = array();
        foreach ($rewards['reward_id'] as $itemId) {
            $itemId   = (int)$itemId;
            if (!$itemId) {
                continue;
            }

            $results[] = $itemId;
        }
        $rewards['reward_id'] = $results;

        $rewards = new Joomla\Registry\Registry($rewards);

        return $rewards->toString();
    }

    public function removeImage($id)
    {
        // Load a record from the database
        $row = $this->getTable();
        $row->load($id);

        if ($row->get('image')) {
            $params     = JComponentHelper::getParams($this->option);
            /** @var  $params Joomla\Registry\Registry */

            $filesystemHelper   = new Prism\Filesystem\Helper($params);
            $mediaFolder        = $filesystemHelper->getMediaFolder();

            $fileImage  = JPath::clean(JPATH_ROOT . DIRECTORY_SEPARATOR .$mediaFolder. DIRECTORY_SEPARATOR . $row->get('image'));
            $fileSmall  = JPath::clean(JPATH_ROOT . DIRECTORY_SEPARATOR .$mediaFolder. DIRECTORY_SEPARATOR . $row->get('image_small'));
            $fileSquare = JPath::clean(JPATH_ROOT . DIRECTORY_SEPARATOR .$mediaFolder. DIRECTORY_SEPARATOR . $row->get('image_square'));

            if (is_file($fileImage)) {
                JFile::delete($fileImage);
            }

            if (is_file($fileSmall)) {
                JFile::delete($fileSmall);
            }

            if (is_file($fileSquare)) {
                JFile::delete($fileSquare);
            }
        }

        $row->set('image');
        $row->set('image_small');
        $row->set('image_square');
        $row->store(true);
    }

    /**
     * Store the file in a folder of the extension.
     *
     * @param array $image
     *
     * @throws \RuntimeException
     * @throws \Exception
     *
     * @return array
     */
    public function uploadImage($image)
    {
        $app = JFactory::getApplication();
        /** @var $app JApplicationSite */

        $uploadedFile = Joomla\Utilities\ArrayHelper::getValue($image, 'tmp_name');
        $uploadedName = Joomla\Utilities\ArrayHelper::getValue($image, 'name');
        $errorCode    = Joomla\Utilities\ArrayHelper::getValue($image, 'error');

        $params     = JComponentHelper::getParams('com_gamification');
        /** @var  $params Joomla\Registry\Registry */

        $filesystemHelper   = new Prism\Filesystem\Helper($params);
        $mediaFolder        = $filesystemHelper->getMediaFolder();

        $destinationFolder  = JPath::clean(JPATH_ROOT .DIRECTORY_SEPARATOR. $mediaFolder);
        $temporaryFolder    = $app->get('tmp_path');

        // Joomla! media extension parameters
        $mediaParams = JComponentHelper::getParams('com_media');
        /** @var $mediaParams Joomla\Registry\Registry */

        $file = new Prism\File\File();

        // Prepare size validator.
        $KB            = 1024 * 1024;
        $fileSize      = (int)$app->input->server->get('CONTENT_LENGTH');
        $uploadMaxSize = $mediaParams->get('upload_maxsize') * $KB;

        // Prepare file validators.
        $sizeValidator   = new Prism\File\Validator\Size($fileSize, $uploadMaxSize);
        $serverValidator = new Prism\File\Validator\Server($errorCode, array(UPLOAD_ERR_NO_FILE));
        $imageValidator  = new Prism\File\Validator\Image($uploadedFile, $uploadedName);

        // Get allowed mime types from media manager options
        $mimeTypes = explode(',', $mediaParams->get('upload_mime'));
        $imageValidator->setMimeTypes($mimeTypes);

        // Get allowed image extensions from media manager options
        $imageExtensions = explode(',', $mediaParams->get('image_extensions'));
        $imageValidator->setImageExtensions($imageExtensions);

        $file
            ->addValidator($sizeValidator)
            ->addValidator($serverValidator)
            ->addValidator($imageValidator);

        // Validate the file
        if (!$file->isValid()) {
            throw new RuntimeException($file->getError());
        }

        // Generate temporary file name
        $ext = strtolower(JFile::makeSafe(JFile::getExt($image['name'])));

        $generatedName = Prism\Utilities\StringHelper::generateRandomString();

        $temporaryFile = $generatedName.'_achievement.'. $ext;
        $temporaryDestination = JPath::clean($temporaryFolder .DIRECTORY_SEPARATOR. $temporaryFile);

        // Prepare uploader object.
        $uploader = new Prism\File\Uploader\Local($uploadedFile);
        $uploader->setDestination($temporaryDestination);

        // Upload temporary file
        $file->setUploader($uploader);
        $file->upload();

        $temporaryFile = $file->getFile();
        if (!is_file($temporaryFile)) {
            throw new Exception('COM_GAMIFICATION_ERROR_FILE_CANT_BE_UPLOADED');
        }

        // Resize image
        $image = new JImage();
        $image->loadFile($temporaryFile);
        if (!$image->isLoaded()) {
            throw new Exception(JText::sprintf('COM_GAMIFICATION_ERROR_FILE_NOT_FOUND', $temporaryDestination));
        }

        $imageName  = $generatedName . '_image.png';
        $smallName  = $generatedName . '_small.png';
        $squareName = $generatedName . '_square.png';

        $imageFile  = $destinationFolder .DIRECTORY_SEPARATOR. $imageName;
        $smallFile  = $destinationFolder .DIRECTORY_SEPARATOR. $smallName;
        $squareFile = $destinationFolder .DIRECTORY_SEPARATOR. $squareName;

        $scaleOption = $params->get('image_resizing_scale', JImage::SCALE_INSIDE);

        // Create main image
        $width  = $params->get('image_width', 200);
        $height = $params->get('image_height', 200);
        $image->resize($width, $height, false, $scaleOption);
        $image->toFile($imageFile, IMAGETYPE_PNG);

        // Create small image
        $width  = $params->get('image_small_width', 100);
        $height = $params->get('image_small_height', 100);
        $image->resize($width, $height, false, $scaleOption);
        $image->toFile($smallFile, IMAGETYPE_PNG);

        // Create square image
        $width  = $params->get('image_square_width', 50);
        $height = $params->get('image_square_height', 50);
        $image->resize($width, $height, false, $scaleOption);
        $image->toFile($squareFile, IMAGETYPE_PNG);

        $names = array(
            'image'        => $imageName,
            'image_small'  => $smallName,
            'image_square' => $squareName
        );

        // Remove the temporary file.
        if (JFile::exists($temporaryFile)) {
            JFile::delete($temporaryFile);
        }

        return $names;
    }
}
