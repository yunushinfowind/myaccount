<?php
$id = $this->params['pass'][0];
?>

<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-edit"></i>
                        Email Duration                                              <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">


                        <div class="clearfix"></div>
                        <div class="form">
                            <?php echo $this->Session->flash(); ?>  
                            <?php echo $this->Form->create('Email_duration', array('url' => array('controller' => 'student', 'action' => 'email_duration', 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal')); ?>   

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">2nd to Last Email</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('second', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Second', 'required' => FALSE, 'value' => $find['Email_duration']['second'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Last Email</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('last', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Last', 'required' => FALSE, 'value' => $find['Email_duration']['last'])); ?>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-success"><?php echo __('Email Duration'); ?></button>
                                </div>
                            </div>
                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>