[?php use_stylesheets_for_form($form) ?]
[?php use_javascripts_for_form($form) ?]

<div class="sf_admin_form">
  [?php echo form_tag_for($form, '@<?php echo $this->params['route_prefix'] ?>') ?]
    [?php $display = $configuration->getShowDisplay() ?]
    
    [?php $first = true ?]
    [?php foreach ($display as $fieldset => $field_names): ?]
      <span id="tab_[?php echo $fieldset ?]_link" class="tab_link_[?php echo ($first ? 'selected' : 'not_selected' ); $first = false; ?]">
        [?php echo link_to_function(__($fieldset, array(), '<?php echo $this->getI18nCatalogue() ?>'), "selectTab('$fieldset')") ?]
        </span>
    [?php endforeach ?]
    
    [?php $first = true ?]
    [?php foreach ($display as $fieldset => $field_names): ?]
      <fieldset id="sf_fieldset_[?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?]">
        <div id="tab_[?php echo $fieldset ?]" class="[?php echo ($first ? 'selected' : 'not-selected'); $first = false; ?]">
          [?php $decorator_format = explode("%content%", $form->getWidgetSchema()->getFormFormatter()->getDecoratorFormat()) ?]
        
          [?php echo $decorator_format[0] ?]
        
          [?php foreach ($field_names as $field): ?]
            [?php include_partial('<?php echo $this->getModuleName() ?>/show_form_field', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper, 'field' => $field)) ?]
          [?php endforeach ?]
        
          [?php echo $decorator_format[1] ?]
        </div>
      </fieldset>
    [?php endforeach ?]

    [?php include_partial('<?php echo $this->getModuleName() ?>/show_form_actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
  </form>
</div>
