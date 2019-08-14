@extends('layouts.login')
@section('body.content')
<link href="{{asset('/asset/package/login/custom.login.css')}}" rel="stylesheet" type="text/css" />
<style>
    .twitter-typeahead, .tt-hint, .tt-input, .tt-menu { 
        width: 100%; 
    }
    .grecaptcha-badge{
        z-index: 21 !important;
    }
</style>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="m-grid__item m-grid__item--fluid m-login__wrapper cus-m-login__wrapper">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-content">
            <div class="row">
                <div class="col-lg-5">
                    <!--Begin::register box-->
                    <div class="m-login__container cus_login_box">
                        <div class="m-login__signin">
                            <div class="m-login__head">
                                <h3 class="m-login__title">No Account Yet?</h3>
                            </div>
                            <!--begin::Form-->
                            <form class="m-register__form m-form" id="register_form">
                                @csrf
                                <div class="m-form__section m-form__section--first">
                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title">1. Create your profile to login:</h3>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label for="first_name">First Name<span style="color:red">*</span></label>
                                        <input type="text" class="form-control m-input" placeholder="John" id="first_name" name="first_name" maxlength="20">
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label for="lastname">Last Name<span style="color:red">*</span></label>
                                        <input type="text" class="form-control m-input" placeholder="Smith" id="last_name" name="last_name" maxlength="20">
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label for="job_title">Job Title<span style="color:red">*</span></label>
                                        <input type="text" class="form-control m-input" placeholder="Manager" id="job_title" name="job_title" maxlength="20">
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label for="email">Email<span style="color:red">*</span></label>
                                        <span class="m-form__helper-customize">This will also be your username.</span>
                                        <input type="email" class="form-control m-input" placeholder="yourname@yourcompany.com" id="email" name="email" maxlength="100">
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label for="password">Password<span style="color:red">*</span></label>
                                        <span class="m-form__helper-customize">Minimum 8 characters.</span>
                                        <input type="password" class="form-control m-input" placeholder="Enter your password" id="password" name="password" maxlength="30">
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label for="mobile_number">Mobile Number<span style="color:red">*</span></label>
                                        <div class="m-input-icon m-input-icon--left">
                                            <input type="text" class="form-control m-input" placeholder="Enter Phone number" id="mobile_number" name="mobile_number" maxlength="20">
                                            <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="la la-phone"></i></span></span>
                                        </div>
                                        <span class="m-form__help" style="display:none"></span>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label for="skype_id">Skype</label>
                                        <div class="m-input-icon m-input-icon--left">
                                            <input type="text" class="form-control m-input" placeholder="Enter Your Skype" id="skype_id" name="skype_id" maxlength="50">
                                            <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="la la-skype"></i></span></span>
                                        </div>
                                        <span class="m-form__help" style="display:none"></span>
                                    </div>
                                </div>
                                <div class="m-separator m-separator--dashed" style="border-bottom: 1px dashed #9699a2"></div>
                                <div class="m-form__section m-form__section--last">
                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title">2. Company Information:</h3>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label for="company_name">Company Name<span style="color:red">*</span></label>
                                        <input type="text" class="form-control m-input" placeholder="My Travel Company" id="company_name" name="company_name" maxlength="100">
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label for="company_web">Company Website</label>
                                        <input type="text" class="form-control m-input" placeholder="https://www.mytravelcompany.com" id="company_web" name="company_web" maxlength="100">
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>Country<span style="color:red">*</span></label>
                                        <div class="m-typeahead">
                                            <input class="form-control m-input" id="m_typeahead_country" name="country" type="text" placeholder="Select your Country" maxlength="100">
                                        </div>
                                        <input type="hidden" id="country_id">
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>Region<span style="color:red">*</span></label>
                                        <div class="m-typeahead">
                                            <input class="form-control m-input" id="m_typeahead_region" name="region" type="text" placeholder="Select your Region" maxlength="100">
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>Which supplier type best describes your company?</label>
                                        @foreach($category as $item)
                                        <div class="m-checkbox-inline">
                                            <label class="m-checkbox">
                                                <input type="checkbox" name="supplier_category[]" value="{{$item->category_id}}"> 
                                                {{$item->category_name}}
                                                <span></span>
                                            </label>
                                        </div>
                                        @endforeach
                                        <span class="m-form__help"></span>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>Which product type would you like to offer?</label>
                                         @foreach($product as $item)
                                        <div class="m-checkbox-inline">
                                            <label class="m-checkbox">
                                                <input type="checkbox" name="supplier_product_type[]" value="{{$item->id}}"> 
                                                {{$item->name}}
                                                <span></span>
                                            </label>
                                        </div>
                                        @endforeach
                                        <span class="m-form__help"></span>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>Can your products be on Instant Confirmation basis with 0-72 hours cut-off period?</label>
                                        <div class="m-radio-list">
                                            <label class="m-radio m-radio--state-primary">
                                                <input type="radio" name="instant_confirm" value="yes" checked> Yes
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--state-primary">
                                                <input type="radio" name="instant_confirm" value="no"> No
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group m--margin-top-10">
                                        <div class="alert m-alert m-alert--default" role="alert">
                                            <p>Tips: Package Plus + works largely with suppliers who provide instant confirmation products and cut-off period less than 72 hours to in order to attract more bookings.</p>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <div class="m-checkbox-inline">
                                            <label class="m-checkbox">
                                                <input type="checkbox" name="term_condition"> 
                                                    I accept the <a href="#" onclick="open_term_condition()">Terms and Conditions</a>
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div id='recaptcha' class="g-recaptcha"
                                        data-sitekey="6LcBkZcUAAAAAC3k9PLdkF3qeCBR1DMbBsOksP_e"
                                        data-callback="onSubmit"
                                        data-size="invisible">
                                    </div>
                                
                                </div>
                                <div class="m-register__form-actions" style="text-align:right">
                                    <button type="submit" class="btn btn-primary m-btn m-btn--bolder m-btn--uppercase m-btn--wide" id="m_sweetalert_regiter">Apply Now</button>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                    </div>
                    <!-- End Register Box -->
                </div>
                <div class="col-lg-7">
                    <!--Cotent::right-->
                    <div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-grid m-grid--hor m-login__aside cus_content_box">
                        <div class="m-grid__item">
                            <h3 class="m-login__welcome">Who can join?</h3>
                            <p class="m-login__msg">Package Plus + works with professional hospitality industry suppliers including hotels, tourist attractions, restaurants, spas, transport companies, river cruises, guides and retailers to deliver to consumers a unique experience.</p>
                        </div>
                        <div class="m-grid__item">
                            <h3 class="m-login__welcome">Application process</h3>
                            <p class="m-login__msg">Complete the form via the 'Apply Now' button.  Package Plus+ screens all applications and due to the large volume, we will prioritize applications from suppliers that offer instant confirmation.  Once the initial screening process is completed, we will contact you and guide you through the easy setup process, put a contract in place and assist you with setting up your activities online.</p>
                        </div>
                    </div>
                    <!--EndCotent::right-->
                </div>
            </div>
        </div>
    </div>
