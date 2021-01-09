<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Student Resend Details
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="form">
                            <?php echo $this->Session->flash(); ?>  
                            <?php echo $this->Form->create('Email_content', array('url' => array('controller' => 'dashboard', 'action' => 'student_resend', 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'enctype' => 'multipart/form-data')); ?>   

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Subject</label>
                                <div class="col-lg-8">
                                    <?php echo $this->Form->input('subject', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Subject', 'required' => FALSE, 'value' => @$find['Email_content']['subject'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Email Content</label>
                                <div class="col-lg-10">
                                        <textarea rows="1000" id="editor1" class="form-control ckeditor" name="data[Email_content][student_resend]"><?php echo @$find['Email_content']['content'];?></textarea> 
                                    <?php // echo $this->Form->input('student_resend', array('class' => 'form-control ckeditor', 'label' => FALSE, 'placeholder' => 'Teacher Resend', 'type' => 'textarea', 'required' => FALSE, 'value' => @$find['Email_content']['content'])); ?>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-success"><?php echo __('Add'); ?></button>
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

