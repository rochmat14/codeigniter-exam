$('form#form-login').on('submit', function(event) { //memanggil attribute id="form-login" pada elemenet form dan aktif ketika submit

    $('.input-email').each(function() { //memanggil attribute id="form-login" pada elemenet form
        $(this).rules("add", {
            required: true,
            email: true,
            messages: {
                required: "Email must be filled",
                email: "Not Email type"
            }
        });
    });

    $('.input-password').each(function() {
        $(this).rules("add", {
            required: true,
            messages: {
                required: "Password must be filled",
            }
        });
    });
});
$("#form-login").validate();

function formProfile(){
    $('.input-email').each(function() { //memanggil attribute id="form-register" pada elemenet form
        $(this).rules("add", {
            required: true,
            email: true,
            messages: {
                required: "Email must be filled",
                email: "Not Email type"
            }
        });
    });

    $('.input-name').each(function() {
        $(this).rules("add", {
            required: true,
            messages: {
                required: "Name must be filled",
            }
        });
    });

    $('.input-password').each(function() {
        $(this).rules("add", {
            required: true,
            messages: {
                required: "Password must be filled",
            }
        });
    });

    $('.input-profile_picture').each(function() {
        $(this).rules("add", {
            required: true,
            messages: {
                required: "Profile Picture must be filled",
            }
        });
    });
}

$('form#form-register').on('submit', function(event) { //memanggil attribute id="form-register" pada elemenet form dan aktif ketika submit
    formProfile();
});

$("#form-register").validate();


$('form#form-forgot').on('submit', function(event) { //memanggil attribute id="form-forgot" pada elemenet form dan aktif ketika submit

    $('.input-email').each(function() { //memanggil attribute id="form-forgot" pada elemenet form
        $(this).rules("add", {
            required: true,
            email: true,
            messages: {
                required: "Email must be filled",
                email: "Not Email type"
            }
        });
    });

    
});

$("#form-forgot").validate();


$('form#form-update').on('submit', function(event) { //memanggil attribute id="form-update" pada elemenet form dan aktif ketika submit
    formProfile();
});

$("#form-update").validate();