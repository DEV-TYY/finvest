/**
 * Futuristic IT Theme - Customizer Repeater
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        initAll();
    });

    function initAll() {
        $(document).off('click', '.repeater-add').on('click', '.repeater-add', handleAdd);
        $(document).off('click', '.repeater-remove').on('click', '.repeater-remove', handleRemove);
        $(document).off('click', '.repeater-item-header').on('click', '.repeater-item-header', handleToggle);
        $(document).off('input', '.repeater-field').on('input', '.repeater-field', handleInput);
        $(document).off('click', '.repeater-upload-btn').on('click', '.repeater-upload-btn', handleUpload);
        $(document).off('click', '.repeater-remove-img').on('click', '.repeater-remove-img', handleRemoveImg);
    }

    function handleAdd(e) {
        e.preventDefault();
        var $wrap = $(this).closest('.futuristic-it-repeater-wrap');
        var settingId = $wrap.data('setting');
        var items = getItems($wrap);
        if (settingId === 'custom_product_cards') {
            items.push({ title: 'New Product', desc: '', price: '$999', link: '#', link_text: 'Learn More', image: '' });
        } else {
            items.push({ icon: '⚙️', title: 'New Service', desc: '', link: '#', link_text: 'Learn More', image: '' });
        }
        saveItems($wrap, settingId, items);
    }

    function handleRemove(e) {
        e.preventDefault();
        e.stopPropagation();
        if (!confirm('Remove this item?')) return;
        var $wrap = $(this).closest('.futuristic-it-repeater-wrap');
        var $item = $(this).closest('.repeater-item');
        var index = $item.data('index');
        var settingId = $wrap.data('setting');
        var items = getItems($wrap);
        items.splice(index, 1);
        saveItems($wrap, settingId, items);
    }

    function handleToggle(e) {
        if ($(e.target).hasClass('repeater-remove') || $(e.target).closest('.repeater-remove').length) return;
        $(this).closest('.repeater-item').toggleClass('expanded');
    }

    function handleInput(e) {
        var $wrap = $(this).closest('.futuristic-it-repeater-wrap');
        var $item = $(this).closest('.repeater-item');
        var index = $item.data('index');
        var field = $(this).data('field');
        var settingId = $wrap.data('setting');
        var items = getItems($wrap);
        if (items[index]) {
            items[index][field] = $(this).val();
            saveItems($wrap, settingId, items);
            if (field === 'title') {
                $item.find('.repeater-item-title').text($(this).val() || 'Item ' + (index + 1));
            }
        }
    }

    function handleUpload(e) {
        e.preventDefault();
        e.stopPropagation();
        var $btn = $(this);
        var $wrap = $btn.closest('.repeater-image-wrap');
        var $preview = $wrap.find('.repeater-image-preview');
        var $input = $wrap.find('.repeater-image-url');
        var $removeBtn = $wrap.find('.repeater-remove-img');

        var url = prompt('Enter image URL:', 'https://');
        if (url && url !== 'https://') {
            $input.val(url);
            $preview.attr('src', url).show();
            $removeBtn.show();

            var $item = $input.closest('.repeater-item');
            var $rWrap = $input.closest('.futuristic-it-repeater-wrap');
            var index = $item.data('index');
            var settingId = $rWrap.data('setting');
            var items = getItems($rWrap);
            if (items[index]) {
                items[index]['image'] = url;
                saveItems($rWrap, settingId, items);
            }
        }
    }

    function handleRemoveImg(e) {
        e.preventDefault();
        e.stopPropagation();
        var $wrap = $(this).closest('.repeater-image-wrap');
        var $preview = $wrap.find('.repeater-image-preview');
        var $input = $wrap.find('.repeater-image-url');
        var $item = $input.closest('.repeater-item');
        var $rWrap = $input.closest('.futuristic-it-repeater-wrap');
        var index = $item.data('index');
        var settingId = $rWrap.data('setting');

        $input.val('');
        $preview.attr('src', '').hide();
        $(this).hide();

        var items = getItems($rWrap);
        if (items[index]) {
            items[index]['image'] = '';
            saveItems($rWrap, settingId, items);
        }
    }

    function getItems($wrap) {
        var $input = $wrap.find('input[type="hidden"].repeater-data');
        try {
            var val = $input.val();
            if (!val || val === '[]' || val === 'null') return [];
            var parsed = JSON.parse(val);
            return Array.isArray(parsed) ? parsed : [];
        } catch (e) {
            return [];
        }
    }

    function saveItems($wrap, settingId, items) {
        var json = JSON.stringify(items);
        $wrap.find('input[type="hidden"].repeater-data').val(json);
        if (typeof wp !== 'undefined' && typeof wp.customize !== 'undefined' && wp.customize(settingId)) {
            wp.customize(settingId).set(json);
        }
        renderItems($wrap, items);
    }

    function renderItems($wrap, items) {
        var $container = $wrap.find('.repeater-items');
        $container.empty();

        if (items.length === 0) {
            $container.html('<p style="color:#666;font-style:italic;">No items yet. Click the add button.</p>');
            return;
        }

        var settingId = $wrap.data('setting');
        var isProduct = settingId === 'custom_product_cards';

        items.forEach(function(item, index) {
            var hasImg = item.image && item.image.length > 0;
            var h = '<div class="repeater-item" data-index="' + index + '">' +
                '<div class="repeater-item-header">' +
                    '<span class="repeater-item-title">' + escH(item.title || 'Item ' + (index + 1)) + '</span>' +
                    '<button type="button" class="repeater-remove" title="Remove">&times;</button>' +
                '</div>' +
                '<div class="repeater-item-body">';

            h += '<p><label>Image</label><span class="repeater-image-wrap">' +
                '<img class="repeater-image-preview" src="' + escA(item.image || '') + '" style="' + (hasImg ? '' : 'display:none;') + 'max-width:100px;height:auto;margin-bottom:5px;">' +
                '<br><button type="button" class="button button-secondary repeater-upload-btn">Choose Image</button> ' +
                '<button type="button" class="button button-link repeater-remove-img" style="' + (hasImg ? '' : 'display:none;') + '">Remove</button>' +
                '<input type="hidden" class="repeater-image-url" value="' + escA(item.image || '') + '">' +
                '</span></p>';

            if (isProduct) {
                h += '<p><label>Title</label><input type="text" class="widefat repeater-field" value="' + escA(item.title || '') + '" data-field="title"></p>' +
                    '<p><label>Description</label><textarea class="widefat repeater-field" rows="2" data-field="desc">' + escH(item.desc || '') + '</textarea></p>' +
                    '<p><label>Price</label><input type="text" class="widefat repeater-field" value="' + escA(item.price || '') + '" data-field="price" placeholder="$999"></p>' +
                    '<p><label>Link URL</label><input type="text" class="widefat repeater-field" value="' + escA(item.link || '') + '" data-field="link"></p>' +
                    '<p><label>Link Text</label><input type="text" class="widefat repeater-field" value="' + escA(item.link_text || 'Learn More') + '" data-field="link_text"></p>';
            } else {
                h += '<p><label>Icon (emoji)</label><input type="text" class="widefat repeater-field" value="' + escA(item.icon || '') + '" data-field="icon" placeholder="e.g., 💻"></p>' +
                    '<p><label>Title</label><input type="text" class="widefat repeater-field" value="' + escA(item.title || '') + '" data-field="title"></p>' +
                    '<p><label>Description</label><textarea class="widefat repeater-field" rows="2" data-field="desc">' + escH(item.desc || '') + '</textarea></p>' +
                    '<p><label>Link URL</label><input type="text" class="widefat repeater-field" value="' + escA(item.link || '') + '" data-field="link"></p>' +
                    '<p><label>Link Text</label><input type="text" class="widefat repeater-field" value="' + escA(item.link_text || 'Learn More') + '" data-field="link_text"></p>';
            }

            h += '</div></div>';
            $container.append(h);
        });
    }

    function escH(s) { return s ? s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;') : ''; }
    function escA(s) { return s ? s.replace(/&/g,'&amp;').replace(/"/g,'&quot;') : ''; }

})(jQuery);
