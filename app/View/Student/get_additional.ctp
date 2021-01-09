<div class="col-md-12 form-group">
    <div class="col-lg-3">
        First Name <span class="asterick">*</span>
    </div>
    <div class="col-lg-9">
        <?php echo $this->Form->input('firstname', array('class' => 'form-control', 'id' => 'first_name', 'label' => FALSE, 'placeholder' => 'First Name', 'value' => $get_Data['Child_user']['firstname'])); ?>
    </div>
</div>

<div class="col-md-12 form-group">
    <div class="col-lg-3">
        Last Name
    </div>
    <div class="col-lg-9">
        <?php echo $this->Form->input('lastname', array('class' => 'form-control', 'id' => 'last_name', 'label' => FALSE, 'placeholder' => 'Last Name', 'value' => $get_Data['Child_user']['lastname'])); ?>
    </div>
</div>

<div class="col-md-12 form-group">
    <div class="col-lg-3">
        Age <span class="asterick">*</span> 
    </div>
    <div class="col-lg-9">
        <?php
        echo $this->Form->input('age', array('class' => 'form-control', 'id' => 'stu_age', 'label' => FALSE, 'placeholder' => 'Age', 'value' => $get_Data['Child_user']['age']));
        ?>
    </div>
</div>

<div class="col-md-12 form-group">
    <div class="col-lg-3">
        Subject <span class="asterick">*</span> 
    </div>
    <div class="col-lg-9">
        <?php
        if (!empty($subjects)) {
            foreach ($subjects as $subject) {
                $sub[$subject['Subject']['subject']] = $subject['Subject']['subject'];
            }
        }

        echo $this->Form->input('subject', array('class' => 'form-control', 'id' => 'stu_subject', 'label' => FALSE, 'empty' => '-Select-', 'value' => $get_Data['Child_user']['subject'], 'options' => $sub));
        ?>
    </div>
</div>