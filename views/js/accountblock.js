/**
 * Account Block JavaScript - Enhanced for Password Manager Compatibility and AJAX Login
 */
$(document).ready(function() {
    
    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.account-dropdown').length) {
            $('.account-dropdown').removeClass('active');
        }
    });
    
    // Handle ESC key to close dropdown
    $(document).on('keydown', function(e) {
        if (e.keyCode === 27) { // ESC key
            $('.account-dropdown').removeClass('active');   
        }
    });
    
    // Login popup behavior (click-to-toggle for password manager compatibility)
    $('.account-dropdown').has('.login').find('.account-trigger').on('click', function(e) {
        e.preventDefault();
        $(this).closest('.account-dropdown').toggleClass('active');
    });
    
    // Prevent login form clicks from closing the dropdown
    $('.account-menu.login').on('click', function(e) {
        e.stopPropagation();
    });
    
    // Keep dropdown open when password fields are focused (for password managers)
    $('.account-menu.login input[type="password"], .account-menu.login input[type="email"]').on('focus', function() {
        $(this).closest('.account-dropdown').addClass('active');
    });

    // Handle login form submission
    $('#login_form_header').on('submit', function(e) {
        var $submitBtn = $(this).find('#SubmitLogin_header');
        
        // Just show loading state before submission
        $submitBtn.prop('disabled', true).text('Logging in...');
        
        // Form will submit normally
    });
    
    // Handle mobile responsive behavior
    $(window).on('resize', function() {
        if ($(window).width() > 768) {
            $('.account-dropdown').removeClass('active');
        }
        moveAccountToMobile();
    });
    
    // Move account block content to mobile container
    function moveAccountToMobile() {
        var $accountBlock = $('#accountblock');
        var $mobileUserInfo = $('#_mobile_user_info');
        
        if ($accountBlock.length && $mobileUserInfo.length) {
            if ($(window).width() < 768) {
                // Mobile: clone accountblock to mobile container
                if (!$mobileUserInfo.find('#accountblock').length) {
                    $mobileUserInfo.html($accountBlock.clone(true));
                }
            } else {
                // Desktop: clear mobile container (content stays in original position)
                $mobileUserInfo.empty();
            }
        }
    }
    
    // Initial setup
    moveAccountToMobile();
    
});