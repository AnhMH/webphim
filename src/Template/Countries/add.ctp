<h1>Add Country</h1>
<?php
    echo $this->Form->create($data);
    // Hard code the user for now.
//    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
    echo $this->Form->control('name');
    echo $this->Form->button(__('Save'));
    echo $this->Form->end();
?>
