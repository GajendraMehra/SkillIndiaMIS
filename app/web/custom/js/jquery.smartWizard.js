/*
 * SmartWizard 3.3.1 plugin
 * jQuery Wizard control Plugin
 * by Dipu
 *
 * Refactored and extended:
 * https://github.com/mstratman/jQuery-Smart-Wizard
 *
 * Original URLs:
 * http://www.techlaboratory.net
 * http://tech-laboratory.blogspot.com
 */

function SmartWizard(target, options) {
    this.target       = target;
    this.options      = options;
    this.curStepIdx   = options.selected;
    this.steps        = jQuery(target).children("ul").children("li").children("a"); // Get all anchors
    this.contentWidth = 0;
    this.msgBox = jQuery('<div class="msgBox"><div class="content"></div><a href="#" class="close">X</a></div>');
    this.elmStepContainer = jQuery('<div></div>').addClass("stepContainer");
    this.loader = jQuery('<div>Loading</div>').addClass("loader");
    this.buttons = {
        next : jQuery('<a>'+options.labelNext+'</a>').attr("href","#").addClass("buttonNext"),
        previous : jQuery('<a>'+options.labelPrevious+'</a>').attr("href","#").addClass("buttonPrevious"),
        finish  : jQuery('<a>'+options.labelFinish+'</a>').attr("href","#").addClass("buttonFinish")
    };

    /*
     * Private functions
     */

    var _init = function(jQuerythis) {
        var elmActionBar = jQuery('<div></div>').addClass("actionBar");
        elmActionBar.append(jQuerythis.msgBox);
        jQuery('.close',jQuerythis.msgBox).click(function() {
            jQuerythis.msgBox.fadeOut("normal");
            return false;
        });

        var allDivs = jQuerythis.target.children('div');
        // CHeck if ul with steps has been added by user, if not add them
        if(jQuerythis.target.children('ul').length == 0 ){
            var ul = jQuery("<ul/>");
            target.prepend(ul)

            // for each div create a li
            allDivs.each(function(i,e){
                var title = jQuery(e).first().children(".StepTitle").text();
                var s = jQuery(e).attr("id")
                // if referenced div has no id, add one.
                if (s==undefined){
                    s = "step-"+(i+1)
                    jQuery(e).attr("id",s);
                }
                var span = jQuery("<span/>").addClass("stepDesc").text(title);
                var li = jQuery("<li></li>").append(jQuery("<a></a>").attr("href", "#" + s).append(jQuery("<label></label>").addClass("stepNumber").text(i + 1)).append(span));
                ul.append(li);
            });
            // (re)initialise the steps property
            jQuerythis.steps = jQuery(target).children("ul").children("li").children("a"); // Get all anchors
        }
        jQuerythis.target.children('ul').addClass("anchor");
        allDivs.addClass("content");

        // highlight steps with errors
        if(jQuerythis.options.errorSteps && jQuerythis.options.errorSteps.length>0){
            jQuery.each(jQuerythis.options.errorSteps, function(i, n){
                jQuerythis.setError({ stepnum: n, iserror:true });
            });
        }

        jQuerythis.elmStepContainer.append(allDivs);
        elmActionBar.append(jQuerythis.loader);
        jQuerythis.target.append(jQuerythis.elmStepContainer);

        for( var btnIndex in jQuerythis.options.buttonOrder)
        {
            if(!jQuerythis.options.buttonOrder.hasOwnProperty(btnIndex))
            {
                continue;
            }

            switch(jQuerythis.options.buttonOrder[btnIndex])
            {
                case 'finish':
                    elmActionBar.append(jQuerythis.buttons.finish);
                    break;
                case 'next':
                    elmActionBar.append(jQuerythis.buttons.next);
                    break;
                case 'prev':
                    elmActionBar.append(jQuerythis.buttons.previous);
                    break;
            }
        }
        
        jQuerythis.target.append(elmActionBar);
        this.contentWidth = jQuerythis.elmStepContainer.width();

        jQuery(jQuerythis.buttons.next).click(function() {
            jQuerythis.goForward();
            return false;
        });
        jQuery(jQuerythis.buttons.previous).click(function() {
            jQuerythis.goBackward();
            return false;
        });
        jQuery(jQuerythis.buttons.finish).click(function() {
            if(!jQuery(this).hasClass('buttonDisabled')){
                if(jQuery.isFunction(jQuerythis.options.onFinish)) {
                    var context = { fromStep: jQuerythis.curStepIdx + 1 };
                    if(!jQuerythis.options.onFinish.call(this,jQuery(jQuerythis.steps), context)){
                        return false;
                    }
                }else{
                    var frm = jQuerythis.target.parents('form');
                    if(frm && frm.length){
                        frm.submit();
                    }
                }
            }
            return false;
        });

        jQuery(jQuerythis.steps).bind("click", function(e){
            if(jQuerythis.steps.index(this) == jQuerythis.curStepIdx){
                return false;
            }
            var nextStepIdx = jQuerythis.steps.index(this);
            var isDone = jQuerythis.steps.eq(nextStepIdx).attr("isDone") - 0;
            if(isDone == 1){
                _loadContent(jQuerythis, nextStepIdx);
            }
            return false;
        });

        // Enable keyboard navigation
        if(jQuerythis.options.keyNavigation){
            jQuery(document).keyup(function(e){
                if(e.which==39){ // Right Arrow
                    jQuerythis.goForward();
                }else if(e.which==37){ // Left Arrow
                    jQuerythis.goBackward();
                }
            });
        }
        //  Prepare the steps
        _prepareSteps(jQuerythis);
        // Show the first slected step
        _loadContent(jQuerythis, jQuerythis.curStepIdx);
    };

    var _prepareSteps = function(jQuerythis) {
        if(! jQuerythis.options.enableAllSteps){
            jQuery(jQuerythis.steps, jQuerythis.target).removeClass("selected").removeClass("done").addClass("disabled");
            jQuery(jQuerythis.steps, jQuerythis.target).attr("isDone",0);
        }else{
            jQuery(jQuerythis.steps, jQuerythis.target).removeClass("selected").removeClass("disabled").addClass("done");
            jQuery(jQuerythis.steps, jQuerythis.target).attr("isDone",1);
        }

        jQuery(jQuerythis.steps, jQuerythis.target).each(function(i){
            jQuery(jQuery(this).attr("href").replace(/^.+#/, '#'), jQuerythis.target).hide();
            jQuery(this).attr("rel",i+1);
        });
    };

    var _step = function (jQuerythis, selStep) {
        return jQuery(
            jQuery(selStep, jQuerythis.target).attr("href").replace(/^.+#/, '#'),
            jQuerythis.target
        );
    };

    var _loadContent = function(jQuerythis, stepIdx) {
        var selStep = jQuerythis.steps.eq(stepIdx);
        var ajaxurl = jQuerythis.options.contentURL;
        var ajaxurl_data = jQuerythis.options.contentURLData;
        var hasContent = selStep.data('hasContent');
        var stepNum = stepIdx+1;
        if (ajaxurl && ajaxurl.length>0) {
            if (jQuerythis.options.contentCache && hasContent) {
                _showStep(jQuerythis, stepIdx);
            } else {
                var ajax_args = {
                    url: ajaxurl,
                    type: jQuerythis.options.ajaxType,
                    data: ({step_number : stepNum}),
                    dataType: "text",
                    beforeSend: function(){
                        jQuerythis.loader.show();
                    },
                    error: function(){
                        jQuerythis.loader.hide();
                    },
                    success: function(res){
                        jQuerythis.loader.hide();
                        if(res && res.length>0){
                            selStep.data('hasContent',true);
                            _step(jQuerythis, selStep).html(res);
                            _showStep(jQuerythis, stepIdx);
                        }
                    }
                };
                if (ajaxurl_data) {
                    ajax_args = jQuery.extend(ajax_args, ajaxurl_data(stepNum));
                }
                jQuery.ajax(ajax_args);
            }
        }else{
            _showStep(jQuerythis,stepIdx);
        }
    };

    var _showStep = function(jQuerythis, stepIdx) {
        var selStep = jQuerythis.steps.eq(stepIdx);
        var curStep = jQuerythis.steps.eq(jQuerythis.curStepIdx);
        if(stepIdx != jQuerythis.curStepIdx){
            if(jQuery.isFunction(jQuerythis.options.onLeaveStep)) {
                var context = { fromStep: jQuerythis.curStepIdx+1, toStep: stepIdx+1 };
                if (! jQuerythis.options.onLeaveStep.call(jQuerythis,jQuery(curStep), context)){
                    return false;
                }
            }
        }
        jQuerythis.elmStepContainer.height(_step(jQuerythis, selStep).outerHeight());
        var prevCurStepIdx = jQuerythis.curStepIdx;
        jQuerythis.curStepIdx =  stepIdx;
        if (jQuerythis.options.transitionEffect == 'slide'){
            _step(jQuerythis, curStep).slideUp("fast",function(e){
                _step(jQuerythis, selStep).slideDown("fast");
                _setupStep(jQuerythis,curStep,selStep);
            });
        } else if (jQuerythis.options.transitionEffect == 'fade'){
            _step(jQuerythis, curStep).fadeOut("fast",function(e){
                _step(jQuerythis, selStep).fadeIn("fast");
                _setupStep(jQuerythis,curStep,selStep);
            });
        } else if (jQuerythis.options.transitionEffect == 'slideleft'){
            var nextElmLeft = 0;
            var nextElmLeft1 = null;
            var nextElmLeft = null;
            var curElementLeft = 0;
            if(stepIdx > prevCurStepIdx){
                nextElmLeft1 = jQuerythis.elmStepContainer.width() + 10;
                nextElmLeft2 = 0;
                curElementLeft = 0 - _step(jQuerythis, curStep).outerWidth();
            } else {
                nextElmLeft1 = 0 - _step(jQuerythis, selStep).outerWidth() + 20;
                nextElmLeft2 = 0;
                curElementLeft = 10 + _step(jQuerythis, curStep).outerWidth();
            }
            if (stepIdx == prevCurStepIdx) {
                nextElmLeft1 = jQuery(jQuery(selStep, jQuerythis.target).attr("href"), jQuerythis.target).outerWidth() + 20;
                nextElmLeft2 = 0;
                curElementLeft = 0 - jQuery(jQuery(curStep, jQuerythis.target).attr("href"), jQuerythis.target).outerWidth();
            } else {
                jQuery(jQuery(curStep, jQuerythis.target).attr("href"), jQuerythis.target).animate({left:curElementLeft},"fast",function(e){
                    jQuery(jQuery(curStep, jQuerythis.target).attr("href"), jQuerythis.target).hide();
                });
            }

            _step(jQuerythis, selStep).css("left",nextElmLeft1).show().animate({left:nextElmLeft2},"fast",function(e){
                _setupStep(jQuerythis,curStep,selStep);
            });
        } else {
            _step(jQuerythis, curStep).hide();
            _step(jQuerythis, selStep).show();
            _setupStep(jQuerythis,curStep,selStep);
        }
        return true;
    };

    var _setupStep = function(jQuerythis, curStep, selStep) {
        jQuery(curStep, jQuerythis.target).removeClass("selected");
        jQuery(curStep, jQuerythis.target).addClass("done");

        jQuery(selStep, jQuerythis.target).removeClass("disabled");
        jQuery(selStep, jQuerythis.target).removeClass("done");
        jQuery(selStep, jQuerythis.target).addClass("selected");

        jQuery(selStep, jQuerythis.target).attr("isDone",1);

        _adjustButton(jQuerythis);

        if(jQuery.isFunction(jQuerythis.options.onShowStep)) {
            var context = { fromStep: parseInt(jQuery(curStep).attr('rel')), toStep: parseInt(jQuery(selStep).attr('rel')) };
            if(! jQuerythis.options.onShowStep.call(this,jQuery(selStep),context)){
                return false;
            }
        }
        if (jQuerythis.options.noForwardJumping) {
            // +2 == +1 (for index to step num) +1 (for next step)
            for (var i = jQuerythis.curStepIdx + 2; i <= jQuerythis.steps.length; i++) {
                jQuerythis.disableStep(i);
            }
        }
    };

    var _adjustButton = function(jQuerythis) {
        if (! jQuerythis.options.cycleSteps){
            if (0 >= jQuerythis.curStepIdx) {
                jQuery(jQuerythis.buttons.previous).addClass("buttonDisabled");
                if (jQuerythis.options.hideButtonsOnDisabled) {
                    jQuery(jQuerythis.buttons.previous).hide();
                }
            }else{
                jQuery(jQuerythis.buttons.previous).removeClass("buttonDisabled");
                if (jQuerythis.options.hideButtonsOnDisabled) {
                    jQuery(jQuerythis.buttons.previous).show();
                }
            }
            if ((jQuerythis.steps.length-1) <= jQuerythis.curStepIdx){
                jQuery(jQuerythis.buttons.next).addClass("buttonDisabled");
                if (jQuerythis.options.hideButtonsOnDisabled) {
                    jQuery(jQuerythis.buttons.next).hide();
                }
            }else{
                jQuery(jQuerythis.buttons.next).removeClass("buttonDisabled");
                if (jQuerythis.options.hideButtonsOnDisabled) {
                    jQuery(jQuerythis.buttons.next).show();
                }
            }
        }
        // Finish Button
        jQuerythis.enableFinish(jQuerythis.options.enableFinishButton);
    };

    /*
     * Public methods
     */

    SmartWizard.prototype.goForward = function(){
        var nextStepIdx = this.curStepIdx + 1;
        if (this.steps.length <= nextStepIdx){
            if (! this.options.cycleSteps){
                return false;
            }
            nextStepIdx = 0;
        }
        _loadContent(this, nextStepIdx);
    };

    SmartWizard.prototype.goBackward = function(){
        var nextStepIdx = this.curStepIdx-1;
        if (0 > nextStepIdx){
            if (! this.options.cycleSteps){
                return false;
            }
            nextStepIdx = this.steps.length - 1;
        }
        _loadContent(this, nextStepIdx);
    };

    SmartWizard.prototype.goToStep = function(stepNum){
        var stepIdx = stepNum - 1;
        if (stepIdx >= 0 && stepIdx < this.steps.length) {
            _loadContent(this, stepIdx);
        }
    };
    SmartWizard.prototype.enableStep = function(stepNum) {
        var stepIdx = stepNum - 1;
        if (stepIdx == this.curStepIdx || stepIdx < 0 || stepIdx >= this.steps.length) {
            return false;
        }
        var step = this.steps.eq(stepIdx);
        jQuery(step, this.target).attr("isDone",1);
        jQuery(step, this.target).removeClass("disabled").removeClass("selected").addClass("done");
    }
    SmartWizard.prototype.disableStep = function(stepNum) {
        var stepIdx = stepNum - 1;
        if (stepIdx == this.curStepIdx || stepIdx < 0 || stepIdx >= this.steps.length) {
            return false;
        }
        var step = this.steps.eq(stepIdx);
        jQuery(step, this.target).attr("isDone",0);
        jQuery(step, this.target).removeClass("done").removeClass("selected").addClass("disabled");
    }
    SmartWizard.prototype.currentStep = function() {
        return this.curStepIdx + 1;
    }

    SmartWizard.prototype.showMessage = function (msg) {
        jQuery('.content', this.msgBox).html(msg);
        this.msgBox.show();
    }

    SmartWizard.prototype.enableFinish = function (enable) {
        // Controll status of finish button dynamically
        // just call this with status you want
        this.options.enableFinishButton = enable;
        if (this.options.includeFinishButton){
            if (!this.steps.hasClass('disabled') || this.options.enableFinishButton){
                jQuery(this.buttons.finish).removeClass("buttonDisabled");
                if (this.options.hideButtonsOnDisabled) {
                    jQuery(this.buttons.finish).show();
                }
            }else{
                jQuery(this.buttons.finish).addClass("buttonDisabled");
                if (this.options.hideButtonsOnDisabled) {
                    jQuery(this.buttons.finish).hide();
                }
            }
        }
        return this.options.enableFinishButton;
    }

    SmartWizard.prototype.hideMessage = function () {
        this.msgBox.fadeOut("normal");
    }
    SmartWizard.prototype.showError = function(stepnum) {
        this.setError(stepnum, true);
    }
    SmartWizard.prototype.hideError = function(stepnum) {
        this.setError(stepnum, false);
    }
    SmartWizard.prototype.setError = function(stepnum,iserror) {
        if (typeof stepnum == "object") {
            iserror = stepnum.iserror;
            stepnum = stepnum.stepnum;
        }

        if (iserror){
            jQuery(this.steps.eq(stepnum-1), this.target).addClass('error')
        }else{
            jQuery(this.steps.eq(stepnum-1), this.target).removeClass("error");
        }
    }

    SmartWizard.prototype.fixHeight = function(){
        var height = 0;

        var selStep = this.steps.eq(this.curStepIdx);
        var stepContainer = _step(this, selStep);
        stepContainer.children().each(function() {
            if(jQuery(this).is(':visible')) {
                 height += jQuery(this).outerHeight(true);
            }
        });

        // These values (5 and 20) are experimentally chosen.
        stepContainer.height(height + 5);
        this.elmStepContainer.height(height + 20);
    }

    _init(this);
};



(function(jQuery){

    jQuery.fn.smartWizard = function(method) {
        var args = arguments;
        var rv = undefined;
        var allObjs = this.each(function() {
            var wiz = jQuery(this).data('smartWizard');
            if (typeof method == 'object' || ! method || ! wiz) {

                // show deprecated message for includeFinishButton  and reverseButtonsOrder options
                if(method.hasOwnProperty('includeFinishButton') || method.hasOwnProperty('reverseButtonsOrder'))
                {
                    console.log("[WARNING] Parameter 'includeFinishButton' and 'reverseButtonsOrder' are " +
                        "deprecated an will be removed in the next release. Use option 'buttonOrder' instead.");
                }

                var options = jQuery.extend({}, jQuery.fn.smartWizard.defaults, method || {});

                // handle deprecated reverseButtonsOrder option
                if(options.reverseButtonsOrder === true)
                {
                    options.buttonOrder.reverse()
                }

                // handle deprecated includeFinishButton option
                if(options.includeFinishButton === false)
                {
                    var index = options.buttonOrder.indexOf('finish');
                    if (index > -1) {
                        options.buttonOrder.splice(index, 1);
                    }
                }

                if (! wiz) {
                    wiz = new SmartWizard(jQuery(this), options);
                    jQuery(this).data('smartWizard', wiz);
                }
            } else {
                if (typeof SmartWizard.prototype[method] == "function") {
                    rv = SmartWizard.prototype[method].apply(wiz, Array.prototype.slice.call(args, 1));
                    return rv;
                } else {
                    jQuery.error('Method ' + method + ' does not exist on jQuery.smartWizard');
                }
            }
        });
        if (rv === undefined) {
            return allObjs;
        } else {
            return rv;
        }
    };

// Default Properties and Events
    jQuery.fn.smartWizard.defaults = {
        selected: 0,  // Selected Step, 0 = first step
        keyNavigation: true, // Enable/Disable key navigation(left and right keys are used if enabled)
        enableAllSteps: false,
        transitionEffect: 'fade', // Effect on navigation, none/fade/slide/slideleft
        contentURL:null, // content url, Enables Ajax content loading
        contentCache:true, // cache step contents, if false content is fetched always from ajax url
        cycleSteps: false, // cycle step navigation
        enableFinishButton: false, // make finish button enabled always
        hideButtonsOnDisabled: false, // when the previous/next/finish buttons are disabled, hide them instead?
        errorSteps:[],    // Array Steps with errors
        labelNext:'Next',
        labelPrevious:'Previous',
        labelFinish:'Finish',
        noForwardJumping: false,
        ajaxType: "POST",
        onLeaveStep: null, // triggers when leaving a step
        onShowStep: null,  // triggers when showing a step
        onFinish: null,  // triggers when Finish button is clicked
        includeFinishButton : true,   // Add the finish button
        reverseButtonsOrder: false, //shows buttons ordered as: prev, next and finish
        buttonOrder: ['finish', 'next', 'prev']  // button order, to hide a button remove it from the list
};

})(jQuery);
