<h1>Add Movie</h1>
<?php
    echo $this->Form->create($data, ['type' => 'file']);
    echo $this->Form->control('name');
?>
<div class="form-group">
    <label>Country</label>
    <select name="country_id" class="form-control">
        <?php foreach($_countries as $c): ?>
        <option value="<?php echo $c['id'];?>"><?php echo $c['name'];?></option>
        <?php endforeach; ?>
    </select>
</div>

<?php
    echo $this->Form->control('image', ['type' => 'file']);
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
    echo $this->Form->control('pro_year');
    echo $this->Form->button(__('Save'));
    echo $this->Form->end();
?>
