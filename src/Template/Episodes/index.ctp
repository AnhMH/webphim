<h1>Episodes</h1>
<a href="<?php echo $BASE_URL; ?>/episodes/add/<?php echo $movieId;?>">Add episode</a>
<table class="table table-striped table-bordered dataTable" style="width:100%">
    <thead>
        <tr>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
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
</tbody>
</table>