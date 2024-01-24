<div id="GNAHS-my-booking"></div>

<script>
    window.GNAHS_MyBooking = window.GNAHS_MyBooking || {}
    window.GNAHS_MyBooking.url = 'https://<?= $atts['api'] ?>.gnahs.app/<?= $atts['slug'] ?>'
    window.GNAHS_MyBooking.locale = window.GNAHS_MyBooking.locale || '<?= get_locale() ?>'
</script>

<script src="https://<?= $atts['api'] ?>.gnahs.app/my-booking/launcher.js"></script>
