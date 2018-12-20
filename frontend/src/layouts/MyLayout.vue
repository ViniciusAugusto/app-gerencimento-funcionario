<template>
  <q-layout view="lHh Lpr lFf" ref="layout">
    <q-layout-header class="header">
      <q-toolbar>
        <q-toolbar-title class="text-center">
          Central de gerenciamento de funcionários
        </q-toolbar-title>
      </q-toolbar>
    </q-layout-header>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>

export default {
  name: 'MyLayout'
}
</script>

<style lang="stylus">
@import '~variables'
html, body
  .offline
    margin-top 2vh
  background-color $neutral
  .security_question
    top 1px
</style>
