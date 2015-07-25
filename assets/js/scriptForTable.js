/*
 * Add edit delete rows dynamically using jquery and php
 * http://www.amitpatil.me/
 *
 * @version
 * 2.0 (4/19/2014)
 * 
 * @copyright
 * Copyright (C) 2014-2015 
 *
 * @Auther
 * Amit Patil
 * Maharashtra (India)
 *
 * @license
 * This file is part of Add edit delete rows dynamically using jquery and php.
 * 
 * Add edit delete rows dynamically using jquery and php is freeware script. you can redistribute it and/or 
 * modify it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Add edit delete rows dynamically using jquery and php is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this script.  If not, see <http://www.gnu.org/copyleft/lesser.html>.
 */

// init variables
var trcopy;
var editing = 0;
var tdediting = 0;
var editingtrid = 0;
var editingtdcol = 0;
var inputs = 'select,select,:text,select,select';


$(document).ready(function () {

    // set images for edit and delete 
    $(".eimage").attr("src", editImage);
    $(".dimage").attr("src", deleteImage);

    // init table
    blankrow = '<tr valign="top" class="inputform">';
    for (i = 0; i < columns.length; i++) {
        // Create input element as per the definition
        input = createInput(i, '', '');
        blankrow += '<td class="ajaxReq">' + input + '</td>';
    }
    blankrow += '<td><a href="javascript:;" class="' + savebutton + '"><img src="' + saveImage + '"></button></td></tr>';

    // append blank row at the end of table
    $("." + table).append(blankrow);

    // Delete record
    $(document).on("click", "." + deletebutton, function () {
        var id = $(this).attr("id");
        if (id) {
            if (confirm("Do you really want to delete record ?"))
                ajax("rid=" + id, "del");
        }
    });

    // Add new record
    $("." + savebutton).on("click", function () {
        var modulesAlreadyInside = [];
        var validation = 1;
        var requirementCheck = 0;
        var $inputs =
                $(document).find("." + table).find(inputs).filter(function () {
            // check if input element is blank ??
            if ($.trim(this.value) == "") {
                $(this).addClass("error");
                validation = 0;
            } else {
                $(this).addClass("success");
            }
            return $.trim(this.value);
        });

        var array = $inputs.map(function () {
            return this.value;
        }).get();

        if (validation == 0) {
            alert("Please fill in all necessary field");
        } else {
            $.getJSON("assets/json/201415moduleInformation.json", function (data) {
                for (i = 0; i < data.length; i++) {
                    if (data[i]['ModuleCode'] == array[2]) {
                        if (data[i]['Prerequisite'] == null) {
                            alert("No prerequisite");
                        } else {
                            alert(data[i]['Prerequisite']);
                        }
                    }
                }
            });
            var serialized = $inputs.serialize();
            alert(serialized);
            ajax(serialized, "save");
        }
    });

    // Edit record
    $(document).on("click", "." + editbutton, function () {
        var id = $(this).attr("id");
        if (id && editing == 0 && tdediting == 0) {
            // hide editing row, for the time being
            $("." + table + " tr:last-child").fadeOut("fast");

            var html;
            //html += "<td>" + $("." + table + " tr[id=" + id + "] td:first-child").html() + "</td>";
            for (i = 0; i < columns.length; i++) {
                // fetch value inside the TD and place as VALUE in input field
                var val = $(document).find("." + table + " tr[id=" + id + "] td[class='" + columns[i] + "']").html();
                input = createInput(i, val, "edit");
                html += '<td>' + input + '</td>';
            }
            html += '<td><a href="javascript:;" id="' + id + '" class="' + updatebutton + '"><img src="' + updateImage + '"></a> <a href="javascript:;" id="' + id + '" class="' + cancelbutton + '"><img src="' + cancelImage + '"></a></td>';

            // Before replacing the TR contents, make a copy so when user clicks on 
            trcopy = $("." + table + " tr[id=" + id + "]").html();
            $("." + table + " tr[id=" + id + "]").html(html);

            // set editing flag
            editing = 1;
        }
    });

    $(document).on("click", "." + cancelbutton, function () {
        var id = $(this).attr("id");
        $("." + table + " tr[id='" + id + "']").html(trcopy);
        $("." + table + " tr:last-child").fadeIn("fast");
        editing = 0;
    });

    $(document).on("click", "." + updatebutton, function () {
        id = $(this).attr("id");
        var $inputs =
                $(document).find("." + table).find(inputs).filter(function () {
            return $.trim(this.value);
        });

        var array = $inputs.map(function () {
            console.log(this.value);
            return this.value;
        }).get();
        var data = "&semester=" + array[0] + "&year=" + array[1] + "&moduleCode=" + array[2] + "&requirement=" + array[3] + "&gpa=" + array[4] + "&rid=" + id;
        editing = 0;
        ajax(data, "update");

        // clear editing flag

    });

    // td doubleclick event
    /*
     $(document).on("dblclick", "." + table + " td", function (e) {
     // check if any other TD is in editing mode ? If so then dont show editing box
     //alert(tdediting+"==="+editing);
     var isEditingform = $(this).closest("tr").attr("class");
     if (tdediting == 0 && editing == 0 && isEditingform != "inputform") {
     editingtrid = $(this).closest('tr').attr("id");
     editingtdcol = $(this).attr("class");
     var text = $(this).html();
     var tr = $(this).parent();
     var tbody = tr.parent();
     for (var i = 0; i < tr.children().length; i++) {
     if (tr.children().get(i) == this) {
     var column = i;
     break;
     }
     }
     
     // decrement column value by one to avoid sr no column
     column--;
     //alert(column+"==="+placeholder[column]);
     if (column <= columns.length) {
     var text = $(this).html();
     //alert(text);
     input = createInput(column, text, "");
     $(this).html(input);
     $(this).find(inputs).focus();
     tdediting = 1;
     }   
     }
     }); */

    // td lost focus event
    $(document).on("blur", "." + table + " td", function (e) {
        if (tdediting == 1) {
            var newval = $("." + table + " tr[id='" + editingtrid + "'] td[class='" + editingtdcol + "']").find(inputs).val();
            ajax(editingtdcol + "=" + newval + "&rid=" + editingtrid, "updated");
        }
    });

});

