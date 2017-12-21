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

                var html = "<div id='imgListDir'>"+data[0][0]+"</div>";
                app(html);

                //Print all folders
                html = "<div id='imgListFolders'>";
                for (i = 0; i < data[1].length; ++ i) {
                    html += "<div class='imgListFolder'>";
                    html += "/"+data[1][i];
                    html += "</div>";
                }
                html += "</div>";
                app(html);

                //Print all images
                html = "<div id='imgListImgs'>";
                for (i = 0; i < data[2].length; ++ i) {
                    html += "<div class='imgListItem'>";
                    html += data[2][i];
                    html += "</div>";
                }
                html += "</div>";
                app(html);

                var imgs = $(".imgListItem");
                imgs.hover(function() {
                    $("#imgPreview img").attr("src", data[0][0]+"/"+$(this).html());
                });

                imgs.on("dblclick", function() {
                    var url = data[0][0]+"/"+$(this).html();
                    var id = $(data[0][1]).parent().parent().parent().attr("id");

                    $(data[0][1]).attr("src", url);

                    $("#imgChanged #url").html(url);
                    $("#imgChanged #id").html(id);
                    $("#imgChanged").click();
                });

                function app(html) {
                    $("#imgListContainer").append(html);
                }
            }
        });
    }

    removeModal() {
        $("#modal").remove();
    }
}
