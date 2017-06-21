var origTableData = $('#tableBody').html()

function populateTable() {
  $.ajax('insert.php', {
  type: 'POST',
  data: {},
  success: function (data) {
    console.log('OK');
    $('#tableBody').html(origTableData + data);
  },
  error: function(a) {
    console.log(a)
  }
  })
}

$(document).ready(function() {
  populateTable();
})
