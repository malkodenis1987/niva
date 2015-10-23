jQuery(document).ready(function(){
   $ = jQuery;



    $('#contact-submit').click(function(){
        if ($('#info_error'))
        {
            $('#info_error').remove();
        }
        var name = $('#contact_name').val();
        var email = $('#contact_email').val();
        var message = $('#contact_message').val();
        var my_email = $('#email').val();
        var subject = $('#subject').val();
        var url = $('#url').val();
        function validateEmail(email) {
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
       var valid_email = validateEmail(email);
        var error = '';
        var error1 = '';
        var error2 = '';
        var error3 = '';

        if (name.length>2)
        {
            if(valid_email){
                if (message.length > 5){


                    var data = {'my_email': my_email,'subject': subject, 'name':name, 'email':email, 'message':message};
                    var ajaxurl = url+'/contact.php';

                    jQuery.post(ajaxurl, data, function(response) {
                        var info_succes = document.createElement('p');
                        info_succes.id = "info_succes";
                        info_succes.innerText = response;
                        $('#contact-form').append(info_succes);
                        $('#contact_name').val('');
                        $('#contact_email').val('');
                        $('#contact_message').val('');
                    });



                }else {
                    error3 = 'Message must contain al least 6 characters!\n';

                }
            }else
            {
                error2 = 'Enter a valid email adress\n';

            }
        }else
        {
            error1 = 'The "Full Name" field must contain at least 3 characters!\n';

        }
        error = error1+error2+error3;

        var info_error = document.createElement('p');
        info_error.id = "info_error";
        info_error.innerText = error;
        $('#contact-form').append(info_error);

        setTimeout(function() {
            if ($('#info_succes'))
            {
                $('#info_succes').remove();
            }
        }, 9000);

            return false;
        });


});