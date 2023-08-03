<div id="rho-my-booking" style="max-width: 100%;"></div>
    <script src="https://assets.gnahs.com/scripts/gna-iframe-injection.js"></script>
    <script async defer src="https://assets.gnahs.com/scripts/show-booking-mail/showBookingMail.js" onload="showBookingMail()"></script>
    <script async defer src="https://assets.gnahs.com/scripts/rho-initialization/gnahs-booking-details-v1.js" onload="sendBookingDetails()"></script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const uuid = urlParams.get('uuid');

        function showBookingMail () {
            var selector = '#rho-my-booking'
            new window.ShowBookingMail(selector, {
                uuid: uuid, // UUID de la URL
                secretKey:'<?= $atts['secretKey'] ?>',
                api:'<?= $atts['rhoApi'] ?>',
            })
        }

        async function sendBookingDetails() {
            const bookingDetails = new GNAHSBookingDetails({
                secretKey:'<?= $atts['secretKey'] ?>',
                api:'<?= $atts['rhoApi'] ?>',
            });
            const booking = await bookingDetails.getBooking(uuid);
            // Avoid sending unconfirmed, not paid or old bookings
            if (!booking || !booking.needsCheck()) {
                return;
            }
            bookingDetails.sendRhoCookies(booking);
        }
    </script>
