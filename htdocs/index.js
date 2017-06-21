var origTableData = $('#tableBody').html()

$('#contact').focus(function() {
  $('#contactInfo').css('display', 'block')
})

$('#contact').focusout(function() {
  $('#contactInfo').css('display', 'none')
})

$('#dob').focus(function() {
  $('#dobInfo').css('display', 'block')
})

$('#dob').focusout(function() {
  $('#dobInfo').css('display', 'none')
})

function getContactMethod() {
  if ($('#bothCheck').is(':checked')) return 1; // Both
  else if ($('#voiceCheck').is(':checked') && $('#smsCheck').is(':checked')) return 1; // Both
  else if ($('#voiceCheck').is(':checked') && !$('#smsCheck').is(':checked')) return 2; // Voice
  else if (!$('#voiceCheck').is(':checked') && $('#smsCheck').is(':checked')) return 3; // Text
  else return null;

}

function submitApplication() {
  var patientName = $('#personName').val();
  var dob = $('#dob').val();
  var prescription = $('#prescription').val();
  var dose = $('#dose').val();
  var doseDays = $('#doseDays').val();
  var doseTime = $('#doseTime').val();
  var contact = $('#contact').val();
  var contactMethod = getContactMethod();

  $.ajax('index.php', {
  type: 'POST',
  data: {patientName: patientName, dob: dob, prescription: prescription, dose: dose, doseDays: doseDays, doseTime: doseTime, contact: contact, contactMethod: contactMethod},
  success: function (data) {
    if (data == 'success') {
      $('#successMessage').css('display', 'inline')
    }
    else {
      console.log('bad data sent => ' + data);
    }
  }
})

}

$('#submitApp').submit(function(event) {
  event.preventDefault();
  submitApplication();
})
