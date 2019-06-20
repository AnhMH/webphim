<h1>Edit Movie</h1>
<a href="<?php echo $BASE_URL; ?>/episodes/add/<?php echo $data['id']; ?>">Add episode</a>
<a href="<?php echo $BASE_URL; ?>/episodes?movie_id=<?php echo $data['id']; ?>">Manage episodes</a>
<?php
    echo $this->Form->create($data, ['type' => 'file', 'class' => 'custom-form']);
    echo $this->Form->control('name');
?>
<div class="form-group">
    <label>Country</label>
    <select name="country_id" class="form-control">
        <?php foreach($_countries as $c): ?>
        <option value="<?php echo $c['id'];?>" <?php echo $data['country_id'] == $c['id'] ? "selected" : "";?>><?php echo $c['name'];?></option>
        <?php endforeach; ?>
    </select>
</div>
<?php if (!empty($data['image'])): ?>
<div class="form-group input">
    <label>Old image</label>
    <img src="<?php echo $data['image'];?>" width="200px"/>
</div>
<?php endif;?>
<?php
    echo $this->Form->control('image2', ['type' => 'file', 'label' => 'New image']);
    echo $this->Form->control('description', ['type' => 'textarea', 'cols' => 100, 'rows' => '7']);
    echo $this->Form->control('trailer');
    echo $this->Form->control('runtime');
    echo $this->Form->control('tags', ['type' => 'textarea', 'cols' => 100, 'rows' => '4']);
?>

<div class="form-group">
    <label>Type</label>
    <select name="type_id" class="form-control">
        <?php foreach($_movieTypes as $k => $v): ?>
        <option value="<?php echo $k;?>"><?php echo $v;?></option>
        <?php endforeach; ?>
    </select>
</div>
<?php
    echo $this->Form->control('last_episode');
    echo $this->Form->button(__('Save'));
    echo $this->Form->end();
?>
