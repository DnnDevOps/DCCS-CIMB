$(document).ready(function () {
    function switchMacroState(macro) {
        var hideTrunk = false,
            hidePeer = true,
            hideQueue = true,
            hideDestination = false,
            hideRecord = false;
        
        if (macro !== 'dial-trunk') {
            hideTrunk = true;
            hideDestination = true;
            hideRecord = true;
        }
        
        switch (macro) {
            case 'dial-peer':
                hidePeer = false;
                hideQueue = true;
                break;
            case 'enter-queue':
                hidePeer = true;
                hideQueue = false;
                break;
        }
        
        if (hideTrunk) {
            $('#trunk-field').addClass('hidden');
        } else {
            $('#trunk-field').removeClass('hidden');
        }
        
        if (hidePeer) {
            $('#peer-field').addClass('hidden');
        } else {
            $('#peer-field').removeClass('hidden');
        }
        
        if (hideQueue) {
            $('#queue-field').addClass('hidden');
        } else {
            $('#queue-field').removeClass('hidden');
        }
        
        if (hideDestination) {
            $('#destination-field').addClass('hidden');
        } else {
            $('#destination-field').removeClass('hidden');
        }
        
        if (hideRecord) {
            $('#record-field').addClass('hidden');
        } else {
            $('#record-field').removeClass('hidden');
        }
    }
    
    switchMacroState($('#macro').val());
    
    $('#macro').change(function (event) {
        switchMacroState(event.currentTarget.value);
    });
});
//# sourceMappingURL=extension.js.map
