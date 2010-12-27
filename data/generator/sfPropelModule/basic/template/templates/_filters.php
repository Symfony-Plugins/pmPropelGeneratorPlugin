[?php use_stylesheets_for_form($form) ?]
[?php use_javascripts_for_form($form) ?]

<div class="sf_admin_filter">
  <form action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter')) ?]" method="post">
    <h2>[?php echo link_to_function(__('Apply filters to list', array(), '<?php echo $this->getI18nCatalogue() ?>'), "var div = document.getElementById('sf_admin_filter_hideable'); if (div.style.display == 'none') { div.style.display = 'block' } else { div.style.display = 'none' }")  ?]</h2>
    <div id="sf_admin_filter_hideable" style="display: none;">
        [?php echo strtr($form->getWidgetSchema()->getFormFormatter()->getDecoratorFormat(), array("%content%" => (string) $form)) ?]
        <div class="sf_admin_form_row" style="text-align: right;">
          [?php echo link_to(__('Reset', array(), 'sf_admin'), '<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post')) ?]
          <input type="submit" value="[?php echo __('Filter', array(), 'sf_admin') ?]" />
        </div>
    </div>
  </form>
</div>
