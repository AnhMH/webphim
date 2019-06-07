<h1>Add Admin</h1>
<?php
    echo $this->Form->create($admin);
    // Hard code the user for now.
//    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
    echo $this->Form->control('account');
    echo $this->Form->control('password');
    echo $this->Form->control('name');
    echo $this->Form->button(__('Save'));
    echo $this->Form->end();
?>
