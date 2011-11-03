<tr>
  <th colspan="<?php echo count($this->configuration->getValue('list.display')) + ($this->configuration->getValue('list.object_actions') ? 1 : 0) + ($this->configuration->getValue('list.batch_actions') ? 1 : 0) ?>">
    [?php if ($pager->haveToPaginate()): ?]
      [?php include_partial('<?php echo $this->getModuleName() ?>/pagination', array('pager' => $pager)) ?]
    [?php endif ?]

    [?php echo format_number_choice('[0] no result|[1] 1 result|(1,+Inf] %1% results', array('%1%' => $pager->getNbResults()), $pager->getNbResults(), 'sf_admin') ?]
    
    <div class="sf_admin_pagination">
    [?php if ($configuration->getPagerMaxPerPageArray()): ?]
      [?php echo __("Items per page", array(), 'sf_admin') ?]
      <select onchange="window.location='[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $pager->getPage() ?]&max_per_page='+$(this).val()" name="per_page" id="per_page">
      [?php foreach ($configuration->getPagerMaxPerPageArray() as $per_page): ?]
        [?php if ($pager->getMaxPerPage() == $per_page): ?]
        <option value="[?php echo $per_page ?]" selected="selected">[?php echo $per_page ?]</option>
        [?php else: ?]
        <option value="[?php echo $per_page ?]">[?php echo $per_page ?]</option>
        [?php endif ?]
      [?php endforeach ?]
      </select>
    [?php endif ?]
    </div>
    
    [?php if ($pager->haveToPaginate()): ?]
      [?php echo __('(page %%page%%/%%nb_pages%%)', array('%%page%%' => $pager->getPage(), '%%nb_pages%%' => $pager->getLastPage()), 'sf_admin') ?]
    [?php endif ?]
  </th>
</tr>
