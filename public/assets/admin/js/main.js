$("#menu").click(function () {
    $(".layer").addClass("layer_show");
    $("#aside").addClass("ul_show");
});

$(".layer").click(function () {
    $("#aside").removeClass("ul_show");
    $(".layer").removeClass("layer_show");
});


$("#flip-products").click(function () {
    $("#panel-products").slideToggle(200);
    $("#flip-products.has-items").toggleClass("down");
});

$("#flip-users").click(function () {
    $("#panel-users").toggle();
    $("#flip-users.has-items").toggleClass("down");
});

$(".checkThis").on("keyup", function () {
    check($(this).closest("form"));
});

function check(form) {
    var allFilled = true;

    form.find(".checkThis").each(function () {


        if ($(this).hasClass('modelSelect')) {

            if ($(this).select2('data')[0] == undefined || $(this).select2('data')[0].id === "") {
                allFilled = false;
                return false;
            }

        } else if ($(this).hasClass('select-dropdown')) {

            var selectizeControl = $(".select-dropdown.checkThis")[0].selectize;
            var selectedValues = selectizeControl.getValue();

            if (selectedValues.length == 0) {
                allFilled = false;
                return false;
            }

        } else {

            if ($(this).val().trim() === "") {
                allFilled = false;
                return false;
            }
        }


    });

    form.find("#submitBtn").prop("disabled", !allFilled);
}

function checkAllForms() {
    $("form").each(function () {
        check($(this));
    });

}

function checkUseDate() {
    check($("input.date").closest("form"));
}

$(document).ready(function () {
    checkAllForms();
});


var confirmCheckBox = document.getElementById("confirmCheckBox");
if (confirmCheckBox) {
    confirmCheckBox.addEventListener("change", function () {
        var button = document.getElementById("deleteBtn");
        if (this.checked) {
            button.removeAttribute("disabled");
        } else {
            button.setAttribute("disabled", "disabled");
        }
    });
}

$(document).on("click", function (e) {
    var container = $(".select2-container--open");
    if (container.length > 0 && !container.is(e.target) && container.has(e.target).length === 0) {
        $(".js-example-basic-single").select2("close");
    }
});

function delete_model(e) {
    var confirmCheckBox = document.getElementById("confirmCheckBox");
    confirmCheckBox.checked = false;

    var button = document.getElementById("deleteBtn");
    button.setAttribute("disabled", "true");

    event.stopPropagation();
    let element = e;
    let data_name = element.getAttribute("data-name");
    let data_id = element.getAttribute("data-id");
    $("#delete_title").text(data_name);
    $("#delete_id").val(data_id);
}


