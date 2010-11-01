  public function getDefaultSort()
  {
<?php if ($sort = (isset($this->config['list']['sort']) ? $this->config['list']['sort'] : false)): ?>
<?php if (!is_array($sort)) $sort = array($sort, 'asc'); ?>
    return array('<?php echo $sort[0] ?>', '<?php echo isset($sort[1]) ? $sort[1] : 'asc' ?>');
<?php else: ?>
    return array(null, null);
<?php endif; ?>
  }

  public function getIsMultipleSort()
  {
<?php if (isset($this->config['list']['multiple_sort'])): ?>
    return <?php echo strval($this->config['list']['multiple_sort']) ?>;
<?php unset($this->config['list']['multiple_sort']) ?>
<?php else: ?>
    return false;
<?php endif ?>
  }

  public function isValidSortColumn($field, $modelClass)
  {
    if (array_key_exists($field, $list_fields = array_merge($this->getFieldsList(), $this->getFieldsDefault())))
    {
      if (array_key_exists('peer_column', $list_fields[$field]))
      {
        return true;
      }
    }
    return in_array($field, BasePeer::getFieldnames($modelClass, BasePeer::TYPE_FIELDNAME));
  }

  public function getSortColumnNameForField($field, $modelClass)
  {
    if (array_key_exists($field, $list_fields = array_merge($this->getFieldsList(), $this->getFieldsDefault())))
    {
      if (array_key_exists('peer_column', $list_fields[$field]))
      {
        return constant($list_fields[$field]['peer_column']);
      }
    }
    // camelize lower case to be able to compare with BasePeer::TYPE_PHPNAME translate field name
    $peer = constant($modelClass.'::PEER');
    
    return call_user_func(array($peer,'translateFieldName'), sfInflector::camelize(strtolower($field)), BasePeer::TYPE_PHPNAME, BasePeer::TYPE_COLNAME);
  }

  public function getDefaultMultipleSort()
  {
<?php if ($sort = (isset($this->config['list']['sort']) ? $this->config['list']['sort'] : false)): ?>
<?php if (!is_array($sort)) $sort = array($sort, 'asc'); ?>
    return array('<?php echo $sort[0] ?>' => array('<?php echo $sort[0] ?>', '<?php echo isset($sort[1]) ? $sort[1] : 'asc' ?>'));
<?php else: ?>
    return array();
<?php endif; ?>
<?php unset($this->config['list']['sort']) ?>
  }