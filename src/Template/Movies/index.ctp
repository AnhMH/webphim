<h1>Movies</h1>
<p><?= $this->Html->link("Add Movie", ['action' => 'add']) ?></p>
<table>
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Action</th>
    </tr>

<!-- Here's where we iterate through our $admins query object, printing out admin info -->

<?php foreach ($data as $v): ?>
    <tr>
        <td>
            <image src="<?= $v->image ;?>" width="150"/>
        </td>
        <td>
            <?= $this->Html->link($v->name, ['action' => 'view', $v->id]) ?>
        </td>
        <td>
            <?= $this->Html->link('Edit', ['action' => 'edit', $v->id]) ?>
            <?= $this->Form->postLink(
                'Delete',
                ['action' => 'delete', $v->id],
                ['confirm' => 'Are you sure?'])
            ?>
        </td>
    </tr>
<?php endforeach; ?>

</table>