{$image_uploader}

<table class="table tableDnD" id="imageTable">
    <thead>
    <tr class="nodrag nodrop">
        <th class="fixed-width-lg"><span class="title_box">{l s='Image' mod='ph_simpleblog'}</span></th>
        <th class="fixed-width-xs"><span class="title_box">{l s='Position' mod='ph_simpleblog'}</span></th>
        <th></th>
    </tr>
    </thead>
    <tbody id="imageList"></tbody>
</table>

<table id="lineType" style="display:none;">
    <tr id="image_id">
        <td>
            <a href="{$module_dir}ph_simpleblog/galleries/image_filename.jpg" class="fancybox">
                <img src="{$module_dir}ph_simpleblog/galleries/image_filename-thumb.jpg" alt="" title="" class="img-thumbnail" />
            </a>
        </td>
        <td id="td_image_id" class="pointer dragHandle center positionImage">
            image_position
        </td>
        <td>
            <a href="#" class="delete_post_image pull-right btn btn-default">
                <i class="icon-trash"></i> {l s='Delete this image' mod='ph_simpleblog'}
            </a>
        </td>
    </tr>
</table>

<script type="text/javascript">
    var upbutton = '{l s='Upload an image' mod='ph_simpleblog' js=1}';
    var come_from = '{$table}';
    var success_add =  '{l s='The image has been successfully added.' mod='ph_simpleblog' js=1}';
    var id_tmp = 0;

    var ThickboxI18nImage = "{l s='Image' mod='ph_simpleblog' js=1}";
    var ThickboxI18nOf = "{l s='of' mod='ph_simpleblog' js=1}";
    var ThickboxI18nClose = "{l s='Close' mod='ph_simpleblog' js=1}";
    var ThickboxI18nOrEscKey = "{l s='(or "Esc")' mod='ph_simpleblog' js=1}";
    var ThickboxI18nNext = "{l s='Next >' mod='ph_simpleblog' js=1}";
    var ThickboxI18nPrev = "{l s='< Previous' mod='ph_simpleblog' js=1}";
    var tb_pathToImage = "../img/loadingAnimation.gif";

    {literal}

    function imageLine(id, filename, position)
    {
        line = $("#lineType").html();
        line = line.replace(/image_id/g, id);
        line = line.replace(/image_filename/g, filename);
        line = line.replace(/image_position/g, position);
        line = line.replace(/<tbody>/gi, "");
        line = line.replace(/<\/tbody>/gi, "");

        $("#imageList").append(line);
    }

    $(document).ready(function()
    {
        {/literal}
            {foreach from=$images item=image}
                imageLine({$image->id}, '{$image->image}', {$image->position});
            {/foreach}
        {literal}

        var originalOrder = false;

        $("#imageTable").tableDnD(
        {	onDragStart: function(table, row) {
            originalOrder = $.tableDnD.serialize();
        },
            onDrop: function(table, row) {
                if (originalOrder != $.tableDnD.serialize()) {
                    current = $(row).attr("id");
                    stop = false;
                    image_up = "{";
                    $("#imageList").find("tr").each(function(i) {
                        $("#td_" +  $(this).attr("id")).html(i + 1);
                        if (!stop || (i + 1) == 2)
                            image_up += '"' + $(this).attr("id") + '" : ' + (i + 1) + ',';
                    });
                    image_up = image_up.slice(0, -1);
                    image_up += "}";
                    updateImagePosition(image_up);
                }
            }
        });

        function afterDeletePostImage(data)
        {
            data = $.parseJSON(data);
            if (data)
            {
                id = data.id;
                if (data.status == 'ok'){
                    $("#" + id).remove();
                }
                refreshImagePositions($("#imageTable"));
                showSuccessMessage(data.confirmations);
            }
        }

        function refreshImagePositions(imageTable)
        {
            var reg = /_[0-9]$/g;
            var up_reg  = new RegExp("imgPosition=[0-9]+&");

            imageTable.find("tbody tr").each(function(i,el) {
                $(el).find("td.positionImage").html(i + 1);
            });
            imageTable.find("tr td.dragHandle a:hidden").show();
            imageTable.find("tr td.dragHandle:first a:first").hide();
            imageTable.find("tr td.dragHandle:last a:last").hide();
        }


        $('.delete_post_image').die().live('click', function(e)
        {
            e.preventDefault();
            id = $(this).parent().parent().attr('id');
            if (confirm("{/literal}{l s='Are you sure?' mod='ph_simpleblog' js=1}{literal}"))
                doAdminAjax({
                    "action":"deletePostImage",
                    "id_simpleblog_post_image" : id,
                    "token" : "{/literal}{$token}{literal}",
                    "tab" : "AdminSimpleBlogPosts",
                    "ajax" : 1 }, afterDeletePostImage
                );
        });

        function updateImagePosition(json)
        {
            doAdminAjax({
                "action":"updateImagePosition",
                "json":json,
                "token" : "{/literal}{$token}{literal}",
                "tab" : "AdminSimpleBlogPosts",
                "ajax" : 1
            });
        }

        function delQueue(id)
        {
            $("#img" + id).fadeOut("slow");
            $("#img" + id).remove();
        }

        $('.fancybox').fancybox();
    });
    {/literal}
</script>