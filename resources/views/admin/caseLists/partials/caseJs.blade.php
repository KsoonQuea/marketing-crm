<script>
    // recover to number format
    function recoverNumberFormat(str){
        var str = str.toString().replace(/,/g, '');// remove comma
        var negative = 0;
        if (str.indexOf('(') > -1 || str.indexOf('-') > -1) {
            // got negative
            negative = 1;
            str = str.replace('(','').replace(')','').replace('-','');
        }
        var final;
        if (negative == 1) {
            final = '-'+str;
        } else {
            final = str;
        }
        return final;
    }
    // add commas
    function addCommas(str){
        var str = str.toString().replace(/,/g, '');// remove comma
        var negative = 0;
        if (str.indexOf('(') == 0 && str.indexOf(')') == -1){
            str = str.substring(0,str.length - 1);
            if(str.length > 1){
                negative = 1;
                str = str.replace('(','').replace(')','').replace('-','');
            }
        } else if (str.indexOf('(') > -1 || str.indexOf('-') > -1) {
            // got negativeaddCommas
            negative = 1;
            str = str.replace('(','').replace(')','').replace('-','');
        }
        var str = str.replace(/^0+/, '').replace(/\D/g, "");
        var parts = str.toString().split(".");
        parts[0] = parts[0].replace(/^0+/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        var final;
        if (negative == 1) {
            final = '('+parts.join(".")+')';
        } else {
            final = parts.join(".");
        }

        if(final == ''){ final = 0; }

        return final;
    }
    function addCommasWithinDecimal(str){
        var value = str.toString().split('.');

        var display = addCommas(value[0]);

        if(display == ''){ display = 0; }
        if(display == '()'){ display = '(' + 0 + ')'; }
        if(value[1] > 0) {
            if (display.toString().indexOf('(') > -1 || display.toString().indexOf('-') > -1) {
                // negative value
                var newone = display.replace('(','').replace(')','').replace('-','');
                display = '('+newone+'.'+value[1]+')';
            } else {
                display += '.'+ value[1];
            }
        }
        return display;
    }
    function addCommasNegative(str){
        var str = str.toString().replace(/,/g, '');// remove comma
        if (str.indexOf('(') == 0 && str.indexOf(')') == -1){
            str = str.substring(0,str.length - 1);
            if(str.length > 1){
                str = str.replace('(','').replace(')','').replace('-','');
            }
        } else if (str.indexOf('(') > -1 || str.indexOf('-') > -1) {
            // got negative
            str = str.replace('(','').replace(')','').replace('-','');
        }
        var str = str.replace(/^0+/, '').replace(/\D/g, "");
        var parts = str.toString().split(".");
        parts[0] = parts[0].replace(/^0+/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var final;
        final = '('+parts.join(".")+')';
        if(parts.join(".") == ''){ final = 0; }
        return final;
    }

    // formatter (arrow, enter tab, assign number to comma function)
    function formatter_init(){
        // formatter
        function formArrow(element) {
            if ($(element).length == 0) {
                return 0;
            } else if ($(element).find('input').length > 0) {
                // $(element).find('input').focus();
                var this_val = $(element).find('input').val();
                $(element).find('input').focus().focus().val('').val(this_val);
            } else if ($(element).find('textarea').length > 0) {
                $(element).find('textarea').focus();
            } else if ($(element).find('select').length > 0) {
                $(element).find('select').select2('open');
            }

        }
        // input auto add comma after 3 digit
        $('.number-input').on('input', function (e){
            var value = $(this).val();
            $(this).val(addCommas(value));
        });

        // input which is force negative
        $('.number-input-negative').on('input', function (e){
            var value = $(this).val();
            $(this).val(addCommasNegative(value));
        });

        // input auto add comma after 3 digit & negative with decimal
        $('.number-decimal-input').on('keyup', function (e){
            var value = $(this).val();

            if ($(this).val().indexOf('(') != -1 && $(this).val().indexOf(')') != -1){
                var last_char   = value.substring(value.length - 1);

                if (last_char == ')') {
                    last_char = '';
                }

                value           = value.substring(value.indexOf('(') + 1, value.indexOf(')'));
                value           = '-' + value + last_char;
            }

            if (value == '-') {
                value = '0';
            }

            if ((e.keyCode == 107 || e.keyCode == 171 || e.keyCode == 187) && value.charAt(0) == '-') { // plus code & check it is minus or not
                value = value.substring(1);
            }

            if (e.keyCode == 189 || e.keyCode == 173 || e.keyCode == 109){ //when click subtract
                value = '-' + value;
            }

            if (e.keyCode == 190 || e.keyCode == 110){ //when click dot
                var arr = value.split('.');

                if (arr.length > 2) {
                    value = arr.slice(0, 2).join('.');//remove all after second dot
                }
            }

            if (value.indexOf('.') != -1) { // when have dot
                var arr = value.split('.');

                if (arr[1].length > 2) {
                    value = value.substring(0, value.length - 1); // limit the number place
                }
            }

            if (!(value.charAt(value.length - 1) == '.' || value.slice(-2) == '.0' || value.slice(-3) == '.00')){ // if they not the comma at last / '.0' / '.00' at last
                value = addCommasWithinDecimal(value);
            }
            else{
                if (value.slice(-2) == '.0' || value.slice(-3) == '.00'){ // if they '.0' / '.00' at last
                    if (value.charAt(0) == '-'){
                        value = value.substring(1);
                        value = '('+ value +')';
                    }
                }
                else if (!(e.keyCode == 190 || e.keyCode == 110)){ // if they not click the dot
                    value = value.substring(0, value.length - 1);
                    value = addCommasWithinDecimal(value);
                }
                else {
                    if (value.charAt(0) == '-'){
                        value = value.substring(1);
                        value = '('+ value +')';
                    }
                }
            }

            $(this).val(value);
        });

        // prevent backspace
        $('.number-decimal-input').on('keydown', function (e){
            var value = $(this).val();

            if ($(this).val().indexOf('(') != -1 && $(this).val().indexOf(')') != -1){
                value = value.substring(value.indexOf('(') + 1, value.indexOf(')'));
                value = '-' + value;
            }

            if (e.keyCode == 46 || e.keyCode == 8){ //when click delete or backspace
                $(this).val(value);
            }
        })

        // enter == tab
        $("input, button").keydown(function(e) {
            var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
            if(key == 13) {
                e.preventDefault();
                var inputs = $(this).closest('form').find(':input:visible');
                var new_inputs = inputs.eq( inputs.index(this)+1).focus();
                var new_inputs_val = new_inputs.val();
                new_inputs.focus().val('').val(new_inputs_val);
            }
        });

        // inputs arrow
        $('input,textarea').keyup(function(e) {
            if (e.which == 39) { // right arrow
                e.preventDefault();
                // if ($(this).closest('td').next().length > 0) {
                //     formArrow($(this).closest('td').next());
                // } else {
                //     formArrow($(this).closest('div').next());
                // }
            } else if (e.which == 37) { // left arrow
                e.preventDefault();
                // if ($(this).closest('td').prev().length > 0) {
                //     formArrow($(this).closest('td').prev());
                // } else {
                //     formArrow($(this).closest('div').prev());
                // }
            } else if (e.which == 40) { // down arrow
                e.preventDefault();
                var down_div = $(this).closest('tr').next().find('td:eq(' + $(this).closest('td').index() + ')');
                if (down_div.length > 0) {
                    formArrow(down_div);
                } else if($(this).closest('tr').next().closest('template').length > 0){
                    var this_index = $(this).closest('td').index();
                    var template = $(this).closest('tr').next().closest('template').next().find('td:eq('+this_index+')');
                    formArrow(template);
                } else {
                    formArrow($(this).closest('div').next());
                }
            } else if (e.which == 38) { // up arrow
                e.preventDefault();
                var template_prev = $(this).closest('tr').prev().closest('template');
                if ($(this).closest('tr').prev().find('td:eq(' + $(this).closest('td').index() +')')) {
                    var this_index_up = $(this).closest('td').index();
                    if(template_prev.length > 0){
                        formArrow(template_prev.prev().closest('tr').find('td:eq(' + this_index_up + ')'));
                    } else {
                        formArrow($(this).closest('tr').prev().find('td:eq(' + this_index_up + ')'));
                    }
                } else {
                    formArrow($(this).closest('div').prev());
                }
            }
        });

        // btn-remove wont trigger by enter
        $('.btn-remove').on('keypress', function(e) {
            return e.which !== 13;
        });

        $(".wrapper-textarea").each(function () {
            this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
        }).on("input", function () {
            this.style.height = 0;
            this.style.height = (this.scrollHeight) + "px";
        });

        // only-number
        $(".only-number").on('input', function (e){
            var value = $(this).val();
            if (value.charAt(value.length - 1) != '.'){
                var str = value.replace(/\D/g, "");
                $(this).val(str);
            }
        });

        $(".month-year-input").on('input', function (e){
            var str = $(this).val().toString().replace(/,/g, '');// remove comma
            var before = str.replace(/\D/g, "");
            var after = '';
            var error = 0;
            if(before.length > 0){
                var first = before[0]+before[1];
                if(!isNaN(first)){
                    var sum = parseInt(first);
                    if(sum > 12){ error += 1; }
                }
                if (before[0] == 0 && before[1] == 0){ error += 1 }
            }
            if(error > 0){
                after = '';
            } else {
                // check only 6 digit
                if(before.length > 6){ before = before.substr(0,6);}
                // add spacing if after month
                after = before;
                if(before.length > 2){
                    var first = before[0]+before[1];
                    var second = ' ';
                    var last = before.substr(2,6);
                    after = first+second+last;
                }
            }
            $(this).val(after);
        });
    }

    $(".month-picker").on("keydown", function(event) {
        var englishAlphabetAndWhiteSpace = /[^0-9 ]/g;
        var key = String.fromCharCode(event.which);

        var num_code_arr = [48, 49, 50, 51, 52, 53, 54, 55, 56, 57,
            96, 97, 98, 99, 100, 101, 102, 103, 104, 105,
            8, 32]; // 8 is backspace, 32 is spacebar

        if (jQuery.inArray(event.keyCode, num_code_arr) != '-1') {
            return true;
        }
        else {
            alert ("Invalid Input");
            return false;
        }
        // $(this).val($(this).val());
    });

    // initial
    $(document).ready(function() {
        // formatter
        formatter_init();
        var eachNumberInput = $('input[class="number-input"]');
        $.each(eachNumberInput, function( index, value ) {
            var value = $(this).val();
            $(this).val(addCommas(value));
        });

        var eachNumberInputDecimal = $('input[class="number-decimal-input"]');

        $.each($('.number-decimal-input'), function( index, value ) {
            var value = $(this).val();

            if ($(this).val().indexOf('(') != -1 || $(this).val().indexOf(')') != -1){
                value = value.substring(1);
                value = value.substring(0,value.length - 1);
            }

            if (value.charAt(value.length - 1) != '.'){
                $(this).val(addCommasWithinDecimal(value));
            }
        });

        var eachNumberInputNegative = $('input[class="number-input-negative"]');
        $.each(eachNumberInputNegative, function( index, value ) {
            var value = $(this).val();
            $(this).val(addCommasNegative(value));
        });

        $.each($('.bank-stt-input'), function( index, value ) {
            var value = $(this).val();
            if (value.charAt(value.length - 1) != '.'){
                $(this).val(bankSttFormat(value));
            }
        });
    });
</script>
<script>
    // formatter (bank statement only)
    function bankSttFormat(str){
        if(str == '0'){
            return 0;
        }
        var negative = 0;
        if (str.toString().indexOf(')') > -1 || str.toString().indexOf('-') > -1) {
            negative = 1;
        }
        var new_str = str.replace('(','').replace(')','').replace('-',''); // remove negative symbol
        var value = new_str.toString().split('.');
        var front_val = value[0].replace(/^0+/, '').replace(/\D/g, "").replace(/,/g, ''); // remove , / only allow number
        var final = front_val.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        if(value.length > 1){
            var decimal = value[1];
            if($.isNumeric(decimal) == true){
                final += '.'+(decimal.substring(0,2)); //replace(/^0+/, '')
            }
        }
        var display;
        if(negative > 0){ display = '('+final+')'; } else { display = final; }
        return display;
    }
    function bank_stt_formatter_init(){
        $('.bank-stt-input').on('input', function (e){
            var value = $(this).val();
            if (value.charAt(value.length - 1) != '.'){
                $(this).val(bankSttFormat(value));
            }
        });
    }

    $(document).ready(function() {
        $('.bank-stt-input').on('input', function (e) {
            var value = $(this).val();
            if (value.charAt(value.length - 1) != '.') {
                $(this).val(bankSttFormat(value));
            }
        });
    });
</script>
