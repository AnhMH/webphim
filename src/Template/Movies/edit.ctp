<h1>Edit Movie</h1>
<?php
    echo $this->Form->create($data, ['type' => 'file']);
    echo $this->Form->control('name');
    echo $this->Form->control('image2', ['type' => 'file']);
    echo $this->Form->button(__('Save'));
    echo $this->Form->end();
?>
