// <!-- Initiate WYIWYG text area
$(function ()
{
    $('#wysiwyg').wysiwyg(
            {
                controls: {
                    separator01: {visible: true},
                    separator03: {visible: true},
                    separator04: {visible: true},
                    separator00: {visible: true},
                    separator07: {visible: false},
                    separator02: {visible: false},
                    separator08: {visible: false},
                    insertOrderedList: {visible: true},
                    insertUnorderedList: {visible: true},
                    undo: {visible: true},
                    redo: {visible: true},
                    justifyLeft: {visible: true},
                    justifyCenter: {visible: true},
                    justifyRight: {visible: true},
                    justifyFull: {visible: true},
                    subscript: {visible: true},
                    superscript: {visible: true},
                    underline: {visible: true},
                    increaseFontSize: {visible: false},
                    decreaseFontSize: {visible: false}
                }
            });
});


//   Initiate tablesorter script -->
$(document).ready(function () {
    $("#myTable")
            .tablesorter({
                // zebra coloring
                widgets: ['zebra'],
                // pass the headers argument and assing a object
                headers: {
                    // assign the sixth column (we start counting zero)
                    6: {
                        // disable it by setting the property sorter to false
                        sorter: false
                    }
                }
            })
            .tablesorterPager({container: $("#pager")});



});

$(function () {
    $('.password').pstrength();
});

/**
 * Function for hide message box after 5 seconds
 */
function hideMsgbox() {
    if ($('#msgBox')) {
        setTimeout(function () {
            $('#msgBox').css('display', 'none');
        }, 5000);
    }
}

/*
 * Ajax Requests Functions Start Here
 * @type XMLHttpRequest
 */

function sendAjax(dataajx) {
    if (dataajx != '') {
        $.ajax({
            type: "POST",
            url: "index.php",
            data: dataajx,
            dataType: 'json',
            success: function (data) {
                viewOutput(data);
            }
        });
    }
    else
        return false;
}

function statusChange(statusid, idu, classn) {
    if (statusid != '' && idu != '' && classn != '') {
        var sendstring = {
            page: 'ajaxFunctions',
            ajx: 'Yes',
            func_name: 'statusActiveInactive',
            class: classn,
            id: idu
        };
        $.ajax({
            type: "POST",
            url: "index.php",
            data: sendstring,
            dataType: 'json',
            success: function (data) {
                if (data == '0')
                    $('#' + statusid).attr('src', 'images/minus-circle.gif');
                else
                    $('#' + statusid).attr('src', 'images/tick-circle.gif');
            }
        });
    }
}

function getTehsilbyAjax(districtid, divid, classn) {
    if (districtid != '' && divid != '' && classn != '') {
        var returnstring = '<option value="">Select Tehsil</option>';
        var sendstring = {
            page: 'ajaxFunctions',
            ajx: 'Yes',
            func_name: 'getTehsils',
            class: classn,
            id: districtid
        };
        $.ajax({
            type: "POST",
            url: "index.php",
            data: sendstring,
            dataType: 'json',
            success: function (data) {
                if (typeof (data) === 'object') {
                    $(data).each(function (i, val) {
                        returnstring += '<option value="' + val['id'] + '">' + val['tehsil_name'] + '</option>';
                    });
                    console.log(returnstring);
                    $('#' + divid).html(returnstring);
                }
            }
        });
    }
}

/**
 * Comment
 */
function getCallercountries(callertypeid, elementid) {
    if (callertypeid === '') {
        $('#' + elementid).attr('disabled', 'disabled');
    }
    if (callertypeid !== '' && elementid !== '') {
        if (callertypeid === '1') {
            $('#' + elementid).val('99');
            $('#country_id').val('99');
        }
        else {
            $('#' + elementid).val('');
            $('#' + elementid).removeAttr('disabled');
        }
    }
}
/*
 * Ajax Requests Functions End Here
 * @type XMLHttpRequest
 */

/**
 * Function for add category textbox using javascript
 */
function addmore_category(textboxid) {
    var counttextbox = document.getElementById('counttextbox');
    if (textboxid != '') {
//        var addformid = document.getElementById(formid);
        var newtextbox = document.createElement("p");
        var input = document.createElement('input');
        input.setAttribute('type', 'text');
        input.setAttribute('name', textboxid + '[]');
        input.setAttribute('class', 'input-short');
        input.setAttribute('id', textboxid + (parseInt(counttextbox.value) + parseInt(1)));
        newtextbox.appendChild(input);
        document.getElementById('dynamic').appendChild(newtextbox);
        var pretextbox = document.getElementById(textboxid).setAttribute('name', textboxid + '[]');
//        pretextbox.setAttribute('name',textboxid+'[]');
        counttextbox = counttextbox.setAttribute('value', parseInt(counttextbox.value) + parseInt(1));
    }
}

/**
 * function change the input textbox case
 */