createInput = function (i, str, editMode) {
    str = typeof str !== 'undefined' ? str : null;
    if (inputType[i] == "text") {
        if (editMode == "edit") {
            input = '<input type=' + inputType[i] + ' name=' + columns[i] + ' placeholder="' + placeholder[i] + '" value=' + str + ' readonly>';
        } else {
            input = '<input type=' + inputType[i] + ' name=' + columns[i] + ' placeholder="' + placeholder[i] + '" value=' + str + ' >';
        }
    } else if (inputType[i] == "textarea") {
        input = '<textarea name=' + columns[i] + ' placeholder="' + placeholder[i] + '">' + str + '</textarea>';
    }
    else if (inputType[i] == "select") {
        var length = 0;
        input = '<select name=' + columns[i] + '>';
        if (columns[i] == "semester") {
            length = 2;
        } else if (columns[i] == "year") {
            length = 5;
        } else if (columns[i] == "gpa") {
            length = 12;
        } else if (columns[i] == "requirement") {
            length = 7;
        }
        for (a = 0; a < length; a++) {
            selected = "";
            if (str == selectOptSem[a] || str == selectOptYear[a] || str == selectOptGPA[a] || str == selectOptRequirement[a]) {
                selected = "selected";
            }
            // This place
            if (columns[i] == "semester") {
                input += '<option value="' + selectOptSem[a] + '" ' + selected + '>' + selectOptSem[a] + '</option>';
            } else if (columns[i] == "year") {
                input += '<option value="' + selectOptYear[a] + '" ' + selected + '>' + selectOptYear[a] + '</option>';
            } else if (columns[i] == "gpa") {
                input += '<option value="' + selectOptGPA[a] + '" ' + selected + '>' + selectOptGPA[a] + '</option>';
            } else if (columns[i] == "requirement") {
                input += '<option value="' + selectOptRequirement[a] + '" ' + selected + '>' + selectOptRequirement[a] + '</option>';
            }
        }
        input += '</select>';
    }
    return input;
}

