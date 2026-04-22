/**
 * Easter Egg Module
 * =================
 * Handles the profile photo heartbeat animation and confetti effects.
 *
 * Triggers:
 * - Double-click on profile photo (desktop)
 * - Double-tap on profile photo (mobile)
 * - Spacebar key press
 * - Automatic confetti after 111 seconds (1:51) as a "thank you" for staying
 *
 * Note: Disabled on Safari due to rendering issues
 */
(function() {
    'use strict';

    // State management
    let isEasterEggActive = false;
    let lastTap = 0;
    let confettiTriggered = false;
    let confettiLoaded = false;

    // Safari detection - Easter egg disabled due to rendering issues
    const isSafari = /safari/i.test(navigator.userAgent) &&
                     !/chrome|chromium|android/i.test(navigator.userAgent);

    /**
     * Dynamically load confetti.js library when needed
     * This reduces initial page load time
     * @param {Function} callback - Called when script is loaded
     */
    function loadConfetti(callback) {
        if (confettiLoaded) {
            callback();
            return;
        }

        const script = document.createElement('script');
        script.src = '/js/confetti.min.js';
        script.onload = function() {
            confettiLoaded = true;
            callback();
        };
        script.onerror = function() {
            console.warn('Confetti script could not be loaded');
        };
        document.head.appendChild(script);
    }

    /**
     * Fire confetti animation from both sides of screen
     * Only fires once per session
     */
    function fireConfetti() {
        if (confettiTriggered) return;
        if (document.hidden) return;
        confettiTriggered = true;

        const duration = 3000;
        const end = Date.now() + duration;
        const colors = ['#667eea', '#764ba2', '#ffffff', '#ffd700', '#ff6b6b'];

        // Animation loop using requestAnimationFrame for smooth 60fps
        function frame() {
            // Fire from left side
            window.confetti({
                particleCount: 3,
                angle: 60,
                spread: 55,
                origin: { x: 0 },
                colors: colors
            });

            // Fire from right side
            window.confetti({
                particleCount: 3,
                angle: 120,
                spread: 55,
                origin: { x: 1 },
                colors: colors
            });

            if (Date.now() < end) {
                requestAnimationFrame(frame);
            }
        }

        frame();
    }

    /**
     * Initialize auto-trigger timer for confetti
     * Rewards users who stay on the page
     */
    function initConfettiTimer() {
        // 111 seconds (1:51) - a quirky "thank you" timing
        setTimeout(function() {
            if (confettiTriggered) return;
            if (document.hidden) return;
            loadConfetti(fireConfetti);
        }, 111000);
    }

    /**
     * Main Easter egg animation - heartbeat effect on profile photo
     * Sequence: scale up in stages with heartbeat pulse, then spin back
     */
    function triggerEasterEgg() {
        if (isEasterEggActive) return;
        if (isSafari) return;

        // Respect accessibility preference
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (prefersReducedMotion) return;

        const profilePhoto = document.querySelector('.profile-photo');
        // Guard against detached element — parentNode is needed for phantom insertion below
        if (!profilePhoto || !profilePhoto.parentNode) return;

        isEasterEggActive = true;

        // Get current position and size, accounting for potential hover scaling
        const rect = profilePhoto.getBoundingClientRect();
        const computedStyle = window.getComputedStyle(profilePhoto);
        const cssWidth = parseFloat(computedStyle.width);
        const isScaled = rect.width > cssWidth + 1;

        const originalWidth = isScaled ? cssWidth : rect.width;
        const originalHeight = isScaled ? cssWidth : rect.height;
        const offsetX = isScaled ? (rect.width - originalWidth) / 2 : 0;
        const offsetY = isScaled ? (rect.height - originalHeight) / 2 : 0;

        // Disable pointer events during animation
        profilePhoto.style.pointerEvents = 'none';

        // Create phantom div to hold space and prevent layout shift
        const phantom = document.createElement('div');
        phantom.id = 'photo-phantom';
        phantom.style.width = originalWidth + 'px';
        phantom.style.height = originalHeight + 'px';
        phantom.style.margin = computedStyle.margin;
        phantom.style.display = 'block';
        phantom.style.borderRadius = '50%';
        profilePhoto.parentNode.insertBefore(phantom, profilePhoto);

        // Convert to fixed positioning for animation
        profilePhoto.style.position = 'fixed';
        profilePhoto.style.left = (rect.left + offsetX) + 'px';
        profilePhoto.style.top = (rect.top + offsetY) + 'px';
        profilePhoto.style.zIndex = '10000';
        profilePhoto.style.margin = '0';
        profilePhoto.style.transform = 'scale(1)';

        // Animation stages: scale to 3x, then 5x
        const scales = [3, 5];
        let step = 0;

        // Single heartbeat: expand slightly, compress, return to base
        function singleBeat(baseScale, callback) {
            // Expand phase (12% larger)
            profilePhoto.style.transition = 'transform 0.08s cubic-bezier(0.4, 0, 0.2, 1)';
            profilePhoto.style.transform = 'scale(' + (baseScale * 1.12) + ')';

            setTimeout(function() {
                // Compress phase (3% smaller)
                profilePhoto.style.transition = 'transform 0.1s cubic-bezier(0.4, 0, 0.2, 1)';
                profilePhoto.style.transform = 'scale(' + (baseScale * 0.97) + ')';

                setTimeout(function() {
                    // Return to base
                    profilePhoto.style.transition = 'transform 0.15s ease-out';
                    profilePhoto.style.transform = 'scale(' + baseScale + ')';
                    setTimeout(callback, 180);
                }, 100);
            }, 80);
        }

        // Double heartbeat: two beats in quick succession (like "lub-dub")
        function doubleBeat(baseScale, callback) {
            singleBeat(baseScale, function() {
                setTimeout(function() {
                    singleBeat(baseScale, callback);
                }, 60);
            });
        }

        // Return photo to original position with spinning animation
        function resetPhoto() {
            const phantomEl = document.getElementById('photo-phantom');
            const phantomRect = phantomEl.getBoundingClientRect();

            // Animate back with 720-degree spin (two full rotations)
            profilePhoto.style.transition = 'left 0.8s cubic-bezier(0.4, 0, 0.2, 1), top 0.8s cubic-bezier(0.4, 0, 0.2, 1), transform 0.8s cubic-bezier(0.8, 0, 0.2, 1)';
            profilePhoto.style.left = phantomRect.left + 'px';
            profilePhoto.style.top = phantomRect.top + 'px';
            profilePhoto.style.transform = 'scale(1) rotate(-720deg)';

            setTimeout(function() {
                // Clean up
                phantomEl.remove();
                profilePhoto.style.position = '';
                profilePhoto.style.left = '';
                profilePhoto.style.top = '';
                profilePhoto.style.zIndex = '';
                profilePhoto.style.margin = '';
                profilePhoto.style.transition = '';
                profilePhoto.style.pointerEvents = '';
                isEasterEggActive = false;
            }, 800);
        }

        // Recursive: heartbeat at current size, then grow to next
        function doHeartbeatAndGrow() {
            const currentScale = step === 0 ? 1 : scales[step - 1];
            const targetScale = scales[step];

            doubleBeat(currentScale, function() {
                setTimeout(function() {
                    // Grow to next scale
                    profilePhoto.style.transition = 'transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
                    profilePhoto.style.transform = 'scale(' + targetScale + ')';

                    setTimeout(function() {
                        step++;
                        if (step < scales.length) {
                            doHeartbeatAndGrow();
                        } else {
                            // Final heartbeat at max size, then reset
                            doubleBeat(5, function() {
                                setTimeout(resetPhoto, 300);
                            });
                        }
                    }, 900);
                }, 200);
            });
        }

        // Start animation after short delay
        setTimeout(doHeartbeatAndGrow, 400);
    }

    /**
     * Handle double-tap detection for mobile
     * @param {TouchEvent} e - Touch event
     */
    function handleDoubleTap(e) {
        const currentTime = Date.now();
        const tapLength = currentTime - lastTap;

        if (tapLength < 300 && tapLength > 0) {
            e.preventDefault();
            triggerEasterEgg();
        }
        lastTap = currentTime;
    }

    /**
     * Start the hint animation loop
     * Periodically shows "press space" hint to encourage discovery
     * Only on desktop and non-Safari browsers
     */
    function startHintLoop() {
        if (window.innerWidth <= 768) return;
        if (isSafari) return;

        const footerHint = document.getElementById('footer-hint');
        if (!footerHint) return;

        function showHint() {
            if (document.hidden) {
                // 42 seconds - a quirky Douglas Adams reference
                setTimeout(showHint, 42000);
                return;
            }

            footerHint.classList.add('visible');

            setTimeout(function() {
                footerHint.classList.remove('visible');
                setTimeout(showHint, 42000);
            }, 3000);
        }

        // First hint after 42 seconds
        setTimeout(showHint, 42000);
    }

    /**
     * Spacebar trigger (only if not in input/textarea).
     * Named so it can be removed on pagehide — prevents listener accumulation
     * when the page is restored from bfcache.
     */
    function handleSpacebar(e) {
        if (e.key === ' ' && e.target === document.body) {
            e.preventDefault();
            triggerEasterEgg();
        }
    }

    function cleanup() {
        document.removeEventListener('keydown', handleSpacebar);
        window.removeEventListener('pagehide', cleanup);
    }

    /**
     * Initialize Easter egg module
     */
    function init() {
        const profilePhoto = document.querySelector('.profile-photo');
        if (!profilePhoto) return;

        // Double-click trigger (desktop)
        profilePhoto.addEventListener('dblclick', triggerEasterEgg);

        // Double-tap trigger (mobile)
        profilePhoto.addEventListener('touchend', handleDoubleTap);

        document.addEventListener('keydown', handleSpacebar);
        window.addEventListener('pagehide', cleanup);

        // Start hint loop and confetti timer
        startHintLoop();
        initConfettiTimer();
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Export for external use
    window.EasterEgg = {
        trigger: triggerEasterEgg,
        fireConfetti: function() {
            loadConfetti(fireConfetti);
        }
    };
})();
