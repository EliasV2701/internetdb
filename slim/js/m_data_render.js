/* ------------------------------------------------ */
/*   m_get_render.js - code for js object module    */
/*                     RENDERING DATA               */
/*                                                  */
/*   (C) 2021 Wappfactory - Michael Kreinbihl       */
/*                                                  */
/* ------------------------------------------------ */
/* jshint -W117 */

var m_data_render = (function () {
    "use strict";
    
    // Application object.
    var m_data_render = {};

    //************************************************
    // PRIVATE member variables
        
    var var1;
    
    //************************************************
    // PRIVATE FUNCTIONS
    
	function _myPrivFunc (param) {
		// code here
	}
    
    //************************************************
    // member variables

	

    //************************************************
    // member functions

	// init object 

	m_data_render.init = function () {
		// init object here
	};


    // get json data with ajax

	m_data_render.renderLocationList = function () {

        // do rendering
        var jsonObj, textItems, htmlText;

        console.log(m_data_get);
 
        if (!m_data_get.finishedWithError) {

            // get saved data
            jsonObj = m_data_get.locations;

            var output = '<table class="table table-hover">' +
            '<tr><th>Major-Wert&nbsp&nbsp</th><th>Minor-Wert&nbsp&nbsp</th><th>Bezeichnung</th></tr>';

            console.log("DATA: ", jsonObj);

            $.each(jsonObj, function(index, location){
                output += '<tr id="' +index+ '"><td>'+location.major+ '</td><td>' +location.minor+ '</td><td>' +location.location+'</td></tr>';
            });

            output += '</table>';

            // Now that we have build html let's render into the DOM            
            $('#locations').html(output);

            // Then define click events on items
            $.each(jsonObj, function(index, location){
                $('#'+index).click(function() { 
                    m_data_get.getLocationDetail(
                        m_data_get.locations[index].major, 
                        m_data_get.locations[index].minor, 
                        m_data_render.renderLocationDetail
                    ); 
                });
            });

        } else {
            var alertHeading = "Error " + m_data_get.error.code;
            var alertText = m_data_get.error.message;

            alert(alertHeading + ": " + alertText);
        }
    };


    m_data_render.renderLocationDetail = function () {

        console.log(m_data_get);
        
        // do rendering for detail
        $('#detailsModalBody').html(JSON.stringify(m_data_get.detail));
        $('#detailsModal').modal('show');
    }



    return m_data_render;

})();

/* 
 * Sometimes it it a good idea to do the init right here
 * after module is loaded, if so => remove comment chars //
*/ 

// m_data_render.init();
