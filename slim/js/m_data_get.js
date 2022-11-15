/* ------------------------------------------------ */
/*   m_data_get.js - code for js object module      */
/*                   GETTING DATA                   */
/*                                                  */
/*   (C) 2021 Wappfactory - Michael Kreinbihl       */
/*                                                  */
/* ------------------------------------------------ */
/* jshint -W117 */

var m_data_get = (function () {
    "use strict";
    
    // Application object.
    var m_data_get = {};

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

	m_data_get.locations = null;
    m_data_get.detail = null;
    m_data_get.finishedWithError = false;
    m_data_get.error = {};
    m_data_get.baseadr = "https://dev.wappprojects.de/wiws20i/slim";  // www.xxx.de/app/api/v3

	

    //************************************************
    // member functions

	// init object 

	m_data_get.init = function () {
		// init object here
	};


    // get locations list in json with ajax

	m_data_get.getLocationsList = function (do_next_func) {

        function success_func (result) {
           if (result !== null) {
                m_data_get.locations = result.data;
            } else {
                m_data_get.data = {};
            }

            do_next_func();

        };

        function error_func (xhr, status, error) {
            console.log("XHR", xhr);
            m_data_get.locations = {};
            m_data_get.finishedWithError = true;
            m_data_get.error.status = status;
            m_data_get.error.code = xhr.status;
            m_data_get.error.message = error;

            do_next_func();
        };

        $.ajax({
            type: "GET",
            url: m_data_get.baseadr + '/locations',
            headers: {
                'email': 'test@wappprojects.de',
                'api-token': 'dummy'
            },
            data: '',
            success: success_func,
            error: error_func
        });
    };


    // get location detail in json with ajax

    m_data_get.getLocationDetail = function (major, minor, do_next_func) {

        function success_func (result) {
           if (result !== null) {
                m_data_get.detail = result.data;
            } else {
                m_data_get.detail = {};
            }

            do_next_func();

        };

        function error_func (xhr, status, error) {
            console.log("XHR", xhr);
            m_data_get.detail = {};
            m_data_get.finishedWithError = true;
            m_data_get.error.status = status;
            m_data_get.error.code = xhr.status;
            m_data_get.error.message = error;

            do_next_func();
        };

        $.ajax({
            type: "GET",
            url: m_data_get.baseadr + '/location/' + major + '/' + minor,
            headers: {
                'email': 'test@wappprojects.de',
                'api-token': 'dummy'
            },
            data: '',
            success: success_func,
            error: error_func
        });
    };


    return m_data_get;
})();

/* 
 * Sometimes it it a good idea to do the init right here
 * after module is loaded, if so => remove comment chars //
*/ 

// m_data_get.init();
