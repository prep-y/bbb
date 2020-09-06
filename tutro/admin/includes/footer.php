</div><br><br>
<footer class="col-md-12 text-center" id="footer">&copy; Copyright 2020 Gift Box Direct</footer> 

    <script>
    function updateSizes(){
        var sizeString = '';
        for(i=1;i<12;i++){
            if(jQuery('#size'+i).val()!= ''){
                sizeString += jQuery('#size'+i).val()+':'+jQuery('#qty'+i).val()+',';
            }
        }
        jQuery('#sizes').val(sizeString);
    }

    function get_child_options(){
        var parentID = jQuery('#parent').val();
        jQuery.ajax({
            url: '/tutro/admin/parsers/child_categories.php',
            type: 'POST',
            data: {parentID : parentID},
            success: function(data){
                jQuery('#child').html(data);
            },
            error: function(){alert("Something went wrong wiht the child options.")},
        });
    }
    jQuery('select[name="parent"]').change(get_child_options);
    </script>

    </body>
</html>


 
      