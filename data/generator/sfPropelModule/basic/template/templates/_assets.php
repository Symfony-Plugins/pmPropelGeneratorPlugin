<?php if (isset($this->params['css']) && ($this->params['css'] !== false)): ?>
[?php use_stylesheet('<?php echo $this->params['css'] ?>', 'first') ?]
<?php elseif(!isset($this->params['css'])): ?>
[?php use_stylesheet('/pmPropelGeneratorPlugin/css/global.css', 'first') ?]
[?php use_stylesheet('/pmPropelGeneratorPlugin/css/default.css', 'first') ?]
[?php use_stylesheet('/pmPropelGeneratorPlugin/css/exportation.css', 'first') ?]
<?php endif; ?>
[?php use_javascript('/pmPropelGeneratorPlugin/js/exportation.js', 'last') ?]
