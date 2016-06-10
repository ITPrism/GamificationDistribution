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
?>
<form action="<?php echo JRoute::_('index.php?option=com_gamification'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-horizontal" enctype="multipart/form-data">

    <?php echo JHtml::_('bootstrap.startTabSet', 'detailsTab', array('active' => 'details')); ?>

    <?php echo JHtml::_('bootstrap.addTab', 'detailsTab', 'details', JText::_('COM_GAMIFICATION_DETAILS')); ?>
    <div class="row-fluid">
        <div class="span8">
            <?php echo $this->form->renderField('title'); ?>
            <?php echo $this->form->renderField('context'); ?>
            <?php echo $this->form->renderField('group_id'); ?>
            <?php echo $this->form->renderField('image'); ?>
            <?php echo $this->form->renderField('published'); ?>
            <?php echo $this->form->renderField('description'); ?>

            <div class="control-group">
                <div class="control-label">
                    <?php echo $this->form->getLabel('activity_text'); ?>
                    <a class="btn btn-mini hasTooltip" href="javascript: void(0);" title="<?php echo JHtml::tooltipText('COM_GAMIFICATION_PLACEHOLDERS', 'COM_GAMIFICATION_PLACEHOLDERS_DESCRIPTION'); ?>">
                        <i class="icon-info"></i>
                    </a>
                </div>
                <div class="controls">
                    <?php echo $this->form->getInput('activity_text'); ?>
                </div>
            </div>

            <?php echo $this->form->renderField('note'); ?>
            <?php echo $this->form->renderField('id'); ?>

            <input type="hidden" name="task" value=""/>
            <?php echo JHtml::_('form.token'); ?>
        </div>

        <?php if ($this->item->image) { ?>
        <div class="span4">
            <img src="<?php echo '../' . $this->mediaFolder . '/' . $this->item->image; ?>" class="img-polaroid"/>
            <br/><br/>
            <a class="btn btn-danger" href="<?php echo JRoute::_('index.php?option=com_gamification&task=achievement.removeimage&id=' . (int)$this->item->id . '&' . JSession::getFormToken() . '=1'); ?>" id="gfy-remove-image">
                <i class="icon-trash"></i>
                <?php echo JText::_('COM_GAMIFICATION_REMOVE_IMAGE'); ?>
            </a>
        </div>
        <?php } ?>
    </div>
    <?php echo JHtml::_('bootstrap.endTab'); ?>

    <?php echo JHtml::_('bootstrap.addTab', 'detailsTab', 'params', JText::_('COM_GAMIFICATION_OPTIONS')); ?>

    <?php echo $this->form->renderField('custom_data', 'params'); ?>
    <?php echo $this->form->renderField('link', 'params'); ?>

    <?php echo JHtml::_('bootstrap.endTab'); ?>

    <?php echo JHtml::_('bootstrap.endTabSet'); ?>
</form>