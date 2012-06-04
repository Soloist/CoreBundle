#
#
# Namespace declaration
window.soloist =      {} if not window.soloist?
window.soloist.core = {} if not window.soloist.core?

#
#
# Action selector pop-in
class window.soloist.core.ActionSelector
    defaultOptions =
        buttonHtml:         '<a href="#" class="btn">Chercher</a>'
        retrieveActionsUrl: window.soloist.core.retrieveActionsUrl

    #
    # Constructor
    # Assign options and dom elements
    constructor: (options = {}) ->
        @options      = jQuery.extend {}, defaultOptions, options
        @$labelField  = jQuery '#soloist_action_label'
        @$actionField = jQuery '#soloist_action_action'
        @$paramsField = jQuery '#soloist_action_params'
        @$button      = jQuery @options.buttonHtml

        @initDom()
        @initEvents()

    #
    # Initialize DOM elements, hides system controls
    initDom: ->
        @$labelField.attr 'disabled', true
        @$labelField.after @$button
        @$actionField.parents('.control-group').hide()
        @$paramsField.parents('.control-group').hide()

    #
    # Assign events
    initEvents: ->
        @$button.click @onButtonClickListener.bind @

    #
    #
    # Event listeners

    #
    # Listener triggered when clicking to search button
    onButtonClickListener: ->
        jQuery.ajax
            url:     @options.retrieveActionsUrl
            success: @onActionRequestSuccess.bind @
            error:   ->
                alert 'Impossible de récuperer la liste des actions'
        false

    #
    # Listener triggered at AJAX action retrieving
    onActionRequestSuccess: (data) ->
        @modal = jQuery Twig.render action_modal, data
        @modal.modal()
        # Not using `=>` cause we need initial context.
        that = this
        @modal.find('.action-choose').click ->
            that.onActionChoose.call that, jQuery this

    #
    # Triggered when clicking on choose btn
    onActionChoose: ($button) ->
        $tr = $button.parents 'tr:first'
        @$labelField.val  $tr.attr 'data-label'
        @$actionField.val $tr.attr 'data-action'
        @$paramsField.val $tr.attr 'data-params'
        @modal.modal 'hide'
        false

jQuery ->
    if jQuery '#soloist_action_action'
        new window.soloist.core.ActionSelector()



