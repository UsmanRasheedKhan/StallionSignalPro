// Fix for login and registration functionality
document.addEventListener('DOMContentLoaded', function() {
    console.log('Auth fix script loaded');
    
    // Direct event listeners for login buttons
    const loginBtn = document.getElementById('login-btn');
    const mobileLoginBtn = document.getElementById('mobile-login-btn');
    const loginModal = document.getElementById('login-modal');
    
    // Password-related elements
    const passwordToggles = document.querySelectorAll('.password-toggle');
    const signupPassword = document.getElementById('signup-password');
    const signupPasswordConfirm = document.getElementById('signup-password-confirm');
    const passwordMatchError = document.getElementById('password-match-error');
    const passwordStrengthMeter = document.getElementById('password-strength-meter');
    const passwordStrengthText = document.getElementById('password-strength-text');
    const reqLength = document.getElementById('req-length');
    const reqUppercase = document.getElementById('req-uppercase');
    const reqLowercase = document.getElementById('req-lowercase');
    const reqNumber = document.getElementById('req-number');    
    
    // Forgot password modal elements
    const forgotPasswordLink = document.getElementById('forgot-password-link');
    const forgotPasswordModal = document.getElementById('forgot-password-modal');
    const forgotPasswordStepOne = document.getElementById('forgot-password-step-one');
    const forgotStepOne = document.getElementById('forgot-step-one');
    const forgotStepTwo = document.getElementById('forgot-step-two');
    const forgotEmail = document.getElementById('forgot-email');
    const forgotPassword = document.getElementById('forgot-password');
    const forgotPasswordConfirm = document.getElementById('forgot-password-confirm');
    const forgotPasswordMatchError = document.getElementById('forgot-password-match-error');
    const closeForgotPasswordModal = document.getElementById('close-forgot-password-modal');
    const forgotPasswordStrengthMeter = document.getElementById('forgot-password-strength-meter');
    const forgotPasswordStrengthText = document.getElementById('forgot-password-strength-text');
    const forgotReqLength = document.getElementById('forgot-req-length');
    const forgotReqUppercase = document.getElementById('forgot-req-uppercase');
    const forgotReqLowercase = document.getElementById('forgot-req-lowercase');
    const forgotReqNumber = document.getElementById('forgot-req-number');
    
    // Log what we find for debugging
    console.log('Login button found:', !!loginBtn);
    console.log('Mobile login button found:', !!mobileLoginBtn);
    console.log('Login modal found:', !!loginModal);
    console.log('Forgot password modal found:', !!forgotPasswordModal);
    
    // Check for all required forgot password elements
    const forgotPasswordElements = {
        'forgotPasswordLink': forgotPasswordLink,
        'forgotPasswordModal': forgotPasswordModal,
        'forgotStepOne': forgotStepOne,
        'forgotStepTwo': forgotStepTwo,
        'forgotEmail': forgotEmail,
        'forgotPasswordStepOne': forgotPasswordStepOne,
        'forgotPassword': forgotPassword,
        'forgotPasswordConfirm': forgotPasswordConfirm,
        'forgotPasswordMatchError': forgotPasswordMatchError,
        'closeForgotPasswordModal': closeForgotPasswordModal
    };
    
    console.log('Checking forgot password elements:');
    for (const [name, element] of Object.entries(forgotPasswordElements)) {
        console.log(`${name}: ${element ? 'Found ✓' : 'Missing ✗'}`);
    }
    
    // Initialize password validation indicators if signup form is displayed
    if (document.getElementById('signup-modal') && 
        !document.getElementById('signup-modal').classList.contains('hidden') &&
        signupPassword && signupPassword.value) {
        setTimeout(() => checkPasswordStrength(signupPassword.value), 100);
    }
    
    // Create global login function that can be called directly
    window.openLoginModal = function() {
        console.log('Global login handler triggered');
        if (loginModal) {
            loginModal.classList.remove('hidden');
            console.log('Login modal shown via global handler');
        } else {
            console.error('Login modal not found in global handler');
        }
        return false;
    };
    
    // Login button click handler
    if (loginBtn) {
        console.log('Setting up login button click handler');
        loginBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Login button clicked');
            if (loginModal) {
                loginModal.classList.remove('hidden');
                console.log('Login modal shown');
            } else {
                console.error('Login modal not found');
            }
        });
    } else {
        console.error('Login button not found - cannot attach click handler');
    }
    
    // Mobile login button click handler
    if (mobileLoginBtn) {
        mobileLoginBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Mobile login button clicked');
            if (loginModal) {
                loginModal.classList.remove('hidden');
                console.log('Login modal shown (mobile)');
            } else {
                console.error('Login modal not found');
            }
        });
    }
    
    // Close button handlers
    const closeLoginBtn = document.getElementById('close-login-modal');
    if (closeLoginBtn && loginModal) {
        closeLoginBtn.addEventListener('click', function(e) {
            e.preventDefault();
            loginModal.classList.add('hidden');
            console.log('Login modal closed');
        });
    }
    
    // Close signup modal button
    const closeSignupBtn = document.getElementById('close-signup-modal');
    const signupModal = document.getElementById('signup-modal');
    
    if (closeSignupBtn && signupModal) {
        closeSignupBtn.addEventListener('click', function(e) {
            e.preventDefault();
            signupModal.classList.add('hidden');
            console.log('Signup modal closed');
        });
    }
    
    // Close modal when clicking outside
    if (loginModal) {
        loginModal.addEventListener('click', function(e) {
            if (e.target === loginModal || e.target.classList.contains('fixed')) {
                loginModal.classList.add('hidden');
                console.log('Login modal closed by outside click');
            }
        });
    }
    
    // Close signup modal when clicking outside
    if (signupModal) {
        signupModal.addEventListener('click', function(e) {
            if (e.target === signupModal || e.target.classList.contains('fixed')) {
                signupModal.classList.add('hidden');
                console.log('Signup modal closed by outside click');
            }
        });
    }
    
    // Switch between login and signup modals
    const showSignupLink = document.getElementById('show-signup-link');
    
    if (showSignupLink && loginModal && signupModal) {
        showSignupLink.addEventListener('click', function(e) {
            e.preventDefault();
            loginModal.classList.add('hidden');
            signupModal.classList.remove('hidden');
            console.log('Switched from login to signup modal');
        });
    }
    
    // Switch from signup to login
    const showLoginLink = document.getElementById('show-login-link');
    
    if (showLoginLink && loginModal && signupModal) {
        showLoginLink.addEventListener('click', function(e) {
            e.preventDefault();
            signupModal.classList.add('hidden');
            loginModal.classList.remove('hidden');
            console.log('Switched from signup to login modal');
        });
    }
    
    // Password eye icon toggle functionality
    if (passwordToggles.length > 0) {
        passwordToggles.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordField = document.getElementById(targetId);
                
                if (passwordField) {
                    // Toggle between password and text type
                    if (passwordField.type === 'password') {
                        passwordField.type = 'text';
                        this.innerHTML = '<i class="fas fa-eye-slash"></i>';
                    } else {
                        passwordField.type = 'password';
                        this.innerHTML = '<i class="fas fa-eye"></i>';
                    }
                }
            });
        });
        console.log('Password toggle functionality initialized');
    }
    
    // Password strength validation function
    function checkPasswordStrength(pwd) {
        if (!passwordStrengthMeter || !passwordStrengthText || 
            !reqLength || !reqUppercase || !reqLowercase || !reqNumber) {
            return false;
        }
        
        let strength = 0;
        let strengthClass = '';
        
        // Check requirements
        const hasLength = pwd.length >= 8;
        const hasUppercase = /[A-Z]/.test(pwd);
        const hasLowercase = /[a-z]/.test(pwd);
        const hasNumber = /[0-9]/.test(pwd);
        
        // Update requirement indicators
        reqLength.className = hasLength ? 'text-green-400' : 'text-red-400';
        reqUppercase.className = hasUppercase ? 'text-green-400' : 'text-red-400';
        reqLowercase.className = hasLowercase ? 'text-green-400' : 'text-red-400';
        reqNumber.className = hasNumber ? 'text-green-400' : 'text-red-400';
        
        // Calculate strength
        if (hasLength) strength += 25;
        if (hasUppercase) strength += 25;
        if (hasLowercase) strength += 25;
        if (hasNumber) strength += 25;
        
        // Set strength meter properties
        if (strength < 50) {
            strengthClass = 'bg-red-500';
            passwordStrengthText.textContent = 'Weak';
            passwordStrengthText.className = 'ml-2 text-red-400';
        } else if (strength < 75) {
            strengthClass = 'bg-yellow-500';
            passwordStrengthText.textContent = 'Fair';
            passwordStrengthText.className = 'ml-2 text-yellow-400';
        } else if (strength < 100) {
            strengthClass = 'bg-amber-500';
            passwordStrengthText.textContent = 'Good';
            passwordStrengthText.className = 'ml-2 text-amber-400';
        } else {
            strengthClass = 'bg-green-500';
            passwordStrengthText.textContent = 'Strong';
            passwordStrengthText.className = 'ml-2 text-green-400';
        }
        
        passwordStrengthMeter.style.width = strength + '%';
        passwordStrengthMeter.className = 'h-1.5 rounded-full ' + strengthClass;
        
        return hasLength && hasUppercase && hasLowercase && hasNumber;
    }
    
    // Real-time password validation
    if (signupPassword && passwordStrengthMeter) {
        signupPassword.addEventListener('input', function() {
            checkPasswordStrength(this.value);
            
            // Also check if passwords match when typing
            if (signupPasswordConfirm && signupPasswordConfirm.value) {
                if (signupPassword.value !== signupPasswordConfirm.value) {
                    if (passwordMatchError) passwordMatchError.classList.remove('hidden');
                } else {
                    if (passwordMatchError) passwordMatchError.classList.add('hidden');
                }
            }
        });
    }
    
    // Password confirmation validation
    if (signupPasswordConfirm && passwordMatchError) {
        signupPasswordConfirm.addEventListener('input', function() {
            if (signupPassword && signupPassword.value !== signupPasswordConfirm.value) {
                passwordMatchError.classList.remove('hidden');
            } else {
                passwordMatchError.classList.add('hidden');
            }
        });
    }
    
    // Forgot password modal functionality
    console.log("Debug forgot password elements:", {
        forgotPasswordLink: !!forgotPasswordLink,
        loginModal: !!loginModal,
        forgotPasswordModal: !!forgotPasswordModal,
        forgotStepOne: !!forgotStepOne,
        forgotStepTwo: !!forgotStepTwo
    });
    
    // Create global forgot password function
    window.openForgotPasswordModal = function() {
        console.log('Global forgot password handler triggered');
        if (loginModal) loginModal.classList.add('hidden');
        if (forgotPasswordModal) forgotPasswordModal.classList.remove('hidden');
        
        // Reset the form and show step one
        const forgotForm = document.getElementById('forgot-password-form');
        const forgotSuccess = document.getElementById('forgot-password-success');
        const forgotError = document.getElementById('forgot-password-error');
        
        if (forgotForm) forgotForm.reset();
        if (forgotStepOne) forgotStepOne.classList.remove('hidden');
        if (forgotStepTwo) forgotStepTwo.classList.add('hidden');
        if (forgotSuccess) forgotSuccess.classList.add('hidden');
        if (forgotError) forgotError.classList.add('hidden');
        
        return false;
    };
    
    if (forgotPasswordLink && loginModal && forgotPasswordModal) {
        console.log('Setting up forgot password link click handler');
        forgotPasswordLink.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Forgot password link clicked via event listener');
            window.openForgotPasswordModal();
        });
    } else {
        console.error('Cannot set up forgot password modal due to missing elements:', 
            !forgotPasswordLink ? 'forgotPasswordLink' : '',
            !loginModal ? 'loginModal' : '',
            !forgotPasswordModal ? 'forgotPasswordModal' : '');
    }
    
    // Close forgot password modal
    if (closeForgotPasswordModal && forgotPasswordModal) {
        closeForgotPasswordModal.addEventListener('click', function(e) {
            e.preventDefault();
            forgotPasswordModal.classList.add('hidden');
            console.log('Forgot password modal closed');
        });
    }
    
    // Close forgot password modal when clicking outside
    if (forgotPasswordModal) {
        forgotPasswordModal.addEventListener('click', function(e) {
            if (e.target === forgotPasswordModal || e.target.classList.contains('fixed')) {
                forgotPasswordModal.classList.add('hidden');
                console.log('Forgot password modal closed by outside click');
            }
        });
    }
      
    // Step one continue button
    console.log("Debug forgot password step one elements:", {
        forgotPasswordStepOne: !!forgotPasswordStepOne,
        forgotStepOne: !!forgotStepOne,
        forgotStepTwo: !!forgotStepTwo,
        forgotEmail: !!forgotEmail
    });
    
    if (forgotPasswordStepOne && forgotStepOne && forgotStepTwo && forgotEmail) {
        console.log('Setting up forgot password step one button click handler');
        forgotPasswordStepOne.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Forgot password step one button clicked');
            
            // Simple validation for email field
            if (forgotEmail.value.trim() === '') {
                const forgotError = document.getElementById('forgot-password-error');
                if (forgotError) {
                    forgotError.textContent = 'Please enter your email or username';
                    forgotError.classList.remove('hidden');
                } else {
                    console.error('Forgot password error element not found');
                }
                return;
            }
            
            // Hide step one, show step two
            if (forgotStepOne) forgotStepOne.classList.add('hidden');
            else console.error('Forgot step one element not found');
            
            if (forgotStepTwo) forgotStepTwo.classList.remove('hidden');
            else console.error('Forgot step two element not found');
            
            console.log('Forgot password: moved to step two');
        });
    } else {
        console.error('Cannot set up forgot password step one button due to missing elements:', 
            !forgotPasswordStepOne ? 'forgotPasswordStepOne' : '',
            !forgotStepOne ? 'forgotStepOne' : '',
            !forgotStepTwo ? 'forgotStepTwo' : '',
            !forgotEmail ? 'forgotEmail' : '');
    }
    
    // Password strength validation function for forgot password
    function checkForgotPasswordStrength(pwd) {
        if (!forgotPasswordStrengthMeter || !forgotPasswordStrengthText || 
            !forgotReqLength || !forgotReqUppercase || !forgotReqLowercase || !forgotReqNumber) {
            return false;
        }
        
        let strength = 0;
        let strengthClass = '';
        
        // Check requirements
        const hasLength = pwd.length >= 8;
        const hasUppercase = /[A-Z]/.test(pwd);
        const hasLowercase = /[a-z]/.test(pwd);
        const hasNumber = /[0-9]/.test(pwd);
        
        // Update requirement indicators
        forgotReqLength.className = hasLength ? 'text-green-400' : 'text-red-400';
        forgotReqUppercase.className = hasUppercase ? 'text-green-400' : 'text-red-400';
        forgotReqLowercase.className = hasLowercase ? 'text-green-400' : 'text-red-400';
        forgotReqNumber.className = hasNumber ? 'text-green-400' : 'text-red-400';
        
        // Calculate strength
        if (hasLength) strength += 25;
        if (hasUppercase) strength += 25;
        if (hasLowercase) strength += 25;
        if (hasNumber) strength += 25;
        
        // Set strength meter properties
        if (strength < 50) {
            strengthClass = 'bg-red-500';
            forgotPasswordStrengthText.textContent = 'Weak';
            forgotPasswordStrengthText.className = 'ml-2 text-red-400';
        } else if (strength < 75) {
            strengthClass = 'bg-yellow-500';
            forgotPasswordStrengthText.textContent = 'Fair';
            forgotPasswordStrengthText.className = 'ml-2 text-yellow-400';
        } else if (strength < 100) {
            strengthClass = 'bg-amber-500';
            forgotPasswordStrengthText.textContent = 'Good';
            forgotPasswordStrengthText.className = 'ml-2 text-amber-400';
        } else {
            strengthClass = 'bg-green-500';
            forgotPasswordStrengthText.textContent = 'Strong';
            forgotPasswordStrengthText.className = 'ml-2 text-green-400';
        }
        
        forgotPasswordStrengthMeter.style.width = strength + '%';
        forgotPasswordStrengthMeter.className = 'h-1.5 rounded-full ' + strengthClass;
        
        return hasLength && hasUppercase && hasLowercase && hasNumber;
    }
    
    // Real-time password validation for forgot password
    if (forgotPassword && forgotPasswordStrengthMeter) {
        forgotPassword.addEventListener('input', function() {
            checkForgotPasswordStrength(this.value);
            
            // Also check if passwords match when typing
            if (forgotPasswordConfirm && forgotPasswordConfirm.value) {
                if (forgotPassword.value !== forgotPasswordConfirm.value) {
                    if (forgotPasswordMatchError) forgotPasswordMatchError.classList.remove('hidden');
                } else {
                    if (forgotPasswordMatchError) forgotPasswordMatchError.classList.add('hidden');
                }
            }
        });
    }
    
    // Password confirmation validation for forgot password
    if (forgotPasswordConfirm && forgotPasswordMatchError) {
        forgotPasswordConfirm.addEventListener('input', function() {
            if (forgotPassword && forgotPassword.value !== forgotPasswordConfirm.value) {
                forgotPasswordMatchError.classList.remove('hidden');
            } else {
                forgotPasswordMatchError.classList.add('hidden');
            }
        });
    }
    
    // Form validation before submission for forgot password
    const forgotPasswordForm = document.getElementById('forgot-password-form');
    const forgotPasswordError = document.getElementById('forgot-password-error');
    
    if (forgotPasswordForm) {
        forgotPasswordForm.addEventListener('submit', function(e) {
            // Only validate step two if it's visible
            if (!forgotStepTwo.classList.contains('hidden')) {
                let isValid = true;
                
                // Check if passwords match
                if (forgotPassword && forgotPasswordConfirm && 
                    forgotPassword.value !== forgotPasswordConfirm.value) {
                    if (forgotPasswordMatchError) {
                        forgotPasswordMatchError.classList.remove('hidden');
                        isValid = false;
                    }
                }
                
                // Check password strength
                if (forgotPassword && forgotPassword.value) {
                    const hasLength = forgotPassword.value.length >= 8;
                    const hasUppercase = /[A-Z]/.test(forgotPassword.value);
                    const hasLowercase = /[a-z]/.test(forgotPassword.value);
                    const hasNumber = /[0-9]/.test(forgotPassword.value);
                    
                    if (!(hasLength && hasUppercase && hasLowercase && hasNumber)) {
                        if (forgotPasswordError) {
                            forgotPasswordError.textContent = 'Password must meet all requirements';
                            forgotPasswordError.classList.remove('hidden');
                            isValid = false;
                        }
                    }
                }
                
                if (!isValid) {
                    e.preventDefault();
                    console.log('Forgot password form submission prevented due to validation errors');
                }
            }
        });
    }
    
    // Form validation for signup
    const signupForm = document.getElementById('signup-form');
    const signupError = document.getElementById('signup-error');
    const signupSuccess = document.getElementById('signup-success');
    
    if (signupForm) {
        signupForm.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Hide any previous messages
            if (signupError) signupError.classList.add('hidden');
            if (signupSuccess) signupSuccess.classList.add('hidden');
            
            // Check if passwords match
            if (signupPassword && signupPasswordConfirm && 
                signupPassword.value !== signupPasswordConfirm.value) {
                if (passwordMatchError) {
                    passwordMatchError.classList.remove('hidden');
                    isValid = false;
                }
            }
            
            // Check password strength
            if (signupPassword && signupPassword.value) {
                const hasLength = signupPassword.value.length >= 8;
                const hasUppercase = /[A-Z]/.test(signupPassword.value);
                const hasLowercase = /[a-z]/.test(signupPassword.value);
                const hasNumber = /[0-9]/.test(signupPassword.value);
                
                if (!(hasLength && hasUppercase && hasLowercase && hasNumber)) {
                    if (signupError) {
                        signupError.textContent = 'Password must meet all requirements';
                        signupError.classList.remove('hidden');
                        isValid = false;
                    }
                }
            }
            
            if (!isValid) {
                e.preventDefault();
                console.log('Form submission prevented due to validation errors');
                return;
            }
              // If form is valid, handle the AJAX submission
            const ajaxRegisterField = document.getElementById('is-ajax-register');
            if (ajaxRegisterField && ajaxRegisterField.value === 'true') {
                e.preventDefault();
                console.log('Submitting form via AJAX...');
                
                const submitBtn = document.getElementById('signup-submit-btn');
                if (!submitBtn) {
                    console.error('Submit button not found');
                    return;
                }
                
                const originalBtnText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                submitBtn.disabled = true;
                
                const formData = new FormData(signupForm);                console.log('Form action URL:', signupForm.action);
                console.log('Sending AJAX request to:', signupForm.action);
                
                // Automatically use mock endpoint if WordPress is not available
                let ajaxUrl = signupForm.action;
                if (typeof ajaxUrl !== 'string') {
                    ajaxUrl = String(ajaxUrl);
                }
                // Always use the WordPress AJAX endpoint for production
                if (!ajaxUrl.includes('admin-ajax.php')) {
                    ajaxUrl = window.ajaxurl || '/wp-admin/admin-ajax.php';
                }
                formData.set('action', 'custom_register_user');
                
                fetch(ajaxUrl, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response statusText:', response.statusText);
                    console.log('Response URL:', response.url);
                    
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                    if (data.success) {
                        // Store username and email for verification page auto-population
                        if (data.username) {
                            sessionStorage.setItem('verifyUsername', data.username);
                        }
                        if (data.email) {
                            sessionStorage.setItem('verifyEmail', data.email);
                        }
                        
                        // Check if we should redirect immediately or show success message
                        const shouldAutoRedirect = data.redirect || true; // Default to auto-redirect
                        
                        if (shouldAutoRedirect) {
                            // Show brief success message then redirect
                            if (signupSuccess) {
                                signupSuccess.innerHTML = `
                                    <p class="mb-2"><strong>Registration successful!</strong></p>
                                    <p class="mb-2">Redirecting to verification page...</p>
                                `;
                                signupSuccess.classList.remove('hidden');
                            }
                            
                            // Hide the modal after a brief moment
                            setTimeout(() => {
                                const signupModal = document.getElementById('signup-modal');
                                if (signupModal) {
                                    signupModal.classList.add('hidden');
                                }
                                
                                // Redirect to verification page
                                const verifyUrl = data.verify_url || '/verify';
                                window.location.href = window.location.origin + verifyUrl;
                            }, 1500);
                        } else {
                            // Show manual verification message
                            if (signupSuccess) {
                                signupSuccess.innerHTML = `
                                    <p class="mb-2"><strong>Registration successful!</strong></p>
                                    <p class="mb-2">Due to technical issues with our email system, you need to verify your account manually.</p>
                                    <p class="mb-3">Please go to the Verification page and enter your username and email to complete the process.</p>
                                    <a href="${window.location.origin}/verify" class="inline-block px-4 py-2 bg-green-700 hover:bg-green-800 text-white font-medium rounded-md transition">
                                        Go to Verification Page
                                    </a>
                                `;
                                signupSuccess.classList.remove('hidden');
                            }
                        }
                        
                        signupForm.reset();
                            
                            // Reset password strength indicators
                            if (passwordStrengthMeter) {
                                passwordStrengthMeter.style.width = '0%';
                                passwordStrengthMeter.className = 'h-1.5 rounded-full bg-red-500';
                            }
                            if (passwordStrengthText) {
                                passwordStrengthText.textContent = 'Weak';
                                passwordStrengthText.className = 'ml-2 text-gray-400';
                            }
                            
                            // Reset requirement indicators
                            if (reqLength) reqLength.className = 'text-red-400';
                            if (reqUppercase) reqUppercase.className = 'text-red-400';
                            if (reqLowercase) reqLowercase.className = 'text-red-400';
                            if (reqNumber) reqNumber.className = 'text-red-400';
                            
                            // Hide password match error
                            if (passwordMatchError) {
                                passwordMatchError.classList.add('hidden');
                            }
                            
                            // Hide any error messages
                            if (signupError) {
                                signupError.classList.add('hidden');
                            }
                            
                            // Scroll to the success message                            signupSuccess.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        } else {
                            // Show error message
                            if (signupError) {
                                signupError.textContent = data.message || 'Registration failed. Please try again.';
                                signupError.classList.remove('hidden');
                                
                                // Hide success message if it was showing
                                if (signupSuccess) {
                                    signupSuccess.classList.add('hidden');
                                }
                                
                                // Scroll to the error message
                                signupError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Registration error details:', error);
                        console.error('Error type:', error.name);
                        console.error('Error message:', error.message);
                        submitBtn.innerHTML = originalBtnText;
                        submitBtn.disabled = false;
                        if (signupError) {
                            let errorMessage = 'An error occurred during registration.';
                            if (error.message.includes('404')) {
                                errorMessage = 'Registration endpoint not found. Please ensure WordPress is running and the site is properly configured.';
                            } else if (error.message.includes('Failed to fetch')) {
                                errorMessage = 'Unable to connect to the registration server. Please check your internet connection and try again.';
                            } else if (error.message.includes('HTTP 500')) {
                                errorMessage = 'Server error occurred. Please try again later or contact support.';
                            } else if (error.message.includes('HTTP')) {
                                errorMessage = `Server responded with error: ${error.message}`;
                            } else {
                                errorMessage = 'A network error occurred. Please check your connection and try again.';
                            }
                            signupError.textContent = errorMessage;
                            signupError.classList.remove('hidden');
                            if (signupSuccess) {
                                signupSuccess.classList.add('hidden');
                            }
                            signupError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    });
            } // closes if (ajaxRegisterField && ajaxRegisterField.value === 'true')
        }); // closes signupForm.addEventListener('submit', ...)
    } // closes if (signupForm)

    console.log('Auth fix initialization complete');
}); // closes DOMContentLoaded