<?php // $Id: node.tpl.php,v 1.1.2.2 2008/09/12 21:50:37 psynaptic Exp $ ?>
<div id="node-<?php print $node->nid ?>" class="node">

<?php 
if (!$page) { 
    // if the node is one of the blocks being displayed on the front page.
    // remove the link that appears in the title.
    if ($node->nid == '72') { ?>
        <h2 class="teaser-title"><?php print $title ?></h2>
    <?php }
    else if ($node->nid == '73') { 
        // For the welcome message node, don't print the title at all
	// because the front page already has an appropriate title.
    } else { ?>
  <h2 class="teaser-title"><a href="<?php print $node_url ?>" title="<?php print $title ?>">
    <?php print $title ?></a></h2>
<?php }
}  ?>

<?php if ($submitted || $terms): ?>
  <div class="meta">
    <?php if ($submitted): ?>
      <div class="submitted"><?php print $submitted ?></div>
    <?php endif; ?>
    <?php if ($terms): ?>
<?php //      <div class="terms"> ?><?php
//      print $terms;
      ?><?php //</div>?>
    <?php endif;?>
  </div>
<?php endif; ?>

  <div class="content clear-block">
    <?php print $picture ?>
    <?php print $content ?>
  </div>

<?php if ($links): ?>
  <div class="node-links"><?php print $links ?></div>
<?php endif; ?>

</div>
