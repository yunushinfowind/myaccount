<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-users"></i>
                        Manage Teacher(s) Information
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">

                            <!--div class="col-md-6 searchTable">

                                <input type="text" class="form-control" placeholder="Search" id="searchFieldTeacher">


                                <input type="button"  id="searchTeacher" value="Go" class="btn btn-danger">
                            </div-->
                            <?php echo $this->Session->flash(); ?> 
                            <div class="admin_tchr">

                                <table  class="display table table-bordered table-striped dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Phone Number</th>
                                            <th>Address</th>
                                            <th>Email</th>
                                            <th>Resend Sign-Up Details</th>
                                            <th>Actions</th>

                                            <th>Status<br/>
                                                <select id="active_filter" data-status-index="7">
                                                    <option value="">All</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </th>
                                            <th>Added On</th>
                                            <th>Delete</th>

                                        </tr>
                                    </thead>
                                    <tbody class="searchResults">
                                        <?php
                                        if (!empty($FindTeacher)) {
                                            $i = 1;
                                            foreach ($FindTeacher as $teacher) {
                                                $address = explode(',', $teacher['User']['address']);
                                                ?>
                                                <tr class="gradeX">
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $teacher['User']['first_name'] . ' ' . $teacher['User']['last_name']; ?></td>
                                                    <td><?php echo $teacher['User']['primary_phone']; ?></td>
                                                    <td><?php
                                                    
                                                        if (!empty($teacher['User']['suite']) && !empty($address[0])) {
                                                            echo $address[0] . ' Apt. ' . $teacher['User']['suite'] . ' ' . $address[1] . ', ' . $address[2] . ' ' . $teacher['User']['zip_code'];
                                                        } elseif (!empty($address[0]) && !empty($address[1]) && !empty($address[2])) {
                                                            echo $address[0] . ' ' . $address[1] . ', ' . $address[2] . ' ' . $teacher['User']['zip_code'];
                                                        } else {
                                                            echo $teacher['User']['address'] . ' ' . $teacher['User']['zip_code'];
                                                        }
                                                        ?></td>

                                                    <td><?php echo $teacher['User']['email']; ?></td>

                                                    <td style="text-align: center;"><?php echo $this->Html->link('', array('action' => 'resend_signup_details', $teacher['User']['id']), array('class' => 'fa fa-envelope-o')); ?></td>
                                                    <td class="AllActions">
                                                        <button class="action">Actions &nbsp;<i class="fa fa-chevron-down"></i></button>
                                                        <ul class="action-list hide1">
                                                            <li><a href="<?php echo BASE_URL . 'webadmin/teacher/edit_basic/' . $teacher['User']['id']; ?>"><i class="fa fa-edit"></i> &nbsp; Edit Basic Info</a></li>
                                                            <li><a href="<?php echo BASE_URL . 'webadmin/teacher/edit_profile/' . $teacher['User']['id']; ?>"><i class="fa fa-edit"></i> &nbsp; Edit Profile Info</a></li>
                                                            <li><a href="<?php echo BASE_URL . 'webadmin/teacher/view_calendar/' . $teacher['User']['id']; ?>"><i class="fa fa-calendar"></i> &nbsp; Manage Calendar</a></li>
                                                            <li><a href="<?php echo BASE_URL . 'webadmin/teacher/completed_lesson/', $teacher['User']['id']; ?>"><i class="fa fa-check"></i> &nbsp; Completed Lessons</a></li>
                                                            <li><a href="<?php echo BASE_URL . 'webadmin/teacher/pay/' . $teacher['User']['id']; ?>"><i class="fa fa-paypal"></i> &nbsp; Pay Teacher</a></li>

                                                        </ul>
                                                    </td>
                                                    <td><a title = "Change Status" href="<?php echo BASE_URL; ?>webadmin/teacher/change_status/<?php echo $teacher['User']['id']; ?>"><?php if ($teacher['User']['status'] == "1") { ?>
                                                                <span style="display:none;">1</span>
                                                                <img width = "20" alt = "tick" src = "<?php echo $this->webroot; ?>img/tick.png" />
                                                            <?php } else { ?>
                                                                <span style="display:none;">0</span>
                                                                <img width = "20" alt = "tick" src = "<?php echo $this->webroot; ?>img/cross.png" />
                                                            <?php } ?> </a></td>
                                                    <td><?php echo date('m/d/Y', strtotime($teacher['User']['created'])); ?></td>
                                                    <td style="text-align: center;"><?php echo $this->Form->postLink('', array('action' => 'delete_teacher', $teacher['User']['id']), array('confirm' => 'Are you sure you want to delete Teacher?', 'class' => 'fa fa-trash-o')); ?></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        } else {
                                            echo '<tr class="gradeX"><td colspan="10" style="text-align:center;">No Teacher Added yet!</td></tr>';
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Phone Number</th>
                                            <th>Address</th>
                                            <th>Email</th>
                                            <th>Resend Sign-Up Details</th>
                                            <th>Actions</th>
                                            <th>Status</th>
                                            <th>Added On</th>
                                            <th>Delete</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- page end-->
    </section>
</section>