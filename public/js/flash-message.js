(() => {
    const FLASH_TIMER = 3000;
    const flashMessages = document.querySelectorAll('.js-flash-message');
    const flashMessageContainer = document.querySelector('#page-content');

    if (flashMessages.length > 0) {

        flashMessages.forEach((flashMessage) => {
            const label = flashMessage.dataset.label;
            const message = flashMessage.dataset.message;

            Swal.fire({
                title: message,
                icon: label,
                toast: true,
                target: flashMessageContainer,
                position: 'top-end',
                timer: FLASH_TIMER,
                onBeforeOpen: function () {
                    Swal.getContainer().style.position = 'absolute';
                }
            });
        });
    }

})();