function changecase(obj) {
    obj.value = obj.value.toUpperCase();
}

/**document.getElementById(selectid)
 * Function for validate selectbox
 */
function validateSelectbox(selectid) {
    var e = document.getElementById(selectid);
    var strUser = e.options[e.selectedIndex].value;
    if (strUser != '') {
        return true;
    }
    else
        return false;
}

function validateInputBox(inputid) {
    var e = document.getElementById(inputid);
    var strUser = e.value;
    if ((strUser != '') && (strUser.replace(/\s+$/, "") != "")) {
        return true;
    }
    else
        return false;
}


function checkEmail(inputid) {
    var email = document.getElementById(inputid);
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!filter.test(email.value)) {
        return false;
    }
    else {
        return true;
    }
}

/**
 * Comment
 */
function checkUpload(elementid) {
    var re = /(\.jpg|\.jpeg|\.gif|\.bmp|\.png|\.pdf|\.doc|\.docx|\.xls|\.xlsx)$/i;
    var upload = document.getElementById(elementid);
    if (!re.exec(upload.value))
    {
        alert('Please upload images(.jpg,.jpeg,.gif,.bmp,.png), .pdf and document(.doc,.docx,.xls,.xlsx) extension file.');
        return false;
    }
}


/**
 * Function for validate URL
 */

function checkUrl(inputid) {
    var url = document.getElementById(inputid).value;
    var pattern = /^(?:(ftp|http|https):\/\/)?(?:[\w-]+\.)+[a-z]{3,6}$/;
    if (pattern.test(url)) {
        return true;
    }
    else
        return false;
}



function showDiv(divId) {
    if (divId != '') {
        if (document.getElementById(divId)) {
            document.getElementById(divId).style.display = 'block';
            document.getElementById('buttonDiv').style.display = 'none';
        }
        else
            alert('Div not found');
    }
}

function checknum(e)
{
    evt = e || window.event;
    var keypressed = evt.which || evt.keyCode;
    //alert(keypressed);
    if (keypressed != "48" && keypressed != "49" && keypressed != "50" && keypressed != "51" && keypressed != "52" && keypressed != "53" && keypressed != "54" && keypressed != "55" && keypressed != "8" && keypressed != "56" && keypressed != "57" && keypressed != "45" && keypressed != "46" && keypressed != "37" && keypressed != "39" && keypressed != "9")
    {
        return false;
    }
}

function alphaNum(id) {
    if (id == '')
        return;
    var regex = /^[a-zA-Z0-9- ]*$/;
    var idval = document.getElementById(id).value;
    if (regex.test(idval) == false) {
        return true;
    }
    else
        return false;
}

function alphaOnly(id) {
    if (id == '')
        return;
    var regex = /^[a-zA-Z ]*$/;
    var idval = document.getElementById(id).value;
    if (regex.test(idval) == false) {
        return true;
    }
    else
        return false;
}


/**
 * validate complaint form
 */
function validatecomplaintfrm() {
    var cname = document.getElementById('cname');
    var cemail = document.getElementById('cemail');
    var contactno = document.getElementById('contactno');
    var caddress = document.getElementById('caddress');
    var city = document.getElementById('city');
    var complainttype = document.getElementById('complainttype');
    var cdescription = document.getElementById('cdescription');

    if (cname.value == '' || cname.value.replace(/\s+$/, '') == '') {
        alert('Please enter name.');
        cname.focus();
        return false;
    }

    if (cemail.value == '' || cemail.value.replace(/\s+$/, '') == '') {
        alert('Please enter email.');
        cemail.focus();
        return false;
    }
    else if (!checkEmail('cemail')) {
        alert('Please enter valid email.');
        cemail.focus();
        return false;
    }


    if (contactno.value == '' || contactno.value.replace(/\s+$/, '') == '') {
        alert('Please enter contact no.');
        contactno.focus();
        return false;
    }
    else if (isNaN(contactno.value)) {
        alert('Please enter valid contact no.');
        contactno.focus();
        return false;
    }


    if (caddress.value == '' || caddress.value.replace(/\s+$/, '') == '') {
        alert('Please enter address.');
        caddress.focus();
        return false;
    }

    if (city.value == '' || city.value.replace(/\s+$/, '') == '') {
        alert('Please enter city.');
        city.focus();
        return false;
    }

    if (complainttype.value == '' || complainttype.value.replace(/\s+$/, '') == '') {
        alert('Please select complaint type.');
        complainttype.focus();
        return false;
    }

    if (cdescription.value == '' || cdescription.value.replace(/\s+$/, '') == '') {
        alert('Please enter complaint description.');
        cdescription.focus();
        return false;
    }
    window.abillfrm.submit();
}


/**
 * function for go to back page
 */
function gotopage(page_name) {
    window.location = document.getElementById('URL_SITE').getAttribute('title') + '?page=' + page_name;
}



