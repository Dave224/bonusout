<?php
function dj_custom_user_profile_fields( $user ) {
    echo '<h3 class="heading">Dodatečné informace</h3>';
    ?>
    <table class="form-table">
        <tr>
            <th><label for="added-description">Rozšířený popis na detail autora</label></th>
            <td>
                <textarea name="added-description" id="added-description" cols="60" rows="7"><?php echo esc_attr( get_the_author_meta( 'added-description', $user->ID ) ); ?></textarea>
            </td>
        </tr>
        <tr>
            <th><label for="app-id">ID z aplikace</label></th>
            <td>
                <input type="text" name="app-id" id="app-id" value="<?php echo esc_attr( get_the_author_meta( 'app-id', $user->ID ) ); ?>">
            </td>
        </tr>
    </table>
    <?php
}
add_action( 'show_user_profile', 'dj_custom_user_profile_fields' );
add_action( 'edit_user_profile', 'dj_custom_user_profile_fields' );

function dj_save_custom_user_profile_fields( $user_id ) {
    if ( current_user_can( 'edit_user', $user_id ) ) {
        update_user_meta( $user_id, 'added-description',  $_POST['added-description']  );
        update_user_meta( $user_id, 'app-id',  $_POST['app-id']  );
    }
}
add_action( 'personal_options_update', 'dj_save_custom_user_profile_fields' );
add_action( 'edit_user_profile_update', 'dj_save_custom_user_profile_fields' );