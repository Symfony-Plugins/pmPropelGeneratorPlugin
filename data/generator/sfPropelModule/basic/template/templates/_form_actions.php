<ul class="sf_admin_actions">
<?php foreach (array('new', 'edit') as $action): ?>
<?php if ('new' == $action): ?>
[?php if ($form->isNew()): ?]
<?php else: ?>
[?php else: ?]
<?php endif ?>
<?php foreach ($this->configuration->getValue($action.'.actions') as $name => $params): ?>
  <?php $show_when = isset($params['show_when'])?$params['show_when']:false; ?>
<?php if ('_delete' == $name): ?>
  <?php echo $this->addCredentialCondition('[?php echo $helper->linkToDelete($form->getObject(), '.$this->asPhp($params).') ?]', $params) ?>

<?php elseif ('_list' == $name): ?>
  <?php echo $this->addCredentialCondition('[?php echo $helper->linkToList('.$this->asPhp($params).') ?]', $params) ?>

<?php elseif ('_save' == $name): ?>
  <?php echo $this->addCredentialCondition('[?php echo $helper->linkToSave($form->getObject(), '.$this->asPhp($params).') ?]', $params) ?>

<?php elseif ('_save_and_list' == $name): ?>
  <?php echo $this->addCredentialCondition('[?php echo $helper->linkToSaveAndList($form->getObject(), '.$this->asPhp($params).') ?]', $params) ?>

<?php elseif ('_save_and_add' == $name): ?>
  <?php echo $this->addCredentialCondition('[?php echo $helper->linkToSaveAndAdd($form->getObject(), '.$this->asPhp($params).') ?]', $params) ?>

<?php else: ?>
  <?php if($show_when): ?>
  [?php if (method_exists($form->getObject(), '<?php echo $show_when?>') && $form->getObject()-><?php echo $show_when?>($sf_user)): ?]
  <?php endif; ?>
      <li class="sf_admin_action_<?php echo $params['class_suffix'] ?>">
    [?php if (method_exists($helper, 'linkTo<?php echo $method = ucfirst(sfInflector::camelize($name)) ?>')): ?]
      <?php echo $this->addCredentialCondition('[?php echo $helper->linkTo'.$method.'($form->getObject(), '.$this->asPhp($params).') ?]', $params) ?>

    [?php else: ?]
      <?php echo $this->addCredentialCondition($this->getLinkToAction($name, $params, true), $params) ?>

    [?php endif ?]
      </li>
  <?php if($show_when): ?>
  [?php endif ?]
  <?php endif; ?>
<?php endif ?>
<?php endforeach ?>
<?php endforeach ?>
[?php endif ?]
</ul>
