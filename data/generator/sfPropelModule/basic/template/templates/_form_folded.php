[?php use_stylesheets_for_form($form) ?]
[?php use_javascripts_for_form($form) ?]

<div class="sf_admin_form">
  [?php echo form_tag_for($form, '@<?php echo $this->params['route_prefix'] ?>') ?]
    [?php if (method_exists($form, 'getFieldsets')): ?]
      [?php echo $form->renderHiddenFields() ?]
      [?php foreach ($form->getFieldsets() as $fieldset => $field_names): ?]
        <fieldset id="sf_fieldset_[?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?]"[?php echo ($form->getWidgetSchema()->getFormFormatterName() == 'table') ? " style=\"background: none; border: none;\"":""?]>
          [?php if ('NONE' != $fieldset): ?]
          <h2>[?php echo link_to_function(__($fieldset, array(), '<?php echo $this->getI18nCatalogue() ?>'), "var div = document.getElementById('fold_$fieldset'); if (div.style.display == 'none') { div.style.display = 'block' } else { div.style.display = 'none' }") ?]</h2>
          [?php endif; ?]
          <div id="fold_[?php echo $fieldset ?]"[?php echo 'NONE' != $fieldset ? ' style="display: none;"' : '' ?]>
            [?php if ($form->getWidgetSchema()->getFormFormatterName() == 'table'): ?]
              <table>
                <tbody>
                  [?php foreach ($field_names as $name): ?]
                    [?php echo $form[$name]->renderRow() ?]
                  [?php endforeach ?]
                </tbody>
              </table>
            [?php else: ?]
              [?php foreach ($field_names as $name): ?]
                [?php echo $form[$name]->renderRow() ?]
              [?php endforeach ?]
            [?php endif ?]
          </div>
        </fieldset>
      [?php endforeach ?]
    [?php else: ?]
      [?php if ($form->getWidgetSchema()->getFormFormatterName() == 'table'): ?]
        <table>
          <tbody>
            [?php echo $form ?]
          </tbody>
        </table>
      [?php else: ?]
        <fieldset id="sf_fieldset_none">
          [?php echo $form ?]
        </fieldset>
      [?php endif ?]
    [?php endif ?]

    [?php include_partial('<?php echo $this->getModuleName() ?>/form_actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
  </form>
</div>
