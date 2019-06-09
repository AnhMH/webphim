<h1>Add Episode</h1>
<?php
    echo $this->Form->create($data, ['type' => 'file']);
    echo $this->Form->control('name');
    echo $this->Form->control('servers', ['type' => 'textarea', 'cols' => 100, 'rows' => '7']);
    echo $this->Form->button(__('Save'));
    echo $this->Form->end();
?>
