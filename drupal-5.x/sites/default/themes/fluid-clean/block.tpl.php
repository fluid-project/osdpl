<?php // $Id: block.tpl.php,v 1.1.2.2 2008/09/12 21:50:37 psynaptic Exp $ ?>
<div id="block-<?php print $block->module .'-'. $block->delta; ?>" class="block block-<?php print $block->module ?>">

<?php if ($block->subject): ?>
  <h2><?php print $block->subject ?></h2>
<?php endif;?>

  <div class="content"><?php print $block->content ?></div>
</div>
