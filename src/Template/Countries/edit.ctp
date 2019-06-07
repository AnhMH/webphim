<h1>Edit Country</h1>
<?php
    echo $this->Form->create($data);
    echo $this->Form->control('name');
    echo $this->Form->button(__('Save'));
    echo $this->Form->end();
?>
