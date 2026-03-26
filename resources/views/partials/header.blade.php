<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GP Margin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('purple/src/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('purple/src/assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('purple/src/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('purple/src/assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('purple/src/assets/vendors/summernote/summernote-bs5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('purple/src/assets/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('purple/src/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">

    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('purple/src/assets/vendors/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('purple/src/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('purple/src/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('purple/src/assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('purple/src/assets/css/vertical-light/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('purple/src/assets/images/logo/agt.png') }}" />
    <style>
        /* --- Tabel utama --- */
        #order-listing {
            table-layout: fixed;
            width: 100%;
        }

        /* Default biar tampilan rapi */
        #order-listing th,
        #order-listing td {
            vertical-align: top;
            padding: 15px;
        }

        /* Kolom umum (non-wrap) */
        #order-listing th,
        #order-listing td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ✅ Kolom yang boleh wrap text */
        #order-listing th.col-wrap,
        #order-listing td.col-wrap {
            white-space: normal !important;
            word-wrap: break-word;
            max-width: 250px !important;
            overflow: visible;
            text-overflow: unset;
        }

        /* Kolom ID Material (fix width) */
        #order-listing th.col-id,
        #order-listing td.col-id {
            width: 100px !important;
            max-width: 100px !important;
        }

        /* Kolom No dan Action tetap kecil */
        #order-listing th:first-child,
        #order-listing td:first-child {
            width: 60px !important;
            text-align: center;
        }
    </style>

</head>

<body>
