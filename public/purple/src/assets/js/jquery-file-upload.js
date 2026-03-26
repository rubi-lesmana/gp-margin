(function ($) {
    "use strict";
    if ($("#fileuploader").length) {
        $("#fileuploader").uploadFile({
            url: "/category/store_import",
            fileName: "myfile",
            returnType: "json",
            onSuccess: function (files, data, xhr, pd) {
                console.log("Upload sukses:", data.file);
            },
            onError: function (files, status, errMsg, pd) {
                console.error("Upload gagal:", errMsg);
            },
        });
    }
})(jQuery);
