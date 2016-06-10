jQuery(document).ready(function() {
	
	// Validation script
    Joomla.submitbutton = function(task){
        if (task == 'achievement.cancel' || document.formvalidator.isValid(document.getElementById('adminForm'))) {
            Joomla.submitform(task, document.getElementById('adminForm'));
        }
    };

    jQuery("#gfy-remove-image").on("click", function(event){
        event.preventDefault();

        if (confirm(Joomla.JText._("COM_GAMIFICATION_DELETE_IMAGE_QUESTION"))) {
            window.location = jQuery(this).attr("href");
        }

    });

    /*jQuery('#jform_context').typeahead({
        source: gfyContexts,
        highlighter: false
    }); */

    /*var contexts = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        // `states` is an array of state names defined in "The Basics"
        local: gfyContexts
    });

    jQuery('#jform_context').typeahead({
            highlight: true,
            minLength: 4
        },
        {
            source: contexts
        });*/

    jQuery('#jform_context').autocomplete({
        lookup: gfyContexts
    });

});