ajax = function (params, action) {
    $.ajax({
        type: "POST",
        url: "liveUpdateTable.php",
        data: params + "&action=" + action,
        dataType: "json",
        success: function (response) {
            switch (action) {
                case "save":
                    var seclastRow = $("." + table + " tr").length;
                    if (response.success == 1) {
                        var html = "";
                        for (i = 0; i < columns.length; i++) {
                            alert(columns[i] + " " + response[columns[i]]);
                            html += '<td class="' + columns[i] + '">' + response[columns[i]] + '</td>';
                        }
                        html += '<td><a href="javascript:;" id="' + response["id"] + '" class="ajaxEdit"><img src="' + editImage + '"></a> <a href="javascript:;" id="' + response["id"] + '" class="' + deletebutton + '"><img src="' + deleteImage + '"></a></td>';
                        // Append new row as a second last row of a table
                        $("." + table + " tr").last().before('<tr id="' + response.id + '">' + html + '</tr>');

                        if (effect == "slide") {
                            // Little hack to animate TR element smoothly, wrap it in div and replace then again replace with td and tr's ;)
                            $("." + table + " tr:nth-child(" + seclastRow + ")").find('td')
                                    .wrapInner('<div style="display: none;" />')
                                    .parent()
                                    .find('td > div')
                                    .slideDown(700, function () {
                                        var $set = $(this);
                                        $set.replaceWith($set.contents());
                                    });
                        }
                        else if (effect == "flash") {
                            $("." + table + " tr:nth-child(" + seclastRow + ")").effect("highlight", {color: '#acfdaa'}, 100);
                        } else
                            $("." + table + " tr:nth-child(" + seclastRow + ")").effect("highlight", {color: '#acfdaa'}, 1000);

                        // Blank input fields 
                        $(document).find("." + table).find(inputs).filter(function () {
                            // check if input element is blank ??
                            this.value = "";
                            $(this).removeClass("success").removeClass("error");
                        });
                    }
                    break;
                case "del":
                    var seclastRow = $("." + table + " tr").length;
                    if (response.success == 1) {
                        $("." + table + " tr[id='" + response.id + "']").effect("highlight", {color: '#f4667b'}, 500, function () {
                            $("." + table + " tr[id='" + response.id + "']").remove();
                        });
                    }
                    break;
                case "update":
                    $("." + cancelbutton).trigger("click");
                    for (i = 0; i < columns.length; i++) {
                        if (i = columns.length - 1) {
                            var result = response[columns[i]].substring(response[columns[i]].indexOf(":") + 2);
                            var data = ['5', '4.5', '4', '3.5', '3', '2.5', '2', '1.5', '1', '0'];
                            var data2 = ["A+/A : 5", "A- : 4.5", "B+ : 4", "B : 3.5", "B- : 3", "C+ : 2.5", "C : 2", "D+ : 1.5", "D : 1", "F : 0"];
                            for (x = 0; x < data.length; x++) {
                                if (data[x] == result) {
                                    $("tr[id='" + response.id + "'] td[class='" + columns[i] + "']").html(data2[x]);
                                }
                            }
                        } else {
                            alert(response.id + " " + columns[i] + " " + response[columns[i]]);
                            $("tr[id='" + response.id + "'] td[class='" + columns[i] + "']").html(response[columns[i]]);
                        }
                    }
                    break;
                    /*
                     case "updated":
                     //$("."+cancelbutton).trigger("click");
                     var newval = $("." + table + " tr[id='" + editingtrid + "'] td[class='" + editingtdcol + "']").find(inputs).val();
                     
                     //alert($("."+table+" tr[id='"+editingtrid+"'] td[class='"+editingtdcol+"']").html());
                     $("." + table + " tr[id='" + editingtrid + "'] td[class='" + editingtdcol + "']").html(newval);
                     
                     //$("."+table+" tr[id='"+editingtrid+"'] td[class='"+editingtdcol+"']").html(newval);
                     // remove editing flag
                     tdediting = 0;
                     $("." + table + " tr[id='" + editingtrid + "'] td[class='" + editingtdcol + "']").effect("highlight", {color: '#acfdaa'}, 1000);
                     break;
                     */
            }
        },
        error: function () {
            alert("Unexpected error, Please try again");
        }
    });
}