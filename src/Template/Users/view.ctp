<h1><?= h($admin->name) ?></h1>
<p><?= h($admin->account) ?></p>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $admin->id]) ?></p>
