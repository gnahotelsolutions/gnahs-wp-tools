<div id="GNAHSEngine" style="max-width: none !important;"></div>
<script>
    window.BookingParams = window.BookingParams || {}
    window.BookingParams.uuid = '<?= $atts['uuid'] ?>'
    window.BookingParams.singleEstablishment = <?= $atts['establishmentId'] ?> || null
    window.BookingParams.language = window.BookingParams.language || '<?= get_locale() ?>'
    window.BookingParams.api = 'https://<?= $atts['api'] ?>.gnahs.app'
    window.BookingParams.assets = 'https://<?= $atts['api'] ?>.gnahs.app/dist/'
 </script>
 <script src="https://assets.gnahs.com/scripts/rho-initialization/gnahs-get-rho-initial-settings-v2.js" onload="(new GNAHSGetRhoInitialSettings())"></script>
 <script src="https://assets.gnahs.com/scripts/booking-engine/fetch.min.js"></script>
