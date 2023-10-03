<script>
    var grids = grids || {};
</script>
<script>
    //custom jquery method for toggle attr
    $.fn.toggleAttr = function (attr, attr1, attr2) {
        return this.each(function () {
            var self = $(this);
            if (self.attr(attr) == attr1) self.attr(attr, attr2);
            else self.attr(attr, attr1);
        });
    };
    (function ($) {
        // USE STRICT
        "use strict";

        grids.data = {
            csrf: "{{csrf_token()}}",
            appUrl: "{{asset('/')}}",
            fileBaseUrl: "{{asset('/storage')}}/",
        };
        grids.uploader = {
            data: {
                selectedFiles: [],
                selectedFilesObject: [],
                clickedForDelete: null,
                allFiles: [],
                multiple: false,
                type: "all",
                next_page_url: null,
                prev_page_url: null,
            },
            removeInputValue: function (id, array, elem) {
                var selected = array.filter(function (item) {
                    return item !== id;
                });
                if (selected.length > 0) {
                    $(elem)
                        .find(".file-amount")
                        .html(grids.uploader.updateFileHtml(selected));
                } else {
                    elem.find(".file-amount").html("عدد الملفات");
                }
                $(elem).find(".selected-files").val(selected);
            },
            removeAttachment: function () {
                $(document).on("click",'.remove-attachment', function () {
                    var value = $(this)
                        .closest(".file-preview-item")
                        .data("id");
                    var selected = $(this)
                        .closest(".file-preview")
                        .prev('[data-toggle="gridsuploader"]')
                        .find(".selected-files")
                        .val()
                        .split(",")
                        .map(Number);

                    grids.uploader.removeInputValue(
                        value,
                        selected,
                        $(this)
                            .closest(".file-preview")
                            .prev('[data-toggle="gridsuploader"]')
                    );
                    $(this).closest(".file-preview-item").remove();
                });
            },
            deleteUploaderFile: function () {
                $(".grids-uploader-delete").each(function () {
                    $(this).on("click", function (e) {
                        e.preventDefault();
                        var id = $(this).data("id");
                        grids.uploader.data.clickedForDelete = id;
                        $("#gridsUploaderDelete").modal("show");

                        $(".grids-uploader-confirmed-delete").on("click", function (
                            e
                        ) {
                            e.preventDefault();
                            if (e.detail === 1) {
                                var clickedForDeleteObject =
                                    grids.uploader.data.allFiles[
                                        grids.uploader.data.allFiles.findIndex(
                                            (x) =>
                                                x.id ===
                                                grids.uploader.data.clickedForDelete
                                        )
                                        ];
                                $.ajax({
                                    url:
                                        grids.data.appUrl +
                                        "/grids-uploader/destroy/" +
                                        grids.uploader.data.clickedForDelete,
                                    type: "DELETE",
                                    dataType: "JSON",
                                    data: {
                                        id: grids.uploader.data.clickedForDelete,
                                        _method: "DELETE",
                                        _token: grids.data.csrf,
                                    },
                                    success: function () {
                                        grids.uploader.data.selectedFiles = grids.uploader.data.selectedFiles.filter(
                                            function (item) {
                                                return (
                                                    item !==
                                                    grids.uploader.data
                                                        .clickedForDelete
                                                );
                                            }
                                        );
                                        grids.uploader.data.selectedFilesObject = grids.uploader.data.selectedFilesObject.filter(
                                            function (item) {
                                                return (
                                                    item !== clickedForDeleteObject
                                                );
                                            }
                                        );
                                        grids.uploader.updateUploaderSelected();
                                        grids.uploader.getAllUploads(

                                            "{{route("admin.get_uploaded_files")}}"
                                        );
                                        grids.uploader.data.clickedForDelete = null;
                                        $("#gridsUploaderDelete").modal("hide");
                                    },
                                });
                            }
                        });
                    });
                });
            },
            uploadSelect: function () {
                $(".grids-uploader-select").each(function () {
                    var elem = $(this);
                    elem.on("click", function (e) {
                        var value = $(this).data("value");
                        var valueObject =
                            grids.uploader.data.allFiles[
                                grids.uploader.data.allFiles.findIndex(
                                    (x) => x.id === value
                                )
                                ];
                        // console.log(valueObject);

                        elem.closest(".grids-file-box-wrap").toggleAttr(
                            "data-selected",
                            "true",
                            "false"
                        );
                        if (!grids.uploader.data.multiple) {
                            elem.closest(".grids-file-box-wrap")
                                .siblings()
                                .attr("data-selected", "false");
                        }
                        if (!grids.uploader.data.selectedFiles.includes(value)) {
                            if (!grids.uploader.data.multiple) {
                                grids.uploader.data.selectedFiles = [];
                                grids.uploader.data.selectedFilesObject = [];
                            }
                            grids.uploader.data.selectedFiles.push(value);
                            grids.uploader.data.selectedFilesObject.push(valueObject);
                        } else {
                            grids.uploader.data.selectedFiles = grids.uploader.data.selectedFiles.filter(
                                function (item) {
                                    return item !== value;
                                }
                            );
                            grids.uploader.data.selectedFilesObject = grids.uploader.data.selectedFilesObject.filter(
                                function (item) {
                                    return item !== valueObject;
                                }
                            );
                        }
                        grids.uploader.addSelectedValue();
                        grids.uploader.updateUploaderSelected();
                    });
                });
            },
            updateFileHtml: function (array) {
                var fileText = "";
                if (array.length > 1) {
                    var fileText = "Files";
                } else {
                    var fileText = "File";
                }
                return array.length + " " + fileText + " " + "selected";
            },
            updateUploaderSelected: function () {
                $(".grids-uploader-selected").html(
                    "عدد الملفات المختار"+
                    grids.uploader.updateFileHtml(grids.uploader.data.selectedFiles)
                );
            },
            clearUploaderSelected: function () {
                $(".grids-uploader-selected-clear").on("click", function () {
                    grids.uploader.data.selectedFiles = [];
                    grids.uploader.addSelectedValue();
                    grids.uploader.addHiddenValue();
                    grids.uploader.resetFilter();
                    grids.uploader.updateUploaderSelected();
                    grids.uploader.updateUploaderFiles();
                });
            },
            resetFilter: function () {
                $('[name="grids-uploader-search"]').val("");
                $('[name="grids-show-selected"]').prop("checked", false);
                $('[name="grids-uploader-sort"] option[value=newest]').prop(
                    "selected",
                    true
                );
            },
            getAllUploads: function (url, search_key = null, sort_key = null) {
                $(".grids-uploader-all").html(
                    '<div class="align-items-center d-flex h-100 justify-content-center w-100"><div class="spinner-border" role="status"></div></div>'
                );
                var params = {};
                if (search_key != null && search_key.length > 0) {
                    params["search"] = search_key;
                }
                if (sort_key != null && sort_key.length > 0) {
                    params["sort"] = sort_key;
                }
                else{
                    params["sort"] = 'newest';
                }
                $.get(url, params, function (data, status) {
                    //console.log(data);
                    if(typeof data == 'string'){
                        data = JSON.parse(data);
                    }
                    console.log(data.data)

                    grids.uploader.data.allFiles = data.data;

                    grids.uploader.allowedFileType();
                    grids.uploader.addSelectedValue();
                    grids.uploader.addHiddenValue();
                    //grids.uploader.resetFilter();
                    grids.uploader.updateUploaderFiles();
                    if (data.next_page_url != null) {
                        grids.uploader.data.next_page_url = data.next_page_url;
                        $("#uploader_next_btn").removeAttr("disabled");
                    } else {
                        $("#uploader_next_btn").attr("disabled", true);
                    }
                    if (data.prev_page_url != null) {
                        grids.uploader.data.prev_page_url = data.prev_page_url;
                        $("#uploader_prev_btn").removeAttr("disabled");
                    } else {
                        $("#uploader_prev_btn").attr("disabled", true);
                    }
                });
            },
            showSelectedFiles: function () {
                $('[name="grids-show-selected"]').on("change", function () {
                    if ($(this).is(":checked")) {

                        grids.uploader.data.allFiles =
                            grids.uploader.data.selectedFilesObject;
                    } else {

                        grids.uploader.getAllUploads(
                            "{{route("admin.get_uploaded_files")}}"
                        );
                    }
                    grids.uploader.updateUploaderFiles();
                });
            },
            searchUploaderFiles: function () {
                $('[name="grids-uploader-search"]').on("keyup", function () {
                    var value = $(this).val();
                    grids.uploader.getAllUploads(
                        "{{route("admin.get_uploaded_files")}}",
                        value,
                        $('[name="grids-uploader-sort"]').val()
                    );

                });
            },
            sortUploaderFiles: function () {
                $('[name="grids-uploader-sort"]').on("change", function () {
                    var value = $(this).val();
                    grids.uploader.getAllUploads(
                        "{{route("admin.get_uploaded_files")}}",
                        $('[name="grids-uploader-search"]').val(),
                        value
                    );


                });
            },
            addSelectedValue: function () {
                for (var i = 0; i < grids.uploader.data.allFiles.length; i++) {
                    if (
                        !grids.uploader.data.selectedFiles.includes(
                            grids.uploader.data.allFiles[i].id
                        )
                    ) {
                        grids.uploader.data.allFiles[i].selected = false;
                    } else {
                        grids.uploader.data.allFiles[i].selected = true;
                    }
                }
            },
            addHiddenValue: function () {
                for (var i = 0; i < grids.uploader.data.allFiles.length; i++) {
                    grids.uploader.data.allFiles[i].aria_hidden = false;
                }
            },
            allowedFileType: function () {
                if (grids.uploader.data.type !== "all") {
                    grids.uploader.data.allFiles = grids.uploader.data.allFiles.filter(
                        function (item) {
                            return item.type === grids.uploader.data.type;
                        }
                    );
                }
            },
            updateUploaderFiles: function () {
                $(".grids-uploader-all").html(
                    '<div class="align-items-center d-flex h-100 justify-content-center w-100"><div class="spinner-border" role="status"></div></div>'
                );

                var data = grids.uploader.data.allFiles;

                setTimeout(function () {

                    $(".grids-uploader-all").html(null);

                    if (data.length > 0) {
                        for (var i = 0; i < data.length; i++) {
                            var thumb = "";
                            var hidden = "";
                            if (data[i].type === "image") {
                                thumb =
                                    '<img src="' +
                                    grids.data.fileBaseUrl +
                                    data[i].file_name +
                                    '" class="img-fit">';
                            }
                            else if(data[i].type === "video"){
thumb='<video  controls> ' +
    '<source width="100%" src="'+grids.data.fileBaseUrl +
                                data[i].file_name+'" >' +
    '<source src="'+grids.data.fileBaseUrl +
    data[i].file_name+'" type="video/ogg">' +
    'Your browser does not support the video tag. </video>'
                            }
                            else if(data[i].type === "audio"){
                                thumb='<audio controls>' +
                                    '<source src="'+grids.data.fileBaseUrl +
                                    data[i].file_name+'" type="audio/ogg"> ' +
                                    '<source src="'+grids.data.fileBaseUrl +
                                    data[i].file_name+'" type="audio/mpeg">' +
                                    'Your browser does not support the audio element. ' +
                                    '</audio>'

                            }
                            else {
                                thumb = '<i class="fa fa-file"></i>';
                            }
                            var html =
                                '<div class="grids-file-box-wrap" aria-hidden="' +
                                data[i].aria_hidden +
                                '" data-selected="' +
                                data[i].selected +
                                '">' +
                                '<div class="grids-file-box">' +

                                '<div class="card card-file grids-uploader-select" title="' +
                                data[i].file_original_name +
                                "." +
                                data[i].extension +
                                '" data-value="' +
                                data[i].id +
                                '">' +
                                '<div class="card-file-thumb">' +
                                thumb +
                                "</div>" +
                                '<div class="card-body">' +
                                '<h6 class="d-flex">' +
                                '<span class="text-truncate title">' +
                                data[i].file_original_name +
                                "</span>" +
                                '<span class="ext">.' +
                                data[i].extension +
                                "</span>" +
                                "</h6>" +
                                "<p>" +
                                grids.extra.bytesToSize(data[i].file_size) +
                                "</p>" +
                                "</div>" +
                                "</div>" +
                                "</div>" +
                                "</div>";

                            $(".grids-uploader-all").append(html);
                        }
                    } else {
                        $(".grids-uploader-all").html(
                            '<div class="align-items-center d-flex h-100 justify-content-center w-100 nav-tabs"><div class="text-center"><h3>لايوجد ملفات</h3></div></div>'
                        );
                    }
                    grids.uploader.uploadSelect();
                    grids.uploader.deleteUploaderFile();
                }, 300);
            },
            inputSelectPreviewGenerate: function (elem) {
                elem.find(".selected-files").val(grids.uploader.data.selectedFiles);
                elem.next(".file-preview").html(null);

                if (grids.uploader.data.selectedFiles.length > 0) {

                    $.get(
                       '{{route("admin.get_file_by_ids")}}',
                        { _token: grids.data.csrf, ids: grids.uploader.data.selectedFiles.toString() },
                        function (data) {

                            elem.next(".file-preview").html(null);

                            if (data.length > 0) {
                                elem.find(".file-amount").html(
                                    grids.uploader.updateFileHtml(data)
                                );
                                for (
                                    var i = 0;
                                    i < data.length;
                                    i++
                                ) {
                                    var thumb = "";
                                    if (data[i].type === "image") {
                                        thumb =
                                            '<img src="' +
                                            grids.data.fileBaseUrl +
                                            data[i].file_name +
                                            '" class="img-fit">';
                                    }
                                    else if(data[i].type === "video"){

thumb='<video width="100%" controls> ' +
    '<source src="' +
    grids.data.fileBaseUrl +
    data[i].file_name +
    '" type="video/mp4"> ' +
    '<source src="' +
    grids.data.fileBaseUrl +
    data[i].file_name +
    '" type="video/ogg">' +
    'Your browser does not support the video tag. ' +
    '</video>'
                                    }
                                    else if(data[i].type === "audio"){
                                        thumb='<audio controls> ' +
                                            '<source src="' +
                                            grids.data.fileBaseUrl +
                                            data[i].file_name +
                                            '" type="audio/ogg"> ' +
                                            '<source src="' +
                                            grids.data.fileBaseUrl +
                                            data[i].file_name +
                                            '" type="audio/mpeg">' +
                                            'Your browser does not support the audio element. ' +
                                            '</audio>'
                                    }

                                    else {
                                        thumb = '<i class="fas fa-file"></i>';
                                    }
                                    var html =
                                        '<div class="d-flex justify-content-between align-items-center mt-2 file-preview-item" data-id="' +
                                        data[i].id +
                                        '" title="' +
                                        data[i].file_original_name +
                                        "." +
                                        data[i].extension +
                                        '">' +
                                        '<div class="align-items-center align-self-stretch d-flex justify-content-center thumb">' +
                                        thumb +
                                        "</div>" +
                                        '<div class="col body">' +
                                        '<h6 class="d-flex">' +
                                        '<span class="text-truncate title">' +
                                        data[i].file_original_name +
                                        "</span>" +
                                        '<span class="ext">.' +
                                        data[i].extension +
                                        "</span>" +
                                        "</h6>" +
                                        "<p>" +
                                        grids.extra.bytesToSize(
                                            data[i].file_size
                                        ) +
                                        "</p>" +
                                        "</div>" +
                                        '<div class="remove">' +
                                        '<button class="btn btn-sm btn-link remove-attachment" type="button">' +
                                        '<i class="fa fa-times"></i>' +
                                        "</button>" +
                                        "</div>" +
                                        "</div>";

                                    elem.next(".file-preview").append(html);
                                }
                            } else {
                                elem.find(".file-amount").html("عدد الملفات");
                            }
                        });
                } else {
                    elem.find(".file-amount").html("عدد الملفات");
                }


            },
            editorImageGenerate: function (elem) {
                if (grids.uploader.data.selectedFiles.length > 0) {
                    for (
                        var i = 0;
                        i < grids.uploader.data.selectedFiles.length;
                        i++
                    ) {
                        var index = grids.uploader.data.allFiles.findIndex(
                            (x) => x.id === grids.uploader.data.selectedFiles[i]
                        );
                        var thumb = "";
                        if (grids.uploader.data.allFiles[index].type === "image") {
                            thumb =
                                '<img src="' +
                                grids.data.fileBaseUrl +
                                grids.uploader.data.allFiles[index].file_name +
                                '">';
                            elem[0].insertHTML(thumb);
                            // console.log(elem);
                        }
                    }
                }
            },
            dismissUploader: function () {
                $("#gridsUploaderModal").on("hidden.bs.modal", function () {
                    $(".grids-uploader-backdrop").remove();
                    $("#gridsUploaderModal").remove();
                });
            },
            trigger: function (
                elem = null,
                from = "",
                type = "all",
                selectd = "",
                multiple = false,
                callback = null
            ) {
                // $("body").append('<div class="grids-uploader-backdrop"></div>');

                var elem = $(elem);
                var multiple = multiple;
                var type = type;
                var oldSelectedFiles = selectd;
                if (oldSelectedFiles !== "") {
                    grids.uploader.data.selectedFiles = oldSelectedFiles
                        .split(",")
                        .map(Number);
                } else {
                    grids.uploader.data.selectedFiles = [];
                }
                if ("undefined" !== typeof type && type.length > 0) {
                    grids.uploader.data.type = type;
                }

                if (multiple) {
                    grids.uploader.data.multiple = multiple;
                }

                // setTimeout(function() {
                $.get(
                    "{{route("admin.grids_uploader")}}",
                    { _token: grids.data.csrf },
                    function (data) {

                        $("body").append(data);
                        $("#gridsUploaderModal").modal("show");
                        grids.plugins.gridsUppy();
                        grids.uploader.getAllUploads(
                            "{{route("admin.get_uploaded_files")}}",
                            null,
                            $('[name="grids-uploader-sort"]').val()
                        );
                        grids.uploader.updateUploaderSelected();
                        grids.uploader.clearUploaderSelected();
                        grids.uploader.sortUploaderFiles();
                        grids.uploader.searchUploaderFiles();
                        grids.uploader.showSelectedFiles();
                        grids.uploader.dismissUploader();

                        $("#uploader_next_btn").on("click", function () {
                            if (grids.uploader.data.next_page_url != null) {
                                $('[name="grids-show-selected"]').prop(
                                    "checked",
                                    false
                                );
                                grids.uploader.getAllUploads(
                                    grids.uploader.data.next_page_url
                                );
                            }
                        });

                        $("#uploader_prev_btn").on("click", function () {
                            if (grids.uploader.data.prev_page_url != null) {
                                $('[name="grids-show-selected"]').prop(
                                    "checked",
                                    false
                                );
                                grids.uploader.getAllUploads(
                                    grids.uploader.data.prev_page_url
                                );
                            }
                        });

                        $(".grids-uploader-search i").on("click", function () {
                            $(this).parent().toggleClass("open");
                        });

                        $('[data-toggle="gridsUploaderAddSelected"]').on(
                            "click",
                            function () {
                                if (from === "input") {
                                    grids.uploader.inputSelectPreviewGenerate(elem);
                                } else if (from === "direct") {
                                    callback(grids.uploader.data.selectedFiles);
                                }
                                $("#gridsUploaderModal").modal("hide");
                            }
                        );
                    }
                );
                // }, 50);
            },
            initForInput: function () {
                $(document).on("click",'[data-toggle="gridsuploader"]', function (e) {
                    if (e.detail === 1) {
                        var elem = $(this);
                        var multiple = elem.data("multiple");
                        var type = elem.data("type");

                        var oldSelectedFiles = elem.find(".selected-files").val();

                        multiple = !multiple ? "" : multiple;
                        type = !type ? "" : type;
                        oldSelectedFiles = !oldSelectedFiles
                            ? ""
                            : oldSelectedFiles;

                        grids.uploader.trigger(
                            this,
                            "input",
                            type,
                            oldSelectedFiles,
                            multiple
                        );
                    }
                });
            },
            previewGenerate: function(){
                $('[data-toggle="gridsuploader"]').each(function () {
                    var $this = $(this);
                    var files = $this.find(".selected-files").val();

                    $.get(
                       "{{route("admin.get_file_by_ids")}}",
                        { _token: grids.data.csrf, ids: files },
                        function (data) {

                            $this.next(".file-preview").html(null);

                            if (data.length > 0) {
                                $this.find(".file-amount").html(
                                    grids.uploader.updateFileHtml(data)
                                );
                                for (
                                    var i = 0;
                                    i < data.length;
                                    i++
                                ) {
                                    var thumb = "";
                                    if (data[i].type === "image") {
                                        thumb =
                                            '<img src="' +
                                            grids.data.fileBaseUrl +
                                            data[i].file_name +
                                            '" class="img-fit">';
                                    }

                                    else if(data[i].type === "video"){

                                        thumb='<video width="100%"  controls> ' +
                                            '<source src="' +
                                            grids.data.fileBaseUrl +
                                            data[i].file_name +
                                            '" type="video/mp4"> ' +
                                            '<source src="' +
                                            grids.data.fileBaseUrl +
                                            data[i].file_name +
                                            '" type="video/ogg">' +
                                            'Your browser does not support the video tag. ' +
                                            '</video>'
                                    }
                                    else if(data[i].type === "audio"){
                                        thumb='<audio controls> ' +
                                            '<source src="' +
                                            grids.data.fileBaseUrl +
                                            data[i].file_name +
                                            '" type="audio/ogg"> ' +
                                            '<source src="' +
                                            grids.data.fileBaseUrl +
                                            data[i].file_name +
                                            '" type="audio/mpeg">' +
                                            'Your browser does not support the audio element. ' +
                                            '</audio>'
                                    }
                                    else {
                                        thumb = '<i class="fa fa-file"></i>';
                                    }
                                    var html =
                                        '<div class="d-flex justify-content-between align-items-center mt-2 file-preview-item" data-id="' +
                                        data[i].id +
                                        '" title="' +
                                        data[i].file_original_name +
                                        "." +
                                        data[i].extension +
                                        '">' +
                                        '<div class="align-items-center align-self-stretch d-flex justify-content-center thumb">' +
                                        thumb +
                                        "</div>" +
                                        '<div class="col body">' +
                                        '<h6 class="d-flex">' +
                                        '<span class="text-truncate title">' +
                                        data[i].file_original_name +
                                        "</span>" +
                                        '<span class="ext">.' +
                                        data[i].extension +
                                        "</span>" +
                                        "</h6>" +
                                        "<p>" +
                                        grids.extra.bytesToSize(
                                            data[i].file_size
                                        ) +
                                        "</p>" +
                                        "</div>" +
                                        '<div class="remove">' +
                                        '<button class="btn btn-sm btn-link remove-attachment" type="button">' +
                                        '<i class="fa fa-times"></i>' +
                                        "</button>" +
                                        "</div>" +
                                        "</div>";

                                    $this.next(".file-preview").append(html);
                                }
                            } else {
                                $this.find(".file-amount").html("عدد الملفات");
                            }
                        });
                });
            }
        };
        grids.plugins = {
            metismenu: function () {
                // $('[data-toggle="grids-side-menu"]').metisMenu();
            },
            bootstrapSelect: function (refresh = "") {
                // $(".grids-selectpicker").each(function (el) {
                //     var $this = $(this);
                //     if(!$this.parent().hasClass('bootstrap-select')){
                //         var selected = $this.data('selected');
                //         if( typeof selected !== 'undefined' ){
                //             $this.val(selected);
                //         }
                //         $this.selectpicker({
                //             size: 5,
                //             virtualScroll: false
                //         });
                //     }
                //     if (refresh === "refresh") {
                //         $this.selectpicker("refresh");
                //     }
                //     if (refresh === "destroy") {
                //         $this.selectpicker("destroy");
                //     }
                // });
            },
            tagify: function () {
                $(".grids-tag-input").not(".tagify").each(function () {
                    var $this = $(this);

                    var maxTags = $this.data("max-tags");
                    var whitelist = $this.data("whitelist");
                    var onchange = $this.data("on-change");

                    maxTags = !maxTags ? Infinity : maxTags;
                    whitelist = !whitelist ? [] : whitelist;

                    $this.tagify({
                        maxTags: maxTags,
                        whitelist: whitelist,
                        dropdown: {
                            enabled: 1,
                        },
                    });
                    try {
                        callback = eval(onchange);
                    } catch (e) {
                        var callback = '';
                    }
                    if (typeof callback == 'function') {
                        $this.on('removeTag',function(){
                            callback();
                        });
                        $this.on('add',function(){
                            callback();
                        });
                    }
                });
            },
            textEditor: function () {
                $(".grids-text-editor").each(function (el) {
                    var $this = $(this);
                    var buttons = $this.data("buttons");
                    var minHeight = $this.data("min-height");
                    var placeholder = $this.attr("placeholder");

                    buttons = !buttons
                        ? [
                            ["font", ["bold", "underline", "italic", "clear"]],
                            ["para", ["ul", "ol", "paragraph"]],
                            ["style", ["style"]],
                            ["color", ["color"]],
                            ["table", ["table"]],
                            ["insert", ["link", "picture", "video"]],
                            ["view", ["fullscreen", "undo", "redo"]],
                        ]
                        : buttons;
                    placeholder = !placeholder ? "" : placeholder;
                    minHeight = !minHeight ? 200 : minHeight;

                    $this.summernote({
                        toolbar: buttons,
                        placeholder: placeholder,
                        height: minHeight,
                        callbacks: {
                            onImageUpload: function (data) {
                                data.pop();
                            }
                        }
                    });
                });
            },
            dateRange: function () {
                $(".grids-date-range").each(function () {
                    var $this = $(this);
                    var today = moment().startOf("day");
                    var value = $this.val();
                    var startDate = false;
                    var minDate = false;
                    var maxDate = false;
                    var advncdRange = false;
                    var ranges = {
                        Today: [moment(), moment()],
                        Yesterday: [
                            moment().subtract(1, "days"),
                            moment().subtract(1, "days"),
                        ],
                        "Last 7 Days": [moment().subtract(6, "days"), moment()],
                        "Last 30 Days": [moment().subtract(29, "days"), moment()],
                        "This Month": [
                            moment().startOf("month"),
                            moment().endOf("month"),
                        ],
                        "Last Month": [
                            moment().subtract(1, "month").startOf("month"),
                            moment().subtract(1, "month").endOf("month"),
                        ],
                    };

                    var single = $this.data("single");
                    var monthYearDrop = $this.data("show-dropdown");
                    var format = $this.data("format");
                    var separator = $this.data("separator");
                    var pastDisable = $this.data("past-disable");
                    var futureDisable = $this.data("future-disable");
                    var timePicker = $this.data("time-picker");
                    var timePickerIncrement = $this.data("time-gap");
                    var advncdRange = $this.data("advanced-range");

                    single = !single ? false : single;
                    monthYearDrop = !monthYearDrop ? false : monthYearDrop;
                    format = !format ? "YYYY-MM-DD" : format;
                    separator = !separator ? " / " : separator;
                    minDate = !pastDisable ? minDate : today;
                    maxDate = !futureDisable ? maxDate : today;
                    timePicker = !timePicker ? false : timePicker;
                    timePickerIncrement = !timePickerIncrement ? 1 : timePickerIncrement;
                    ranges = !advncdRange ? "" : ranges;

                    $this.daterangepicker({
                        singleDatePicker: single,
                        showDropdowns: monthYearDrop,
                        minDate: minDate,
                        maxDate: maxDate,
                        timePickerIncrement: timePickerIncrement,
                        autoUpdateInput: false,
                        ranges: ranges,
                        locale: {
                            format: format,
                            separator: separator,
                            applyLabel: "Select",
                            cancelLabel: "Clear",
                        },
                    });
                    if (single) {
                        $this.on("apply.daterangepicker", function (ev, picker) {
                            $this.val(picker.startDate.format(format));
                        });
                    } else {
                        $this.on("apply.daterangepicker", function (ev, picker) {
                            $this.val(
                                picker.startDate.format(format) +
                                separator +
                                picker.endDate.format(format)
                            );
                        });
                    }

                    $this.on("cancel.daterangepicker", function (ev, picker) {
                        $this.val("");
                    });
                });
            },
            timePicker: function () {
                $(".grids-time-picker").each(function () {
                    var $this = $(this);

                    var minuteStep = $this.data("minute-step");
                    var defaultTime = $this.data("default");

                    minuteStep = !minuteStep ? 10 : minuteStep;
                    defaultTime = !defaultTime ? "00:00" : defaultTime;

                    $this.timepicker({
                        template: "dropdown",
                        minuteStep: minuteStep,
                        defaultTime: defaultTime,
                        icons: {
                            up: "las la-angle-up",
                            down: "las la-angle-down",
                        },
                        showInputs: false,
                    });
                });
            },
            fooTable: function () {
                $(".grids-table").each(function () {
                    var $this = $(this);

                    var empty = $this.data("empty");
                    empty = !empty ? "Nothing Found" : empty;

                    $this.footable({
                        breakpoints: {
                            xs: 576,
                            sm: 768,
                            md: 992,
                            lg: 1200,
                            xl: 1400,
                        },
                        cascade: true,
                        on: {
                            "ready.ft.table": function (e, ft) {
                                grids.extra.deleteConfirm();
                            },
                        },
                        empty: empty,
                    });
                });
            },
            notify: function (type = "dark", message = "") {
                $.notify(
                    {
                        // options
                        message: message,
                    },
                    {
                        // settings
                        showProgressbar: true,
                        delay: 2500,
                        mouse_over: "pause",
                        placement: {
                            from: "bottom",
                            align: "left",
                        },
                        animate: {
                            enter: "animated fadeInUp",
                            exit: "animated fadeOutDown",
                        },
                        type: type,
                        template:
                            '<div data-notify="container" class="grids-notify alert alert-{0}" role="alert">' +
                            '<button type="button" aria-hidden="true" data-notify="dismiss" class="close"><i class="las la-times"></i></button>' +
                            '<span data-notify="message">{2}</span>' +
                            '<div class="progress" data-notify="progressbar">' +
                            '<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                            "</div>" +
                            "</div>",
                    }
                );
            },
            gridsUppy: function () {
                if ($("#grids-upload-files").length > 0) {
                    var uppy = Uppy.Core({
                        autoProceed: true,
                    });
                    uppy.use(Uppy.Dashboard, {
                        target: "#grids-upload-files",
                        inline: true,
                        showLinkToFileUploadResult: false,
                        showProgressDetails: true,
                        hideCancelButton: true,
                        hidePauseResumeButton: true,
                        hideUploadButton: true,
                        proudlyDisplayPoweredByUppy: false,
                    });
                    uppy.use(Uppy.XHRUpload, {
                        endpoint: "{{route("admin.grids_uploader_upload")}}",
                        fieldName: "grids_file",
                        formData: true,
                        headers: {
                            'X-CSRF-TOKEN': grids.data.csrf,
                        },
                    });
                    uppy.on("upload-success", function (data) {
                         console.log(data)
                        grids.uploader.getAllUploads(
                            "{{route("admin.get_uploaded_files")}}"
                        );
                    });
                }
            },
            tooltip: function () {
                $('body').tooltip({selector: '[data-toggle="tooltip"]'}).click(function () {
                    $('[data-toggle="tooltip"]').tooltip("hide");
                });
            },
            countDown: function () {
                if ($(".grids-count-down").length > 0) {
                    $(".grids-count-down").each(function () {

                        var $this = $(this);
                        var date = $this.data("date");
                        // console.log(date)

                        $this.countdown(date).on("update.countdown", function (event) {
                            var $this = $(this).html(
                                event.strftime(
                                    "" +
                                    '<div class="countdown-item"><span class="countdown-digit">%-D</span></div><span class="countdown-separator">:</span>' +
                                    '<div class="countdown-item"><span class="countdown-digit">%H</span></div><span class="countdown-separator">:</span>' +
                                    '<div class="countdown-item"><span class="countdown-digit">%M</span></div><span class="countdown-separator">:</span>' +
                                    '<div class="countdown-item"><span class="countdown-digit">%S</span></div>'
                                )
                            );
                        });

                    });
                }
            },
            slickCarousel: function () {
                $(".grids-carousel").not(".slick-initialized").each(function () {
                    var $this = $(this);

                    var slidesRtl = false;

                    var slidesPerViewXs = $this.data("xs-items");
                    var slidesPerViewSm = $this.data("sm-items");
                    var slidesPerViewMd = $this.data("md-items");
                    var slidesPerViewLg = $this.data("lg-items");
                    var slidesPerViewXl = $this.data("xl-items");
                    var slidesPerView = $this.data("items");

                    var slidesCenterMode = $this.data("center");
                    var slidesArrows = $this.data("arrows");
                    var slidesDots = $this.data("dots");
                    var slidesRows = $this.data("rows");
                    var slidesAutoplay = $this.data("autoplay");
                    var slidesFade = $this.data("fade");
                    var asNavFor = $this.data("nav-for");
                    var infinite = $this.data("infinite");
                    var vertical = $this.data("vertical");
                    var focusOnSelect = $this.data("focus-select");

                    slidesPerView = !slidesPerView ? 1 : slidesPerView;
                    slidesPerViewXl = !slidesPerViewXl
                        ? slidesPerView
                        : slidesPerViewXl;
                    slidesPerViewLg = !slidesPerViewLg
                        ? slidesPerViewXl
                        : slidesPerViewLg;
                    slidesPerViewMd = !slidesPerViewMd
                        ? slidesPerViewLg
                        : slidesPerViewMd;
                    slidesPerViewSm = !slidesPerViewSm
                        ? slidesPerViewMd
                        : slidesPerViewSm;
                    slidesPerViewXs = !slidesPerViewXs
                        ? slidesPerViewSm
                        : slidesPerViewXs;

                    slidesCenterMode = !slidesCenterMode ? false : slidesCenterMode;
                    slidesArrows = !slidesArrows ? false : slidesArrows;
                    slidesDots = !slidesDots ? false : slidesDots;
                    slidesRows = !slidesRows ? 1 : slidesRows;
                    slidesAutoplay = !slidesAutoplay ? false : slidesAutoplay;
                    slidesFade = !slidesFade ? false : slidesFade;
                    asNavFor = !asNavFor ? null : asNavFor;
                    infinite = !infinite ? false : infinite;
                    vertical = !vertical ? false : vertical;
                    focusOnSelect = !focusOnSelect ? false : focusOnSelect;

                    if ($("html").attr("dir") === "rtl") {
                        slidesRtl = true;
                    }

                    $this.slick({
                        slidesToShow: slidesPerView,
                        autoplay: slidesAutoplay,
                        dots: slidesDots,
                        arrows: slidesArrows,
                        infinite: infinite,
                        vertical: vertical,
                        rtl: slidesRtl,
                        rows: slidesRows,
                        centerPadding: "0px",
                        centerMode: slidesCenterMode,
                        fade: slidesFade,
                        asNavFor: asNavFor,
                        focusOnSelect: focusOnSelect,
                        slidesToScroll: 1,
                        prevArrow:
                            '<button type="button" class="slick-prev"><i class="las la-angle-left"></i></button>',
                        nextArrow:
                            '<button type="button" class="slick-next"><i class="las la-angle-right"></i></button>',
                        responsive: [
                            {
                                breakpoint: 1500,
                                settings: {
                                    slidesToShow: slidesPerViewXl,
                                },
                            },
                            {
                                breakpoint: 1200,
                                settings: {
                                    slidesToShow: slidesPerViewLg,
                                },
                            },
                            {
                                breakpoint: 992,
                                settings: {
                                    slidesToShow: slidesPerViewMd,
                                },
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: slidesPerViewSm,
                                },
                            },
                            {
                                breakpoint: 576,
                                settings: {
                                    slidesToShow: slidesPerViewXs,
                                },
                            },
                        ],
                    });
                });
            },
            chart: function (selector, config) {
                if (!$(selector).length) return;

                $(selector).each(function () {
                    var $this = $(this);

                    var gridsChart = new Chart($this, config);
                });
            },
            noUiSlider: function(){
                if ($(".grids-range-slider")[0]) {
                    $(".grids-range-slider").each(function () {
                        var c = document.getElementById("input-slider-range"),
                            d = document.getElementById("input-slider-range-value-low"),
                            e = document.getElementById("input-slider-range-value-high"),
                            f = [d, e];

                        noUiSlider.create(c, {
                            start: [
                                parseInt(d.getAttribute("data-range-value-low")),
                                parseInt(e.getAttribute("data-range-value-high")),
                            ],
                            connect: !0,
                            range: {
                                min: parseInt(c.getAttribute("data-range-value-min")),
                                max: parseInt(c.getAttribute("data-range-value-max")),
                            },
                        }),

                            c.noUiSlider.on("update", function (a, b) {
                                f[b].textContent = a[b];
                            }),
                            c.noUiSlider.on("change", function (a, b) {
                                rangefilter(a);
                            });
                    });
                }
            },
            zoom: function(){
                if($('.img-zoom')[0]){
                    $('.img-zoom').zoom({
                        magnify:1.5
                    });
                }
            },
            jsSocials: function(){
                // $('.grids-share').jsSocials({
                //     showLabel: false,
                //     showCount: false,
                //     shares: [
                //         {
                //             share: "email",
                //             logo: "lar la-envelope"
                //         },
                //         {
                //             share: "twitter",
                //             logo: "lab la-twitter"
                //         },
                //         {
                //             share: "facebook",
                //             logo: "lab la-facebook-f"
                //         },
                //         {
                //             share: "linkedin",
                //             logo: "lab la-linkedin-in"
                //         },
                //         {
                //             share: "whatsapp",
                //             logo: "lab la-whatsapp"
                //         }
                //     ]
                // });
            }
        };
        grids.extra = {
            refreshToken: function (){
                $.get("{{route('refresh_csrf')}}").done(function(data){
                    grids.data.csrf = data;
                });
                // console.log(grids.data.csrf);
            },
            mobileNavToggle: function () {
                $('[data-toggle="grids-mobile-nav"]').on("click", function () {
                    if (!$(".grids-sidebar-wrap").hasClass("open")) {
                        $(".grids-sidebar-wrap").addClass("open");
                    } else {
                        $(".grids-sidebar-wrap").removeClass("open");
                    }
                });
                $(".grids-sidebar-overlay").on("click", function () {
                    $(".grids-sidebar-wrap").removeClass("open");
                });
            },
            initActiveMenu: function () {
                $('[data-toggle="grids-side-menu"] a').each(function () {
                    var pageUrl = window.location.href.split(/[?#]/)[0];
                    if (this.href == pageUrl || $(this).hasClass("active")) {
                        $(this).addClass("active");
                        $(this).closest(".grids-side-nav-item").addClass("mm-active");
                        $(this)
                            .closest(".level-2")
                            .siblings("a")
                            .addClass("level-2-active");
                        $(this)
                            .closest(".level-3")
                            .siblings("a")
                            .addClass("level-3-active");
                    }
                });
            },
            deleteConfirm: function () {
                $(".confirm-delete").click(function (e) {
                    e.preventDefault();
                    var url = $(this).data("href");
                    $("#delete-modal").modal("show");
                    $("#delete-link").attr("href", url);
                });

                $(".confirm-cancel").click(function (e) {
                    e.preventDefault();
                    var url = $(this).data("href");
                    $("#cancel-modal").modal("show");
                    $("#cancel-link").attr("href", url);
                });

                $(".confirm-complete").click(function (e) {
                    e.preventDefault();
                    var url = $(this).data("href");
                    $("#complete-modal").modal("show");
                    $("#comfirm-link").attr("href", url);
                });

                $(".confirm-alert").click(function (e) {
                    e.preventDefault();
                    var url = $(this).data("href");
                    var target = $(this).data("target");
                    $(target).modal("show");
                    $(target).find(".comfirm-link").attr("href", url);
                    $("#comfirm-link").attr("href", url);
                });
            },
            bytesToSize: function (bytes) {
                var sizes = ["Bytes", "KB", "MB", "GB", "TB"];
                if (bytes == 0) return "0 Byte";
                var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
            },
            multiModal: function () {
                $(document).on("show.bs.modal", ".modal", function (event) {
                    var zIndex = 1040 + 10 * $(".modal:visible").length;
                    $(this).css("z-index", zIndex);
                    setTimeout(function () {
                        $(".modal-backdrop")
                            .not(".modal-stack")
                            .css("z-index", zIndex - 1)
                            .addClass("modal-stack");
                    }, 0);
                });
                $(document).on('hidden.bs.modal', function () {
                    if($('.modal.show').length > 0){
                        $('body').addClass('modal-open');
                    }
                });
            },
            bsCustomFile: function () {
                $(".custom-file input").change(function (e) {
                    var files = [];
                    for (var i = 0; i < $(this)[0].files.length; i++) {
                        files.push($(this)[0].files[i].name);
                    }
                    if (files.length === 1) {
                        $(this).next(".custom-file-name").html(files[0]);
                    } else if (files.length > 1) {
                        $(this)
                            .next(".custom-file-name")
                            .html(files.length + " الملفات المحددة");
                    } else {
                        $(this).next(".custom-file-name").html("عدد الملفات");
                    }
                });
            },
            stopPropagation: function(){
                $(document).on('click', '.stop-propagation', function (e) {
                    e.stopPropagation();
                });
            },
            outsideClickHide: function(){
                $(document).on('click', function (e) {
                    $('.document-click-d-none').addClass('d-none');
                });
            },
            inputRating: function () {
                $(".rating-input").each(function () {
                    $(this)
                        .find("label")
                        .on({
                            mouseover: function (event) {
                                $(this).find("i").addClass("hover");
                                $(this).prevAll().find("i").addClass("hover");
                            },
                            mouseleave: function (event) {
                                $(this).find("i").removeClass("hover");
                                $(this).prevAll().find("i").removeClass("hover");
                            },
                            click: function (event) {
                                $(this).siblings().find("i").removeClass("active");
                                $(this).find("i").addClass("active");
                                $(this).prevAll().find("i").addClass("active");
                            },
                        });
                    if ($(this).find("input").is(":checked")) {
                        $(this)
                            .find("label")
                            .siblings()
                            .find("i")
                            .removeClass("active");
                        $(this)
                            .find("input:checked")
                            .closest("label")
                            .find("i")
                            .addClass("active");
                        $(this)
                            .find("input:checked")
                            .closest("label")
                            .prevAll()
                            .find("i")
                            .addClass("active");
                    }
                });
            },
            scrollToBottom: function () {
                $(".scroll-to-btm").each(function (i, el) {
                    el.scrollTop = el.scrollHeight;
                });
            },
            classToggle: function () {
                $(document).on('click','[data-toggle="class-toggle"]',function () {
                    var $this = $(this);
                    var target = $this.data("target");
                    var sameTriggers = $this.data("same");

                    if ($(target).hasClass("active")) {
                        $(target).removeClass("active");
                        $(sameTriggers).removeClass("active");
                        $this.removeClass("active");
                    } else {
                        $(target).addClass("active");
                        $this.addClass("active");
                    }
                });
            },
            collapseSidebar: function () {
                $(document).on('click','[data-toggle="collapse-sidebar"]',function (i, el) {
                    var $this = $(this);
                    var target = $(this).data("target");
                    var sameTriggers = $(this).data("siblings");

                    // var showOverlay = $this.data('overlay');
                    // var overlayMarkup = '<div class="overlay overlay-fixed dark c-pointer" data-toggle="collapse-sidebar" data-target="'+target+'"></div>';

                    // showOverlay = !showOverlay ? true : showOverlay;

                    // if (showOverlay && $(target).siblings('.overlay').length !== 1) {
                    //     $(target).after(overlayMarkup);
                    // }

                    e.preventDefault();
                    if ($(target).hasClass("opened")) {
                        $(target).removeClass("opened");
                        $(sameTriggers).removeClass("opened");
                        $($this).removeClass("opened");
                    } else {
                        $(target).addClass("opened");
                        $($this).addClass("opened");
                    }
                });
            },
            autoScroll: function () {
                if ($(".grids-auto-scroll").length > 0) {
                    $(".grids-auto-scroll").each(function () {
                        var options = $(this).data("options");

                        options = !options
                            ? '{"delay" : 2000 ,"amount" : 70 }'
                            : options;

                        options = JSON.parse(options);

                        this.delay = parseInt(options["delay"]) || 2000;
                        this.amount = parseInt(options["amount"]) || 70;
                        this.autoScroll = $(this);
                        this.iScrollHeight = this.autoScroll.prop("scrollHeight");
                        this.iScrollTop = this.autoScroll.prop("scrollTop");
                        this.iHeight = this.autoScroll.height();

                        var self = this;
                        this.timerId = setInterval(function () {
                            if (
                                self.iScrollTop + self.iHeight <
                                self.iScrollHeight
                            ) {
                                self.iScrollTop = self.autoScroll.prop("scrollTop");
                                self.iScrollTop += self.amount;
                                self.autoScroll.animate(
                                    { scrollTop: self.iScrollTop },
                                    "slow",
                                    "linear"
                                );
                            } else {
                                self.iScrollTop -= self.iScrollTop;
                                self.autoScroll.animate(
                                    { scrollTop: "0px" },
                                    "fast",
                                    "swing"
                                );
                            }
                        }, self.delay);
                    });
                }
            },
            addMore: function () {
                $('[data-toggle="add-more"]').each(function () {
                    var $this = $(this);
                    var content = $this.data("content");
                    var target = $this.data("target");

                    $this.on("click", function (e) {
                        e.preventDefault();
                        $(target).append(content);
                    });
                });
            },
            removeParent: function () {
                $(document).on(
                    "click",
                    '[data-toggle="remove-parent"]',
                    function () {
                        var $this = $(this);
                        var parent = $this.data("parent");
                        $this.closest(parent).remove();
                    }
                );
            },
            selectHideShow: function() {
                $('[data-show="selectShow"]').each(function() {
                    var target = $(this).data("target");
                    $(this).on("change", function() {
                        var value = $(this).val();
                        // console.log(value);
                        $(target)
                            .children()
                            .not("." + value)
                            .addClass("d-none");
                        $(target)
                            .find("." + value)
                            .removeClass("d-none");
                    });
                });
            },
            plusMinus: function(){
                $('.grids-plus-minus button').on('click', function(e) {
                    // console.log(e,this)
                    var id=$('#produ_id').data('id');
                    e.preventDefault();

                    var fieldName = $(this).attr("data-field");
                    var type = $(this).attr("data-type");
                    var input = $("input[name='" + fieldName + "']");
                    var currentVal = parseInt(input.val());


                    if (!isNaN(currentVal)) {
                        if (type == "minus") {
                            if (currentVal > input.attr("min")) {
                                input.val(currentVal - 1).change();
                            }
                            if (parseInt(input.val()) == input.attr("min")) {
                                $(this).attr("disabled", true);
                            }
                        } else if (type == "plus") {
                            if (currentVal < input.attr("max")) {
                                input.val(currentVal + 1).change();
                            }
                            if (parseInt(input.val()) == input.attr("max")) {
                                $(this).attr("disabled", true);
                            }
                        }
                    } else {
                        input.val(0);
                    }
                    upsale(input.val(),id);
                });
                $('.grids-plus-minus input').on('change', function () {
                    var minValue = parseInt($(this).attr("min"));
                    var maxValue = parseInt($(this).attr("max"));
                    var valueCurrent = parseInt($(this).val());

                    name = $(this).attr("name");
                    if (valueCurrent >= minValue) {
                        $(this).siblings("[data-type='minus']").removeAttr("disabled");
                    } else {
                        alert("Sorry, the minimum value was reached");
                        $(this).val($(this).data("oldValue"));
                    }
                    if (valueCurrent <= maxValue) {
                        $(this).siblings("[data-type='plus']").removeAttr("disabled");
                    } else {
                        alert("Sorry, the maximum value was reached");
                        $(this).val($(this).data("oldValue"));
                    }
                });
            },
            hovCategoryMenu: function(){
                $("#category-menu-icon, #category-sidebar")
                    .on("mouseover", function (event) {
                        $("#hover-category-menu").addClass('active').removeClass('d-none');
                    })
                    .on("mouseout", function (event) {
                        $("#hover-category-menu").addClass('d-none').removeClass('active');
                    });
            },
            trimAppUrl: function(){
                // if(grids.data.appUrl.slice(-1) == '/'){
                //     grids.data.appUrl = grids.data.appUrl.slice(0, grids.data.appUrl.length -1);
                //     // console.log(grids.data.appUrl);
                // }
            },
            setCookie: function(cname, cvalue, exdays) {
                var d = new Date();
                d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                var expires = "expires=" + d.toUTCString();
                document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            },
            getCookie: function(cname) {
                var name = cname + "=";
                var decodedCookie = decodeURIComponent(document.cookie);
                var ca = decodedCookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) === ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) === 0) {
                        return c.substring(name.length, c.length);
                    }
                }
                return "";
            },
            acceptCookie: function(){
                if (!grids.extra.getCookie("acceptCookies")) {
                    $(".grids-cookie-alert").addClass("show");
                }
                $(".grids-cookie-accepet").on("click", function() {
                    grids.extra.setCookie("acceptCookies", true, 60);
                    $(".grids-cookie-alert").removeClass("show");
                });
            }
        };

        setInterval(function(){
            grids.extra.refreshToken();
        }, 3600000);

        // init grids plugins, extra options
        grids.extra.initActiveMenu();
        grids.extra.mobileNavToggle();
        grids.extra.deleteConfirm();
        grids.extra.multiModal();
        grids.extra.inputRating();
        grids.extra.bsCustomFile();
        grids.extra.stopPropagation();
        grids.extra.outsideClickHide();
        grids.extra.scrollToBottom();
        grids.extra.classToggle();
        grids.extra.collapseSidebar();
        grids.extra.autoScroll();
        grids.extra.addMore();
        grids.extra.removeParent();
        grids.extra.selectHideShow();
        grids.extra.plusMinus();
        grids.extra.hovCategoryMenu();
        grids.extra.trimAppUrl();
        grids.extra.acceptCookie();

        grids.plugins.metismenu();
        grids.plugins.bootstrapSelect();
        grids.plugins.tagify();
        grids.plugins.textEditor();
        grids.plugins.tooltip();
        grids.plugins.countDown();
        grids.plugins.dateRange();
        grids.plugins.timePicker();
        grids.plugins.fooTable();
        grids.plugins.slickCarousel();
        grids.plugins.noUiSlider();
        grids.plugins.zoom();
        grids.plugins.jsSocials();

        // initialization of grids uploader
        grids.uploader.initForInput();
        grids.uploader.removeAttachment();
        grids.uploader.previewGenerate();

        $(document).ajaxComplete(function(){
            grids.plugins.bootstrapSelect('refresh');
        });

    })(jQuery);


</script>
