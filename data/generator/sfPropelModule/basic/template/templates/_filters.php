[?php use_stylesheets_for_form($form) ?]
[?php use_javascripts_for_form($form) ?]

<div class="sf_admin_filter">
  <form action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter')) ?]" method="post">
    [?php echo link_to_function("<h2>".__('Apply filters to list', array(), 'sf_admin')."</h2>", "var div = document.getElementById('sf_admin_filter_hideable'); if (div.style.display == 'none') { div.style.display = 'block' } else { div.style.display = 'none' }")  ?]
    <div id="sf_admin_filter_hideable" [?php !count($sf_user->getAttribute('<?php echo $this->getModuleName() ?>.filters',array(),'admin_module')) and print 'style="display: none;"' ?]>
        [?php echo $form->renderHiddenFields() ?]
        [?php echo strtr($form->getWidgetSchema()->getFormFormatter()->getDecoratorFormat(), array("%content%" => (string) $form)) ?]
        <div class="sf_admin_form_row" style="text-align: right;">
          [?php echo link_to(__('Reset', array(), 'sf_admin'), '<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post')) ?]
          <input type="submit" value="[?php echo __('Filter', array(), 'sf_admin') ?]" />
        </div>
    </div>
  </form>
</div>
