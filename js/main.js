/**
 * Futuristic IT Theme - Main JavaScript
 */
function initTheme() {

    // FAQ Accordion
    var FAQ_CHEVRON_DOWN = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>';
    var FAQ_CHEVRON_UP = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"></polyline></svg>';
    var faqQuestions = document.querySelectorAll('.faq-question');
    for (var i = 0; i < faqQuestions.length; i++) {
        (function(question) {
            question.addEventListener('click', function() {
                var item = this.closest('.faq-item');
                var answer = item ? item.querySelector('.faq-answer') : null;
                var toggle = this.querySelector('.faq-toggle');
                var allItems = document.querySelectorAll('.faq-item');
                for (var j = 0; j < allItems.length; j++) {
                    if (allItems[j] !== item) {
                        allItems[j].classList.remove('active');
                        var otherAnswer = allItems[j].querySelector('.faq-answer');
                        if (otherAnswer) otherAnswer.style.display = 'none';
                        // Reset the chevron too, otherwise an item closed by this
                        // loop keeps the open-state arrow.
                        var otherToggle = allItems[j].querySelector('.faq-toggle');
                        if (otherToggle) otherToggle.innerHTML = FAQ_CHEVRON_DOWN;
                    }
                }
                item.classList.toggle('active');
                if (answer) answer.style.display = item.classList.contains('active') ? 'block' : 'none';
                if (toggle) {
                    toggle.innerHTML = item.classList.contains('active') ? FAQ_CHEVRON_UP : FAQ_CHEVRON_DOWN;
                }
            });
        })(faqQuestions[i]);
    }

    // Product Image Gallery
    window.changeImage = function(thumb) {
        var main = document.getElementById('mainProductImage');
        if (main) main.src = thumb.src;
        var thumbs = document.querySelectorAll('.product-thumbnail');
        for (var t = 0; t < thumbs.length; t++) thumbs[t].classList.remove('active');
        thumb.classList.add('active');
    };

    // Smooth Scroll
    var anchors = document.querySelectorAll('a[href^="#"]');
    for (var a = 0; a < anchors.length; a++) {
        anchors[a].addEventListener('click', function(e) {
            var id = this.getAttribute('href');
            if (id === '#' || id.length < 2) return;
            var el = document.querySelector(id);
            if (el) {
                e.preventDefault();
                var top = el.getBoundingClientRect().top + window.pageYOffset - 80;
                window.scrollTo({ top: top, behavior: 'smooth' });
            }
        });
    }

    // Product 3D Carousel
    var carousels = document.querySelectorAll('.product-3d-carousel');
    for (var c = 0; c < carousels.length; c++) {
        (function(wrapper) {
            var track = wrapper.querySelector('.product-3d-track');
            var cards = wrapper.querySelectorAll('.product-3d-card');
            var prevBtn = wrapper.querySelector('.carousel-arrow-prev');
            var nextBtn = wrapper.querySelector('.carousel-arrow-next');
            var toggleBtn = wrapper.querySelector('.carousel-toggle');
            var total = cards.length;
            var current = 1;
            var timer;
            var isPlaying = false;

            if (toggleBtn) toggleBtn.classList.add('paused');

            function updateSlide() {
                var isMobile = window.innerWidth <= 480;
                for (var i = 0; i < total; i++) {
                    var card = cards[i];
                    var offset = i - current;
                    if (offset > Math.floor(total / 2)) offset -= total;
                    if (offset < -Math.floor(total / 2)) offset += total;

                    card.classList.remove('pos-center', 'pos-left', 'pos-right', 'pos-hidden');

                    if (offset === 0) {
                        card.classList.add('pos-center');
                        card.style.transform = '';
                        card.style.opacity = '';
                        card.style.zIndex = '5';
                        card.style.pointerEvents = '';
                    } else if (offset === -1) {
                        card.classList.add('pos-left');
                        if (isMobile) {
                            card.style.transform = 'translateX(-100%)';
                            card.style.opacity = '0';
                        } else {
                            card.style.transform = 'translateX(-100%)';
                            card.style.opacity = '0.4';
                        }
                        card.style.zIndex = '2';
                        card.style.pointerEvents = 'none';
                    } else if (offset === 1) {
                        card.classList.add('pos-right');
                        if (isMobile) {
                            card.style.transform = 'translateX(100%)';
                            card.style.opacity = '0';
                        } else {
                            card.style.transform = 'translateX(100%)';
                            card.style.opacity = '0.4';
                        }
                        card.style.zIndex = '2';
                        card.style.pointerEvents = 'none';
                    } else {
                        card.classList.add('pos-hidden');
                        card.style.transform = 'translateX(' + (offset > 0 ? '200%' : '-200%') + ')';
                        card.style.opacity = '0';
                        card.style.zIndex = '0';
                        card.style.pointerEvents = 'none';
                    }
                }
            }

            function goNext() { current = (current + 1) % total; updateSlide(); }
            function goPrev() { current = (current - 1 + total) % total; updateSlide(); }

            function startTimer() {
                clearInterval(timer);
                timer = setInterval(goNext, 4000);
            }

            function stopTimer() { clearInterval(timer); }

            if (prevBtn) prevBtn.addEventListener('click', function() { goPrev(); if (isPlaying) startTimer(); });
            if (nextBtn) nextBtn.addEventListener('click', function() { goNext(); if (isPlaying) startTimer(); });

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    isPlaying = !isPlaying;
                    this.classList.toggle('paused', !isPlaying);
                    this.setAttribute('aria-label', isPlaying ? 'Pause carousel' : 'Play carousel');
                    if (isPlaying) startTimer(); else stopTimer();
                });
            }

            updateSlide();
            if (total > 1 && isPlaying) startTimer();
        })(carousels[c]);
    }

    // Header scroll
    window.addEventListener('scroll', function() {
        var header = document.querySelector('.site-header');
        if (header) {
            if ((window.pageYOffset || document.documentElement.scrollTop) > 100)
                header.classList.add('scrolled');
            else
                header.classList.remove('scrolled');
        }
    });

    // Scroll Animations
    if (typeof IntersectionObserver !== 'undefined') {
        var anims = document.querySelectorAll('[data-anim]');
        var observer = new IntersectionObserver(function(entries) {
            for (var e = 0; e < entries.length; e++) {
                if (entries[e].isIntersecting) {
                    var el = entries[e].target;
                    var d = parseInt(el.getAttribute('data-anim-delay')) || 0;
                    (function(el, d) {
                        setTimeout(function() {
                            el.style.transitionDuration = (el.getAttribute('data-anim-duration') || 600) + 'ms';
                            el.classList.add('anim-visible');
                        }, d);
                    })(el, d);
                    observer.unobserve(el);
                }
            }
        }, { threshold: 0.15 });
        for (var x = 0; x < anims.length; x++) {
            anims[x].classList.add('anim-hidden');
            observer.observe(anims[x]);
        }
    }

    // Contact Page - Searchable Select + Flatpickr + Course Name Toggle
    if (typeof jQuery !== 'undefined') {
        jQuery(document).ready(function($) {

            // Searchable Select
            $('.searchable-select').each(function() {
                var $wrapper = $(this);
                var $native = $wrapper.prev('select.hidden-select');
                var $trigger = $wrapper.find('.searchable-select-trigger');
                var $value = $wrapper.find('.searchable-select-value');
                var $dropdown = $wrapper.find('.searchable-select-dropdown');
                var $searchInput = $wrapper.find('.searchable-select-search-input');
                var $optionsContainer = $wrapper.find('.searchable-select-options');
                var placeholderText = $value.text();

                // Build options from native select
                $native.find('option').each(function() {
                    var val = $(this).val();
                    var text = $(this).text();
                    // Build via jQuery rather than string concatenation so a title
                    // containing quotes or angle brackets cannot break out of the
                    // attribute or inject markup.
                    var $opt = $('<div class="searchable-select-option"></div>')
                        .attr('data-value', val)
                        .text(text);
                    if (val === '') $opt.addClass('placeholder');
                    $optionsContainer.append($opt);
                });

                var $options = $optionsContainer.find('.searchable-select-option');

                function setSelected(val) {
                    $native.val(val).trigger('change');
                    $options.removeClass('selected');
                    if (val) {
                        $options.filter('[data-value="' + val + '"]').addClass('selected');
                        var text = $options.filter('.selected').text();
                        $value.text(text).removeClass('placeholder');
                    } else {
                        $value.text(placeholderText).addClass('placeholder');
                    }
                }

                function openDropdown() {
                    $wrapper.addClass('open');
                    $searchInput.val('').trigger('keyup');
                    setTimeout(function() { $searchInput.focus(); }, 50);
                }

                function closeDropdown() {
                    $wrapper.removeClass('open');
                }

                $trigger.on('click', function(e) {
                    e.stopPropagation();
                    if ($wrapper.hasClass('open')) {
                        closeDropdown();
                    } else {
                        $('.searchable-select').not($wrapper).removeClass('open');
                        openDropdown();
                    }
                });

                $options.on('click', function(e) {
                    e.stopPropagation();
                    var val = $(this).data('value');
                    setSelected(val);
                    closeDropdown();
                    $native[0].dispatchEvent(new Event('change', { bubbles: true }));
                });

                $searchInput.on('keyup', function() {
                    var query = $(this).val().toLowerCase();
                    var found = false;
                    $options.each(function() {
                        var text = $(this).text().toLowerCase();
                        if (text.indexOf(query) !== -1) {
                            $(this).show();
                            found = true;
                        } else {
                            $(this).hide();
                        }
                    });
                    $optionsContainer.find('.no-results').remove();
                    if (!found) {
                        $optionsContainer.append('<div class="searchable-select-option no-results">No results found</div>');
                    }
                });

                $searchInput.on('click', function(e) {
                    e.stopPropagation();
                });

                $(document).on('click', function() {
                    closeDropdown();
                });

                // Set initial value
                setSelected($native.val() || '');

                // Expose the setter so other handlers can reset this widget's
                // visible label when they clear the underlying native select.
                $wrapper.data('searchableSelect', { setSelected: setSelected });
            });

            // Course Name + Location + Mode Toggle
            var serviceSelect = document.getElementById('service');
            if (serviceSelect) {
                function toggleCourseName() {
                    var val = (serviceSelect.value || '').toLowerCase();
                    var courseGroup = document.getElementById('course-name-group');
                    var courseName = document.getElementById('course_name');
                    var courseNameWidget = jQuery('#course-name-select').data('searchableSelect');
                    var locationInput = document.getElementById('location');
                    var optBoxes = document.querySelectorAll('#course-name-group .course-opt-row input[type="checkbox"]');
                    if (val.indexOf('short course') !== -1 || val.indexOf('short-term') !== -1 || val.indexOf('training') !== -1 || val.indexOf('វគ្គបណ្ដុះបណ្ដាលខ្លី') !== -1 || val.indexOf('វគ្គខ្លី') !== -1 || val.indexOf('រយៈពេលខ្លី') !== -1) {
                        courseGroup.style.display = 'block';
                        // The native select is display:none, and a hidden empty
                        // control carrying `required` makes the browser refuse to
                        // submit with "An invalid form control is not focusable".
                        // Validation for it is handled by widgetFields instead.
                        courseName.setAttribute('data-required', '1');
                        if (locationInput) locationInput.setAttribute('required', 'required');
                    } else {
                        courseGroup.style.display = 'none';
                        courseName.removeAttribute('data-required');
                        courseName.value = '';
                        if (courseNameWidget) courseNameWidget.setSelected('');
                        if (locationInput) {
                            locationInput.removeAttribute('required');
                            locationInput.value = '';
                        }
                        // Restore each box to the default declared in the markup
                        // (all four start clear) so the hidden group never
                        // submits a stale selection.
                        for (var m = 0; m < optBoxes.length; m++) {
                            optBoxes[m].checked = optBoxes[m].defaultChecked;
                        }
                    }
                }
                serviceSelect.addEventListener('change', toggleCourseName);
                toggleCourseName();
            }

            // Service-gated Selects
            // The Licence and Customer Type fields each appear only for the
            // services ticked for them in their admin module. Which services
            // those are arrives as a data attribute on the group — a JSON array
            // of titles, because a field can be shown for more than one — so
            // nothing here has to know the titles in either language.
            function bindServiceGatedSelect(groupId, selectId, widgetSel) {
                var group = document.getElementById(groupId);
                var select = document.getElementById(selectId);
                if (!serviceSelect || !group || !select) return;

                // Parse once. A malformed or absent attribute yields [], which
                // means "never show" — the same as an empty list.
                var triggers = [];
                try {
                    var parsed = JSON.parse(group.getAttribute('data-service') || '[]');
                    if (Object.prototype.toString.call(parsed) === '[object Array]') {
                        triggers = parsed;
                    } else if (typeof parsed === 'string' && parsed !== '') {
                        // Tolerate a plain string, in case a cached page still
                        // carries the single-title format this replaced.
                        triggers = [parsed];
                    }
                } catch (e) {
                    var legacy = (group.getAttribute('data-service') || '').trim();
                    triggers = legacy === '' ? [] : [legacy];
                }

                function toggle() {
                    var val = (serviceSelect.value || '').trim();
                    var widget = jQuery(widgetSel).data('searchableSelect');
                    // No trigger configured: never show the field, rather than
                    // showing it for every service or for the empty selection.
                    // With no options saved the field would be unanswerable, and
                    // because it is required while visible that would block the
                    // form permanently — so only show it when there is actually
                    // something to choose.
                    var hasOptions = false;
                    for (var n = 0; n < select.options.length; n++) {
                        if (select.options[n].value !== '') { hasOptions = true; break; }
                    }
                    var matched = false;
                    for (var t = 0; t < triggers.length; t++) {
                        if (val !== '' && val === triggers[t]) { matched = true; break; }
                    }
                    if (hasOptions && matched) {
                        group.style.display = 'block';
                    } else {
                        group.style.display = 'none';
                        select.value = '';
                        if (widget) widget.setSelected('');
                    }
                }
                serviceSelect.addEventListener('change', toggle);
                toggle();
            }
            bindServiceGatedSelect('licence-group', 'licence', '#licence-select');
            bindServiceGatedSelect('customer-type-group', 'customer_type', '#customer-type-select');
        });
    }

}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initTheme);
} else {
    initTheme();
}
