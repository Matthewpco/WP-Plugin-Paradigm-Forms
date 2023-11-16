document.addEventListener('DOMContentLoaded', function() {
    let form = document.getElementById('paradigm-form');

    if (form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            let first_name = document.getElementById('first-name').value;
            let last_name = document.getElementById('last-name').value;
            let phone_number = document.getElementById('phone-number').value;
            let email = document.getElementById('email').value;
            let procedure_of_interest = document.getElementById('procedure-of-interest').value;
            let referral = document.getElementById('referral').value;
            let form_message = document.getElementById('form-message').value;
            let success_message = document.getElementById('paradigm-form-received');
    
    
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Form submission successful
                    success_message.classList.toggle('hidden')
                    setTimeout(function() {
                        form.reset();
                    }, 3000);
                    
                }
            };
            xhr.open('POST', paradigm_forms_ajax_object.ajax_url, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send(
                'action=paradigm_forms_submit' +
                '&first_name=' + first_name +
                '&last_name=' + last_name +
                '&phone_number=' + phone_number +
                '&email=' + email +
                '&procedure_of_interest=' + procedure_of_interest +
                '&referral=' + referral +
                '&form_message=' + form_message +
                '&_ajax_nonce=' + paradigm_forms_ajax_object.nonce
            );
        });
    }
});