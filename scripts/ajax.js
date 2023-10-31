$(document).ready(function () {
  function refreshTable() {
    $.ajax({
      url: "homet.php",
      success: function (data) {
        $("#table-refresh").html(data);
      },
    });
  }
  setInterval(refreshTable, 3000);
});
