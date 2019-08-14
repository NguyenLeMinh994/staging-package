//defined plan form wizard table in add function
$(function() {
    /* TYPEHEAD JS START */
    var engine_country = new Bloodhound({
        remote: {
            url: '/suggest-country?q=%QUERY%',
            wildcard: '%QUERY%'
        },
        datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
        queryTokenizer: Bloodhound.tokenizers.whitespace
    });

    var engine_region = new Bloodhound({
        remote: {
            url: '/suggest-region?q=%QUERY&country_id=%CID',
            replace: function(url, query) {
                return url.replace('%QUERY', query).replace('%CID', $('#country_id').val());
            }
        },
        datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
        queryTokenizer: Bloodhound.tokenizers.whitespace
    });

    $("#country_suggest").typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        source: engine_country.ttAdapter(),
        name: 'value',
        templates: {
            empty: [
                '<ul class="list-group"><li class="list-group-item">Not Found.</li></ul>'
            ],
            header: [
                '<ul class="list-group">'
            ],
            suggestion: function (data) {
                return '<li' + data.id + ' class="list-group-item">' + data.value + ' - ' + data.name + '</li>'
            }
        },
        display: function(data) {
            return data.value + ' - ' + data.name  //Input value to be set when you select a suggestion. 
        }
    }).on('typeahead:selected', function(evt, item) {
        $('#country_suggest').removeClass("complete_loading");
        $('#country_id').val(item.id);
        $('#country_code').val(item.value);
        resetRegionDefaultValue();
    }).on('typeahead:autocompleted', function(evt, item) {
        $('#country_id').val(item.id);
        $('#country_code').val(item.value);
        resetRegionDefaultValue();
    }).on('typeahead:asyncrequest', function() {
        $('#country_suggest').addClass("complete_loading");
    }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
        $('#country_suggest').removeClass("complete_loading");
    });
   

    $("#region_suggest").typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        source: engine_region.ttAdapter(),
        name: 'value',
        templates: {
            empty: [
                '<ul class="list-group"><li class="list-group-item">Not Found.</li></ul>'
            ],
            header: [
                '<ul class="list-group">'
            ],
            suggestion: function (data) {
                return '<li' + data.id + ' class="list-group-item">' + data.value + '</li>'
            }
        },
        display: function(data) {
            return data.value  //Input value to be set when you select a suggestion. 
        }
    }).on('typeahead:selected', function(evt, item) {
        $('#region_suggest').removeClass("complete_loading");
        $('#region_id').val(item.id);
    }).on('typeahead:autocompleted', function(evt, item) {
        $('#region_id').val(item.id);
    }).on('typeahead:asyncrequest', function() {
        $('#region_suggest').addClass("complete_loading");
    }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
        $('#region_suggest').removeClass("complete_loading");
    }).on('typeahead:autocompleted', function(evt, item) {
        $('#region_id').val(item.id);
    });
    /* TYPEHEAD JS END */

    function resetRegionDefaultValue() {
        $('#region_suggest').val('');
        $('#region_id').val('');
    }
});


/* Phone Number Start */
var code={CN:"86",ID:"62",JP:"81",KH:"855",KR:"82",LA:"856",MY:"60",PH:"63",SG:"65",TH:"66",TW:"886",VN:"84",MM:"95"};
var selectCountry = $('.select-country');
var html = '';

for (var i in code) {
    html += '<option value="+' + code[i] + '">' + i + '</option>';
}

selectCountry.html(html);
selectCountry.val('+855');

$("#supplier_phone").val('+855');

var cleavePhone = new Cleave('.input-phone', {
    phone:           true,
    phoneRegionCode: 'KH'
});

selectCountry.on('change', function () {
    cleavePhone.setPhoneRegionCode(this.value);
    cleavePhone.setRawValue(this.value);
    $('.input-phone').focus();
});
/* Phone Number End */

/* Contact 1 on change Start */
$("#contact1_firstname").on('change', function () {
    let contact2_firstname = $("#contact2_firstname").val();
    if (contact2_firstname.length <= 0)
        $("#contact2_firstname").val($("#contact1_firstname").val())
});

$("#contact1_lastname").on('change', function () {
    let contact2_lastname = $("#contact2_lastname").val();
    if (contact2_lastname.length <= 0)
        $("#contact2_lastname").val($("#contact1_lastname").val())
});

$("#contact1_role").on('change', function () {
    let contact2_role = $("#contact2_role").val();
    if (contact2_role.length <= 0)
        $("#contact2_role").val($("#contact1_role").val())
});

$("#contact1_skype").on('change', function () {
    let contact2_skype = $("#contact2_skype").val();
    if (contact2_skype.length <= 0)
        $("#contact2_skype").val($("#contact1_skype").val())
});

$("#contact1_email").on('change', function () {
    let contact2_email = $("#contact2_email").val();
    if (contact2_email.length <= 0)
        $("#contact2_email").val($("#contact1_email").val())
});

$("#contact1_phone").on('change', function () {
    let contact2_phone = $("#contact2_phone").val();
    if (contact2_phone.length <= 0)
        $("#contact2_phone").val($("#contact1_phone").val())
});
/* Contact 1 on change End */
