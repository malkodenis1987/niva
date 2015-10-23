jQuery(document).ready(function(){
    jQuery('SELECT[name=home_team_id], SELECT[name=visitor_team_id]').change(function(){
       console.log(jQuery(this).val());
        var teamId = jQuery(this).val();
        var nivaId = jQuery('INPUT[name=niva_id]').val();
        if (teamId != nivaId) {
            jQuery('INPUT[name=rival_id]').val(teamId);
        }
    });
    jQuery( "#main-players, #sub-players, #all-players" ).sortable({
        connectWith: ".connectedSortable",
        update: function(event, ui) {
            jQuery('#main-players INPUT').attr('name', 'main_players[]');
            jQuery('#sub-players INPUT').attr('name', 'sub_players[]');
            jQuery('#all-players INPUT').attr('name', 'all_players');
        }
    }).disableSelection();
    // Add stat
    jQuery('body').on('click', '.add', function(){
        var field = jQuery(this).parents('.field').clone();
        var parent = jQuery(this).parents('.details');
        jQuery(field).find('INPUT[type=text]').val('');
        jQuery(field).find('INPUT[type=checkbox]').attr('checked', false);
        parent.append(field);
        reindexInputs(parent);
        return false;
    });
    // Delete stat
    jQuery('body').on('click', '.del', function(){
        var parent = jQuery(this).parents('.details');
        jQuery(this).parents('.field').remove();
        reindexInputs(parent);
        return false;
    });
});

function reindexInputs(parent) {
    parent.find(".field").each(function(index) {
        var prefix = "item[" + index + "]";
        jQuery(this).find("input, select").each(function() {
            this.name = this.name.replace(/item\[\d+\]/, prefix);
        });
    });
}
