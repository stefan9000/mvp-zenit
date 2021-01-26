
/* opening home page */
$('.beginingBtn').click(function() {
    event.preventDefault();
    $('#container').attr('class','container');
    $('#container').addClass('home');
    $('.mainNavLinks').removeClass('active');
    $('#linkBegining').addClass('active');
})

/* contact form */
$('.contactBtn').click(function() {
    event.preventDefault();
    $('#container').attr('class','container');
    $('#container').addClass('contact');
    $('.mainNavLinks').removeClass('active');
    $('#linkContact').addClass('active');
})

/* form message */
$('#contact-form').on('submit', (e) => {
    e.preventDefault();

    $.ajax({
        url: location.origin + '/message.php',
        method: 'POST',
        data: {
            'contact': true,
            'name': $('#contact-name').val(),
            'email': $('#contact-email').val(),
            'message': $('#contact-message').val()
        },
        success: (response) => {
            $('#container').attr('class','container');
            $('#container').addClass('formMessage');
        }
    });
});

/* opening mission page */
$('.missionBtn').click(function() {
    event.preventDefault();
    $('#container').attr('class','container');
    $('#container').addClass('mission');
    $('.mainNavLinks').removeClass('active');
    $('#linkMission').addClass('active');
})

/* menu trigger */
$('.menuTrigger').click(function() {
    $('.navigation').slideToggle();
})