jQuery(document).ready(function($) {
    // Loop pro každý input obrázku
    for (var i = 1; i <= 6; i++) {
        $('#upload_category_image_button_' + i).click(function(e) {
            var mediaUploader;
            e.preventDefault();

            var buttonId = $(this).attr('id');
            var imageIndex = buttonId.split('_').pop();

            // Pokud již uploader existuje, otevřeme ho
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }

            // Jinak vytvoříme nový uploader
            mediaUploader = wp.media.frames.file_frame = wp.media({
                title: 'Vyberte obrázek',
                button: {
                    text: 'Vybrat obrázek'
                },
                multiple: false
            });

            // Když je obrázek vybrán
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                // Nastavení hodnoty do inputu
                $('#category_image_' + imageIndex).val(attachment.url);
                // Zobrazení náhledu obrázku
                $('#category_image_preview_' + imageIndex).html('<img src="' + attachment.url + '" style="max-width: 100px; max-height: 100px; display: block;" />');
            });

            // Otevřeme media uploader
            mediaUploader.open();
        });
    }
});