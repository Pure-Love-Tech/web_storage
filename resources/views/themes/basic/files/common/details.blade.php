<div class="row row-cols-1 row-cols-lg-2 g-4 mb-5">
    <div class="col">
        <div class="file-details-item">
            <div class="file-details-item-icon">
                <i class="fa fa-calendar-alt"></i>
            </div>
            <p class="file-details-item-text">
                <span>{{ translate('Date', 'download pages') }}:</span>
                {{ dateFormat($fileEntry->created_at) }}
            </p>
        </div>
    </div>
    <div class="col">
        <div class="file-details-item">
            <div class="file-details-item-icon">
                <i class="fa fa-user"></i>
            </div>
            <p class="file-details-item-text">
                <span>{{ translate('Uploaded By', 'download pages') }}:</span>
                {{ $fileEntry->user ? $fileEntry->user->name : translate('Anonymous', 'download pages') }}
            </p>
        </div>
    </div>
    <div class="col">
        <div class="file-details-item">
            <div class="file-details-item-icon">
                <i class="fa fa-hard-drive"></i>
            </div>
            <p class="file-details-item-text">
                <span>{{ translate('Size', 'download pages') }}:</span>
                {{ $fileEntry->getFullSize() }}
            </p>
        </div>
    </div>
    <div class="col">
        <div class="file-details-item">
            <div class="file-details-item-icon">
                <i class="fa fa-download"></i>
            </div>
            <p class="file-details-item-text">
                <span>{{ translate('Downloads', 'download pages') }}:</span>
                {{ formatNumber($fileEntry->downloads) }}
            </p>
        </div>
    </div>
    <div class="col">
        <div class="file-details-item sm">
            <div class="file-details-item-icon">
                <i class="fa fa-share"></i>
            </div>
            <div class="file-details-item-text">
                <div class="socials socials-sm ">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $fileEntry->sharedLink() }}"
                        class="social-btn social-btn-sm social-facebook" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ $fileEntry->sharedLink() }}"
                        class="social-btn social-btn-sm social-twitter" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{ $fileEntry->sharedLink() }}"
                        class="social-btn social-btn-sm social-linkedin" target="_blank">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="https://wa.me/?text={{ $fileEntry->sharedLink() }}"
                        class="social-btn social-btn-sm social-whatsapp" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="http://pinterest.com/pin/create/button/?url={{ $fileEntry->sharedLink() }}"
                        class="social-btn social-btn-sm social-pinterest" target="_blank">
                        <i class="fab fa-pinterest"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @php
        $reportFileStatus = auth()->user() && $fileEntry->user_id == auth()->user()->id ? false : true;
    @endphp
    @if ($reportFileStatus)
        <div class="col">
            <div class="file-details-item">
                <div class="file-details-item-icon">
                    <i class="fa-solid fa-bug"></i>
                </div>
                <p class="file-details-item-text alert-danger">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#reportModal"
                        class="link link-danger">{{ translate('Send Report', 'download pages') }}</a>
                </p>
            </div>
        </div>
    @endif
</div>
@if ($reportFileStatus)
    <div id="reportModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ translate('Report this file', 'download pages') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('files.file.report', $fileEntry->sharedId()) }}" method="POST">
                        @csrf
                        <div class="row g-3 mb-3">
                            <div class="col-lg-6">
                                <label class="form-label">{{ translate('Name', 'download pages') }} : <span
                                        class="required">*</span></label>
                                <input type="name" name="name"
                                    class="form-control form-control-md radius radius-md"
                                    value="{{ auth()->user()->name ?? '' }}" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">{{ translate('Email', 'download pages') }} : <span
                                        class="required">*</span></label>
                                <input type="email" name="email"
                                    class="form-control form-control-md radius radius-md"
                                    value="{{ auth()->user()->email ?? '' }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ translate('Reason for reporting', 'download pages') }} :
                                <span class="required">*</span></label>
                            <select name="reason" class="form-select form-select-md radius radius-md" required>
                                @foreach (\App\Models\FileReport::reasons() as $reasonsKey => $reasonsValue)
                                    <option value="{{ $reasonsKey }}">{{ $reasonsValue }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ translate('Details', 'download pages') }} : <span
                                    class="required">*</span></label>
                            <textarea name="details" class="form-control radius radius-md" rows="7"
                                placeholder="{{ translate('Describe the reason why you reported the file to a maximum of 600 characters', 'download pages') }}"
                                required></textarea>
                        </div>
                        <x-captcha />
                        <button type="submit"
                            class="btn btn-primary btn-md radius radius-md">{{ translate('Send', 'download pages') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