</div>

<!--begin::Modal Review the Supplier Agreement -->
<div class="modal fade" id="m_modal_register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Terms and Conditions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align:justify;">
                <div class="m-scrollable" data-scrollbar-shown="true" data-scrollable="true" data-height="300" style="overflow:hidden; height: 300px">
                    <p>This Supplier Agreement (the "<b>Agreement</b>") is by and between you ("Supplier") and Mekong Partners Pte Ltd trading both as "TAporta" All defined terms used herein shall have the meaning accorded to such terms in the Agreement.</p>
                    <p><b>Agreement</b></p>
                    <p><b>Overview:</b> Supplier agrees to provide certain tours, activities and other travel-related destination services ("<b>Products</b>") that TAporta may market and distribute through various owned, affiliated, related and third party online and offline marketing and travel distribution channels ("<b>Distribution Channels</b>") for purchase (i.e., booking) by end customers ("<b>Customers</b>"),</p>
                    <p>TAporta and Supplier agree to be bound by the terms and conditions set forth below.</p>
                    <p><b>General Terms and Conditions</b></p>
                    <p>The following terms and conditions apply to all users and their companies of packages.taporta.com hereafter also known as TAporta. Users here refer to individuals who contracts for and on behalf of their companies and includes other staff from the same organization who may be given access to use the site.</p>
                    <p><b>Rights for Usage</b></p>
                    <p>As a condition to use this Website, you warrant that you (i) you are at least 18 years of age, (ii) possess the legal authority to create a binding legal obligation, (iii) you will use this Website in accordance with its Terms & Conditions and (iv) all information supplied by you on this Website are true, accurate, current and complete. We retain the right, at our sole discretion, to deny access to anyone to this Website and the services we offer, at any time and for any reasons, including but not limited to this set of Terms & Conditions.</p>
                    <p><b>Currency</b></p>
                    <p>All amounts in this Agreement are expressed in United States Dollar (USD) the base currency.  All user accounts will be created with the USD base currency for the purpose of invoice and payment unless separately and mutually agreed upon.</p>
                    <p><b>Rates and Payments</b></p>
                    <p>Supplier represents and warrants that the net rates ("<b>Net Rates</b>") offered to TAporta are competitive in relation to rate parity with its own direct booking channel and/or other third-party channels.  TAporta shall have the right in its sole discretion either suspend Supplier or terminate this Agreement with fifteen (15) days prior written notice to Supplier in the event that the net rates are m</p>
                    <p>For each Product, Supplier will provide TAporta the both the net rate and suggested retail rate. Net Rates will include all applicable charge type (per person, per vehicle, per package) fees and all applicable taxes and other charges. Supplier shall be solely responsible for the payment of any and all applicable taxes, including without limitation value added tax, sales and use tax, and any other taxes applicable to the sale of the Products ("<b>Taxes</b>") as calculated based on the suggested retail rate. TAporta has the right to set the actual retail rate of each Product displayed via the Distribution Channels.</p>
                    <p>TAporta will make any payments of Net Rates owed to Supplier under this Agreement pursuant to the payment terms set forth and mutually agreed upon. With respect to any amount to be paid by TAporta under this Agreement, TAporta may offset against such amount any amount that Supplier is obligated to pay to TAporta.</p>
                    <p><b>Product Availability and Updates</b></p>
                    <p>Supplier will follow the operational procedures including without limitation those with respect to product bookings, changes, and availability, and any updates or revisions to as may be provided by TAporta from time to time.</p>
                    <p><b>Cancellation Policies</b></p>
                    <p>Each product has its own set of cancellation policies as implemented by its operator or provider. All users are advised to check the applicable policies that they setup as it can differ by products and travel dates.  On payment of all bookings, it is deemed that the user has accepted the corresponding set of policies. Supplier will not directly accept Customer cancellations for Products purchased via TAporta and its distribution channels. All cancellations for purchased Products must be made by the Customer directly through the distribution partner within the applicable cancellation time period.</p>
                    <p><b>Distribution Channels</b></p>
                    <p>TAporta will have sole discretion over the Distribution Channels utilized and the Product placement within such Distribution Channels. TAporta will be responsible for any applicable travel agents commissions and other third-party intermediaries’ fees for sale of Products through the Distribution Channels.</p>
                    <p><b>Customer Contact and Service</b></p>
                    <p>Supplier will ensure a smooth customer service process, including answering any Customer complaints (including, without limitation, refund requests) in writing within 72 hours after complaint submission.  TAporta where it deems appropriate, will provide Supplier with the Customer contact details.</p>
                    <p>After a Customer has purchased a Product, Supplier will not, without TAporta’s prior consent, contact such Customer for purposes of marketing or selling tours, activities or other travel-related destination services and/or products to such Customer or for any other purpose other than to fulfill the Product purchased or to answer a Customer complaint.</p>
                    <p><b>Supplier Content and Materials</b></p>
                    <p>Supplier hereby grants and agrees to grant to TAporta and its Distribute Channel partners the non-exclusive, perpetual, irrevocable, transferable, sublicenseable (through one or more tiers), worldwide right (but not the obligation) in its sole discretion to reproduce, modify, reformat, create derivative works based upon, publicly display and perform, and otherwise use any and all text, images, videos, and other content and materials provided by the Supplier.</p>
                    <p><b>Term of Contract and Termination</b></p>
                    <p>This Agreement is effective as of the date on which Supplier accepted this Agreement (the "<b>Effective Date</b>") and will remain in effect thereafter, unless terminated in accordance with this Agreement. Either party may terminate this Agreement (a) upon 30 days written notice to the other of its intent to terminate this Agreement, (b) immediately upon written notice to the other if such other party commits an irremediable breach of this Agreement or commits a remediable breach and fails to correct such breach within 15 days following written notice specifying such breach, or (c) immediately upon an event of bankruptcy by Supplier or if Supplier ceases to do business in the ordinary course.</p>
                    <p><b>Force Majeure</b></p>
                    <p>If either party is prevented from performing any of its duties and obligations hereunder in a timely manner by reason of any act of God, strike, labor dispute, earthquake, fire, flood, public disaster, equipment, software or technical malfunctions or failures, power failures or interruptions, acts of terrorism, war, civil unrest, riots or any other reason beyond its reasonable control (each a "Force Majeure Event"), such party will be excused from performance of any such duty or obligation for the period during which such condition exists. </p>
                    <p><b>Dispute Resolution</b></p>
                    <p>This Agreement shall be exclusively governed and construed in all respects in accordance with Singapore law. The Parties hereby irrevocably consent to jurisdiction of the Courts in Singapore.</p>
                    <p>The parties hereto will use their reasonable best efforts to resolve any dispute hereunder through good faith negotiations. A party hereto must submit a written notice to any other party to whom such dispute pertains, and any such dispute that cannot be resolved within thirty (30) calendar days of receipt of such notice (or such other period to which the parties may agree) will be submitted to an arbitrator selected by mutual agreement of the parties. In the event that, within fifty (50) days of the written notice referred to in the preceding sentence, a single arbitrator has not been selected by mutual agreement of the parties, a panel of arbitrators (with each party to the dispute being entitled to select one arbitrator and, if necessary to prevent the possibility of deadlock, one additional arbitrator being selected by such arbitrators selected by the parties to the dispute) shall be selected by the parties. Except as otherwise provided herein or as the parties to the dispute may otherwise agree, such arbitration will be conducted in accordance with the then existing rules of the Singapore International Arbitration Association.</p>
                    <p><b>Limitation of Liability</b></p>
                    <p>TO THE MAXIMUM EXTENT PERMITTED BY LAW, IN NO EVENT WILL EITHER PARTY BE LIABLE UNDER ANY THEORY OF LIABILITY (WHETHER IN CONTRACT, TORT, STATUTE OR OTHERWISE) FOR ANY CONSEQUENTIAL, INCIDENTAL, SPECIAL, EXEMPLARY OR INDIRECT DAMAGES OF ANY KIND, OR FOR ANY LOSS OF PROFITS, LOSS OF REVENUE, LOSS RESULTING FROM INTERRUPTION OF BUSINESS OR LOSS OF USE OR DATA, ARISING OUT OF OR IN CONNECTION WITH THIS AGREEMENT OR THE SUBJECT MATTER OF THIS AGREEMENT, HOWEVER CAUSED, EVEN IF THE OTHER PARTY HAS BEEN ADVISED OF OR SHOULD HAVE KNOWN OF THE POSSIBILITY OF SUCH DAMAGES. TO THE MAXIMUM EXTENT PERMITTED BY LAW, TAPORTA’S LIABILITY TO SUPPLIER FOR DIRECT DAMAGES UNDER THIS AGREEMENT SHALL BE LIMITED TO THE AGGREGATE NET RATE PAID BY TAPORTATO SUPPLIER IN THE THREE MONTHS IMMEDIATELY PRECEDING THE DATE THE CAUSE OF ACTION AROSE.</p>
                    <p><b>By clicking the "APPLY NOW" button, Supplier accepts this Agreement and agrees to the Terms and Conditions.</b></p>
                    <div class="ps__rail-x" style="left: 0px; bottom: -30px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div>
                    <div class="ps__rail-y" style="top: 30px; right: 4px; height: 300px;"><div class="ps__thumb-y" tabindex="0" style="top: 3px; height: 40px;"></div></div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="" type="button" class="btn btn-primary m-btn m-btn--bolder m-btn--uppercase" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->
