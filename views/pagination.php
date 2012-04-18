<?php if (is_array($view->paginator)) { ?>
<ul class="pagination">
<li>Страницы: </li>
<?php foreach ($view->paginator as $ankor => $item) { ?>
<li><a <?php echo ($item['current']) ? 'class="current" ' : ''; ?>href="<?php echo $view->url.$item['page']; ?>"><?php echo Paginator::translate($ankor, array(
	'first' => '&lt;&lt;',
	'prev' => '&lt;',
	'next' => '&gt;',
	'last' => '&gt;&gt;',
)); ?></a></li>
<?php } ?>
</ul>
<?php } ?>