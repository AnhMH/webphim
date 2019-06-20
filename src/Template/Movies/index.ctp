<h1>Movies</h1>
<p><?= $this->Html->link("Add Movie", ['action' => 'add']) ?></p>
<table class="table table-striped table-bordered dataTable" style="width:100%">
    <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Country</th>
            <th>Last Episode</th>
            <th>Episode</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $v): ?>
            <tr>
                <td>
                    <image src="<?= $v->image; ?>" width="150"/>
                </td>
                <td>
                    <?= $this->Html->link($v->name, ['action' => 'edit', $v->id]) ?>
                </td>
                <td><?php echo $countries[$v['country_id']];?></td>
                <td>
                    <?php echo $v['last_episode'];?>
                </td>
                <td>
                    <a href="<?php echo $BASE_URL; ?>/episodes/add/<?php echo $v->id; ?>">Add episode</a>
                    <a href="<?php echo $BASE_URL; ?>/episodes?movie_id=<?php echo $v->id; ?>">Manage episodes</a>
                </td>
                <td>
                    <?= $this->Html->link('Edit', ['action' => 'edit', $v->id]) ?>
                    <?=
                    $this->Form->postLink(
                            'Delete', ['action' => 'delete', $v->id], ['confirm' => 'Are you sure?'])
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>