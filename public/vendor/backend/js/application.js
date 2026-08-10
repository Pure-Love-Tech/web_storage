(function($) {

    "use strict";

    document.querySelectorAll('[data-year]').forEach((el) => {
        el.textContent = " " + new Date().getFullYear();
    });

    let dropdown = document.querySelectorAll('[data-dropdown]'),
        dropdownv2 = document.querySelectorAll('[data-dropdown-v2]'),
        itemHeight = 45;

    if (dropdown !== null) {
        dropdown.forEach((el) => {
            let dropdownFunc = () => {
                let sideBarLinksMenu = el.querySelector('.vironeer-sidebar-link-menu');
                if (el.classList.contains('active')) {
                    sideBarLinksMenu.style.height = sideBarLinksMenu.children.length * itemHeight + 'px';
                } else {
                    sideBarLinksMenu.style.height = 0;
                }
            };

            el.querySelector('.vironeer-sidebar-link-title').onclick = () => {
                el.classList.toggle('active');
                dropdownFunc();
            };
            window.addEventListener('load', dropdownFunc);
        });
    }

    if (dropdownv2 !== null) {
        dropdownv2.forEach(function(el) {
            window.addEventListener('click', function(e) {
                if (el.contains(e.target)) {
                    el.classList.toggle('active');
                    setTimeout(function() {
                        el.classList.toggle('animated');
                    }, 0);
                } else {
                    el.classList.remove('active');
                    el.classList.remove('animated');
                }
            });
        });
    }

    let counterCards = document.querySelectorAll('.counter-card');
    let dashCountersOP = () => {
        counterCards.forEach((el) => {
            let itemWidth = 350,
                clientWidthX = el.clientWidth;
            if (clientWidthX > itemWidth) {
                el.classList.remove('active');
            } else {
                el.classList.add('active');
            }
        });
    };

    window.addEventListener('load', dashCountersOP);
    window.addEventListener('resize', dashCountersOP);

    let sideBar = document.querySelector('.vironeer-sidebar'),
        pageContent = document.querySelector('.vironeer-page-content'),
        sideBarIcon = document.querySelector('.vironeer-sibebar-icon');
    if (sideBar !== null) {
        sideBarIcon.onclick = () => {
            sideBar.classList.toggle('active');
            pageContent.classList.toggle('active');
            setTimeout(dashCountersOP, 150);

        };
        sideBar.querySelector('.overlay').onclick = () => {
            sideBar.classList.remove('active');
            pageContent.classList.remove('active');
        };
        window.addEventListener('resize', () => {
            if (window.innerWidth < 1200) {
                sideBar.classList.remove('active');
                pageContent.classList.remove('active');
            }
        });
    }

    let sidebarLinkCounter = document.querySelectorAll(".vironeer-sidebar-link-title .counter");
    if (sidebarLinkCounter) {
        sidebarLinkCounter.forEach((el) => {
            if (el.innerHTML == 0) {
                el.classList.add("disabled");
            }
        });
    }

    let navbarLinkCounter = document.querySelectorAll(".vironeer-notifications-title .counter");
    if (navbarLinkCounter) {
        navbarLinkCounter.forEach((el) => {
            if (el.innerHTML == 0) {
                el.classList.add("disabled");
            } else {
                el.classList.add("flashit");
            }
        });
    }

    let datatable = $('#datatable'),
        askDatatable = $('.ask-datatable'),
        unsortDatatable = $('.unsort-datatable'),
        datatableConfig = {
            "language": {
                searchPlaceholder: "Start typing to search...",
                search: "",
                sLengthMenu: "Rows per page _MENU_",
                info: "Showing page _PAGE_ of _PAGES_",
            },
            "dom": '<"top"f><"table-wrapper"rt><"bottom"ilp><"clear">',
            drawCallback: function() {
                document.querySelector('.dataTables_wrapper .pagination').classList.add('pagination-sm');
                $('.dataTables_filter input').attr('type', 'text');
            }
        }
    if (datatable.length) {
        datatable.DataTable($.extend({}, datatableConfig, {
            "pageLength": 50,
            order: [
                [0, "desc"]
            ],
        }));
    }

    if (askDatatable.length) {
        askDatatable.DataTable($.extend({}, datatableConfig, {
            "pageLength": 50,
        }));
    }

    if (unsortDatatable.length) {
        unsortDatatable.DataTable($.extend({}, datatableConfig, {
            "pageLength": 50,
            order: [],
        }));
    }



    let ckEditors = document.querySelectorAll('.ckeditor');
    if (ckEditors.length > 0) {
        function UploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new UploadAdapter(loader);
            };
        }
        for (let i = 0; i < ckEditors.length; i++) {
            ClassicEditor.create(ckEditors[i], {
                extraPlugins: [UploadAdapterPlugin],
            }).catch(error => {
                alert(error);
            });
        }
    }



    let selectFileBtn = $('#selectFileBtn'),
        selectedFileInput = $("#selectedFileInput"),
        filePreviewBox = $('.file-preview-box'),
        filePreviewImg = $('#filePreview');

    selectFileBtn.on('click', function() {
        selectedFileInput.trigger('click');
    });

    selectedFileInput.on('change', function() {
        var file = true,
            readLogoURL;
        if (file) {
            readLogoURL = function(input_file) {
                if (input_file.files && input_file.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        filePreviewBox.removeClass('d-none');
                        filePreviewImg.attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input_file.files[0]);
                }
            }
        }
        readLogoURL(this);
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let createSlug = $("#create_slug"),
        showSlug = $('#show_slug');

    createSlug.on('input', function() {
        $.ajax({
            type: 'GET',
            url: GET_SLUG_URL,
            data: {
                content: $(this).val(),
            },
            success: function(data) {
                showSlug.val(data.slug);
            }
        });
    });

    let articleLang = $('#articleLang'),
        articleCategory = $('#articleCategory');

    articleLang.on('change', function() {
        const langCode = $(this).val();
        if (langCode) {
            $.ajax({
                url: config.url + '/blog/articles/categories/' + langCode,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if ($.isEmptyObject(data.info)) {
                        articleCategory.empty();
                        $.each(data, function(key, value) {
                            articleCategory.append('<option value="' + key + '">' + value + '</option>');
                        });
                    } else {
                        articleCategory.empty();
                        articleCategory.append('<option value="" selected disabled>Choose</option>');
                        toastr.info(data.info);
                    }
                }
            });
        } else {
            articleCategory.empty();
        }
    });


    let ableToDeleteBtn = $('.vironeer-able-to-delete');
    ableToDeleteBtn.on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'question',
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: config.colors.primary_color,
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).parents('form')[0].submit();
            }
        })
    });

    let confirmFormBtn = $('.vironeer-form-confirm');
    confirmFormBtn.on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want do this action?",
            icon: 'question',
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: config.colors.primary_color,
            confirmButtonText: 'Yes, Do it!',
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).parents('form')[0].submit();
            }
        })
    });

    let confirmActionLink = $('.vironeer-link-confirm');
    confirmActionLink.on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want do this action?",
            icon: 'question',
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: config.colors.primary_color,
            confirmButtonText: 'Yes, Do it!',
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = $(this).attr('href');
            }
        })
    });

    let actionConfirm = $('.action-confirm');
    if (actionConfirm.length) {
        actionConfirm.on('click', function(e) {
            if (!confirm('Are you sure?')) {
                e.preventDefault();
            }
        });
    }


    let attachImageButton = $('.attach-image-button');
    attachImageButton.on('click', function() {
        var dataId = $(this).data('id');
        let targetedImageInput = $('#attach-image-targeted-input-' + dataId),
            targetedImagePreview = $('#attach-image-preview-' + dataId);
        targetedImageInput.trigger('click');
        targetedImageInput.on('change', function() {
            var file = true,
                readLogoURL;
            if (file) {
                readLogoURL = function(input_file) {
                    if (input_file.files && input_file.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            targetedImagePreview.attr('src', e.target.result);
                        }
                        reader.readAsDataURL(input_file.files[0]);
                    }
                }
            }
            readLogoURL(this);
        });
    });

    let imageInput = $('.image-input');
    imageInput.on('change', function() {
        var dataId = $(this).data('id');
        let imagePreview = $('#image-preview-' + dataId);
        var file = true,
            readLogoURL;
        if (file) {
            readLogoURL = function(input_file) {
                if (input_file.files && input_file.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input_file.files[0]);
                }
            }
        }
        readLogoURL(this);
    });


    let select2 = $(".select2");
    if (select2.length) {
        select2.select2({
            theme: "bootstrap-5",
            placeholder: "Choose",
        });
    }

    let selectpicker = $('.selectpicker');
    if (selectpicker.length) {
        selectpicker.selectpicker();
    }


    let removeSpaces = $(".remove-spaces");
    removeSpaces.on('input', function() {
        $(this).val($(this).val().replace(/\s/g, ""));
    });

    var cssEditor = document.getElementById("css-editor");
    if (cssEditor) {
        var editor = CodeMirror.fromTextArea(cssEditor, {
            lineNumbers: true,
            mode: "text/css",
            theme: "monokai",
            keyMap: "sublime",
            autoCloseBrackets: true,
            matchBrackets: true,
            showCursorWhenSelecting: true,
        });
        editor.setSize(null, 700);
    }

    let htmlEditor = document.getElementById("html-editor");
    if (htmlEditor) {
        var editor = CodeMirror.fromTextArea(htmlEditor, {
            lineNumbers: true,
            mode: "htmlmixed",
            theme: "monokai",
            keyMap: "sublime",
            autoCloseBrackets: true,
            matchBrackets: true,
            showCursorWhenSelecting: true,
        });
        editor.setSize(null, 400);
    }

    let logsBtn = $('.vironeer-getlog-btn'),
        logModal = $('#logModal');

    logsBtn.on('click', function(e) {
        e.preventDefault();
        const userID = $(this).data('user');
        const logID = $(this).data('log');
        $.ajax({
            url: config.url + '/users/' + userID + '/edit/logs/get/' + logID,
            type: 'get',
            dataType: "JSON",
            success: function(response) {
                if ($.isEmptyObject(response.error)) {
                    $('#ip').attr('href', response.ip_link).html(response.ip);
                    $('#location').html(response.location);
                    $('#timezone').html(response.timezone);
                    $('#latitude').html(response.latitude);
                    $('#longitude').html(response.longitude);
                    $('#browser').html(response.browser);
                    $('#os').html(response.os);
                    logModal.modal('show');
                } else {
                    toastr.error(response.error);
                }
            },
        });
    });

    let changeUserAvatarInput = $('.vironeer-user-avatar'),
        changeUserAvatarForm = $('#changeUserAvatarForm'),
        changeUserAvatarError = $('.image-error-icon');

    changeUserAvatarInput.on('change', function(e) {
        e.preventDefault();
        const fileExtension = ['jpeg', 'jpg', 'png'];
        const userId = $(this).data('id');
        const formData = new FormData($(this).parents('form')[0]);
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            toastr.error('File type not allowed');
        } else {
            $.ajax({
                url: config.url + '/users/' + userId + '/edit/change/avatar',
                type: 'POST',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if ($.isEmptyObject(response.error)) {
                        changeUserAvatarError.addClass('d-none');
                        changeUserAvatarForm.trigger("reset");
                        toastr.success(response.success);
                    } else {
                        changeUserAvatarError.removeClass('d-none');
                        changeUserAvatarForm.trigger("reset");
                        toastr.error(response.error);
                    }
                },
            });
        }
    });

    let input2Fa = $('#2faCheckbox');
    input2Fa.on('change', function() {
        if ($(this).is(':checked')) {
            Swal.fire({
                icon: "info",
                title: "Be careful",
                text: "If the user does not scan the QR code or have a code already it can't access to his account",
                confirmButtonColor: config.colors.primary_color,
                confirmButtonText: 'Ok, Get it',
            });
        }
    });

    let vironeerTargetMenu = $('.vironeer-sort-menu'),
        nestable = $('.nestable'),
        idsInput = $('#ids');

    if (vironeerTargetMenu.length) {
        vironeerTargetMenu.sortable({
            handle: '.vironeer-navigation-handle',
            placeholder: 'vironeer-navigation-placeholder',
            axis: "y",
            update: function() {
                const vironeerSortData = vironeerTargetMenu.sortable('toArray', {
                    attribute: 'data-id'
                })
                idsInput.attr('value', vironeerSortData.join(','));
            }
        });
    }

    let colorpicker = $('.colorpicker');
    if (colorpicker.length) {
        Coloris({ el: '.coloris' });
        Coloris.setInstance('.coloris', {
            theme: 'pill',
            themeMode: 'light',
            formatToggle: true,
            closeButton: true,
            clearButton: true,
            swatches: ['#067bc2', '#84bcda', '#80e377', '#ecc30b', '#f37748', '#d56062']
        });
    }

    if (nestable.length) {
        nestable.nestable({ maxDepth: 2 });
        nestable.on('change', function() {
            var data = JSON.stringify(nestable.nestable('serialize'));
            idsInput.attr('value', data);
        });
    }

    let commentView = $('.vironeer-view-comment'),
        viewCommentModal = $('#viewComment'),
        deleteCommentForm = $('#deleteCommentForm'),
        publishCommentForm = $('#publishCommentForm'),
        publishCommentBtn = $('.publish-comment-btn'),
        commentInput = $('#comment');
    commentView.on('click', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        $.ajax({
            url: config.url + '/blog/comments/' + id + '/view',
            type: 'GET',
            dataType: 'JSON',
            success: function(response) {
                if ($.isEmptyObject(response.error)) {
                    commentInput.val(response.comment);
                    deleteCommentForm.attr('action', response.delete_link);
                    if (response.status === 1) {
                        publishCommentBtn.addClass('disabled');
                    } else {
                        publishCommentBtn.removeClass('disabled');
                        publishCommentForm.attr('action', response.publish_link);
                    }
                    viewCommentModal.modal('show');
                } else {
                    toastr.error(response.error);
                }
            },
        });
    });

    let inputNumeric = document.querySelectorAll('.input-numeric');
    if (inputNumeric) {
        inputNumeric.forEach((el) => {
            el.oninput = () => {
                el.value = el.value.replace(/[^0-9]/g, '').substr(0, 6);
            };
        });
    }

    let clipboardBtn = document.querySelector("#copy-btn");
    if (clipboardBtn) {
        let clipboard = new ClipboardJS(clipboardBtn);
        clipboard.on('success', function(e) {
            toastr.success('Copied to clipboard');
        });
    }

    let inputPrice = $('.input-price');
    if (inputPrice.length) {
        inputPrice.priceFormat({
            prefix: '',
            thousandsSeparator: '',
            clearOnEmpty: true
        });
    }

    let optionCheckbox = $('.option-checkbox'),
        optionCheckbox2 = $('.option-checkbox2');;
    optionCheckbox.on('change', function() {
        var optionId = $(this).data('id');
        if ($(this).is(':checked')) {
            $('.option-' + optionId).removeClass('d-none');
        } else {
            $('.option-' + optionId).addClass('d-none');
        }
    });
    optionCheckbox2.on('change', function() {
        var optionId = $(this).data('id');
        if ($(this).is(':checked')) {
            $('.option-' + optionId).addClass('d-none');
        } else {
            $('.option-' + optionId).removeClass('d-none');
        }
    });

    let multipleSelectSearchForm = $('.multiple-select-search-form'),
        multipleSelectDeleteForm = $('.multiple-select-delete-form'),
        multipleSelectDeleteIds = $('.multiple-select-delete-ids'),
        multipleSelectCheckAll = $('.multiple-select-check-all'),
        multipleSelectCheckbox = $('.multiple-select-checkbox');
    if (multipleSelectCheckAll.length) {
        var multipleSelectDeleteIdsArr = [];
        multipleSelectCheckAll.on('click', function() {
            if ($(this).is(':checked', true)) {
                multipleSelectCheckbox.prop('checked', true);
                multipleSelectPushDeleteIds();
                multipleSelectSearchForm.addClass('d-none');
                multipleSelectDeleteForm.removeClass('d-none');
            } else {
                multipleSelectRemoveDeleteIds();
                multipleSelectCheckbox.prop('checked', false);
                multipleSelectSearchForm.removeClass('d-none');
                multipleSelectDeleteForm.addClass('d-none');
            }
        });
        multipleSelectCheckbox.on('click', function() {
            multipleSelectPushDeleteIds()
            if ($('.multiple-select-checkbox:checked').length == multipleSelectCheckbox.length) {
                multipleSelectCheckAll.prop('checked', true);
            } else {
                multipleSelectCheckAll.prop('checked', false);
            }
            if ($(this).is(':checked', true)) {
                multipleSelectSearchForm.addClass('d-none');
                multipleSelectDeleteForm.removeClass('d-none');
            } else {
                if ($('.multiple-select-checkbox:checked').length == 0) {
                    multipleSelectSearchForm.removeClass('d-none');
                    multipleSelectDeleteForm.addClass('d-none');
                }
            }
        });
        let multipleSelectPushDeleteIds = () => {
            multipleSelectDeleteIdsArr = [];
            $(".multiple-select-checkbox:checked").each(function() {
                multipleSelectDeleteIdsArr.push($(this).attr('data-id'));
            });
            multipleSelectDeleteIds.val(multipleSelectDeleteIdsArr);
        }
        let multipleSelectRemoveDeleteIds = () => {
            multipleSelectDeleteIdsArr = [];
            multipleSelectDeleteIds.val(multipleSelectDeleteIdsArr);
        }
    }

    let periodSelect = $('#period-select');
    periodSelect.on('change', function() {
        location.href = $(this).val();
    });

    let tableResponsive = $('.table-responsive');
    tableResponsive.on('show.bs.dropdown', function() {
        tableResponsive.css("overflow", "inherit");
    });
    tableResponsive.on('hide.bs.dropdown', function() {
        tableResponsive.css("overflow", "auto");
    });

    let addonStatus = $('#addonStatus');
    addonStatus.on('change', function() {
        let updateLink = $(this).data('update-link'),
            status = $(this).is(':checked') ? 1 : 0;
        $.ajax({
            url: updateLink,
            type: "POST",
            data: { status: status },
            dataType: "JSON",
            success: function(response) {
                if (!$.isEmptyObject(response.error)) {
                    toastr.error(response.error);
                }
            },
            error: function(request, status, error) {
                toastr.error(error);
            }
        });
    });

})(jQuery);