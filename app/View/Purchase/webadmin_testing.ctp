<div class="container">
    <div class="row">

        <h1 class="text-center"><a href="#myModal" role="button" class="btn btn-primary btn-lg" data-toggle="modal">Contact Us</a></h1>

    </div>
</div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">We'd Love to Hear From You</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal col-sm-12">
                    <div class="form-group"><label>Name</label><input class="form-control required" placeholder="Your name" data-placement="top" data-trigger="manual" data-content="Must be at least 3 characters long, and must only contain letters." type="text"></div>
                    <div class="form-group"><label>Message</label><textarea class="form-control" placeholder="Your message here.." data-placement="top" data-trigger="manual"></textarea></div>
                    <div class="form-group"><label>E-Mail</label><input class="form-control email" placeholder="email@you.com (so that we can contact you)" data-placement="top" data-trigger="manual" data-content="Must be a valid e-mail address (user@gmail.com)" type="text"></div>
                    <div class="form-group"><label>Phone</label><input class="form-control phone" placeholder="999-999-9999" data-placement="top" data-trigger="manual" data-content="Must be a valid phone number (999-999-9999)" type="text"></div>
                    <div class="form-group"><button type="submit" class="btn btn-success pull-right">Send It!</button> <p class="help-block pull-left text-danger hide" id="form-error">&nbsp; The form is not valid. </p></div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
            </div>
        </div>
    </div>
</div>


<style>
    body {
        background: url('/assets/example/bg_6.jpg') no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        background-color:#333;
    }

    h1 .btn {
        font-size:30px;
    }
</style>

<script>

    /* form validation plugin */
    $.fn.goValidate = function () {
        var $form = this,
                $inputs = $form.find('input:text');

        var validators = {
            name: {
                regex: /^[A-Za-z]{3,}$/
            },
            pass: {
                regex: /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/
            },
            email: {
                regex: /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/
            },
            phone: {
                regex: /^[2-9]\d{2}-\d{3}-\d{4}$/,
            }
        };
        var validate = function (klass, value) {
            var isValid = true,
                    error = '';

            if (!value && /required/.test(klass)) {
                error = 'This field is required';
                isValid = false;
            } else {
                klass = klass.split(/\s/);
                $.each(klass, function (i, k) {
                    if (validators[k]) {
                        if (value && !validators[k].regex.test(value)) {
                            isValid = false;
                            error = validators[k].error;
                        }
                    }
                });
            }
            return {
                isValid: isValid,
                error: error
            }
        };
        var showError = function ($input) {
            var klass = $input.attr('class'),
                    value = $input.val(),
                    test = validate(klass, value);

            $input.removeClass('invalid');
            $('#form-error').addClass('hide');

            if (!test.isValid) {
                $input.addClass('invalid');

                if (typeof $input.data("shown") == "undefined" || $input.data("shown") == false) {
                    $input.popover('show');
                }

            }
            else {
                $input.popover('hide');
            }
        };

        $inputs.keyup(function () {
            showError($(this));
        });

        $inputs.on('shown.bs.popover', function () {
            $(this).data("shown", true);
        });

        $inputs.on('hidden.bs.popover', function () {
            $(this).data("shown", false);
        });

        $form.submit(function (e) {

            $inputs.each(function () { /* test each input */
                if ($(this).is('.required') || $(this).hasClass('invalid')) {
                    showError($(this));
                }
            });
            if ($form.find('input.invalid').length) { /* form is not valid */
                e.preventDefault();
                $('#form-error').toggleClass('hide');
            }
        });
        return this;
    };
    $('form').goValidate();


</script>