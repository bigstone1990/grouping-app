<script setup>

import { usePage } from '@inertiajs/vue3';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}

const { props } = usePage();

if (props.flash.status === 'success') {
  toastr.success(props.flash.message);
}
</script>

<template>
</template>
