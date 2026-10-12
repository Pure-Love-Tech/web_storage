(function($) {
    "use strict";

    document.querySelectorAll('[data-year]').forEach(function(el) {
        el.textContent = new Date().getFullYear();
    });

    let inputNumeric = document.querySelectorAll('.input-numeric');
    if (inputNumeric) {
        inputNumeric.forEach((el) => {
            el.oninput = () => {
                el.value = el.value.replace(/[^0-9]/g, '').substr(0, 6);
            };
        });
    }

    window.copy = () => {
        let clipboardBtn = document.querySelectorAll(".btn-copy");
        if (clipboardBtn) {
            clipboardBtn.forEach((el) => {
                let clipboard = new ClipboardJS(el);
                clipboard.on("success", () => {
                    toastr.success(config.translates.copied);
                });
            });
        }
    }

    window.copy();

    let actionConfirm = $('.action-confirm');
    if (actionConfirm.length) {
        actionConfirm.on('click', function(e) {
            if (!confirm(config.translates.actionConfirm)) {
                e.preventDefault();
            }
        });
    }

    if (window.location.hash === "#_=_") {
        if (history.replaceState) {
            var cleanHref = window.location.href.split("#")[0];
            history.replaceState(null, null, cleanHref);
        } else {
            window.location.hash = "";
        }
    }

    if ($('[data-aos]').length > 0) {
        AOS.init({ once: true });
    }

    var dropdown = document.querySelectorAll('[data-dropdown]');
    if (dropdown) {
        dropdown.forEach(function(el) {
            let dropdownMenu = el.querySelector(".drop-down-menu");

            function dropdownOP() {
                if (el.getBoundingClientRect().top + dropdownMenu.offsetHeight > window.innerHeight - 60 && el.getAttribute("data-dropdown-position") !== "top") {
                    dropdownMenu.style.top = "auto";
                    dropdownMenu.style.bottom = "40px";
                } else {
                    dropdownMenu.style.top = "40px";
                    dropdownMenu.style.bottom = "auto";
                }
            }
            window.addEventListener("click", function(e) {
                if (el.contains(e.target)) {
                    el.classList.toggle('active');
                    setTimeout(function() {
                        el.classList.toggle('animated');
                    }, 0);
                } else {
                    el.classList.remove('active');
                    el.classList.remove('animated');
                }
                dropdownOP();
            });
            window.addEventListener("resize", dropdownOP);
            window.addEventListener("scroll", dropdownOP);
        });
    }


    var toggle = document.querySelectorAll('[data-toggle]');
    if (toggle) {
        toggle.forEach(function(el, id) {
            el.querySelector(".toggle-title").onclick = () => {
                for (var i = 0; i < toggle.length; i++) {
                    if (i !== id) {
                        toggle[i].classList.remove("active");
                        toggle[i].classList.remove("animated");
                    }
                }
                if (el.classList.contains("active")) {
                    el.classList.remove("active");
                    el.classList.remove("animated");
                } else {
                    el.classList.add("active");
                    setTimeout(function() {
                        el.classList.add("animated");
                    }, 0);
                }
            };
        });
    }

    let getCookie = (cname) => {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    let setCookie = (cName, cValue, expDays) => {
        let date = new Date();
        date.setTime(date.getTime() + (expDays * 24 * 60 * 60 * 1000));
        const expires = "expires=" + date.toUTCString();
        document.cookie = cName + "=" + cValue + "; " + expires + "; path=/";
    }

    let annoBtn = document.querySelector(".announcements-menu-btn");
    if (annoBtn) {
        let annoCounter = annoBtn.querySelector(".announcements-menu-counter"),
            annoCounterContext = parseInt(annoCounter.textContent);
        annoBtn.onclick = () => {
            annoCounter.classList.add("d-none");
            setCookie('anno', annoCounterContext, 365);
        };
        if (getCookie("anno") >= annoCounterContext) {
            annoCounter.classList.add("d-none");
            setCookie('anno', getCookie("anno"), 365);
        }
    }

    let password = document.querySelectorAll(".input-password");
    if (password) {
        password.forEach((el) => {
            let passwordBtn = el.querySelector("button"),
                passwordInput = el.querySelector("input");
            passwordBtn.onclick = (e) => {
                e.preventDefault();
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    passwordBtn.innerHTML = `<i class="fas fa-eye-slash"></i>`;
                } else {
                    passwordInput.type = "password";
                    passwordBtn.innerHTML = `<i class="fas fa-eye"></i>`;
                }
            };
        });
    }

    let navbar = document.querySelector(".nav-bar");
    if (navbar) {
        let navbarOp = () => {
            if (window.scrollY > 0) {
                navbar.classList.add("scrolling");
            } else {
                navbar.classList.remove("scrolling");
            }
        };
        window.addEventListener("scroll", navbarOp);
        window.addEventListener("load", navbarOp);
    }

    let navbarMenu = document.querySelector(".nav-bar-menu"),
        navbarMenuBtn = document.querySelector(".nav-bar-menu-btn");
    if (navbarMenu) {
        let navbarMenuClose = navbarMenu.querySelector(".nav-bar-menu-close"),
            navbarMenuOverlay = navbarMenu.querySelector(".overlay"),
            navUploadBtn = document.querySelector(".nav-bar-menu [data-upload-btn]");
        if (navbarMenuBtn) {
            navbarMenuBtn.onclick = () => {
                navbarMenu.classList.add("show");
                document.body.classList.add("overflow-hidden");
            };
        }
        if (navbarMenuClose) {
            navbarMenuClose.onclick = navbarMenuOverlay.onclick = () => {
                navbarMenu.classList.remove("show");
                document.body.classList.remove("overflow-hidden");
            };
        }
        if (navUploadBtn) {
            navUploadBtn.addEventListener("click", () => {
                navbarMenu.classList.remove("show");
            });
        }
    }


    var swiperBrands = document.querySelector(".swiper-brands");
    if (swiperBrands) {
        const swiper = new Swiper(swiperBrands, {
            slidesPerView: 1,
            spaceBetween: 16,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                450: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 3,
                },
                1200: {
                    slidesPerView: 4,
                },
                1300: {
                    slidesPerView: 5,
                }
            },
        });

        const swiperOP = () => {
            if (!swiper.allowSlideNext && !swiper.allowSlidePrev) {
                swiper.el.parentElement.classList.add("p-0");
                swiper.el.parentElement.querySelector(".swiper-actions").classList.add("d-none");
                swiper.el.querySelector(".swiper-wrapper").classList.add("justify-content-center");
            } else {
                swiper.el.parentElement.classList.remove("p-0");
                swiper.el.parentElement.querySelector(".swiper-actions").classList.remove("d-none");
                swiper.el.querySelector(".swiper-wrapper").classList.remove("justify-content-center");
            }
        };

        window.addEventListener("load", swiperOP);
        window.addEventListener("resize", swiperOP);
    }

    let preloader = document.querySelector(".preloader");
    if (preloader) {
        window.addEventListener("load", () => {
            preloader.classList.add("d-none");
        });
    }

    let sidebarBtn = document.querySelector(".dash-sidebar-btn");
    if (sidebarBtn) {
        window.addEventListener("click", (e) => {
            if (e.target.closest(".nav-bar-menu-btn")) {
                document.querySelector(".dash").classList.remove("toggle");
            }
        });

        sidebarBtn.onclick = () => {
            document.querySelector(".dash").classList.toggle("toggle");
        };
        document.querySelector(".dash-sidebar .overlay").onclick = (e) => {
            document.querySelector(".dash").classList.remove("toggle");
        };
        window.addEventListener("resize", () => {
            document.querySelector(".dash").classList.remove("toggle");
        });
    }

    let links = document.querySelectorAll('[data-link]');
    if (links) {
        links.forEach((el) => {
            el.onclick = (e) => {
                e.preventDefault();
                var scrollTarget = document.querySelector(el.getAttribute('data-link')).offsetTop - 120;
                window.scrollTo('0', scrollTarget);
                navbarMenu.classList.remove("show");
                document.body.classList.remove("overflow-hidden");
            };
        });
    }

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    let cookies = document.querySelector('.cookies');
    if (cookies) {
        window.addEventListener('load', () => {
            setTimeout(() => {
                cookies.classList.add('show');
            }, 1000);
        });
    }

    let acceptCookie = $('#acceptCookie'),
        cookieDiv = $('.cookies');
    acceptCookie.on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: config.url + '/cookie/accept',
            type: 'get',
            dataType: "JSON",
            success: function(response) {
                if ($.isEmptyObject(response.error)) {
                    cookieDiv.remove();
                }
            },
        });
    });

    let loadModalBtn = document.querySelector('#loadModalBtn');
    if (loadModalBtn) {
        window.addEventListener('load', () => {
            setTimeout(() => {
                loadModalBtn.click();
                loadModalBtn.remove();
            }, 1000);
        });
        document.querySelector('#load-modal .btn-close').onclick = () => {
            $.ajax({
                url: config.url + '/popup/close',
                type: 'get',
                dataType: "JSON",
                success: function() {
                    $('load-modal').remove();
                },
            });
        };
    }

    let SelectImageButton = $('.select-image-button');
    SelectImageButton.on('click', function() {
        var dataId = $(this).data('id');
        let targetedImageInput = $('#image-targeted-input-' + dataId),
            targetedImagePreview = $('#preview-img-' + dataId);
        targetedImageInput.trigger('click');
        targetedImageInput.on('change', function() {
            var file = true,
                readImageURL;
            if (file) {
                readImageURL = function(input_file) {
                    if (input_file.files && input_file.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            targetedImagePreview.attr('src', e.target.result);
                        }
                        reader.readAsDataURL(input_file.files[0]);
                    }
                }
            }
            readImageURL(this);
        });
    });

    let uploadBox = $('.uploadbox'),
        uploadBoxBtn = $('[data-upload-btn]');

    if (uploadBox.length) {
        console.log('=== DIRECT R2 APP.JS LOADED ===');
        let maxFiles = parseInt(uploadConfig.upload.max_files);

        /*
        |--------------------------------------------------------------------------
        | Direct R2 Upload State
        |--------------------------------------------------------------------------
        */

        const DIRECT_FILE_CONCURRENCY = 3;
        const DIRECT_PART_CONCURRENCY = 2;
        const DIRECT_PART_RETRIES = 3;

        let directUploadingCount = 0;

        /*
         * Menyimpan state upload berdasarkan object File Dropzone.
         */
        let directUploadStates = new Map();

        uploadBoxBtn.on('click', function() {
            uploadBox.addClass('active');
            $('body').addClass("overflow-hidden");
        });

        uploadBox.find('.btn-close').on('click', function () {

            if (
                dropzone.getQueuedFiles().length > 0 ||
                dropzone.getUploadingFiles().length > 0 ||
                directUploadingCount > 0
            ) {

                let removeConfirm = confirm(
                    uploadConfig.trans.close_alert_msg
                );

                if (removeConfirm) {

                    dropzone.removeAllFiles(true);

                    uploadBox.removeClass("active");

                    $('body').removeClass(
                        "overflow-hidden"
                    );
                }

            } else {

                dropzone.removeAllFiles(true);

                uploadBox.removeClass("active");

                $('body').removeClass(
                    "overflow-hidden"
                );
            }
        });


        let UploadUrl = config.url + '/upload';
        let previewNode = $('#upload-previews');
        previewNode.attr('id', '');
        let previewTemplate = previewNode.html();
        previewNode.remove();

        var dropzoneConfig = Object.assign({}, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: UploadUrl,
            method: "POST",
            paramName: 'file',
            filesizeBase: 1024,
            parallelUploads: parseInt(uploadConfig.upload.max_files),
            maxFiles: maxFiles,
            maxFilesize: parseInt(uploadConfig.upload.max_file_size),
            acceptedFiles: uploadConfig.upload.allowed_file_types,
            autoProcessQueue: false,
            timeout: 0,
            chunking: true,
            forceChunking: true,
            chunkSize: parseInt(uploadConfig.upload.chunk_size),
            retryChunks: true,
            clickable: "[data-dz-click]",
            previewsContainer: "#dropzone",
            previewTemplate: previewTemplate,
        }, dropzoneOptions);

        Dropzone.autoDiscover = false;
        var dropzone = new Dropzone(".uploadbox-body", dropzoneConfig);


        let uploadMoreBtn = $('.upload-more-btn'),
            uploadboxWrapperForm = $('.uploadbox-wrapper-form'),
            submitBtn = $("#upload-files-btn");

        submitBtn.on('click', async function (e) {

            e.preventDefault();


            if (
                dropzone.files.length > 0
            ) {

                /*
                 * Jangan double click upload.
                 */
                if (
                    directUploadingCount > 0
                ) {
                    return;
                }


                submitBtn.prop(
                    'disabled',
                    true
                );


                uploadboxWrapperForm.addClass(
                    'd-none'
                );


                uploadMoreBtn.addClass(
                    'd-none'
                );


                /*
                 * PENTING:
                 *
                 * Tidak lagi:
                 *
                 * dropzone.processQueue();
                 *
                 * File sekarang masuk direct uploader.
                 */
                await startDirectUploads();


            } else {

                toastr.error(
                    uploadConfig.trans.errors.empty
                );
            }
        });

        let resetUploadBox = $('[data-dz-reset]');
        resetUploadBox.on('click', function() {
            dropzone.removeAllFiles(true);
            $(".dz-processing-overlay").removeClass("active");

        });


        function uploadBoxDrag() {
            let uploadboxDrag = $('.uploadbox-drag'),
                uploadboxWrapper = $('.uploadbox-wrapper');
            if (dropzone.files.length > 0) {
                uploadboxDrag.addClass("inactive");
                uploadboxWrapper.addClass("active");
                $('body').addClass("overflow-hidden");
                resetUploadBox.removeClass("d-none");
                uploadBox.addClass("active");
                if (dropzone.files.length == maxFiles) {
                    uploadMoreBtn.addClass('d-none');
                } else {
                    uploadMoreBtn.removeClass('d-none');
                }
            } else {
                uploadboxDrag.removeClass("inactive");
                uploadboxWrapper.removeClass("active");
                resetUploadBox.addClass("d-none");
                submitBtn.prop('disabled', false);
                uploadboxWrapperForm.removeClass('d-none');
                uploadMoreBtn.addClass('d-none');
            }
        }

        /*
|--------------------------------------------------------------------------
| DIRECT R2 UPLOAD HELPERS
|--------------------------------------------------------------------------
*/


        /**
         * Request kecil dari browser ke Laravel.
         *
         * Ini hanya mengirim metadata.
         * Tidak pernah mengirim isi file.
         */
        async function directApiRequest(endpoint, payload) {

            const csrfToken = document.querySelector(
                'meta[name="csrf-token"]'
            );

            if (!csrfToken) {
                throw new Error(
                    'CSRF token was not found.'
                );
            }

            const response = await fetch(
                config.url + endpoint,
                {
                    method: 'POST',

                    credentials: 'same-origin',

                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken.content
                    },

                    body: JSON.stringify(payload)
                }
            );

            const responseText = await response.text();

            let data = null;

            try {

                data = JSON.parse(responseText);

            } catch (e) {

                throw new Error(
                    'Invalid response from server.'
                );
            }

            /*
             * Laravel bisa saja memberikan HTTP 200
             * tetapi response StorageResponse type=error.
             */
            if (
                !response.ok ||
                !data ||
                data.type === 'error'
            ) {

                throw new Error(
                    data && data.message
                        ? data.message
                        : 'Upload request failed.'
                );
            }

            return data;
        }


        /**
         * Ambil metadata file dari UI Dropzone.
         *
         * Isinya sama dengan metadata yang sebelumnya
         * dimasukkan melalui onSending().
         */
        function getDirectFileMetadata(file) {

            let preview = $(file.previewElement);

            let fileEditPopUp =
                preview.find('.dz-file-edit');

            let popUpFileName =
                fileEditPopUp.find(
                    'input[name=name]'
                );

            let popUpFileVisibility =
                fileEditPopUp.find(
                    'select[name=visibility]'
                );

            let popUpFilePassword =
                fileEditPopUp.find(
                    'input[name=password]'
                );

            let popUpFileDescription =
                fileEditPopUp.find(
                    'textarea[name=description]'
                );

            let folder =
                uploadboxWrapperForm.find(
                    'select[name=folder]'
                );


            let name =
                popUpFileName.length
                    ? popUpFileName.val()
                    : file.name.replace(
                        /\.[^/.]+$/,
                        ""
                    );


            if (!name) {

                throw new Error(
                    uploadConfig.trans.errors.file_name_empty
                );
            }


            let visibility = null;

            if (
                popUpFileVisibility.length &&
                popUpFileVisibility.val() !== ""
            ) {

                visibility = Number(
                    popUpFileVisibility.val()
                );
            }


            let folderId = null;

            if (
                folder.length &&
                folder.val() !== ""
            ) {

                folderId = Number(
                    folder.val()
                );
            }


            return {

                original_name: file.name,

                name: name,

                size: file.size,

                mime:
                    file.type ||
                    'application/octet-stream',

                visibility: visibility,

                password:
                    popUpFilePassword.length &&
                        popUpFilePassword.val() !== ""
                        ? popUpFilePassword.val()
                        : null,

                description:
                    popUpFileDescription.length &&
                        popUpFileDescription.val() !== ""
                        ? popUpFileDescription.val()
                        : null,

                folder: folderId
            };
        }

        function ensureDirectProgressUI(file) {

            let preview = $(file.previewElement);

            let progressBox = preview.find(
                '.direct-upload-progress'
            );

            if (progressBox.length) {
                return progressBox;
            }

            /*
             * Progress UI direct upload.
             *
             * Dibuat lewat JS supaya tidak perlu
             * mengubah template Blade.
             */
            let html = `
        <div class="direct-upload-progress mt-3">

            <div class="d-flex justify-content-between align-items-center mb-2">

                <div class="direct-upload-status fw-600">
                    Preparing upload...
                </div>

                <div class="direct-upload-percent fw-600">
                    0%
                </div>

            </div>

            <div
                class="progress"
                style="
                    height: 10px;
                    border-radius: 10px;
                    overflow: hidden;
                "
            >
                <div
                    class="progress-bar progress-bar-striped progress-bar-animated direct-upload-progress-bar"
                    role="progressbar"
                    style="width: 0%"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    aria-valuenow="0"
                ></div>
            </div>

            <div class="direct-upload-bytes text-muted small mt-2">
                0 B / ${formatBytes(file.size)}
            </div>

        </div>
    `;

            /*
             * Masukkan ke preview file.
             */
            let previewContainer = preview.find(
                '.dz-preview-container'
            );

            if (previewContainer.length) {

                previewContainer.append(html);

            } else {

                preview.append(html);
            }

            return preview.find(
                '.direct-upload-progress'
            );
        }

        function setDirectUploadStatus(
            file,
            text,
            percent = null,
            status = 'uploading'
        ) {

            let box = ensureDirectProgressUI(file);

            let statusText = box.find(
                '.direct-upload-status'
            );

            let percentText = box.find(
                '.direct-upload-percent'
            );

            let progressBar = box.find(
                '.direct-upload-progress-bar'
            );


            statusText.text(text);


            if (percent !== null) {

                percent = Math.max(
                    0,
                    Math.min(
                        100,
                        Number(percent)
                    )
                );

                percentText.text(
                    percent.toFixed(0) + '%'
                );

                progressBar.css(
                    'width',
                    percent + '%'
                );

                progressBar.attr(
                    'aria-valuenow',
                    percent.toFixed(0)
                );
            }


            /*
             * UPLOADING
             */
            if (status === 'uploading') {

                progressBar
                    .removeClass(
                        'bg-success bg-danger'
                    )
                    .addClass(
                        'progress-bar-striped progress-bar-animated'
                    );
            }


            /*
             * PROCESSING
             */
            if (status === 'processing') {

                progressBar
                    .removeClass(
                        'bg-success bg-danger'
                    )
                    .addClass(
                        'progress-bar-striped progress-bar-animated'
                    );

                percentText.text('100%');

                progressBar.css(
                    'width',
                    '100%'
                );

                progressBar.attr(
                    'aria-valuenow',
                    '100'
                );
            }


            /*
             * SUCCESS
             */
            if (status === 'success') {

                progressBar
                    .removeClass(
                        'progress-bar-striped progress-bar-animated bg-danger'
                    )
                    .addClass(
                        'bg-success'
                    );

                progressBar.css(
                    'width',
                    '100%'
                );

                progressBar.attr(
                    'aria-valuenow',
                    '100'
                );

                percentText.text(
                    '100%'
                );
            }


            /*
             * ERROR
             */
            if (status === 'error') {

                progressBar
                    .removeClass(
                        'progress-bar-striped progress-bar-animated bg-success'
                    )
                    .addClass(
                        'bg-danger'
                    );
            }
        }

        /**
         * Update progress seluruh multipart.
         *
         * Progress tiap part disimpan lalu dijumlahkan
         * agar progress tetap benar walaupun 4 part
         * sedang upload bersamaan.
         */
        function updateDirectUploadProgress(
            file,
            state
        ) {

            let uploadedBytes = 0;


            Object.keys(
                state.partLoaded
            ).forEach(function (partNumber) {

                uploadedBytes +=
                    state.partLoaded[
                    partNumber
                    ] || 0;
            });


            /*
             * Jangan sampai lebih besar dari
             * ukuran file karena event progress
             * beberapa part berjalan bersamaan.
             */
            uploadedBytes = Math.min(
                uploadedBytes,
                file.size
            );


            let percent =
                file.size > 0
                    ? (
                        uploadedBytes /
                        file.size
                    ) * 100
                    : 0;


            percent = Math.min(
                100,
                Math.max(
                    0,
                    percent
                )
            );


            let preview =
                $(file.previewElement);


            /*
             * Support tampilan lama jika
             * selector ini masih ada.
             */
            preview
                .find(
                    ".dz-upload-precent"
                )
                .html(
                    percent.toFixed(0) + "%"
                );


            /*
             * Progress UI direct upload baru.
             */
            let progressBox =
                ensureDirectProgressUI(
                    file
                );


            progressBox
                .find(
                    '.direct-upload-percent'
                )
                .text(
                    percent.toFixed(0) + '%'
                );


            progressBox
                .find(
                    '.direct-upload-progress-bar'
                )
                .css(
                    'width',
                    percent + '%'
                )
                .attr(
                    'aria-valuenow',
                    percent.toFixed(0)
                );


            progressBox
                .find(
                    '.direct-upload-bytes'
                )
                .text(
                    formatBytes(
                        uploadedBytes
                    ) +
                    ' / ' +
                    formatBytes(
                        file.size
                    )
                );


            /*
             * Selama upload file ke R2.
             */
            if (percent < 100) {

                setDirectUploadStatus(
                    file,
                    'Uploading...',
                    percent,
                    'uploading'
                );

            } else {

                /*
                 * PUT seluruh part selesai,
                 * tetapi Laravel masih melakukan:
                 *
                 * complete multipart
                 * HEAD object
                 * FileEntry::create()
                 */
                setDirectUploadStatus(
                    file,
                    'Finalizing file...',
                    100,
                    'processing'
                );


                preview
                    .find(
                        ".upload-processing-overlay"
                    )
                    .addClass(
                        "active"
                    );


                preview
                    .find(
                        ".dz-preview-container"
                    )
                    .addClass(
                        "processing"
                    );
            }
        }


        /**
         * Abort seluruh XHR R2 aktif
         * untuk satu file.
         */
        function abortDirectXhrs(state) {

            if (!state) {
                return;
            }

            state.xhrs.forEach(
                function (xhr) {

                    try {

                        xhr.abort();

                    } catch (e) {
                        // ignore
                    }
                }
            );

            state.xhrs.clear();
        }


        /**
         * Abort multipart di Laravel/R2.
         */
        async function abortDirectToken(token) {

            if (!token) {
                return;
            }

            try {

                await directApiRequest(
                    '/upload/direct/abort',
                    {
                        token: token
                    }
                );

            } catch (e) {

                /*
                 * Best effort.
                 *
                 * Tidak perlu toastr karena biasanya
                 * fungsi ini dipanggil saat user cancel.
                 */
                console.warn(
                    'Direct upload abort failed:',
                    e
                );
            }
        }


        /**
         * Dipanggil ketika file di-remove/reset/close.
         */
        function abortDirectFile(file) {

            let state =
                directUploadStates.get(file);

            if (!state) {
                return;
            }

            if (state.completed) {
                return;
            }

            state.aborted = true;

            abortDirectXhrs(state);

            if (state.token) {

                abortDirectToken(
                    state.token
                );
            }
        }


        /**
         * Upload satu Blob langsung ke presigned R2 URL.
         */
        function putDirectPart(
            file,
            state,
            partNumber,
            blob,
            url
        ) {

            return new Promise(
                function (resolve, reject) {

                    if (
                        state.aborted ||
                        state.failed
                    ) {

                        reject(
                            new Error(
                                'Upload cancelled.'
                            )
                        );

                        return;
                    }


                    const xhr =
                        new XMLHttpRequest();


                    state.xhrs.add(xhr);


                    xhr.open(
                        'PUT',
                        url,
                        true
                    );


                    /*
                     * Jangan set Authorization.
                     * Jangan kirim API key R2.
                     *
                     * Signature sudah berada di URL.
                     */


                    xhr.upload.onprogress =
                        function (event) {

                            if (
                                !event.lengthComputable
                            ) {
                                return;
                            }

                            state.partLoaded[
                                partNumber
                            ] = event.loaded;

                            updateDirectUploadProgress(
                                file,
                                state
                            );
                        };


                    const cleanup = function () {

                        state.xhrs.delete(
                            xhr
                        );
                    };


                    xhr.onload =
                        function () {

                            cleanup();

                            if (
                                xhr.status >= 200 &&
                                xhr.status < 300
                            ) {

                                /*
                                 * Pastikan progress part
                                 * dianggap penuh.
                                 */
                                state.partLoaded[
                                    partNumber
                                ] = blob.size;

                                updateDirectUploadProgress(
                                    file,
                                    state
                                );


                                /*
                                 * ETag wajib dipakai ketika
                                 * CompleteMultipartUpload.
                                 */
                                const etag =
                                    xhr.getResponseHeader(
                                        'ETag'
                                    );


                                if (!etag) {

                                    reject(
                                        new Error(
                                            'R2 did not return ETag. Check R2 CORS ExposeHeaders.'
                                        )
                                    );

                                    return;
                                }


                                resolve({
                                    part_number:
                                        partNumber,

                                    etag:
                                        etag
                                });

                                return;
                            }


                            reject(
                                new Error(
                                    'R2 upload failed with HTTP ' +
                                    xhr.status +
                                    '.'
                                )
                            );
                        };


                    xhr.onerror =
                        function () {

                            cleanup();

                            reject(
                                new Error(
                                    'Network error while uploading to R2.'
                                )
                            );
                        };


                    xhr.onabort =
                        function () {

                            cleanup();

                            reject(
                                new Error(
                                    'Upload cancelled.'
                                )
                            );
                        };


                    xhr.send(blob);
                }
            );
        }


        /**
         * Upload satu part dengan retry.
         *
         * Setiap retry meminta presigned URL baru.
         */
        async function uploadDirectPartWithRetry(
            file,
            state,
            partNumber,
            start,
            end
        ) {

            const blob =
                file.slice(
                    start,
                    end
                );


            let lastError = null;


            for (
                let attempt = 1;
                attempt <= DIRECT_PART_RETRIES;
                attempt++
            ) {

                if (
                    state.aborted ||
                    state.failed
                ) {

                    throw new Error(
                        'Upload cancelled.'
                    );
                }


                try {

                    /*
                     * URL dibuat tepat sebelum
                     * part di-upload.
                     */
                    const partUrlResponse =
                        await directApiRequest(
                            '/upload/direct/part-url',
                            {
                                token:
                                    state.token,

                                part_number:
                                    partNumber
                            }
                        );


                    if (
                        !partUrlResponse.url
                    ) {

                        throw new Error(
                            'Upload URL was not returned.'
                        );
                    }


                    return await putDirectPart(
                        file,
                        state,
                        partNumber,
                        blob,
                        partUrlResponse.url
                    );


                } catch (error) {

                    lastError = error;

                    /*
                     * Reset progress part gagal.
                     */
                    state.partLoaded[
                        partNumber
                    ] = 0;

                    updateDirectUploadProgress(
                        file,
                        state
                    );


                    if (
                        state.aborted ||
                        state.failed
                    ) {

                        throw error;
                    }


                    if (
                        attempt <
                        DIRECT_PART_RETRIES
                    ) {

                        /*
                         * Retry delay:
                         *
                         * attempt 1 -> 750ms
                         * attempt 2 -> 1500ms
                         */
                        await new Promise(
                            function (resolve) {

                                setTimeout(
                                    resolve,
                                    750 * attempt
                                );
                            }
                        );
                    }
                }
            }


            throw lastError ||
            new Error(
                'Failed to upload multipart part.'
            );
        }


        /**
         * Jalankan multipart workers.
         *
         * Default concurrency = 4.
         */
        async function uploadDirectParts(
            file,
            state,
            partSize,
            totalParts
        ) {

            state.nextPart = 1;

            state.uploadedParts = [];

            state.partLoaded = {};


            async function worker() {

                while (true) {

                    if (
                        state.aborted ||
                        state.failed
                    ) {
                        return;
                    }


                    const partNumber =
                        state.nextPart++;


                    if (
                        partNumber >
                        totalParts
                    ) {
                        return;
                    }


                    const start =
                        (
                            partNumber - 1
                        ) * partSize;


                    const end =
                        Math.min(
                            start + partSize,
                            file.size
                        );


                    const uploadedPart =
                        await uploadDirectPartWithRetry(
                            file,
                            state,
                            partNumber,
                            start,
                            end
                        );


                    state.uploadedParts.push(
                        uploadedPart
                    );
                }
            }


            const workerCount =
                Math.min(
                    DIRECT_PART_CONCURRENCY,
                    totalParts
                );


            const workers = [];


            for (
                let i = 0;
                i < workerCount;
                i++
            ) {

                workers.push(
                    worker()
                );
            }


            try {

                await Promise.all(
                    workers
                );

            } catch (error) {

                state.failed = true;

                abortDirectXhrs(
                    state
                );

                throw error;
            }


            state.uploadedParts.sort(
                function (a, b) {

                    return (
                        a.part_number -
                        b.part_number
                    );
                }
            );


            if (
                state.uploadedParts.length !==
                totalParts
            ) {

                throw new Error(
                    'Multipart upload is incomplete.'
                );
            }


            return state.uploadedParts;
        }


        /**
         * Render success.
         *
         * Bentuknya sengaja sama dengan
         * onUploadComplete() lama.
         */
        function renderDirectUploadSuccess(
            file,
            response
        ) {

            let preview =
                $(file.previewElement);


            preview
                .removeClass(
                    'dz-error'
                )
                .addClass(
                    'dz-success'
                );


            preview
                .find(
                    ".upload-processing-overlay"
                )
                .removeClass(
                    "active"
                );


            preview
                .find(
                    ".dz-processing-overlay"
                )
                .removeClass(
                    "active"
                );


            preview
                .find(
                    ".dz-preview-container"
                )
                .removeClass(
                    "processing"
                );


            preview
                .find(
                    '.dz-file-edit'
                )
                .remove();


            let previewContainer =
                preview.find(
                    '.dz-preview-container'
                );


            previewContainer.append(
                '<div class="mt-3">' +

                '<div class="form-group mb-3">' +

                '<input ' +
                'id="entry_' +
                response.shared_id +
                '" ' +
                'type="text" ' +
                'class="form-control form-control-md radius radius-md" ' +
                'value="' +
                response.download_link +
                '" ' +
                'readonly>' +

                '<button ' +
                'type="button" ' +
                'class="btn-copy" ' +
                'data-clipboard-target="#entry_' +
                response.shared_id +
                '">' +

                '<i class="fa-regular fa-clone"></i>' +

                '</button>' +

                '</div>' +

                '<a ' +
                'href="' +
                response.download_link +
                '" ' +
                'target="_blank" ' +
                'class="btn btn-primary btn-md radius radius-md w-100">' +

                uploadConfig.trans.view_file +

                '</a>' +

                '</div>'
            );


            window.copy();


            if (
                typeof Livewire !==
                'undefined'
            ) {

                Livewire.emit(
                    'refreshEntries'
                );
            }
        }


        /**
         * Upload satu file secara penuh:
         *
         * initiate
         * -> multipart PUT R2
         * -> complete
         * -> FileEntry
         */
        async function uploadSingleFileDirect(
            file
        ) {

            let state = {

                token: null,

                aborted: false,

                failed: false,

                completed: false,

                xhrs: new Set(),

                partLoaded: {},

                uploadedParts: []
            };


            directUploadStates.set(
                file,
                state
            );


            directUploadingCount++;


            /*
             * Beritahu Dropzone secara internal
             * bahwa file sedang upload.
             */
            file.status =
                Dropzone.UPLOADING;


            let preview =
                $(file.previewElement);

            ensureDirectProgressUI(file);

            setDirectUploadStatus(
                file,
                'Preparing upload...',
                0,
                'uploading'
            );

            preview
                .removeClass(
                    'dz-error'
                );


            try {

                /*
                 * =====================================================
                 * 1. METADATA
                 * =====================================================
                 */

                const metadata =
                    getDirectFileMetadata(
                        file
                    );


                /*
                 * Sama seperti onSending lama:
                 * setelah mulai upload, action/edit
                 * tidak boleh berubah lagi.
                 */
                preview
                    .find(
                        '.dz-actions'
                    )
                    .remove();


                /*
                 * =====================================================
                 * 2. INITIATE
                 * =====================================================
                 */

                const initiate =
                    await directApiRequest(
                        '/upload/direct/initiate',
                        metadata
                    );


                if (
                    !initiate.token ||
                    !initiate.part_size ||
                    !initiate.total_parts
                ) {

                    throw new Error(
                        'Invalid upload initialization response.'
                    );
                }

                setDirectUploadStatus(
                    file,
                    'Starting upload...',
                    0,
                    'uploading'
                );


                state.token =
                    initiate.token;


                const partSize =
                    Number(
                        initiate.part_size
                    );


                const totalParts =
                    Number(
                        initiate.total_parts
                    );


                /*
                 * User mungkin menekan remove
                 * saat request initiate sedang jalan.
                 */
                if (state.aborted) {

                    await abortDirectToken(
                        state.token
                    );

                    throw new Error(
                        'Upload cancelled.'
                    );
                }


                /*
                 * =====================================================
                 * 3. BROWSER -> R2
                 * =====================================================
                 */

                const uploadedParts =
                    await uploadDirectParts(
                        file,
                        state,
                        partSize,
                        totalParts
                    );


                if (state.aborted) {

                    throw new Error(
                        'Upload cancelled.'
                    );
                }

                setDirectUploadStatus(
                    file,
                    'Finalizing file...',
                    100,
                    'processing'
                );
                /*
                 * =====================================================
                 * 4. COMPLETE
                 * =====================================================
                 */

                const complete =
                    await directApiRequest(
                        '/upload/direct/complete',
                        {
                            token:
                                state.token,

                            parts:
                                uploadedParts
                        }
                    );


                if (
                    !complete.shared_id ||
                    !complete.download_link
                ) {

                    throw new Error(
                        'Invalid upload completion response.'
                    );
                }


                /*
                 * =====================================================
                 * 5. SUCCESS
                 * =====================================================
                 */

                state.completed =
                    true;


                file.status =
                    Dropzone.SUCCESS;


                file._directUploadCompleted =
                    true;

                setDirectUploadStatus(
                    file,
                    'Upload complete',
                    100,
                    'success'
                );

                renderDirectUploadSuccess(
                    file,
                    complete
                );


            } catch (error) {

                file.status =
                    Dropzone.ERROR;

                setDirectUploadStatus(
                    file,
                    'Upload failed',
                    null,
                    'error'
                );

                if (!state.aborted) {

                    state.failed =
                        true;


                    abortDirectXhrs(
                        state
                    );


                    if (
                        state.token &&
                        !state.completed
                    ) {

                        await abortDirectToken(
                            state.token
                        );
                    }


                    let message =
                        error &&
                            error.message
                            ? error.message
                            : 'Upload failed.';


                    preview
                        .removeClass(
                            'dz-success'
                        )
                        .addClass(
                            'dz-error'
                        );


                    onFileError(
                        file,
                        message
                    );
                }


                throw error;


            } finally {

                directUploadingCount =
                    Math.max(
                        0,
                        directUploadingCount - 1
                    );
            }
        }


        /**
         * Upload seluruh file Dropzone.
         *
         * Untuk tahap awal kita upload file
         * SATU PER SATU.
         *
         * Multipart di dalam satu file tetap
         * concurrency 4.
         *
         * Ini sengaja supaya kalau user memilih
         * 5 file, kita tidak menghasilkan
         * 5 x 4 = 20 PUT bersamaan.
         */
        async function startDirectUploads() {

            /*
            |--------------------------------------------------------------------------
            | Ambil file yang ada di Dropzone
            |--------------------------------------------------------------------------
            */

            const files = dropzone.files.slice();


            /*
            |--------------------------------------------------------------------------
            | Langsung beri feedback ke semua file
            |--------------------------------------------------------------------------
            |
            | Sebelum worker dimulai semuanya terlihat "Waiting..."
            | supaya UI langsung merespons.
            |
            */

            files.forEach(function (file) {

                if (!file._directUploadCompleted) {

                    ensureDirectProgressUI(file);

                    setDirectUploadStatus(
                        file,
                        'Waiting...',
                        0,
                        'uploading'
                    );
                }
            });


            /*
            |--------------------------------------------------------------------------
            | Queue file
            |--------------------------------------------------------------------------
            */

            let nextFileIndex = 0;


            /*
            |--------------------------------------------------------------------------
            | File Worker
            |--------------------------------------------------------------------------
            |
            | Setiap worker mengambil satu file,
            | upload sampai selesai,
            | kemudian mengambil file berikutnya.
            |
            */

            async function fileWorker() {

                while (true) {

                    /*
                     * Ambil index secara sinkron.
                     *
                     * JS single-threaded sehingga worker
                     * tidak akan mendapatkan index sama.
                     */
                    const fileIndex =
                        nextFileIndex++;


                    /*
                     * Semua file sudah diambil.
                     */
                    if (
                        fileIndex >=
                        files.length
                    ) {
                        return;
                    }


                    const file =
                        files[fileIndex];


                    /*
                     * Sudah selesai sebelumnya.
                     */
                    if (
                        file._directUploadCompleted
                    ) {
                        continue;
                    }


                    /*
                     * File sudah dihapus dari Dropzone
                     * sebelum mendapat giliran.
                     */
                    if (
                        dropzone.files.indexOf(file)
                        === -1
                    ) {
                        continue;
                    }


                    try {

                        /*
                         * Mulai upload file ini.
                         *
                         * Beberapa worker menjalankan
                         * function ini bersamaan.
                         */
                        await uploadSingleFileDirect(
                            file
                        );


                    } catch (error) {

                        /*
                         * Error sudah ditampilkan
                         * uploadSingleFileDirect().
                         *
                         * Worker tetap hidup sehingga
                         * file lain tidak ikut gagal.
                         */
                        if (
                            error &&
                            error.message !==
                            'Upload cancelled.'
                        ) {

                            console.error(
                                'Direct upload failed:',
                                error
                            );
                        }
                    }
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Jalankan beberapa worker file sekaligus
            |--------------------------------------------------------------------------
            */

            const workerCount =
                Math.min(
                    DIRECT_FILE_CONCURRENCY,
                    files.length
                );


            const workers = [];


            for (
                let i = 0;
                i < workerCount;
                i++
            ) {

                workers.push(
                    fileWorker()
                );
            }


            /*
             * Tunggu seluruh worker selesai.
             */
            await Promise.all(
                workers
            );
        }

        function onAddFile(file) {

            if (dropzone.files.length > maxFiles) {
                this.removeFile(file);
                return;
            }

            if (this.files.length) {
                var _i, _len;
                for (_i = 0, _len = this.files.length; _i < _len - 1; _i++) {
                    if (this.files[_i].name === file.name) {
                        this.removeFile(file);
                        toastr.error(uploadConfig.trans.errors.file_duplicate);
                        return;
                    }
                }
            }

            if (file.size == 0) {
                this.removeFile(file);
                toastr.error(uploadConfig.trans.errors.file_empty);
                return;
            }

            if (uploadConfig.subscription.is_expired == 1) {
                this.removeFile(file);
                toastr.error(uploadConfig.trans.errors.subscription_expired);
                return;
            }

            if (uploadConfig.upload.max_file_size != null) {
                if (file.size > uploadConfig.upload.max_file_size) {
                    toastr.error(uploadConfig.trans.errors.file_limit_exceeded);
                    this.removeFile(file);
                    return;
                }
            }

            if (uploadConfig.upload.storage_space != null) {
                if (file.size > uploadConfig.upload.storage_space) {
                    toastr.error(uploadConfig.trans.errors.storage_space_exceeded);
                    this.removeFile(file);
                    return;
                }
            }

            uploadBoxDrag();

            let preview = $(file.previewElement),
                previewFileEdit = preview.find(".dz-file-edit"),
                previewFileEditBtn = preview.find("[data-dz-edit]"),
                fileEditPopUpButton = previewFileEdit.find("button"),
                popUpFileName = previewFileEdit.find('input[name=name]'),
                popUpFilePassword = previewFileEdit.find('input[name=password]');

            previewFileEdit.on('click', function(e) {
                e.stopPropagation();
            });

            previewFileEditBtn.on('click', function() {
                previewFileEdit.addClass("active");
                popUpFilePassword.prop('disabled', false);
            });

            fileEditPopUpButton.on('click', function() {
                if (popUpFileName.val() != "") {
                    previewFileEdit.removeClass("active");
                } else {
                    toastr.error(uploadConfig.trans.errors.file_name_empty);
                }
            });

            let previewFileName = preview.find("[data-dz-name]"),
                previewFileSize = preview.find('.dz-size');

            previewFileName.html(file.name);
            previewFileSize.html(formatBytes(file.size));


            let previewFileExt = preview.find("[data-dz-extension]"),
                fileExtension = file.name.split('.').pop();

            if (fileExtension != "") {
                previewFileExt.attr('data-type', fileExtension.substring(0, 4));
            } else {
                previewFileExt.attr('data-type', '?');
            }

            if (fileExtension != "") {
                popUpFileName.val(file.name.replace(/\.[^/.]+$/, ""));
            } else {
                popUpFileName.val(file.name);
            }

        }

        function onSending(file, xhr, formData) {
            let preview = $(file.previewElement),
                previewFileActions = preview.find('.dz-actions'),
                fileEditPopUp = preview.find('.dz-file-edit'),
                popUpFileName = fileEditPopUp.find('input[name=name]'),
                popUpFileVisibility = fileEditPopUp.find('select[name=visibility]'),
                popUpFilePassword = fileEditPopUp.find('input[name=password]'),
                popUpFileDescription = fileEditPopUp.find('textarea[name=description]'),
                folder = uploadboxWrapperForm.find('select[name=folder]');
            if (popUpFileName.length && popUpFileName.val() != "") {
                formData.append('name', popUpFileName.val());
            }
            if (popUpFileVisibility.length && popUpFileVisibility.val() != "") {
                formData.append('visibility', popUpFileVisibility.val());
            }
            if (popUpFilePassword.length && popUpFilePassword.val() != "") {
                formData.append('password', popUpFilePassword.val());
            }
            if (popUpFileDescription.length && popUpFileDescription.val() != "") {
                formData.append('description', popUpFileDescription.val());
            }
            if (folder.length && folder.val() != "") {
                formData.append('folder', folder.val());
            }
            previewFileActions.remove();
        }

		function onUploadProgress(file, progress) {
		    let preview = $(file.previewElement);
		    let percent = Number(progress);

		    preview.find(".dz-upload-precent").html(
		        percent.toFixed(0) + "%"
		    );

		    if (percent === 100) {
		        preview.find(".upload-processing-overlay").addClass("active");
		        preview.find(".dz-preview-container").addClass("processing");
		    }
		}

        function onFileError(file, message = null) {

            let preview =
                $(file.previewElement);


            preview
                .find(
                    ".dz-preview-container"
                )
                .removeClass(
                    "processing"
                );


            preview
                .find(
                    ".dz-processing-overlay"
                )
                .removeClass(
                    "active"
                );


            preview
                .find(
                    ".upload-processing-overlay"
                )
                .removeClass(
                    "active"
                );


            if (message) {

                toastr.error(
                    message
                );
            }
        }

        function onUploadComplete(file) {
        	let preview = $(file.previewElement);
			preview.find(".upload-processing-overlay").removeClass("active");
    		preview.find(".dz-preview-container").removeClass("processing");

            if (file.status == "success") {
                let preview = $(file.previewElement),
                    response = JSON.parse(file.xhr.response);
                preview.find('.dz-file-edit').remove();
                if (response.type == 'success') {
                    let previewContainer = preview.find('.dz-preview-container');
                    previewContainer.append('<div class="mt-3">' +
                        '<div class="form-group mb-3">' +
                        '<input id="entry_' + response.shared_id + '" type="text" class="form-control form-control-md radius radius-md" value="' + response.download_link + '" readonly>' +
                        '<button type="button" class="btn-copy" data-clipboard-target="#entry_' + response.shared_id + '">' +
                        '<i class="fa-regular fa-clone"></i>' +
                        '</button>' +
                        '</div>' +
                        '<a href="' + response.download_link + '" target="_blank" class="btn btn-primary btn-md radius radius-md w-100">' + uploadConfig.trans.view_file + '</a>' +
                        '</div>');
                    window.copy();
                    if (typeof Livewire !== 'undefined') {
                        Livewire.emit('refreshEntries');
                    }
                } else {
                    preview.removeClass('dz-success');
                    preview.addClass('dz-error');
                    toastr.error(response.message);
                }
            }
        }

        function onRemovedfile() {
            uploadBoxDrag();
        }

        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return "0 " + uploadConfig.trans.format_bytes[0];
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = uploadConfig.trans.format_bytes;
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }

        dropzone.on("addedfile", onAddFile);
        dropzone.on('sending', onSending);
        dropzone.on(
            "removedfile",
            function (file) {

                /*
                 * Cancel PUT yang sedang berjalan
                 * dan AbortMultipartUpload di R2.
                 */
                abortDirectFile(
                    file
                );


                /*
                 * Function lama tetap dijalankan.
                 */
                onRemovedfile();
            }
        );
        dropzone.on('uploadprogress', onUploadProgress);
        dropzone.on('error', onFileError);
        dropzone.on('complete', onUploadComplete);
    }

    let downloadSection = $('.download-section'),
        down2Form = downloadSection.find('#down_2Form'),
        downloadSectionBox = $('.download-section-box');

    if (downloadSection.length) {

        if (downloadSectionBox.length) {
            setCookie('adb', 1, 1);
            async function adblockDetector() {
                if (downloadConfig.adb != "") {
                    let adBlockEnabled = false
                    const googleAdUrl = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js'
                    try {
                        await fetch(new Request(googleAdUrl)).catch(_ => adBlockEnabled = true)
                    } catch (e) {
                        adBlockEnabled = true
                    } finally {
                        if (adBlockEnabled === true) {
                            if (downloadSection.length) {
                                downloadSectionBox.empty();
                                downloadSectionBox.append('<div class="alert alert-danger text-center mb-0">' +
                                    '<i class="fa-solid fa-hand me-2"></i>' + downloadConfig.trans.adblock_alert + '</div>');
                                setCookie('adb', 2, 1);
                            }
                        }
                    }
                }
            }
            adblockDetector();
        }

        window.recaptchaCallback = () => {
            let down2FormButton = down2Form.find('.btn');
            down2FormButton.prop('disabled', false);
        }

        if (downloadConfig.captcha == 0) {
            window.recaptchaCallback();
        }

        let downloadLink = $(".download-file-link");
        let downloadTimer;

        if (downloadLink.length) {
            let counterTime = downloadConfig.counter_time,
                downloadButton = downloadLink.find("a");

            function generateDownloadLink() {
                setCookie('rqf', downloadConfig.id, 1);

                function errorResponse(error) {
                    downloadLink.empty();
                    downloadLink.html('<div class="alert alert-danger">' + error + '</div>')
                }
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: config.url + '/' + downloadConfig.id + '/file/generate',
                    type: "POST",
                    dataType: 'json',
                    beforeSend: function() {
                        downloadButton.empty();
                        downloadButton.append('<div class="spinner-border spinner-border-sm me-2"></div>' +
                            '<span>' + downloadConfig.trans.generating_button_text + '</span>');
                    },
                    success: function(response) {
                        downloadButton.empty();
                        downloadButton.html('<i class="fa-solid fa-download me-1"></i>' + downloadConfig.trans.download_button_text);
                        if ($.isEmptyObject(response.error)) {
                            if (counterTime != "") {
                                downloadLink.find("h3").remove();
                                downloadLink.find(".download-file-timer").addClass('d-none');
                            }
                            downloadButton.attr("href", response.download_link);
                            downloadButton.removeClass("disabled");
                        } else {
                            errorResponse(response.error);
                        }
                    },
                }).fail(function(jqXHR, ajaxOptions, thrownError) {
                    errorResponse(thrownError);
                });
            }

            if (counterTime == 0) {
                generateDownloadLink()
            } else {
                var downloadTime = downloadLink.find(".download-file-timer span");

                function timerFunc() {
                    downloadTimer = setInterval(() => {
                        downloadTime.text(parseInt(downloadTime.text()) - 1);
                        if (downloadTime.text() == 1) {
                            clearInterval(downloadTimer);
                            generateDownloadLink();
                        }
                    }, 1000);
                }
                timerFunc();
                $(window).on("focus", () => {
                    if (downloadTime.text() > 0) {
                        timerFunc();
                    }
                });
                $(window).on("blur", () => {
                    clearInterval(downloadTimer);
                });
            }
        }
    }

    let withdrawalMethodSelect = $('#withdrawalMethodSelect');
    withdrawalMethodSelect.on('change', function() {
        var value = $(this).val();
        $('.withdrawal-descriptions').addClass('d-none');
        $('.withdrawal-descriptions.description-' + value).removeClass('d-none');
    });


    let periodSelect = $('#period-select');
    periodSelect.on('change', function() {
        location.href = $(this).val();
    });

})(jQuery);