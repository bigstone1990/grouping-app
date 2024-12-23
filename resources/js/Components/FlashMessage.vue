<script setup>
</script>

<template>
    <div v-if="$page.props.flash.status === 'success'" class="mx-auto max-w-7xl bg-blue-300 text-white py-4 px-4 sm:px-6 lg:px-8">
      {{ $page.props.flash.message }}
    </div>
    <div v-if="$page.props.flash.status === 'danger'" class="mx-auto max-w-7xl bg-red-300 text-white py-4 px-4 sm:px-6 lg:px-8">
      {{ $page.props.flash.message }}
    </div>
</template>