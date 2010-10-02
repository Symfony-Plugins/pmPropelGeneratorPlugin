<?php foreach ($this->configuration->getValue('list.display') as $name => $field): ?>
[?php slot('sf_admin.current_header') ?]
<th class="sf_admin_<?php echo strtolower($field->getType()) ?> sf_admin_list_th_<?php echo $name ?>">
<?php if ($field->isReal()): ?>

  [?php if ($configuration->getIsMultipleSort()): ?]
    [?php if (isset($sort['<?php echo $name?>']) ): ?]
      [?php echo link_to(__('<?php echo $field->getConfig('label', '', true) ?>', array(), '<?php echo $this->getI18nCatalogue() ?>'), '@<?php echo $this->getUrlForAction('list') ?>', array('query_string' => 'sort=<?php echo $name ?>&sort_type='.($sort['<?php echo $name?>'][1] == 'asc' ? 'desc' : 'asc'))) ?]
      [?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort['<?php echo $name?>'][1].'.png', array('alt' => __($sort['<?php echo $name?>'][1], array(), 'sf_admin'), 'title' => __($sort['<?php echo $name?>'][1], array(), 'sf_admin'))) ?]
      [?php $clean_icon = image_tag('/pmPropelGeneratorPlugin/images/delete.png', array('alt' => __('Clean', array(), 'sf_admin'), 'title' => __('Clean sort criteria', array(), 'sf_admin'))) ?]
      [?php echo link_to($clean_icon, '@<?php echo $this->getUrlForAction('list') ?>', array('query_string' => 'sort=<?php echo $name ?>&sort_type=clean')) ?]

    [?php else: ?]
      [?php echo link_to(__('<?php echo $field->getConfig('label', '', true) ?>', array(), '<?php echo $this->getI18nCatalogue() ?>'), '@<?php echo $this->getUrlForAction('list') ?>', array('query_string' => 'sort=<?php echo $name ?>&sort_type=asc')) ?]
    [?php endif ?]
  [?php else: ?]
    [?php if ('<?php echo $name ?>' == $sort[0]): ?]
      [?php echo link_to(__('<?php echo $field->getConfig('label', '', true) ?>', array(), '<?php echo $this->getI18nCatalogue() ?>'), '@<?php echo $this->getUrlForAction('list') ?>', array('query_string' => 'sort=<?php echo $name ?>&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?]
      [?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?]
    [?php else: ?]
      [?php echo link_to(__('<?php echo $field->getConfig('label', '', true) ?>', array(), '<?php echo $this->getI18nCatalogue() ?>'), '@<?php echo $this->getUrlForAction('list') ?>', array('query_string' => 'sort=<?php echo $name ?>&sort_type=asc')) ?]
    [?php endif ?]
  [?php endif ?]
<?php else: ?>
  [?php echo __('<?php echo $field->getConfig('label', '', true) ?>', array(), '<?php echo $this->getI18nCatalogue() ?>') ?]
<?php endif ?>
</th>
[?php end_slot() ?]
<?php echo $this->addCredentialCondition("[?php include_slot('sf_admin.current_header') ?]", $field->getConfig()) ?>
<?php endforeach ?>