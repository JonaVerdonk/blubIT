class ImgSelection {
    constructor(dir, el) {
        this.dir = dir;
        this.el = el;
    }

    drawModal() {
        var html = "<div id='modal'>";
        html += "<button id='btnCloseModal'>&#10008;</button>";
        html += "<div id='imgList'><div id='imgListContainer'></div></div>";
        html += "<div id='imgPreview'><div id='imgPreviewContainer'><img src='' alt='Preview image'></div></div>"
        html += "</div>";
        $("body").append(html);

        var obj = this;

        $("#btnCloseModal").on("click", function() {
            obj.removeModal();
        });

        this.showImgs();
    }

    showImgs() {
        $.ajax({
            url: "/scripts/getDir.php",
            type: "POST",
            data: {"dir": this.dir, "el": this.el},
            success: function(json, status) {
                //Get data from ajax request
                var data = $.parseJSON(json);
                //data[0] = info;
                //data[1] = folders
                //data[2] = imgs
console.log(data);
                for (i = 2; i < data[2].length; ++ i) {
                    var html = "";
                    html = "<div class='imgListItem'>";
                    html += data[0][0]+"/"+data[2][i];
                    html += "</div>";
                    $("#imgListContainer").append(html);
                }

                var imgs = $(".imgListItem");
                imgs.hover(function() {
                    $("#imgPreview img").attr("src", $(this).html());
                });

                imgs.on("dblclick", function() {
                    $(data[0][1]).attr("src", $(this).html());
                    $("#imgChanged").click();
                });
            }
        });
    }

    removeModal() {
        $("#modal").remove();
    }
}