function changeColor(colorName) {
    let color;
    let xbuttonBorder;
    let mainBg;

    if (colorName == "عنبري") {
        color = "rgb(245 158 11 /1)";
        xbuttonBorder = "rgb(180 83 9 /1)";
        mainBg = "rgb(245 158 11 /1)";
    } else if (colorName == "أزرق") {
        color = "rgb(59 130 246 /1)";
        xbuttonBorder = "rgb(29 78 216  /1)";
        mainBg = "rgb(59 130 246 /1)";
    } else if (colorName == "بنفسجي") {
        color = "rgb(79, 70, 156)";
        xbuttonBorder = "#2e238d";
        mainBg = "#4F469C";
    } else if (colorName == "سماوي مفتح") {
        color = "rgb(14 116 144 /1)";
        xbuttonBorder = "rgb(14 116 144 /1)";
        mainBg = "rgb(6 182 212 /1)";
    } else if (colorName == "زمردي") {
        color = "rgb(16 185 129 /1)";
        xbuttonBorder = "rgb(4 120 87  /1)";
        mainBg = "rgb(16 185 129 /1)";
    } else if (colorName == "رمادي") {
        color = "rgb(107 114 128/1)";
        xbuttonBorder = "rgb(55 65 81   /1)";
        mainBg = "rgb(107 114 128/1)";
    } else if (colorName == "زهري") {
        color = "rgb(236 72 153 /1)";
        xbuttonBorder = "rgb(190 24 93 /1)";
        mainBg = "rgb(236 72 153/1)";
    } else if (colorName == "أرجواني") {
        color = "rgb(168 85 247 /1)";
        xbuttonBorder = "rgb(126 34 206  /1)";
        mainBg = "rgb(168 85 247/1)";
    } else if (colorName == "احمر") {
        color = "rgb(239 68 68 /1)";
        xbuttonBorder = "rgb(185 28 28 /1)";
        mainBg = "rgb(239 68 68 /1)";
    } else if (colorName == "أخضر") {
        color = "rgb(34 197 94 /1)";
        xbuttonBorder = "rgb(21 128 61 /1)";
        mainBg = "rgb(34 197 94 /1)";
    } else if (colorName == "ليمي") {
        color = "rgb(132 204 22 /1)";
        xbuttonBorder = "rgb(77 124 15 /1)";
        mainBg = "rgb(132 204 22 /1)";
    } else if (colorName == "برتقالي") {
        color = "rgb(249 115 22 /1)";
        xbuttonBorder = "rgb(194 65 12/1)";
        mainBg = "rgb(249 115 22/1)";
    } else if (colorName == "سماوي") {
        color = "rgb(14 165 233 /1)";
        xbuttonBorder = "rgb(3 105 161/1)";
        mainBg = "rgb(14 165 233/1)";
    } else if (colorName == "شرشيري") {
        color = "rgb(20 184 166 /1)";
        xbuttonBorder = "rgb(15 118 110/1)";
        mainBg = "rgb(20 184 166/1)";
    } else if (colorName == "أصفر") {
        color = "rgb(234 179 8 /1)";
        xbuttonBorder = "rgb(161 98 7/1)";
        mainBg = "rgb(234 179 8 /1)";
    } else if (colorName == "اخضر غامق") {
        mainBg = "#335b54";
    } else if (colorName == "اسود") {
        mainBg = "#1b2225";
    }


    let rootStyles = document.documentElement.style;

    rootStyles.setProperty("--mainBg", `${mainBg}`);
    localStorage.setItem("mainBg", `${mainBg}`);
}

function toggleColors() {
    let colors = document.getElementById("colors");
    colors.classList.toggle("colorsShow");
}

function search() {
    var currentUrl = window.location.href;

    if (currentUrl.indexOf('export=yes') === -1) {
        if (currentUrl.indexOf('?') !== -1) {
            currentUrl = currentUrl + "&export=yes";
        } else {
            currentUrl = currentUrl + "/search?export=yes";
        }
        window.location.href = currentUrl;
    } else {
        window.location.href = currentUrl;
    }
}


const toolbarOptions = [[{
    header: 1,
}, {
    header: 2,
},], ["bold", "italic", "underline", "strike", "clean"], [{
    align: "",
}, {
    align: "center",
}, {
    align: "right",
}, {
    align: "justify",
},], [{
    list: "ordered",
}, {
    list: "bullet",
},], ["link"], [{
    color: [],
}, {
    background: [],
},],];

let quills = document.getElementsByClassName("quill");

for (let i = 0; i < quills.length; i++) {
    var quill = new Quill(quills[i], {
        theme: "snow",

        modules: {
            toolbar: toolbarOptions,
        },
        formats: ["bold", "align", "italic", "underline", "strike", "header", "link", "list", "color", "background",],
    });

    quill.format("font", "cairo");
    quill.format("align", "right");
}


function favToggle(e, id) {

    $.ajax({
        url: `/users/favToggle/${id}`, type: "GET", dataType: "json", success: function (response) {
            if (response.status == "created") {
                $(e).find("svg").css("stroke", "red");
                $(e).find("svg").css("fill", "red");
            } else {
                $(e).find("svg").css("stroke", "#6b7280");
                $(e).find("svg").css("fill", "none");
            }
        },
    });

}
