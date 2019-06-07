<h1>Admins</h1>
<p><?= $this->Html->link("Add Admin", ['action' => 'add']) ?></p>
<table>
    <tr>
        <th>Name</th>
        <th>Account</th>
        <th>Action</th>
    </tr>

<!-- Here's where we iterate through our $admins query object, printing out admin info -->

<?php foreach ($admins as $admin): ?>
    <tr>
        <td>
            <?= $this->Html->link($admin->name, ['action' => 'view', $admin->id]) ?>
        </td>
        <td>
            <?= $admin->account ?>
        </td>
        <td>
            <?= $this->Html->link('Edit', ['action' => 'edit', $admin->id]) ?>
            <?= $this->Form->postLink(
                'Delete',
                ['action' => 'delete', $admin->id],
                ['confirm' => 'Are you sure?'])
            ?>
        </td>
    </tr>
<?php endforeach; ?>

</table>