var oCache = {
    iCacheLower: -1
};

function fnSetKey( aoData, sKey, mValue ) {
    for ( var i=0, iLen=aoData.length ; i<iLen ; i++ ) {
        if ( aoData[i].name == sKey ) {
            aoData[i].value = mValue;
        }
    }
}

function fnGetKey( aoData, sKey ) {
    for ( var i=0, iLen=aoData.length ; i<iLen ; i++ ) {
        if ( aoData[i].name == sKey ) {
            return aoData[i].value;
        }
    }
    return null;
}

function fnDataTablesPipeline ( sSource, aoData, fnCallback ) {
    var iPipe = 5; /* Ajust the pipe size */

    var bNeedServer = false;
    var sEcho = fnGetKey(aoData, "sEcho");
    var iRequestStart = fnGetKey(aoData, "iDisplayStart");
    var iRequestLength = fnGetKey(aoData, "iDisplayLength");
    var iRequestEnd = iRequestStart + iRequestLength;
    oCache.iDisplayStart = iRequestStart;

    /* outside pipeline? */
    if ( oCache.iCacheLower < 0 || iRequestStart < oCache.iCacheLower || iRequestEnd > oCache.iCacheUpper ) {
        bNeedServer = true;
    }

    /* sorting etc changed? */
    if ( oCache.lastRequest && !bNeedServer ) {
        for( var i=0, iLen=aoData.length ; i<iLen ; i++ ){
            if ( aoData[i].name != "iDisplayStart" && aoData[i].name != "iDisplayLength" && aoData[i].name != "sEcho" ){
                if ( aoData[i].value != oCache.lastRequest[i].value ){
                    bNeedServer = true;
                    break;
                }
            }
        }
    }

    /* Store the request for checking next time around */
    oCache.lastRequest = aoData.slice();

    if ( bNeedServer ){
        if ( iRequestStart < oCache.iCacheLower ){
            iRequestStart = iRequestStart - (iRequestLength*(iPipe-1));
            if ( iRequestStart < 0 ){
                iRequestStart = 0;
            }
        }

        oCache.iCacheLower = iRequestStart;
        oCache.iCacheUpper = iRequestStart + (iRequestLength * iPipe);
        oCache.iDisplayLength = fnGetKey( aoData, "iDisplayLength" );
        fnSetKey( aoData, "iDisplayStart", iRequestStart );
        fnSetKey( aoData, "iDisplayLength", iRequestLength*iPipe );

        $.getJSON( sSource, aoData, function (json) {
            /* Callback processing */
            oCache.lastJson = jQuery.extend(true, {}, json);

            if ( oCache.iCacheLower != oCache.iDisplayStart ){
                json.aaData.splice( 0, oCache.iDisplayStart-oCache.iCacheLower );
            }
            json.aaData.splice( oCache.iDisplayLength, json.aaData.length );

            fnCallback(json)
        } );
    }else{
        json = jQuery.extend(true, {}, oCache.lastJson);
        json.sEcho = sEcho; /* Update the echo for each response */
        json.aaData.splice( 0, iRequestStart-oCache.iCacheLower );
        json.aaData.splice( iRequestLength, json.aaData.length );
        fnCallback(json);
        return;
    }
}

/* Define two custom functions (asc and desc) for string sorting */
jQuery.fn.dataTableExt.oSort['string-case-asc']  = function(x,y) {
    return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};

jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x,y) {
    return ((x < y) ?  1 : ((x > y) ? -1 : 0));
};


var oTable;
var asInitVals = new Array();

$(document).ready(function() {
    oTable = $('#transfersTable').dataTable({
        "oLanguage": {
            "sProcessing":   "Processing...",
            "sLengthMenu":   "Show _MENU_ entries",
            "sZeroRecords":  "No matching records found",
            "sInfo":         "Showing _START_ to _END_ of _TOTAL_ entries",
            "sInfoEmpty":    "Showing 0 to 0 of 0 entries",
            "sInfoFiltered": "(filtered from _MAX_ total entries)",
            "sInfoPostFix":  "",
            "sSearch":       "Search in all columns:",
            "sUrl":          "",
            "oPaginate": {
                "sFirst":    "First",
                "sPrevious": "Previous",
                "sNext":     "Next",
                "sLast":     "Last"
            }
        },
        "fnDrawCallback": function(oSettings) {
        	$('#transfersTable tbody tr a').click( function(e) {
				aPos = oTable.fnGetPosition(this.parentNode);
				Data = oSettings.aoData[aPos[0]]._aData[1];
				GetID=$(this).attr("id");
				link=$(this).attr("href");
				if(GetID!="NewWindow") {
					window.location = link;
					return false;
				}else{
					e.preventDefault();
					var src = "../dosuuser.php?uid="+ Data;
					$.modal('<iframe src="' + src + '" height="650" width="830" style="border:0">', {
						containerCss:{
						backgroundColor:"#fff", 
						borderColor:"#999999", 
						height:650,
						width:830,
						padding:0 
						
					},
					onClose: function(){
						//logout user session on close
						$.modal.close();
						$.get("../index.php?logout=true");
					},
					overlayClose:true
					});
					return false;
				}
			});
        	
            $('#transfersTable tbody tr').click( function() {
            	var iPos = oTable.fnGetPosition( this );
                whatType=oSettings.aoData[iPos]._aData[4];
                if (whatType.match(/Deposit.*?/)) {
                	window.location = "transfers.php?action=edit_deposit&ref="+oSettings.aoData[iPos]._aData[0];
                }else{
                	window.location = "transfers.php?action=edit_withdraw&ref="+oSettings.aoData[iPos]._aData[0];
                }
            });
        },
        "fnRowCallback": function( nRow, aData ) {
        	eventClass = 'Disabled';
        	if(aData[7]=="Transfered") {
        		eventClass = 'Transfered';
        	}

        	if (aData[7]=="Pending") {
        		eventClass = 'Pending';
        	}
			
        	$(nRow).addClass(eventClass);
			
        	return nRow;
        },
        "bProcessing": true,
        "bServerSide": true,
        "bAutoWidth": false,
        "sAjaxSource": "tables/tables_transfers.php",
        "bJQueryUI": true,
        "bSortClasses": false,
        "sPaginationType": "full_numbers",
        "fnServerData": fnDataTablesPipeline,
        "iDisplayLength": 100,
        "aaSorting": [ [0,'desc'] ],
        "aoColumns": [
        null,
        null,
        null,
        null,
        null,
        null,
		null,
        null,
        {"bSortable": false, "sWidth": "75px" }
        ],
        "sDom": '<"fg-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"lfr>t<"fg-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"ip>T'
    });
	
    $("thead input").click( function (e) {
        stopTableSorting(e);
    });
	
    $("thead input").keyup( function () {
        oTable.fnFilter( this.value, $("thead input").index(this) );
    });
	
    $("#transfersTable tbody").mouseover(function(event) {
        $(event.target.parentNode).css('cursor','pointer');
    });
});