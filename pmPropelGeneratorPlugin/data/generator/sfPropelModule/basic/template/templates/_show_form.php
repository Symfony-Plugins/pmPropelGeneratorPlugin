[?php use_stylesheets_for_form($form) ?]
[?php use_javascripts_for_form($form) ?]

<div class="sf_admin_form">
  [?php echo form_tag_for($form, '@<?php echo $this->params['route_prefix'] ?>') ?]
    [?php if (method_exists($form, 'getFieldsets')): ?]
      [?php foreach ($form->getFieldsets() as $fieldset => $field_names): ?]
        <fieldset id="sf_fieldset_[?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?]">
          [?php if ('NONE' != $fieldset): ?]
          <h2>[?php echo __($fieldset, array(), '<?php echo $this->getI18nCatalogue() ?>') ?]</h2>
          [?php endif; ?]
          <table>
            <tbody>
              [?php foreach ($field_names as $name): ?]
                [?php if (!$form[$name]->isHidden()): ?]
                  <tr>
                    <th>
                      [?php echo $form[$name]->renderLabel() ?]
                    </th>
                    <td>
                      [?php echo $form[$name]->getValue() ?]
                      [?php echo $form[$name]->renderHelp() ?]
                    </td>
                  </tr>
                [?php endif ?]
              [?php endforeach ?]
            </tbody>
          </table>
        </fieldset>
      [?php endforeach ?]
    [?php else: ?]
      <fieldset id="sf_fieldset_none">
        <table>
          <tbody>
            [?php foreach ($form->getFormFieldSchema() as $name => $field): ?]
              [?php if (!$form[$name]->isHidden()): ?]
                <tr>
                  <th>
                    [?php echo $form[$name]->renderLabel() ?]
                  </th>
                  <td>
                    [?php echo $form[$name]->getValue() ?]
                    [?php echo $form[$name]->renderHelp() ?]
                  </td>
                </tr>
              [?php endif ?]
            [?php endforeach ?]
          </tbody>
        </table>
      </fieldset>
    [?php endif ?]

    [?php include_partial('<?php echo $this->getModuleName() ?>/show_form_actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
  </form>
</div>
