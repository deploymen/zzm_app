//Global Variables

var profilelist = $('#profile-list');

function allVars(){
	var  datal;
	var xat;

	$.ajax({
		type    : 'GET',
		url     : '/api/profiles',
		dataType: 'json',
		success : function(data){
			datal = data["data"];
		}
	});

	$.ajaxSetup({
	    beforeSend: function(xhr) {
	        xat =xhr.setRequestHeader('X-access-token', '15|988d09d3d9af03b0abc9d97fb5f709cb77e422f6');
	    }
	});

	return datal;
};
allVars();
//console.log(allVars.datal);

// Single Profile - Edit Inner Page
var editprofileform = $('#edit-profile-form');
var btnsaveprofile = $('#btn-save-profile');
var profilefirstname = $('#profile-first-name');
var profilelastinitial = $('#profile-last-initial');
var profilecity = $('#profile-city');
var profileid = $('#profile-id');
var profileschool = $('#profile-school');
var btnchangesok = $('#btn-changes-ok');
var editselectage = $('#profile-age-edit');
var editselectgrade = $('#profile-grade-edit');

function saveProfile(){

	var modalprofilesaved = $('#profilesaved');

	var editedInfo = {
		first_name : profilefirstname.val(),
		last_name  : null,
		school     : profileschool.val(),
		city       : profilecity.val(),
		id         : profileid.val(),
		age        : editselectage.children('option').filter(':selected').val(),
		grade      : editselectgrade.children('option').filter(':selected').val()
	}

	$.ajaxSetup({
	    beforeSend: function(xat) {
	        allVars.xat;
	    }
	});

	$.ajax({
		type    : 'PUT',
		dataType: 'json',
		url     : '/api/profiles/'+editedInfo.id+'/edit',
		data    : editedInfo,
		success : function(data){
			window.location = "/user/profiles";
			modalprofilesaved.foundation('reveal', 'open');
		},
		error   : function(data){
			// window.location = "/user/profiles";	
		}
	});



};

btnsaveprofile.click(function(){
	saveProfile();
});

btnchangesok.click(function(){
	location.reload();
});

// Add Profile
var createbtn = $('#btn-create-profile');
var btnnewprofile = $('#btn-show-profile-form');
var addprofilemodal = $('#addProfileModal');
var newprofileform = $('#new-profile-form');
var newprofilevalidate = $('#new-profile-validation-msg');

function createNewProfile(){
	var addbtn = $('#btn-add-new-profile');
	var newfirstname = $('#new-first-name');
	var newlastname = $('#new-last-name');
	var newschool = $('#new-school');
	var newcity = $('#new-city');
	var profileemail = $('#profile-email');
	var profilenickname1 = $('#profile-nickname1');
	var profilenickname2 = $('#profile-nickname2');
	var profileavatar = $('#profile-avatar-id');

	var newprofileinfo = {
		first_name   : newfirstname.val(),
		last_name    : null,
		school       : newschool.val(),
		city         : newcity.val(),
		email        : 'marypoppins@nanny.com',
		age        	 : editselectage.children('option').filter(':selected').val(),
		grade     	 : editselectgrade.children('option').filter(':selected').val()
	}

	$.ajaxSetup({
	    beforeSend: function(xat) {
	        allVars.xat;
	    }
	});

	$.ajax({
		type     : 'POST',
		dataType : 'json',
		url      : '/api/profiles',
		data     : newprofileinfo,
		success  : function(data){
			var status = data['status'];
			var message = data['message'];
			//location.reload();
			if(status === 'fail' && message === 'missing parameters'){
				// alert('Missing Parameters');
				newprofilevalidate.show();
			} else {
				addprofilemodal.foundation('reveal', 'close');
				location.reload();
			}
			
		},
		error    : function(){
			console.log('fail');
		}
	});
};

createbtn.click(function(){
	// console.log(newprofileform);
	// newprofileform.on('valid.fndtn.abide', function(){
	// 	createNewProfile();
	// });
	createNewProfile();
});

btnnewprofile.on('click', function() {
    addprofilemodal.foundation('reveal', 'open');
    return false;
    //console.log('add new profile');
});


// End of Add Profile

// Delete Profile
var btndeleteprofile = $('#btn-delete-profile');
var btndeleteok = $('#btn-delete-ok');
var btndeltecancel = $('#btn-delete-cancel');
var modalprofiledeleted = $('#profiledelete');
var modalcannotdelete = $('#cannotdelete');
var btncannotdelete = $('#btn-cannot-delete');

function deleteProfile(){
	var deleteconfirm = $('#profiledelete');

	var profiletodelete = {
		id    : profileid.val()
	}

	$.ajaxSetup({
	    beforeSend: function(xat) {
	        allVars.xat;
	    }
	});

	$.ajax({
		type     : 'DELETE',
		dataType : 'json',
		url      : '/api/profiles/'+profiletodelete.id,
		data     : profiletodelete,
		success  : function(data){
			var status = data['status'];
			var message = data['message'];
			console.log(profiletodelete.id);
			if(status === 'fail' && message === 'at least once profile in account'){
				console.log('You cannot delete the last profile.');
				modalcannotdelete.foundation('reveal', 'open');

				btncannotdelete.click(function(){
					modalcannotdelete.foundation('reveal', 'close');
				});
			} else if(status === 'fail' && message === 'profile not found') {
				window.location = "/user/profiles";
			} else {
				window.location = "/user/profiles";
			}
		}
	});
};

btndeleteprofile.click(function(){
	modalprofiledeleted.foundation('reveal', 'open');
});

btndeltecancel.click(function(){
	modalprofiledeleted.foundation('reveal', 'close');
});

btndeleteok.click(function(){
	deleteProfile();
});


(function($, window, document, undefined){
	if (top.location.pathname === '/user/profiles'){
		//displayProfiles();
	};

	//$(document).foundation('abide', 'reflow');

})(jQuery, this, this.document);