(function($) {

    "use strict";

    window.addEventListener('show-share-modal', function() {
        let shareModal = document.querySelector('#shareModal');
        $(shareModal).modal('show');
        window.copy();
    });

    window.addEventListener('show-edit-modal', function() {
        let editModal = document.querySelector('#editModal');
        $(editModal).modal('show');
    });

    window.addEventListener('show-move-modal', function(event) {
        let moveModal = document.querySelector('#moveModal');
        let movedIdsInput = moveModal.querySelector('#ids');
        movedIdsInput.value = event.detail.ids;
        movedIdsInput.dispatchEvent(new Event('input'));
        $(moveModal).modal('show');
    });


    window.addEventListener('delete-one-confirm', event => {
        if (window.confirm(config.translates.actionConfirm)) {
            Livewire.emit('deleteOneConfirmed');
        }
    });

    window.addEventListener('delete-multiple-confirm', event => {
        if (window.confirm(config.translates.actionConfirm)) {
            Livewire.emit('deleteMultipleConfirmed', event.detail.ids);
        }
    });

    window.addEventListener('close-modal', event => {
        let modal = document.getElementById(event.detail.id);
        if (modal) {
            let modalInstance = bootstrap.Modal.getInstance(modal);
            modalInstance.hide();
        }
    });

    window.addEventListener('alert', event => {
        toastr[event.detail.type](event.detail.message);
    });

})(jQuery);