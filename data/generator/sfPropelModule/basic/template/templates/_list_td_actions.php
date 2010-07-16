<td>
  <ul class="sf_admin_td_actions">
<?php foreach ($this->configuration->getValue('list.object_actions') as $name => $params): ?>
<?php if ('_delete' == $name): ?>
    <?php echo $this->addCredentialCondition('[?php echo $helper->linkToDelete($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>

<?php elseif ('_edit' == $name): ?>
    <?php echo $this->addCredentialCondition('[?php echo $helper->linkToEdit($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>

<?php elseif ('_show' == $name): ?>
    <?php echo $this->addCredentialCondition('[?php echo $helper->linkToShow($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>

<?php else: ?>
    <?php if (isset($params['show_when'])): ?>
      <?php $show_when = $params['show_when'] ?>
    <?php endif ?>

    <?php if (isset($show_when)): ?>
      [?php if (call_user_func(array($<?php echo $this->getSingularName() ?>, '<?php echo $show_when ?>'))): ?]
        [?php if (method_exists($<?php echo $this->getSingularName() ?>->getRawValue(), 'can<?php echo sfInflector::camelize($params['action']) ?>')): ?]
          [?php if ($<?php echo $this->getSingularName() ?>->can<?php echo sfInflector::camelize($params['action']) ?>()): ?]
            <li class="sf_admin_action_<?php echo $params['class_suffix'] ?>">
              <?php echo $this->addCredentialCondition($this->getLinkToAction($name, $params, true), $params) ?>
            </li>
          [?php else: ?]
            <li class="sf_admin_action_<?php echo $params['class_suffix'] ?> disabled">
              [?php echo __('<?php echo $params['label'] ?>', array(), 'messages') ?]
            </li>
          [?php endif ?]
        [?php else: ?]
          <li class="sf_admin_action_<?php echo $params['class_suffix'] ?>">
            <?php echo $this->addCredentialCondition($this->getLinkToAction($name, $params, true), $params) ?>
          </li>
        [?php endif ?]
      [?php endif ?]
      <?php unset($show_when) ?>
    <?php else: ?>
      [?php if (method_exists($<?php echo $this->getSingularName() ?>->getRawValue(), 'can<?php echo sfInflector::camelize($params['action']) ?>')): ?]
        [?php if ($<?php echo $this->getSingularName() ?>->can<?php echo sfInflector::camelize($params['action']) ?>()): ?]
          <li class="sf_admin_action_<?php echo $params['class_suffix'] ?>">
            <?php echo $this->addCredentialCondition($this->getLinkToAction($name, $params, true), $params) ?>
          </li>
        [?php else: ?]
          <li class="sf_admin_action_<?php echo $params['class_suffix'] ?> disabled">
            [?php echo __('<?php echo $params['label'] ?>', array(), 'messages') ?]
          </li>
        [?php endif ?]
      [?php else: ?]
        <li class="sf_admin_action_<?php echo $params['class_suffix'] ?>">
          <?php echo $this->addCredentialCondition($this->getLinkToAction($name, $params, true), $params) ?>
        </li>
      [?php endif ?]
    <?php endif ?>
<?php endif ?>
<?php endforeach ?>
  </ul>
</td>
