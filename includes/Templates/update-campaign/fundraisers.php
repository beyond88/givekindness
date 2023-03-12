<?php
    $myProfile = $object->profile();
?>
<div class="give-donor-dashboard-tab-content" id="give_kindness-campaign-fundraisers" data-tab-content="give_kindness-campaign-fundraisers">
    <div class="give-donor-dashboard-heading" style="display:block;">
        <h4 class='gk-margin-bottom-10'>
            <?php echo __('Fundraisers', 'give-kindness'); ?>
        </h4>
        <p class='gk-margin-bottom-10'> 
            <?php echo __('You can add more family friends as fundraisers for this campaign. It\'s always better with a team!'); ?>
        </p>
   </div>
   <div class="give-donor-dashboard-divider"></div>

   <div class="give-donor-dashboard-field-row">
        <div class="give-donor-dashboard-text-control">
            <div class="give-donor-dashboard-text-control__input give-kindness-fundraisers-list">
                <div class="give-kindness-fundraiser-avater">
                    <?php 
                        if( ! empty( $myProfile['avatarUrl'] ) ) { ?>
                            <img alt="Donor Picture" src="<?php echo esc_url( $myProfile['avatarUrl'] ); ?>" >
                    <?php } else { ?>
                        <span class="give-donor-dashboard-donor-info__avatar-initials">
                            <?php echo $myProfile['initials']; ?>
                        </span>
                    <?php
                        }
                    ?>
                </div>
                <div class="give-kindness-fundraiser-info">
                    <div class="give-kindness-fundairser-name">
                        <?php echo $myProfile['name']; ?>
                    </div>
                    <div class="give-kindness-fundairser-rank">
                        <?php echo __( 'Fundraiser', 'give-kindness' ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>