<?php
function fc_custom_user_profile_fields( $user ) {
    echo '<h3 class="heading">Rozšířený popis na detail autora</h3>';
    ?>
    <table class="form-table">
        <tr>
            <th><label for="added-description">Popis autora</label></th>
            <td>
                <textarea name="added-description" id="added-description" cols="60" rows="7"><?php echo esc_attr( get_the_author_meta( 'added-description', $user->ID ) ); ?></textarea>
            </td>
        </tr>
    </table>
    <?php
}
add_action( 'show_user_profile', 'fc_custom_user_profile_fields' );
add_action( 'edit_user_profile', 'fc_custom_user_profile_fields' );

function fc_save_custom_user_profile_fields( $user_id ) {
    if ( current_user_can( 'edit_user', $user_id ) ) {
        update_user_meta( $user_id, 'added-description',  $_POST['added-description']  );
    }
}
add_action( 'personal_options_update', 'fc_save_custom_user_profile_fields' );
add_action( 'edit_user_profile_update', 'fc_save_custom_user_profile_fields' );