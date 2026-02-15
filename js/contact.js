/**
 * Contact Form Module
 * ===================
 * Handles the contact form modal with AJAX submission,
 * validation, accessibility features, and URL history management.
 */
(function() {
    'use strict';

    let contactOverlay = null;
    let contactForm = null;
    let closeButton = null;
    let previousActiveElement = null;
    let focusableElements = [];
    let csrfToken = null;

    /**
     * Get the contact URL based on current language
     * @returns {string} URL path for contact
     */
    function getContactUrl() {
        const lang = window.LanguageManager ? window.LanguageManager.getCurrentLang() : 'de';
        if (lang === 'en') return '/en/contact';
        if (lang === 'da') return '/dk/kontakt';
        return '/kontakt';
    }

    /**
     * Get the base URL for current language
     * @returns {string} Base URL path
     */
    function getBaseUrl() {
        const lang = window.LanguageManager ? window.LanguageManager.getCurrentLang() : 'de';
        if (lang === 'en') return '/en/';
        if (lang === 'da') return '/dk/';
        return '/';
    }

    /**
     * Fetch CSRF token from server
     */
    async function fetchCsrfToken() {
        try {
            const response = await fetch('/contact.php', {
                method: 'GET',
                credentials: 'same-origin'
            });

            const result = await response.json();

            if (result.success && result.csrf_token) {
                csrfToken = result.csrf_token;

                const csrfInput = document.getElementById('contact-csrf');
                if (csrfInput) {
                    csrfInput.value = csrfToken;
                }
            }
        } catch (e) {
            console.error('Failed to fetch CSRF token:', e);
        }
    }

    /**
     * Get all focusable elements within the contact overlay
     */
    function getFocusableElements() {
        if (!contactOverlay) return [];

        const content = contactOverlay.querySelector('.overlay-content');
        if (!content) return [];

        const selector = [
            'button:not([disabled])',
            'input:not([disabled]):not([tabindex="-1"])',
            'textarea:not([disabled])',
            '[tabindex]:not([tabindex="-1"])'
        ].join(', ');

        return Array.from(content.querySelectorAll(selector))
            .filter(el => el.offsetParent !== null);
    }

    /**
     * Handle Tab key for focus trapping
     */
    function handleTabKey(e) {
        if (!contactOverlay || !contactOverlay.classList.contains('active')) return;

        focusableElements = getFocusableElements();
        if (focusableElements.length === 0) return;

        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];

        if (e.shiftKey) {
            if (document.activeElement === firstElement) {
                e.preventDefault();
                lastElement.focus();
            }
        } else {
            if (document.activeElement === lastElement) {
                e.preventDefault();
                firstElement.focus();
            }
        }
    }

    /**
     * Handle keyboard events
     */
    function handleKeydown(e) {
        if (!contactOverlay || !contactOverlay.classList.contains('active')) return;

        if (e.key === 'Escape') {
            e.preventDefault();
            closeContactForm();
        } else if (e.key === 'Tab') {
            handleTabKey(e);
        }
    }

    /**
     * Open contact form modal
     * @param {boolean} skipHistory - If true, don't push to history (used for popstate)
     */
    function openContactForm(skipHistory) {
        if (!contactOverlay) return;

        previousActiveElement = document.activeElement;

        // Reset form state
        resetForm();

        // Set timestamp for time-based spam check
        const timestampInput = document.getElementById('contact-timestamp');
        if (timestampInput) {
            timestampInput.value = Math.floor(Date.now() / 1000);
        }

        // Fetch CSRF token from server
        fetchCsrfToken();

        // Update URL (unless opening from popstate or server-side)
        if (!skipHistory && document.body.dataset.overlay !== 'contact') {
            history.pushState({ overlay: 'contact' }, '', getContactUrl());
        }

        // Show overlay
        contactOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';

        // Focus first input after transition
        setTimeout(function() {
            const nameInput = document.getElementById('contact-name');
            if (nameInput) {
                nameInput.focus();
            }
        }, 100);

        document.addEventListener('keydown', handleKeydown);
    }

    /**
     * Close contact form modal
     * @param {boolean} skipHistory - If true, don't modify history (used for popstate)
     */
    function closeContactForm(skipHistory) {
        if (!contactOverlay) return;

        contactOverlay.classList.remove('active');
        document.body.style.overflow = '';

        // Update URL back to base (unless closing from popstate)
        if (!skipHistory) {
            history.pushState({ overlay: null }, '', getBaseUrl());
        }

        if (previousActiveElement) {
            previousActiveElement.focus();
            previousActiveElement = null;
        }

        document.removeEventListener('keydown', handleKeydown);
    }

    /**
     * Handle browser back/forward navigation
     */
    function handlePopState(e) {
        if (e.state && e.state.overlay === 'contact') {
            openContactForm(true); // Skip history push
        } else if (contactOverlay && contactOverlay.classList.contains('active')) {
            closeContactForm(true); // Skip history push
        }
    }

    /**
     * Reset form to initial state
     */
    function resetForm() {
        if (!contactForm) return;

        contactForm.reset();

        const feedback = document.getElementById('contact-feedback');
        if (feedback) {
            feedback.textContent = '';
            feedback.className = 'contact-feedback';
        }

        const submitBtn = document.getElementById('contact-submit');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('loading');
        }

        // Remove validation states
        const fields = contactForm.querySelectorAll('.contact-field');
        fields.forEach(field => {
            field.classList.remove('error', 'valid');
        });

        // Show form fields (in case they were hidden after success)
        const formFields = contactForm.querySelectorAll('.contact-field, .contact-privacy, .contact-submit');
        formFields.forEach(field => {
            field.style.display = '';
        });
    }

    /**
     * Show feedback message
     */
    function showFeedback(message, isSuccess) {
        const feedback = document.getElementById('contact-feedback');
        if (!feedback) return;

        feedback.textContent = message;
        feedback.className = 'contact-feedback ' + (isSuccess ? 'success' : 'error');
    }

    /**
     * Get translated error message
     */
    function getErrorMessage(errorCode) {
        const lang = window.LanguageManager ? window.LanguageManager.getCurrentLang() : 'de';

        const messages = {
            de: {
                name_invalid: 'Bitte gib deinen Namen ein (mind. 2 Zeichen).',
                email_invalid: 'Bitte gib eine gültige E-Mail-Adresse ein.',
                message_invalid: 'Bitte gib eine Nachricht ein (mind. 10 Zeichen).',
                rate_limit: 'Zu viele Anfragen. Bitte warte einige Minuten.',
                send_failed: 'Leider ist ein Fehler aufgetreten. Bitte versuche es später erneut.',
                general: 'Leider ist ein Fehler aufgetreten. Bitte versuche es später erneut.'
            },
            en: {
                name_invalid: 'Please enter your name (at least 2 characters).',
                email_invalid: 'Please enter a valid email address.',
                message_invalid: 'Please enter a message (at least 10 characters).',
                rate_limit: 'Too many requests. Please wait a few minutes.',
                send_failed: 'An error occurred. Please try again later.',
                general: 'An error occurred. Please try again later.'
            },
            da: {
                name_invalid: 'Indtast venligst dit navn (mindst 2 tegn).',
                email_invalid: 'Indtast venligst en gyldig e-mailadresse.',
                message_invalid: 'Indtast venligst en besked (mindst 10 tegn).',
                rate_limit: 'For mange anmodninger. Vent venligst et par minutter.',
                send_failed: 'Der opstod en fejl. Prøv venligst igen senere.',
                general: 'Der opstod en fejl. Prøv venligst igen senere.'
            }
        };

        const langMessages = messages[lang] || messages.de;
        return langMessages[errorCode] || langMessages.general;
    }

    /**
     * Get translated success message
     */
    function getSuccessMessage() {
        const lang = window.LanguageManager ? window.LanguageManager.getCurrentLang() : 'de';

        const messages = {
            de: 'Vielen Dank! Deine Nachricht wurde gesendet.',
            en: 'Thank you! Your message has been sent.',
            da: 'Tak! Din besked er blevet sendt.'
        };

        return messages[lang] || messages.de;
    }

    /**
     * Validate form fields client-side
     */
    function validateForm() {
        let isValid = true;

        const nameInput = document.getElementById('contact-name');
        const emailInput = document.getElementById('contact-email');
        const messageInput = document.getElementById('contact-message');

        // Reset states
        [nameInput, emailInput, messageInput].forEach(input => {
            if (input) {
                input.parentElement.classList.remove('error', 'valid');
            }
        });

        // Validate name
        if (!nameInput || nameInput.value.trim().length < 2) {
            nameInput.parentElement.classList.add('error');
            isValid = false;
        } else {
            nameInput.parentElement.classList.add('valid');
        }

        // Validate email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailInput || !emailRegex.test(emailInput.value.trim())) {
            emailInput.parentElement.classList.add('error');
            isValid = false;
        } else {
            emailInput.parentElement.classList.add('valid');
        }

        // Validate message
        if (!messageInput || messageInput.value.trim().length < 10) {
            messageInput.parentElement.classList.add('error');
            isValid = false;
        } else {
            messageInput.parentElement.classList.add('valid');
        }

        return isValid;
    }

    /**
     * Handle form submission
     */
    async function handleSubmit(e) {
        e.preventDefault();

        // Client-side validation
        if (!validateForm()) {
            // Focus first error field
            const firstError = contactForm.querySelector('.contact-field.error input, .contact-field.error textarea');
            if (firstError) {
                firstError.focus();
            }
            return;
        }

        const submitBtn = document.getElementById('contact-submit');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.classList.add('loading');
        }

        // Collect form data
        const formData = {
            name: document.getElementById('contact-name').value.trim(),
            email: document.getElementById('contact-email').value.trim(),
            message: document.getElementById('contact-message').value.trim(),
            website: document.getElementById('contact-website').value, // Honeypot
            _t: parseInt(document.getElementById('contact-timestamp').value, 10),
            csrf_token: document.getElementById('contact-csrf').value,
            lang: window.LanguageManager ? window.LanguageManager.getCurrentLang() : 'de'
        };

        try {
            const response = await fetch('/contact.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData),
                credentials: 'same-origin'
            });

            const result = await response.json();

            if (result.success) {
                showFeedback(getSuccessMessage(), true);

                // Hide form fields after success
                const formFields = contactForm.querySelectorAll('.contact-field, .contact-privacy, .contact-submit');
                formFields.forEach(field => {
                    field.style.display = 'none';
                });
            } else {
                showFeedback(getErrorMessage(result.error), false);

                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('loading');
                }
            }
        } catch (error) {
            showFeedback(getErrorMessage('general'), false);

            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('loading');
            }
        }
    }

    /**
     * Initialize contact form module
     */
    function init() {
        contactOverlay = document.getElementById('contact-overlay');
        contactForm = document.getElementById('contact-form');
        closeButton = document.getElementById('close-contact-btn');

        if (!contactOverlay || !contactForm) return;

        // Set up accessibility
        const overlayContent = contactOverlay.querySelector('.overlay-content');
        if (overlayContent) {
            overlayContent.setAttribute('role', 'dialog');
            overlayContent.setAttribute('aria-modal', 'true');
            overlayContent.setAttribute('aria-labelledby', 'contact-title');
        }

        // Close button click
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                closeContactForm();
            });
        }

        // Click outside to close
        contactOverlay.addEventListener('click', function(e) {
            if (e.target === contactOverlay) {
                closeContactForm();
            }
        });

        // Prevent clicks inside content from closing
        if (overlayContent) {
            overlayContent.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        // Form submission
        contactForm.addEventListener('submit', handleSubmit);

        // Connect email button to open contact form
        // href is set server-side for proper URL preview and no-JS fallback
        const emailLink = document.getElementById('email-link');
        if (emailLink) {
            emailLink.addEventListener('click', function(e) {
                e.preventDefault();
                openContactForm();
            });
        }

        // Listen for browser back/forward
        window.addEventListener('popstate', handlePopState);

        // Check URL parameter for auto-open (legacy support)
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('contact') !== null) {
            setTimeout(function() { openContactForm(true); }, 100);
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Export for external use
    window.ContactFormManager = {
        open: openContactForm,
        close: closeContactForm,
        isOpen: function() {
            return contactOverlay && contactOverlay.classList.contains('active');
        }
    };
})();
