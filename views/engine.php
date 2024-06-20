<div id="GNAHSEngine" style="max-width: none !important;"></div>
<script>
    window.BookingParams = {
        uuid: '<?= $atts['uuid'] ?>',
        establishments: [<?= $atts['establishments'] ?>],
        language: '<?= get_locale() ?>',
        api: 'https://<?= $atts['api'] ?>.gnahs.app',
        assets: 'https://<?= $atts['api'] ?>.gnahs.app/dist/',
        <?php if ($atts['room_id']) { ?>
        room_id: '<?= $atts['room_id'] ?>',
        <?php } ?>
        <?php if ($atts['offer_id']) { ?>
        offer_id: '<?= $atts['offer_id'] ?>',
        <?php } ?>
        <?php if ($atts['rate_id']) { ?>
        rate_id: '<?= $atts['rate_id'] ?>',
        <?php } ?>
    }
 </script>
 <script src="https://assets.gnahs.com/scripts/rho-initialization/gnahs-get-rho-initial-settings-v2.js" onload="(new GNAHSGetRhoInitialSettings())"></script>
 <script src="https://assets.gnahs.com/scripts/booking-engine/fetch.min.js"></script>
