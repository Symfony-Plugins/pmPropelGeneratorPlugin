[?php use_stylesheets_for_form($form) ?]
[?php use_javascripts_for_form($form) ?]

<div class="sf_admin_form">
  [?php echo form_tag_for($form, '@<?php echo $this->params['route_prefix'] ?>') ?]
    [?php if (method_exists($form, 'getFieldsets')): ?]
      [?php $first = true ?]
      [?php foreach ($form->getFieldsets() as $fieldset => $field_names): ?]
        <span id="tab_[?php echo $fieldset ?]_link" class="tab_link_[?php echo ($first ? 'selected' : 'not_selected' ); $first = false; ?]">
          [?php echo link_to_function(__($fieldset, array(), '<?php echo $this->getI18nCatalogue() ?>'), "var div = document.getElementById('tab_$fieldset'); var span = document.getElementById('tab_".$fieldset."_link'); divs = document.getElementsByTagName('div'); for (d in divs) { if (divs[d].className == 'selected') { divs[d].className = 'not-selected'; }}; div.className = 'selected'; spans = document.getElementsByTagName('span'); for (s in spans) { if (spans[s].className == 'tab_link_selected') { spans[s].className = 'tab_link_not_selected'; }}; span.className = 'tab_link_selected';") ?]
        </span>
      [?php endforeach ?]
      [?php $first = true ?]
      [?php foreach ($form->getFieldsets() as $fieldset => $field_names): ?]
        <fieldset id="sf_fieldset_[?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?]" style="background-color: #eee; border-width: 0;">
          <div id="tab_[?php echo $fieldset ?]" class="[?php echo ($first ? 'selected' : 'not-selected'); $first = false; ?]">
            [?php if ($form->getWidgetSchema()->getFormFormatterName() == 'table'): ?]
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
            [?php else: ?]
              [?php foreach ($field_names as $name): ?]
                [?php if (!$form[$name]->isHidden()): ?]
                  [?php echo $form->getWidgetSchema()->getFormFormatter()->formatRow($form[$name]->renderLabel(), $form[$name]->getValue(), array(), $form->getWidgetSchema()->getHelp($name), '') ?]
                [?php endif ?]
              [?php endforeach ?]
            [?php endif ?]
          </div>
        </fieldset>
      [?php endforeach ?]
    [?php else: ?]
        [?php if ($form->getWidgetSchema()->getFormFormatterName() == 'table'): ?]
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
        [?php else: ?]
          <fieldset id="sf_fieldset_none">
            [?php foreach ($form->getFormFieldSchema() as $name => $field): ?]
              [?php if (!$form[$name]->isHidden()): ?]
                [?php echo $form->getWidgetSchema()->getFormFormatter()->formatRow($form[$name]->renderLabel(), $form[$name]->getValue(), array(), $form->getWidgetSchema()->getHelp($name), '') ?]
              [?php endif ?]
            [?php endforeach ?]
          </fieldset>
        [?php endif ?]
    [?php endif ?]

    [?php include_partial('<?php echo $this->getModuleName() ?>/show_form_actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
  </form>
</div>
