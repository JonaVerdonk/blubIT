class ImgSelection {
    constructor(dir, el) {
        //Set the variables to the arguments gotten
        this.dir = dir;
        this.el = el;
    }

    // drawModal() {
    //     //Create the modal with two containers, 'imgListContainer' and 'imgPreviewContainer'
    //     var html = "<div id='modal'>";
    //     html += "<button id='btnCloseModal'>&#10008;</button>";
    //     html += "<div id='imgList'><div id='imgListContainer'></div></div>";
    //     html += "<div id='imgPreview'><div id='imgPreviewContainer'></div></div>"
    //     html += "</div>";
    //     $("body").append(html);
    //
    //     var obj = this;
    //
    //     //If the 'close' button is clicked, remove the modal
    //     $("#btnCloseModal").on("click", function() {
    //         obj.removeModal();
    //     });
    //
    //     this.showImgs();
    // }

    showImgs() {
        //Get all images from a specific directory and show the images
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

                //Remove last two entries because for some reason it doesn't
                // work properly in the getDir file
                data[2].pop();
                data[2].pop();

                var html = "<div id='imgListDir'>"+data[0][0]+"</div>";
                app(html);

                //Print all folders in the 'imgListContainer'
                html = "<div id='imgListFolders'>";
                for (i = 0; i < data[1].length; ++ i) {
                    html += "<div class='imgListFolder'>";
                    html += "/"+data[1][i];
                    html += "</div>";
                }
                html += "</div>";
                app(html);

                //Print all images in the 'imgListContainer'
                html = "<div id='imgListImgs'>";
                for (i = 0; i < data[2].length; ++ i) {
                    html += "<div class='imgListItem'>";
                    html += data[2][i];
                    html += "</div>";
                }
                html += "</div>";
                app(html);

                //If the user hovers over a folder, print folder
                var folders = $("#imgListFolders");
                folders.hover(function() {
                    $("#imgPreview").html("Folder");
                });

                //If the user hovers over an img in the list of images, show in the preview
                var imgs = $(".imgListItem");
                imgs.hover(function() {
                    var img = $(this).html();
                    $("#imgPreview").html("<img src='"+data[0][0]+"/"+img+"' alt='Afbeelding'>");
                });

                //If the user double clicks in an image set to elements with specific id's
                // on the page to the new img url and the id that needs to be changed.
                // Javascript on the page that called this object then reads the values of those
                // textfields.
                //Should be rewritten, but it works.
                imgs.on("dblclick", function() {
                    var url = data[0][0]+"/"+$(this).html();
                    var id = $(data[0][1]).attr("id");

                    var attr = $(data[0][1]).attr("src");
                    if (typeof(attr) !== typeof(undefined) && attr !== false) {
                        $(data[0][1]).attr("src", url);
                    } else {
                        $(data[0][1] + " img").attr("src", url);
                    }

                    $("#imgChanged #url").html(url);
                    $("#imgChanged #id").html(id);
                    $("#imgChanged").click();
                });

                //Function so I don't have to keep typing the whole element
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
