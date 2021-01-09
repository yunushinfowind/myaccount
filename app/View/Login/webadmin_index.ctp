<div class="container">
    <?php echo $this->Form->create('Admin', array('url' => array('controller' => 'login', 'action' => 'index', 'prefix' => 'webadmin'), 'class' => 'form-signin')); ?>
    <h2 class="form-signin-heading">sign in now</h2>
    <div class="login-wrap">
        <?php echo $this->Session->flash(); ?>
        <div class="user-login-info">
            <?php echo $this->Form->input('username', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Username', 'autofocus' => true, 'required' => false,)); ?> <br/>
            <?php echo $this->Form->input('password', array('type' => 'password', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Password', 'required' => false)); ?>
        </div>
        <button class="btn btn-lg btn-login btn-block" type="submit">Log in</button>
    </div>
    <?php echo $this->Form->end(); ?>
</div>