<h1>Edit Admin</h1>
<?php
    echo $this->Form->create($admin);
    echo $this->Form->control('account');
    echo $this->Form->control('password');
    echo $this->Form->control('name');
    echo $this->Form->button(__('Save Article'));
    echo $this->Form->end();
?>