<script type="text/javascript">
    var engine_country = new Bloodhound({
		remote: {
			url: '/suggest-country?q=%QUERY%',
			rateLimitWait: 500,
			wildcard: '%QUERY%'
		},
		datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
		queryTokenizer: Bloodhound.tokenizers.whitespace
	});

	var engine_region = new Bloodhound({
		remote: {
			url: '/suggest-region?q=%QUERY&country_id=%CID',
			rateLimitWait: 500,
			replace: function(url, query) {
				return url.replace('%QUERY', query).replace('%CID', $('#country_id').val());
			},
		},
		datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
		queryTokenizer: Bloodhound.tokenizers.whitespace
	});

    $("#m_typeahead_country").typeahead({
		hint: true,
		highlight: true,
		minLength: 2
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
        $('#m_typeahead_region').val('');
	}).on('typeahead:autocompleted', function(evt, item) {
		$('#country_id').val(item.id);
        $('#m_typeahead_region').val('');
	}).on('typeahead:asyncrequest', function() {
		$('#country_suggest').addClass("complete_loading");
	}).on('typeahead:asynccancel typeahead:asyncreceive', function() {
		$('#country_suggest').removeClass("complete_loading");
	});

	$("#m_typeahead_region").typeahead({
		hint: true,
		highlight: true,
		minLength: 2
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
	}).on('typeahead:autocompleted', function(evt, item) {
	}).on('typeahead:asyncrequest', function() {
		$('#region_suggest').addClass("complete_loading");
	}).on('typeahead:asynccancel typeahead:asyncreceive', function() {
		$('#region_suggest').removeClass("complete_loading");
	});

    function open_term_condition() {
        $("#m_modal_register").modal('show');
    }

    function onSubmit(token) {
        $.ajax({
            url: "{!! route('register') !!}",
            type: 'POST',
            data: $("#register_form").serialize(),
            success: function(result){
                if (result.errors == true) {
                    swal({
                        title: "",
                        html: result.message,
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    });
                } 
                else {
                    swal({
                        title: "",
                        text: result.message,
                        type: "success",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    }).then(function() {
                        window.location = "{!!URL::to('/')!!}";
                    })
                }
            },
            error: function(responed) {
                if (responed.responseJSON.message != "") {
                    var message = "";
                    
                    $.each(responed.responseJSON.errors, function(i, val) {
                        message += val+'<br/>';
                    });

                    swal({
                        title: "",
                        html: message,
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    });
                    
                }
            }  
            
        });
    }

    $(document).ready(function(){
        $("#register_form").validate({
            rules: {
                first_name: {
                    required: !0,
                },
                last_name: {
                    required: !0,
                },
                job_title: {
                    required: !0,
                },
                email: {
                    required: !0,
                },
                skype_id: {
                    required: !0,
                },
                password: {
                    required: !0,
                    pattern: /^(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{7,30}$/,
                },
                mobile_number: {
                    required: !0,
                    digits: !0,
                },
                company_name: {
                    required: !0,
                },
                company_web: {
                    required: !0,
                },
                country: {
                    required: !0,
                },
                region: {
                    required: !0,
                },
                'supplier_category[]': {
                    required: !0,
                },
                'supplier_product_type[]': {
                    required: !0,
                },
                instant_confirm: {
                    required: !0,
                },
                term_condition: {
                    required: !0,
                }
                
            },
            messages: {
                password: {
                    pattern : "Your password must including 1 uppercase letter, 1 special character, alphanumeric characters"
                },
                'supplier_category[]': {
                    required: "You must select at least one supplier type"
                },
                'supplier_product_type[]': {
                    required: "You must select at least one product type",
                },
                term_condition: {
                    required: "You must accept the Terms and Conditions",
                }
            },
            invalidHandler: function(e, t) {
                swal({
                    title: "",
                    html: "There are some errors in your submission<br />Please correct them.",
                    type: "error",
                    confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                })
            },
            submitHandler: function(e){
                grecaptcha.execute();
            }
        });
    });
</script>
@endsection
                