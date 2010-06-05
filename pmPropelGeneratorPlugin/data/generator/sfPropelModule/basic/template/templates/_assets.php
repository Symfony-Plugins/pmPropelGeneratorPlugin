<?php if (isset($this->params['css']) && ($this->params['css'] !== false)): ?>
[?php use_stylesheet('<?php echo $this->params['css'] ?>', 'first') ?]
<?php elseif(!isset($this->params['css'])): ?>
[?php use_stylesheet('<?php echo '/pmPropelGeneratorPlugin/css/global.css' ?>', 'first') ?]
[?php use_stylesheet('<?php echo '/pmPropelGeneratorPlugin/css/default.css' ?>', 'first') ?]
<?php endif ?>
