/**
 * Form messages handler for the Stallion Theme
 * 
 * This script handles URL parameters to display appropriate success and error messages
 * in forms after page reloads from non-AJAX submissions.
 */
document.addEventListener('DOMContentLoaded', function() {
    // Get URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const registerStatus = urlParams.get('register');
    const keepModal = urlParams.get('keepmodal');
    const emailSent = urlParams.get('email_sent');
    const message = urlParams.get('message');
    const username = urlParams.get('username');
    
    // Get modal elements
    const signupModal = document.getElementById('signup-modal');
    const loginModal = document.getElementById('login-modal');
    const signupError = document.getElementById('signup-error');
    const signupSuccess = document.getElementById('signup-success');
    
    // Function to show a message in the appropriate element
    function showMessage(type, container, message, isModal = false) {
        if (!container) return;
        
        container.textContent = message;
        container.classList.remove('hidden');
        
        // Show the containing modal if necessary
        if (isModal && keepModal === 'yes') {
            if (type === 'signup-error' || type === 'signup-success') {
                if (signupModal) signupModal.classList.remove('hidden');
            } else if (type === 'login-error') {
                if (loginModal) loginModal.classList.remove('hidden');
            }
        }
        
        // Scroll to the message
        container.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    
    // Handle registration messages
    if (registerStatus) {
        switch (registerStatus) {            case 'success':
                if (signupSuccess) {
                    // Store username for verification if available
                    if (username) {
                        sessionStorage.setItem('verifyUsername', username);
                    }
                    
                    // Create success message with verification instructions
                    signupSuccess.innerHTML = `
                        <p class="mb-2"><strong>Registration successful!</strong></p>
                        <p class="mb-2">Due to technical issues with our email system, you need to verify your account manually.</p>
                        <p class="mb-3">Please go to the Verification page and enter your username and email to complete the process.</p>
                        <a href="${window.location.origin}/verify" class="inline-block px-4 py-2 bg-green-700 hover:bg-green-800 text-white font-medium rounded-md transition">
                            Go to Verification Page
                        </a>
                    `;
                    signupSuccess.classList.remove('hidden');
                    
                    // Show modal if needed
                    if (keepModal === 'yes' && signupModal) {
                        signupModal.classList.remove('hidden');
                    }
                }
                break;
                
            case 'password_mismatch':
                showMessage('signup-error', signupError, 'Passwords do not match.', true);
                break;
                
            case 'weak_password':
                let weakPasswordMsg = 'Password must meet all requirements.';
                if (message) {
                    weakPasswordMsg = decodeURIComponent(message);
                }
                showMessage('signup-error', signupError, weakPasswordMsg, true);
                break;
                
            case 'email_exists':
                showMessage('signup-error', signupError, 'This email address is already registered.', true);
                break;
                
            case 'invalid_email_domain':
                let invalidEmailMsg = 'Please use an email address from Gmail, Outlook, or Yahoo mail services only.';
                if (message) {
                    invalidEmailMsg = decodeURIComponent(message);
                }
                showMessage('signup-error', signupError, invalidEmailMsg, true);
                break;
                
            case 'error':
                let errorMsg = 'Registration failed. Please try again.';
                if (message) {
                    errorMsg = decodeURIComponent(message);
                }
                showMessage('signup-error', signupError, errorMsg, true);
                break;
        }
    }
    
    // Clear URL parameters after processing
    if (registerStatus || keepModal) {
        // Create a new URL without the processed parameters
        const newUrl = new URL(window.location.href);
        newUrl.searchParams.delete('register');
        newUrl.searchParams.delete('keepmodal');
        newUrl.searchParams.delete('email_sent');
        newUrl.searchParams.delete('message');
        newUrl.searchParams.delete('username');
        
        // Replace the current URL without triggering a page reload
        window.history.replaceState({}, document.title, newUrl.toString());
    }
});

// Affiliate form AJAX redirect handler
if (typeof window !== 'undefined') {
  document.addEventListener('DOMContentLoaded', function() {
    // Use querySelector for the first affiliate form only (enforce only one per page)
    var affiliateForm = document.querySelector('form#affiliate-form');
    if (affiliateForm) {
      affiliateForm.addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(affiliateForm);
        var submitBtn = affiliateForm.querySelector('button[type="submit"]');
        if (submitBtn) submitBtn.disabled = true;
        // Remove any previous message in this form's parent
        var oldMsg = affiliateForm.parentNode.querySelector('#affiliate-form-message');
        if (oldMsg) oldMsg.remove();
        // Ensure the action is a string URL, not an input element
        var actionUrl = affiliateForm.getAttribute('action');
        if (typeof actionUrl !== 'string') {
          actionUrl = String(actionUrl);
        }
        fetch(actionUrl, {
          method: 'POST',
          body: formData,
          credentials: 'same-origin'
        })
        .then(res => res.json())
        .then(data => {
          var msgDiv = document.createElement('div');
          msgDiv.id = 'affiliate-form-message';
          msgDiv.className = 'mb-4 p-3 rounded-md text-center';
          if (data && data.success) {
            msgDiv.classList.add('bg-green-800', 'text-green-200');
            msgDiv.textContent = data.message || 'Your affiliate application has been submitted successfully!';
            affiliateForm.reset();
          } else {
            msgDiv.classList.add('bg-red-800', 'text-red-200');
            msgDiv.textContent = (data && data.message) ? data.message : 'There was a problem saving your application. Please try again.';
          }
          affiliateForm.parentNode.insertBefore(msgDiv, affiliateForm);
        })
        .catch(() => {
          var msgDiv = document.createElement('div');
          msgDiv.id = 'affiliate-form-message';
          msgDiv.className = 'mb-4 p-3 bg-red-800 text-red-200 rounded-md text-center';
          msgDiv.textContent = 'There was a problem submitting the form. Please try again.';
          affiliateForm.parentNode.insertBefore(msgDiv, affiliateForm);
        })
        .finally(() => {
          if (submitBtn) submitBtn.disabled = false;
        });
      });
    }
  });
}
