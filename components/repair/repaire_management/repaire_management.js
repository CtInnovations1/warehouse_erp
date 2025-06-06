
$(document).ready(function() {
    $('#stock_id').on('change', function() {
     
        $('#stock_id_for_package_material2').val($(this).val());
        data = [];
        data[0] = stock_id_for_package_material2; // source field name
        data[1] = 'package_id1'; // target field
        data[2] = null;
        data[3] = null;
        data[4] = null;
        generate_combo_new(data);
        
        data = [];
        data[0] = stock_id_for_package_material2; // source field name
        data[1] = 'package_id2'; // target field
        data[2] = null;
        data[3] = null;
        data[4] = null;
        generate_combo_new2(data);
        
        data = [];
        data[0] = stock_id_for_package_material2; // source field name
        data[1] = 'package_id3'; // target field
        data[2] = null;
        data[3] = null;
        data[4] = null;
        generate_combo_new3(data);
    });
}); 
function generate_combo_new(data) { 
    source_field = data[0];
    target_field = data[1];
    other_option = data[2];
    default_value = data[3];
    other_value = data[4];

    var dataString = '';
    dataString = dataString + "source_field=" + $(source_field).attr('name') + "&" + $(source_field).attr('name') + "=" + $(source_field).val() + "";
    dataString = dataString + "&target_field=" + target_field;
    if (other_option != null) {
        dataString = dataString + "&other_option=1";
    }
    if (other_value != null) {
        dataString = dataString + "&other_value=" + other_value;
    }
    //alert(dataString);
    // extra variables for query
    if (data[4] != null) {
        for (i = 4; i < data.length; i++) {
            dataString = dataString + "&" + data[i] + "=" + $('#' + data[i] + '').val() + "";
        }
    }
    //alert(source_field);
    $.ajax({
        url: 'ajax/generate_combo.php',
        type: 'POST',
        dataType: 'json',
        data: dataString,
        success: function(result) {
            $('#' + target_field).html(""); //clear old options
            result = eval(result);
            for (i = 0; i < result.length; i++) {
                for (key in result[i]) {
                    $('#' + target_field).get(0).add(new Option(result[i][key], [key]), document.all ? i : null);
                }
            }
            if (default_value != null) {
                $('#' + target_field).val(default_value); //select default value
            } else {
                $("option:first", target_field).attr("selected", "selected"); //select first option
            }

            $('#' + target_field).css("display", "inline");
        }
    });
}

function generate_combo_new2(data) {
    source_field2 = data[0];
    target_field2 = data[1];
    other_option2 = data[2];
    default_value2 = data[3];
    other_value2 = data[4];
    //alert(other_value);

    var dataString2 = '';
    dataString2 = dataString2 + "source_field=" + $(source_field2).attr('name') + "&" + $(source_field2).attr('name') + "=" + $(source_field2).val() + "";
    dataString2 = dataString2 + "&target_field=" + target_field2;
    if (other_option2 != null) {
        dataString2 = dataString2 + "&other_option=1";
    }
    if (other_value != null) {
        dataString2 = dataString2 + "&other_value=" + other_value;
    }
    //alert(dataString2);
    // extra variables for query
    if (data[4] != null) {
        for (i = 4; i < data.length; i++) {
            dataString2 = dataString2 + "&" + data[i] + "=" + $('#' + data[i] + '').val() + "";
        }
    }
    //alert(source_field2);
    $.ajax({
        url: 'ajax/generate_combo.php',
        type: 'POST',
        dataType: 'json',
        data: dataString2,
        success: function(result) {
            $('#' + target_field2).html(""); //clear old options
            result = eval(result);
            for (i = 0; i < result.length; i++) {
                for (key in result[i]) {
                    $('#' + target_field2).get(0).add(new Option(result[i][key], [key]), document.all ? i : null);
                }
            }
            if (default_value != null) {
                $('#' + target_field2).val(default_value); //select default value
            } else {
                $("option:first", target_field2).attr("selected", "selected"); //select first option
            }

            $('#' + target_field2).css("display", "inline");
        }
    });
}

function generate_combo_new3(data) {
    source_field3   = data[0];
    target_field3   = data[1];
    other_option3   = data[2];
    default_value3  = data[3];
    other_value3    = data[4];
    //alert(other_value);

    var dataString3 = '';
    dataString3 = dataString3 + "source_field=" + $(source_field3).attr('name') + "&" + $(source_field3).attr('name') + "=" + $(source_field3).val() + "";
    dataString3 = dataString3 + "&target_field=" + target_field3;
    if (other_option3 != null) {
        dataString3 = dataString3 + "&other_option=1";
    }
    if (other_value != null) {
        dataString3 = dataString3 + "&other_value=" + other_value;
    }
    //alert(dataString2);
    // extra variables for query
    if (data[4] != null) {
        for (i = 4; i < data.length; i++) {
            dataString3 = dataString3 + "&" + data[i] + "=" + $('#' + data[i] + '').val() + "";
        }
    }
    //alert(source_field3);
    $.ajax({
        url: 'ajax/generate_combo.php',
        type: 'POST',
        dataType: 'json',
        data: dataString3,
        success: function(result) {
            $('#' + target_field3).html(""); //clear old options
            result = eval(result);
            for (i = 0; i < result.length; i++) {
                for (key in result[i]) {
                    $('#' + target_field3).get(0).add(new Option(result[i][key], [key]), document.all ? i : null);
                }
            }
            if (default_value != null) {
                $('#' + target_field3).val(default_value); //select default value
            } else {
                $("option:first", target_field3).attr("selected", "selected"); //select first option
            }

            $('#' + target_field3).css("display", "inline");
        }
    });
}