<template>
    <div>
        Events example: {{data}}
    </div>
</template>

<style>

</style>

<script>
  export default {
    name: 'events-example',
    data() {
      return {
        data: 'example'
      }
    },
    mounted() {
      console.log('Mounted ok')
    }
  }
</script>
