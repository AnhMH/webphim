<h1>Movies</h1>
<p><?= $this->Html->link("Add Movie", ['action' => 'add']) ?></p>
<table class="table-bordered">
    <tr>
        <th>Name</th>
        <th colspan="2">Action</th>
    </tr>

<!-- Here's where we iterate through our $admins query object, printing out admin info -->

<?php foreach ($data as $v): ?>
    <tr>
        <td>
            <?= $this->Html->link($v->name, ['action' => 'edit', $v->id]) ?>
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