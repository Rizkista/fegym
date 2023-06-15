$("input[data-type='currency']").on({
    keyup: function(){ 
        var input_val = $(this).val();
        if(input_val === ""){ return; }

        var sign = input_val.charAt(0);
        var numb = input_val.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        if(sign == '-'){ 
            numb = '-'+numb; 
        }
        
        $(this).val(numb);
    } 
});