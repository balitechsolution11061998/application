$(document).ready(function () {
    fetchJamKerja();
    fetchDepartmentCount();
    fetchCabangCount();
    fetchJumlahCuti();
    fetchListCuti();

});






function fetchJumlahCuti() {
    $("#spinner-leave").show(); // Show spinner
    $.ajax({
        url: "/cuti/count",
        method: "GET",
        success: function (response) {
            $("#spinner-leave").hide(); // Hide spinner
            var content =
                '<div class="cuti-count animated fadeIn">' +
                response.count +
                "</div>";
            $("#leave-content").html(content);
            // Toastify({
            //     text: "Cuti count loaded successfully",
            //     duration: 3000,
            //     close: true,
            //     gravity: "top",
            //     position: "right",
            //     backgroundColor: "#4CAF50",
            //     stopOnFocus: true,
            // }).showToast();
        },
        error: function (error) {
            $("#spinner-leave").hide(); // Hide spinner
            console.log("Error fetching data", error);
            // Toastify({
            //     text: "Error loading cuti count",
            //     duration: 3000,
            //     close: true,
            //     gravity: "top",
            //     position: "right",
            //     backgroundColor: "#FF0000",
            //     stopOnFocus: true,
            // }).showToast();
        },
    });
}

function fetchCabangCount() {
    $("#spinner-cabang").show(); // Show spinner
    $.ajax({
        url: "/cabang/count",
        method: "GET",
        success: function (response) {
            $("#spinner-cabang").hide(); // Hide spinner
            var content =
                '<div class="cabang-count animated fadeIn">' +
                response.count +
                "</div>";
            $("#cabang-content").html(content);
            // Toastify({
            //     text: "Cabang count loaded successfully",
            //     duration: 3000,
            //     close: true,
            //     gravity: "top",
            //     position: "right",
            //     backgroundColor: "#4CAF50",
            //     stopOnFocus: true,
            // }).showToast();
        },
        error: function (error) {
            $("#spinner-cabang").hide(); // Hide spinner
            console.log("Error fetching data", error);
            // Toastify({
            //     text: "Error loading cabang count",
            //     duration: 3000,
            //     close: true,
            //     gravity: "top",
            //     position: "right",
            //     backgroundColor: "#FF0000",
            //     stopOnFocus: true,
            // }).showToast();
        },
    });
}

function fetchDepartmentCount() {
    $("#spinner-department").show(); // Show spinner
    $.ajax({
        url: "/departments/count",
        method: "GET",
        success: function (response) {
            $("#spinner-department").hide(); // Hide spinner
            var content =
                '<div class="department-count animated fadeIn">' +
                response.count +
                "</div>";
            $("#department-content").html(content);
            // Toastify({
            //     text: "Department count loaded successfully",
            //     duration: 3000,
            //     close: true,
            //     gravity: "top",
            //     position: "right",
            //     backgroundColor: "#4CAF50",
            //     stopOnFocus: true,
            // }).showToast();
        },
        error: function (error) {
            $("#spinner-department").hide(); // Hide spinner
            console.log("Error fetching data", error);
            // Toastify({
            //     text: "Error loading department count",
            //     duration: 3000,
            //     close: true,
            //     gravity: "top",
            //     position: "right",
            //     backgroundColor: "#FF0000",
            //     stopOnFocus: true,
            // }).showToast();
        },
    });
}

function fetchListCuti() {
    $("#spinner-leave").show(); // Show spinner

    $.ajax({
        url: "/cuti/data",
        method: "GET",
        success: function (response) {
            $("#spinner-leave").hide(); // Hide spinner
            var content = "";

            if (response.data.length > 0) {
                response.data.forEach(function (item) {
                    content +=
                        '<div class="leave-item">' +
                        '<h3 class="day">' +
                        item.nama_cuti +
                        " (" +
                        item.kode_cuti +
                        ")</h3>" +
                        '<p class="days">Jumlah Hari: ' +
                        item.jumlah_hari +
                        "</p>" +
                        "</div>";
                });
                $("#listleave-content").html(content);
                // Toastify({
                //     text: "Data cuti loaded successfully",
                //     duration: 3000,
                //     close: true,
                //     gravity: "top",
                //     position: "right",
                //     backgroundColor: "#4CAF50",
                //     stopOnFocus: true,
                // }).showToast();
            } else {
                $("#listleave-content").html(
                    '<div class="not-found-message">' +
                        '<div class="icon-container">' +
                        '<i class="fas fa-search" style="font-size: 25px; color: #FFAA00;"></i>' +
                        "</div>" +
                        '<p class="message-text">No data available</p>' +
                        "</div>"
                );
                Toastify({
                    text: "No data available",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#FFAA00",
                    stopOnFocus: true,
                }).showToast();
            }
        },
        error: function (error) {
            $("#spinner-leave").hide(); // Hide spinner
            Toastify({
                text: "Error loading data",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#FF0000",
                stopOnFocus: true,
            }).showToast();
        },
    });
}


function fetchJamKerja() {
    $("#spinner").show(); // Show spinner

    $.ajax({
        url: "/jam_kerja/data",
        method: "GET",
        success: function (response) {
            $("#spinner").hide(); // Hide spinner
            var content = "";

            if (response.data.length > 0) {
                response.data.forEach(function (item) {
                    content +=
                        '<div class="jam-kerja-item">' +
                        '<h3 class="day">' +
                        item.nama_jk +
                        " (" +
                        item.kode_jk +
                        ")</h3>" +
                        '<p class="time">Jam Masuk: ' +
                        item.jam_masuk +
                        " (" +
                        item.awal_jam_masuk +
                        " - " +
                        item.akhir_jam_masuk +
                        ")</p>" +
                        '<p class="time">Jam Pulang: ' +
                        item.jam_pulang +
                        "</p>" +
                        '<p class="time">Lintas Hari: ' +
                        item.lintas_hari +
                        "</p>" +
                        "</div>";
                });
                $("#jam-kerja-content").html(content);
                // Toastify({
                //     text: "Data jam kerja loaded successfully",
                //     duration: 3000,
                //     close: true,
                //     gravity: "top",
                //     position: "right",
                //     backgroundColor: "#4CAF50",
                //     stopOnFocus: true,
                // }).showToast();
            } else {
                $("#jam-kerja-content").html(
                    '<div class="not-found-message">' +
                        '<div class="icon-container">' +
                        '<i class="fas fa-search" style="font-size: 25px; color: #FFAA00;"></i>' +
                        "</div>" +
                        '<p class="message-text">No data available</p>' +
                        "</div>"
                );
                Toastify({
                    text: "No data available",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#FFAA00",
                    stopOnFocus: true,
                }).showToast();
            }
        },
        error: function (error) {
            $("#spinner").hide(); // Hide spinner
            console.log("Error fetching data", error);
            Toastify({
                text: "Error loading data",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#FF0000",
                stopOnFocus: true,
            }).showToast();
        },
    });
}





function formatNumber(num) {
    if (num >= 1e12) {
        return (num / 1e12).toFixed(1) + " t";
    } else if (num >= 1e9) {
        return (num / 1e9).toFixed(1) + " m";
    } else if (num >= 1e6) {
        return (num / 1e6).toFixed(1) + " jt";
    } else if (num >= 1e3) {
        return (num / 1e3).toFixed(1) + " rb";
    } else {
        return num.toString();
    }
}
