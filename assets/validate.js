// validate.js — client-side validation

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    
    if (form) {
        // Real-time validation
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                if (this.classList.contains('error')) {
                    validateField(this);
                }
            });
        });
        
        // Form submission validation
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const inputs = form.querySelectorAll('input, select');
            
            inputs.forEach(input => {
                if (!validateField(input)) {
                    isValid = false;
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                showNotification('Please fix the errors in the form', 'error');
            }
        });
    }
});

function validateField(field) {
    const value = field.value.trim();
    const errorSpan = document.getElementById(field.id + 'Error') || 
                      document.getElementById(field.name + 'Error');
    
    if (!errorSpan) return true;
    
    let errorMessage = '';
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        errorMessage = 'This field is required';
    } else {
        // Field-specific validation
        switch(field.id) {
            case 'name':
                if (value && value.length < 2) {
                    errorMessage = 'Name must be at least 2 characters';
                }
                break;
                
            case 'reg_no':
                if (value && !/^[A-Z0-9-]+$/.test(value)) {
                    errorMessage = 'Invalid registration number format';
                }
                break;
                
            case 'email':
                if (value && !isValidEmail(value)) {
                    errorMessage = 'Please enter a valid email address';
                }
                break;
                
            case 'password':
                if (value && value.length < 6) {
                    errorMessage = 'Password must be at least 6 characters';
                }
                break;
                
            case 'age':
                if (value) {
                    const age = parseInt(value);
                    if (isNaN(age) || age < 1 || age > 120) {
                        errorMessage = 'Please enter a valid age (1-120)';
                    }
                }
                break;
        }
    }
    
    // Gender validation (radio buttons)
    if (field.name === 'gender') {
        const genderSelected = document.querySelector('input[name="gender"]:checked');
        if (!genderSelected) {
            errorMessage = 'Please select a gender';
            // Show error for all radio buttons or a specific error span
            const genderError = document.getElementById('genderError');
            if (genderError) {
                genderError.textContent = errorMessage;
            }
            return false;
        } else {
            const genderError = document.getElementById('genderError');
            if (genderError) {
                genderError.textContent = '';
            }
            return true;
        }
    }
    
    // Display error message
    errorSpan.textContent = errorMessage;
    
    // Add/remove error class
    if (errorMessage) {
        field.classList.add('input-error');
        return false;
    } else {
        field.classList.remove('input-error');
        return true;
    }
}

function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = alert alert-${type};
    notification.textContent = message;
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.zIndex = '1000';
    notification.style.animation = 'slideIn 0.3s ease';
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Clear session data function for reset button
function clearSessionData() {
    // This would typically be an AJAX call
    // For now, we'll just clear the form
    document.getElementById('registrationForm').reset();
    
    // Clear all error messages
    document.querySelectorAll('.error').forEach(el => {
        el.textContent = '';
    });
    
    // Remove input-error class
    document.querySelectorAll('.input-error').forEach(el => {
        el.classList.remove('input-error');
    });
}

// Add animation styles
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .input-error {
        border-color: #dc3545 !important;
    }
    
    .input-error:focus {
        box-shadow: 0 0 0 0.2rem rgba(220,53,69,0.25) !important;
    }
`;
document.head.appendChild(style);
