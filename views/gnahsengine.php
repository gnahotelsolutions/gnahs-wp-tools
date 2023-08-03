<div id="GNAHSEngine" style="max-width: none !important;"></div>
<script>
    window.BookingParams = {
        uuid: '<?= $atts['uuid'] ?>',
        <?php if ($atts['establishmentId']) : ?>
        singleEstablishment: <?= $atts['establishmentId'] ?>,
        <?php endif; ?>
        language: '<?= get_locale() ?>',
        api: 'https://<?= $atts['api'] ?>.gnahs.app',
        assets: 'https://<?= $atts['api'] ?>.gnahs.app/dist/'
    }
 </script>
 <script src="https://assets.gnahs.com/scripts/rho-initialization/gnahs-get-rho-initial-settings-v2.js" onload="(new GNAHSGetRhoInitialSettings())"></script>
 <script src="https://assets.gnahs.com/scripts/booking-engine/fetch.min.js"></script>
