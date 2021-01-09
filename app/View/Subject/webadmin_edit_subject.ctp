<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Edit Subject
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="form">
                            <?php echo $this->Session->flash(); ?>  
                            <?php echo $this->Form->create('Subject', array('url' => array('controller' => 'subject', 'action' => 'edit_subject', $this->params['pass'][0], 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'enctype' => 'multipart/form-data')); ?>   

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Subject</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('subject', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Subject', 'required' => FALSE, 'value' => $subject['Subject']['subject'])); ?>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-primary"><?php echo __('Edit Subject'); ?></button>
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
